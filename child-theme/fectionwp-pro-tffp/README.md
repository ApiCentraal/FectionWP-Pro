# FectionWP Pro – TFFP (child theme)

Deze folder bevat een **child theme** voor FectionWP Pro, specifiek voor de migratie van “The Funky Face Paint”.

## Installatie / deployment
1. Kopieer de map `fectionwp-pro-tffp` naar `wp-content/themes/`.
2. Zorg dat de parent theme foldernaam overeenkomt met de waarde in `style.css` (`Template:`).
   - Standaard staat deze op `fectionwp-pro`.
3. Activeer het child theme in WordPress.

## Wat zit erin
- `style.css`: theme header (wordt door FectionWP Pro als `fwp-style` geladen).
- `functions.php`: laadt token overrides en TFFP custom styles.
- `assets/css/tffp-tokens.css`: design tokens + Bootstrap variable overrides (Optie A).
- `assets/css/tffp.css`: plek voor site-specifieke styling.
- `assets/css/tffp-pbp-overrides.css`: overrides voor FectionWP-Booking assets (na plugin CSS).
- Page templates: `front-page.php`, `page-*.php` als startpunt (Optie C refactor).

