-- Performance-Indexe fuer die Article-DB -- TRANSAKTIONS-VARIANTE (ohne CONCURRENTLY).
--
-- Nutze DIESE Datei, wenn du das Skript in DataGrip / DBeaver / pgAdmin oder mit
-- "psql --single-transaction" ausfuehrst (dort schlaegt CONCURRENTLY fehl).
--
-- ACHTUNG: Ohne CONCURRENTLY nimmt jedes CREATE INDEX kurz einen ACCESS-EXCLUSIVE-Lock
-- auf die Tabelle -> Schreibzugriffe blockieren waehrenddessen. Nur im Wartungsfenster
-- bzw. bei geringer Last ausfuehren. Fuer den laufenden Betrieb stattdessen
-- sql/performance_indexes.sql (CONCURRENTLY, autocommit) verwenden.
--
-- Rein additiv (kein DROP), reversibel via DROP INDEX <name>.
-- Vor dem Rollout Spaltennamen gegen das reale Schema pruefen.

CREATE EXTENSION IF NOT EXISTS pg_trgm;

-- article
CREATE INDEX IF NOT EXISTS ix_article_client        ON article (client_id);
CREATE INDEX IF NOT EXISTS ix_article_client_group  ON article (client_id, article_group_id);
CREATE INDEX IF NOT EXISTS ix_article_client_loc    ON article (client_id, location_id);
CREATE INDEX IF NOT EXISTS ix_article_client_cat    ON article (client_id, category_id);
CREATE INDEX IF NOT EXISTS ix_article_unique_hash   ON article (unique_hash);
CREATE INDEX IF NOT EXISTS ix_article_tags_trgm     ON article USING gin (lower(tags) gin_trgm_ops);

-- Verfuegbarkeits-Subquery
CREATE INDEX IF NOT EXISTS ix_booking_article_range ON article_booking (article_id, booking_start, booking_end);

-- Child-Tabellen
CREATE INDEX IF NOT EXISTS ix_img_article           ON article_image (article_id);
CREATE INDEX IF NOT EXISTS ix_attr_article          ON article_attribute (article_id);
CREATE INDEX IF NOT EXISTS ix_file_article          ON article_file (article_id);
CREATE INDEX IF NOT EXISTS ix_acc_parent            ON article_accessories (article_id_parent);
CREATE INDEX IF NOT EXISTS ix_acc_child             ON article_accessories (article_id_child);
CREATE INDEX IF NOT EXISTS ix_apd_article           ON article_price_deal__list (article_id);

-- article_group + Child-Tabellen
CREATE INDEX IF NOT EXISTS ix_group_client          ON article_group (client_id) WHERE enable_online_booking;
CREATE INDEX IF NOT EXISTS ix_gimg_group            ON article_group_image (article_group_id);
CREATE INDEX IF NOT EXISTS ix_gattr_group           ON article_group_attribute (article_group_id);
CREATE INDEX IF NOT EXISTS ix_gmin_group            ON article_group_min_rental (article_group_id);
CREATE INDEX IF NOT EXISTS ix_gacc_group            ON article_group_accessories (article_group_id);
CREATE INDEX IF NOT EXISTS ix_gpd_group             ON article_group_price_deal__list (article_group_id);

-- Online-Booking-Join
CREATE INDEX IF NOT EXISTS ix_msob_ob_article       ON microservice_article_online_booking (ms_online_booking_id, article_id);

-- Nested-Set-Kategorien
CREATE INDEX IF NOT EXISTS ix_cat_tree              ON settings_category (tree_root, lft, rgt);
