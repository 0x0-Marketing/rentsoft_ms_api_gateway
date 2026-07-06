# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Symfony bundle (`composer.json` `type: symfony-bundle`, PHP >=8.0, Symfony 7.1) published as the library `rentsoft/rentsoft_ms_api_gateway`. It is **not a runnable app** — it exposes a single ~2500-line service class, `src/ConnectController.php` (`extends AbstractController`, throws `NotFoundHttpException` on missing rows), that a consuming Rentsoft app registers and calls. There is no HTTP routing, no console, no tests, no lint config in this repo. `symfony/http-client` and `symfony/serializer` are declared in `composer.json` but currently unused in `src/`.

## Commands

- Install deps: `composer install`
- Release: bump `version` in `composer.json`, commit, then `git tag <version>` (tags mirror the version, e.g. `1.0.141`). Most commits are terse `fix` messages; release commits use the bare version number as the message.

## Architecture

### Two Postgres databases via Nette\Database (NOT Doctrine ORM)

`ConnectController::__construct` takes 8 positional args and builds two `Nette\Database\Explorer` instances:
- `$articleExplorer` → article DB (articles, groups, images, attributes, bookings, locations, categories, price rates)
- `$onlineBookingExplorer` → online-booking DB (appearance/layout/checkout settings, open times, blocked days, vouchers)

The consuming app is responsible for wiring these constructor args (DB host/user/pass/dbname per database) as a Symfony service definition — that config lives in the consumer, not here. `doctrine/collections` is used only for `ArrayCollection` return types, not for persistence.

### Fetch-and-hydrate pattern

Every public method follows the same shape and this is the pattern to match when adding methods:
1. Raw SQL via `$explorer->fetch(...)` (single row) or `fetchAll(...)` (rows).
2. Manually instantiate a `Model\*` object and copy each column into it via setters.
3. Return the model, or an `ArrayCollection` of models.

`Model/*` classes are plain data objects (public-ish typed props + getters/setters), no DB awareness. When a DB column is added, both the SQL `SELECT *` mapping loop AND the corresponding model need updating.

### Nested hydration / fetch flags

Detail methods (`getArticleDetail`, `getArticleGroupDetail`, `getArticles`, `getArticlesFast`) take a long tail of boolean `$fetch_*` params that gate loading of related data (images, attributes, bookings, files, accessories, price deals, location, article groups). These recurse: e.g. `getArticleGroupDetail` calls `getArticleDetail` per article, accessories call `getArticleDetail` on child articles. **Pass `false` for unneeeded relations to avoid deep/expensive recursion** — that is the whole point of the flags. `getArticlesFast` is the flattened, less-recursive variant of `getArticles`.

### Query building

`getArticles`, `getArticlesFast`, and `countArticles` share the WHERE/JOIN assembly (location, articleGroup, category via nested-set `lft`/`rgt`/`tree_root`, tag matching, search, `rentalDates` availability, `online_booking_id` join, quantity). This is centralised in the private helper **`buildArticleConditions($options, $excludedTags)`** → `['condition' => ..., 'inner_join' => ...]`; change filter logic there once, not in three places. Pagination/order (`LIMIT`/`ORDER BY`) stays in the individual list methods.

**Performance: batch hydration, not N+1.** The list methods do NOT loop per-row `getArticleDetail`. They fetch the article rows once, then call the private **`hydrateArticles($rows, $flags, $accessoryChild = null)`** helper, which loads each relation (images/attributes/files/bookings/price_deals/accessories) with a single `WHERE ... IN (ids)` query and groups in PHP via `groupRows()`. Core row→model mapping is `mapArticleRow()`. When adding a relation, add it to `hydrateArticles` (batched), not as a per-article query. `location` and `article_group` are deduplicated through the request-local memo caches `$this->locationCache` / `$this->articleGroupCache` (the article-group cache key includes the fetch-flag signature, since content depends on the flags).

Availability logic exists in two forms: the `rentalDates` anti-join (`NOT EXISTS (... SUM(quantity) >= article.quantity)`) inside the list queries, and `getAvailability()` which computes per-unit availability in PHP.

DB indexes backing all of this live in `sql/performance_indexes.sql` (CONCURRENTLY, run via `psql -f` autocommit) with a transaction-safe fallback `sql/performance_indexes_txn.sql`. The `tags LIKE '%,x,%'` filter relies on a `pg_trgm` GIN index on `lower(tags)`.

### Pricing engine (roughly the bottom half of the file, ~lines 1450–2576)

Price calculation is the largest concern in the class and lives in a cluster of methods:
- `calculatePriceForArticleGroups` (public) → resolves a group to its cheapest article, then delegates down.
- `calculatePriceForArticles` (the core engine) → reads `price_rate_group` / `price_rate_entry` (+ `article_group_price_rate__list` join), applies `$calculation_type` (`per_night` vs `per_day`), and optionally deals/discounts.
- `calculatePriceForArticlesFassbender` → a **client-specific fork** of the core engine (customer id, custom rental price). Client-named variants like this exist; do not assume one pricing path.
- `calculateRentalDays` (helper) → turns a start/end timestamp pair into billable day/hour counts. `per_night` snaps start to 10:00 and end to 09:59:59; note the `kmh` (free km/hours) unit carried alongside price for vehicle-style rentals.

When touching price logic, check whether a change belongs in the generic engine, the Fassbender fork, or both.

### Important caveat

All SQL is built by string concatenation of raw inputs (client IDs, ids, options) directly into the query. This is the existing project-wide convention. When editing or adding queries, follow the surrounding style but be aware there is no parameter binding here.