-- Performance-Indexe fuer die Article-DB (getArticles / getArticlesFast / getArticleGroups)
--
-- Ausfuehrung: gegen die ARTICLE-Datenbank (nicht die Online-Booking-DB).
-- Rein additiv (kein DROP). CONCURRENTLY -> kein Table-Lock, im laufenden Betrieb sicher.
-- Jederzeit reversibel via DROP INDEX <name>.
--
-- WICHTIG: CREATE INDEX CONCURRENTLY darf NICHT in einer Transaktion laufen.
--   => NICHT in DataGrip/DBeaver/pgAdmin als Ganzes ausfuehren (die klammern in BEGIN/COMMIT)
--   => NICHT mit "psql --single-transaction" / "psql -1".
--
--   Richtig (Autocommit, jedes Statement fuer sich):
--       psql -h <host> -U <user> -d <article_db> -f sql/performance_indexes.sql
--
--   In einer GUI: Option "wrap in transaction" deaktivieren ODER Statements einzeln ausfuehren.
--
--   Alternative fuer GUI/Transaktion: sql/performance_indexes_txn.sql (ohne CONCURRENTLY,
--   sperrt aber kurz Schreibzugriffe -> nur im Wartungsfenster).
--
-- Vor dem Rollout Spaltennamen gegen das reale Schema pruefen und nur real
-- vorhandene Spalten indexieren (Schema wird ausserhalb dieses Repos verwaltet).

CREATE EXTENSION IF NOT EXISTS pg_trgm;

-- article: client_id filtert jede Listen-Query, dazu die haeufigen Zusatzfilter
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_article_client        ON article (client_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_article_client_group  ON article (client_id, article_group_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_article_client_loc    ON article (client_id, location_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_article_client_cat    ON article (client_id, category_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_article_unique_hash   ON article (unique_hash);
-- tags LIKE '%,x,%' (fuehrendes Wildcard) -> nur ueber Trigram-GIN indexierbar
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_article_tags_trgm     ON article USING gin (lower(tags) gin_trgm_ops);

-- Verfuegbarkeits-Subquery (booking_start/booking_end BETWEEN, SUM(quantity))
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_booking_article_range ON article_booking (article_id, booking_start, booking_end);

-- Child-Tabellen: Batch-Load per WHERE article_id IN (...)
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_img_article           ON article_image (article_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_attr_article          ON article_attribute (article_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_file_article          ON article_file (article_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_acc_parent            ON article_accessories (article_id_parent);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_acc_child             ON article_accessories (article_id_child);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_apd_article           ON article_price_deal__list (article_id);

-- article_group + dessen Child-Tabellen
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_group_client          ON article_group (client_id) WHERE enable_online_booking;
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_gimg_group            ON article_group_image (article_group_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_gattr_group           ON article_group_attribute (article_group_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_gmin_group            ON article_group_min_rental (article_group_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_gacc_group            ON article_group_accessories (article_group_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_gpd_group             ON article_group_price_deal__list (article_group_id);

-- Online-Booking-Join
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_msob_ob_article       ON microservice_article_online_booking (ms_online_booking_id, article_id);

-- Nested-Set-Kategorien (lft/rgt/tree_root)
CREATE INDEX CONCURRENTLY IF NOT EXISTS ix_cat_tree              ON settings_category (tree_root, lft, rgt);
