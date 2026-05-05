# AGENTS.md

Scoped instructions for SuiteCRM module implementation work.

## Scope

Applies to files under modules/ in this repository.

## Mission

Make module changes that preserve existing SuiteCRM conventions and avoid regressions.

## Rules

- Follow nearest-neighbor structure from existing module code before introducing new patterns.
- For dashlets, preserve class/meta/data file conventions and naming consistency.
- Keep framework-required patterns intact (entry-point guard checks, translation helpers, expected globals).
- Prefer adding new functionality under custom/ equivalents when possible; avoid unnecessary core edits in modules/.

## Verification

- Validate dashlet discoverability after rebuild of dashlet cache.
- Run feasible test suites and document constraints when full env setup is unavailable.
