# FectionWP Pro

Dit repository bevat het FectionWP Pro WordPress-thema, ontwikkeld door ApiCentraal.

Repository: https://github.com/ApiCentraal/FectionWP-Pro

Author: ApiCentraal <help@apicentraal.nl>

## Doel

FectionWP Pro is een professioneel WordPress-thema gericht op flexibele sites met een visuele builder, blocks en boekingsfunctionaliteit. Het thema is bedoeld om samen te werken met de bijbehorende plugins om volledige functionaliteit te bieden.

FectionWP Pro is een flexibel, enterprise-ready WordPress-thema gericht op:
- Visuele sitebouw met een krachtige page-builder
- Herbruikbare Gutenberg-blocks en patterns
- Een geïntegreerd boekingssysteem

## Example Pages & Block Patterns

- De theme includes a set of example layouts under `template-parts/examples/`.
- Quick-create pages: go to Appearance → Example Pages, preview an example and click "Create Page" to add a new Page with that example inserted.
	- You can choose a page template (from `page-*.php` files), set the created page as the static front page, and optionally add the page to an "Example Menu".
- Gutenberg users: examples are also registered as block patterns (FectionWP Examples category). Insert via the block inserter by searching "Example: ...".

This system uses the `[fwp_example name="example-slug"]` shortcode under the hood; created pages contain that shortcode so you can edit or replace the example content after creation.

Het thema levert de front-end templates, styling en integraties; specifieke functionaliteit wordt geleverd door aanvullende FectionWP-plugins (naam en versiebeheer via releases van de respectievelijke repos).

## Vereiste plugins

Dit thema is bedoeld om gebruikt te worden in combinatie met de volgende plugins:

- FectionWP-Booking — biedt boekings- en afspraakfunctionaliteit
- FectionWP-Visual-Builder — visuele page-builder en template-editor
- FectionWP-Blocks — extra Gutenberg blocks en patterns

Zorg dat deze plugins geïnstalleerd en geactiveerd zijn voor volledige functionaliteit. Versies en installatie-instructies vind je in de repositories van de respectievelijke plugins.

## Hoofdfuncties

- **Page Builder Integratie** — volledige ondersteuning voor Elementor, Divi, Beaver Builder, WPBakery, Oxygen, Brizy, en Thrive Architect
- Naadloze integratie met FectionWP-Visual-Builder en FectionWP-Blocks
- Boeking- en afspraakbeheer via FectionWP-Booking
- Aangepaste thema-onderdelen en block-templates in `template-parts/`
- WooCommerce styling en compatibiliteit
- Meertalige ondersteuning via `.pot` in `languages/`

## Page Builder Ondersteuning

FectionWP Pro biedt **out-of-the-box integratie** met alle populaire WordPress page builders:

✅ **Volledig ondersteund:**
- Elementor (gratis & Pro)
- Divi Builder
- Beaver Builder
- WPBakery Page Builder
- Oxygen Builder
- Brizy Builder
- Thrive Architect
- Gutenberg (WordPress Block Editor)

**Features:**
- Automatische kleur- en font-synchronisatie met theme instellingen
- Bootstrap 5.3 container breedte compatibiliteit (1320px)
- Full-width template ondersteuning
- Bootstrap grid integratie optie
- Admin indicators voor actieve builders
- CSS compatibiliteit fixes

**Documentatie:** Zie `PAGE_BUILDER_INTEGRATION.md` voor volledige setup en gebruik.

**Divi Conversie:** Bestaande Divi content kan worden geconverteerd met `inc/import-converter.php`.

## Installatie (kort)

1. Plaats de map `FectionWP-Pro` in `wp-content/themes/` of installeer als ZIP via het dashboard.
2. Activeer het thema via het WordPress-dashboard.
3. Installeer en activeer de vereiste plugins:
	 - `FectionWP-Booking`
	 - `FectionWP-Visual-Builder`
	 - `FectionWP-Blocks`

Voor ontwikkelworkflows lokaal:

```bash
# vanuit project root
# composer install    # alleen indien composer.json aanwezig is
# npm install         # alleen indien package.json aanwezig is
```

## Lokale development (Docker)

Voor live theme-editing is er een `docker-compose.yml` toegevoegd (WordPress + MariaDB). Het theme wordt als volume gemount, dus wijzigingen in deze repo zijn direct zichtbaar.

```bash
docker compose up -d
```

- Admin: `http://localhost:8080/wp-admin/`
- Site: `http://localhost:8080/`

Eerste keer: rond de WordPress install af en activeer daarna het theme **FectionWP Pro** (folder: `fectionwp-pro`).

## Folderstructuur (hoog niveau)

```
FectionWP-Pro/
├─ assets/                 # CSS, JS, afbeeldingen
│  ├─ css/
│  └─ js/
├─ inc/                    # PHP helpers, integraties, widgets
├─ template-parts/         # herbruikbare template-onderdelen & blocks
│  └─ examples/            # voorbeeldpagina's en starter content
├─ languages/              # .pot en vertalingsbestanden
├─ style.css               # thema header + basis CSS
├─ functions.php           # thema bootstrap en registratie
└─ theme.json              # full-site editing instellingen (indien gebruikt)
```

Let op: de map `template-parts/examples/` bevat meerdere voorbeeld-templates die als uitgangspunt dienen bij site-setup.

## CI / Pipeline (aanbeveling)

Plaats een simpele CI in `.github/workflows/ci.yml` met ten minste:

- PHP linting
- Theme check (WordPress Theme Check of `phpcs` met WP-standaarden)
- (Optioneel) JS lint/build en unit tests

Voorbeeld workflow (vereenvoudigd):

```yaml
name: CI
on: [push, pull_request]
jobs:
	checks:
		runs-on: ubuntu-latest
		steps:
			- uses: actions/checkout@v4
			- name: Set up PHP
				uses: shivammathur/setup-php@v2
				with:
					php-version: '8.1'
			- name: PHP lint
				run: find . -name "*.php" -print0 | xargs -0 -n1 php -l
			- name: Install Composer deps
				run: composer install --no-interaction --no-progress || true
			- name: Run theme check (optional)
				run: vendor/bin/phpcs --standard=WordPress --extensions=php || true

```

De exacte pipeline kun je uitbreiden met `wp-cli` checks of `theme-check` via WP-CLI voor strengere validatie.

## Development tips

- Gebruik `FectionWP-Visual-Builder` om templates op te bouwen en `FectionWP-Blocks` om content-booster blocks te gebruiken.
- Raadpleeg `template-parts/examples/` voor herbruikbare patronen en componenten.
- Plaats project-specifieke assets of builds onder `assets/` en registreer ze in `functions.php`.

## Releases & tagging

Gebruik semver voor releases (bijv. `v0.1.0`). Maak op GitHub een release met changelog wanneer je breaking changes of features toevoegt.

## Support & contact

Voor vragen of ondersteuning: help@apicentraal.nl

## Licentie

Controleer de header in `style.css` voor licentie-informatie. Voorbijdragen via pull requests tegen `main`.

