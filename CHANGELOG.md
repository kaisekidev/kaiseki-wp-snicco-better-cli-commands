# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-02

First tagged release.

### Added

- `CommandRegistry` hook provider (and `CommandRegistryFactory` + `ConfigProvider`) that, on
  `cli_init`, builds a `snicco/better-wp-cli` `WPCLIApplication` from a configured list of command
  classes and registers them with WP-CLI. The WP-CLI namespace defaults to `kaiseki`.

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema, composer-require-checker 4); now depends
  on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config` and
  `kaiseki/wp-hook` pinned to `^2.0` (were `dev-master`). Removed the direct `friendsofphp/php-cs-fixer`
  dev dependency (the shared standard owns it). `snicco/better-wp-cli` stays at `^1.2` (resolves to
  v1.10.1). CI now runs via the reusable workflow in `kaisekidev/.github`.

### Fixed

- PHPStan 2 (level max): removed the `@phpstan-ignore-next-line` suppression in
  `CommandRegistryFactory`. The configured command list is now narrowed at runtime to strings that are
  `Snicco\Component\BetterWPCLI\Command` subclasses before being handed to `ArrayCommandLoader`
  (non-string / non-`Command` entries are skipped), and the container-resolved instance is checked with
  an `instanceof Command` guard that throws a `RuntimeException` on a mismatch instead of passing a
  wrong-typed value through.
