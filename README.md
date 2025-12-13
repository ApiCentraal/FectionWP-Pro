# FectionWP Pro

Dit repository bevat het FectionWP Pro WordPress-thema, ontwikkeld door ApiCentraal.

Repository: https://github.com/ApiCentraal/FectionWP-Pro

Author: ApiCentraal <help@apicentraal.nl>

## Doel

FectionWP Pro is een professioneel WordPress-thema gericht op flexibele sites met een visuele builder, blocks en boekingsfunctionaliteit. Het thema is bedoeld om samen te werken met de bijbehorende plugins om volledige functionaliteit te bieden.
# FectionWP Pro

Dit repository bevat het FectionWP Pro WordPress-thema, ontwikkeld en onderhouden door ApiCentraal.

Repository: https://github.com/ApiCentraal/FectionWP-Pro

Author: ApiCentraal <help@apicentraal.nl>

## Doel

FectionWP Pro is een flexibel, enterprise-ready WordPress-thema gericht op:
- Visuele sitebouw met een krachtige page-builder
- Herbruikbare Gutenberg-blocks en patterns
- Een geïntegreerd boekingssysteem

Het thema levert de front-end templates, styling en integraties; specifieke functionaliteit wordt geleverd door aanvullende FectionWP-plugins (naam en versiebeheer via releases van de respectievelijke repos).

## Vereiste plugins

Dit thema is bedoeld om gebruikt te worden in combinatie met de volgende plugins:

- FectionWP-Booking — biedt boekings- en afspraakfunctionaliteit
- FectionWP-Visual-Builder — visuele page-builder en template-editor
- FectionWP-Blocks — extra Gutenberg blocks en patterns

Zorg dat deze plugins geïnstalleerd en geactiveerd zijn voor volledige functionaliteit. Versies en installatie-instructies vind je in de repositories van de respectievelijke plugins.

## Hoofdfuncties

- Naadloze integratie met FectionWP-Visual-Builder en FectionWP-Blocks
- Boeking- en afspraakbeheer via FectionWP-Booking
- Aangepaste thema-onderdelen en block-templates in `template-parts/`
- WooCommerce styling en compatibiliteit
- Meertalige ondersteuning via `.pot` in `languages/`

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

## Local Docker development

This repository can be developed together with a local WordPress compose setup. A convenience `docker-compose.yml` and `.env.example` live in the sibling folder `../FectionWP` for local theme testing.

Quick start (from `/home/x/Applicaties - FectionLabs/FectionWP`):

```bash
# copy example env and edit secrets
cp .env.example .env
# start containers
docker compose up -d
# open WordPress at http://localhost:8000 and phpMyAdmin at http://localhost:8080
```

Notes:
- Do NOT commit a real `.env` with secrets. Use `.env.example` as the template.
- `docker-compose.yml` reads values from `.env` (`MYSQL_ROOT_PASSWORD`, `MYSQL_PASSWORD`, etc.).
- If you want the compose file inside this repo, copy `../FectionWP/docker-compose.yml` here and adapt paths.

