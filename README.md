# FectionWP Pro

Dit repository bevat het FectionWP Pro WordPress-thema, ontwikkeld door ApiCentraal.

Repository: https://github.com/ApiCentraal/FectionWP-Pro

Author: ApiCentraal <help@apicentraal.nl>

## Doel

FectionWP Pro is een professioneel WordPress-thema gericht op flexibele sites met een visuele builder, blocks en boekingsfunctionaliteit. Het thema is bedoeld om samen te werken met de bijbehorende plugins om volledige functionaliteit te bieden.

## Vereiste plugins

Het thema dient gebruikt te worden in combinatie met de volgende premium plugins:

- FectionWP-Booking
- FectionWP-Visual-Builder
- FectionWP-Blocks 

Zorg dat deze plugins geïnstalleerd en geactiveerd zijn voor volledige functionaliteit.

## Hoofdfuncties

- Volledige compatibiliteit met de FectionWP visual builder en block-systeem
- Integratie met een boekingssysteem via `FectionWP-Booking`
- Aangepaste Gutenberg blocks en block patterns
- WooCommerce-styling en -ondersteuning
- Voorbeeldtemplates en 'starter' content

## Installatie

1. Kopieer de map naar de WordPress thema-directory (`wp-content/themes/FectionWP-Pro`) of installeer als ZIP.
2. Activeer het thema via het WordPress-dashboard.
3. Installeer en activeer de vereiste plugins:
 
 `FectionWP-Booking` (https://github.com/ApiCentraal/FectionWP-Booking), 
 
 `FectionWP-Visual-Builder` (https://github.com/ApiCentraal/FectionWP-Visual-Builder), 
 
 `FectionWP-Blocks` (https://github.com/ApiCentraal/FectionWP-Blocks)

Voor ontwikkel-workflow lokaal:

```bash
# in project root
# composer install (indien van toepassing)
# npm install (indien van toepassing)
```

## Folderstructuur (hoog niveau)

- `assets/` — CSS, JS en images voor frontend en editor
- `inc/` — PHP helpers, widget- en plugin-integraties
- `template-parts/` — herbruikbare template-onderdelen en block-templates
- `languages/` — vertalingsbestanden
- `style.css` — thema header en basisstijl
- `functions.php` — thema bootstrap en hooks

Specifieke bestanden en mappen zijn aanwezig voor voorbeeldpagina's en block-voorbeelden.

## CI / Pipeline (aanbeveling)

Voorgestelde GitHub Actions-workflow (plaats in `.github/workflows/ci.yml`):

- PHP lint (`php -l`)
- WordPress Theme Check (via `wp-cli` of `phpcs` + WordPress coding standards)
- Optioneel: PHPUnit tests, JS lint/build (`npm run build`)

De pipeline moet ten minste code-linting en theme-check uitvoeren vóór merges naar `main`.

## Development tips

- Gebruik de `FectionWP-Visual-Builder` tijdens het opzetten van pagina's en templates.
- Gebruik example templates in `template-parts/examples/` als uitgangspunt.



## Licentie & bijdrages

Controleer `style.css` header voor licentie-informatie. Voor bijdragen: open een pull request tegen `main`.
