# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Symfony bundle (`composer.json` `type: symfony-bundle`, PHP >=8.0, Symfony 7.1) published as the library `rentsoft/rentsoft_ms_api_gateway`. It is **not a runnable app** — it exposes a single service class, `ConnectController`, that a consuming Rentsoft app registers and calls. There is no HTTP routing, no console, no tests, no lint config in this repo.

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

`getArticles`, `getArticlesFast`, and `countArticles` share a large block of `$sql_condition` assembly (location, articleGroup, category via nested-set `lft`/`rgt`/`tree_root`, tag matching, search, pagination, `rentalDates` availability subquery, `online_booking_id` join). These three blocks are near-duplicates — a change to filter logic usually needs applying to all three to stay consistent.

Availability logic exists in two forms: the `rentalDates` subquery (`SUM(quantity) >= article.quantity`) inside the list queries, and `getAvailability()` which computes per-unit availability in PHP.

### Important caveat

All SQL is built by string concatenation of raw inputs (client IDs, ids, options) directly into the query. This is the existing project-wide convention. When editing or adding queries, follow the surrounding style but be aware there is no parameter binding here.