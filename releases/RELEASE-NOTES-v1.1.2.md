# Release Notes — v1.1.2

Released: 2026-01-07

## Highlights
- Hero is now rendered consistently on templates that use the landing header (`get_header('landing')`).
- Added safe, optional toggles to control whether the Customizer Hero is rendered in the **default** header and/or **landing** header.
- TFFP child theme can independently decide whether the parent Customizer Hero is shown, preventing duplicate hero/intro sections.

## Changes
### Hero / Customizer
- Added Customizer options:
  - `fwp_hero_render_in_landing_header`
  - `fwp_hero_render_in_default_header`
- Added filter hook for developers/child themes:
  - `fwp_render_hero_in_header` (contexts: `default`, `landing`)

### Templates
- `header-landing.php`: renders the hero (if enabled) and applies top padding so it doesn’t sit under the transparent navbar.
- `header.php`: hero rendering is now conditional based on the new toggle + filter.

### TFFP child theme
- Added `TFFP Header` Customizer section with toggles that control the parent hero display for:
  - landing header
  - default header

### Docker
- `docker-compose.yml`: `WORDPRESS_CONFIG_EXTRA` now uses `if (!defined(...))` guards to avoid “already defined” warnings.

## Upgrade notes
- No breaking changes expected.
- If you use a custom hero/intro inside landing templates, disable “Hero tonen in landing header” to prevent duplicate content.
