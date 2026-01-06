# Hero Section - Gebruikershandleiding

## Overzicht
De hero sectie is nu volledig configureerbaar via de WordPress Customizer. Gebruikers kunnen eenvoudig een vaste header banner maken met tekst, CTA buttons, afbeeldingen en achtergronden.

## Waar te vinden
**WordPress Admin → Uiterlijk → Aanpassen → Hero / Header Banner**

## Beschikbare Opties

### Algemene Instellingen
- **Hero sectie activeren**: Schakel de hero sectie in/uit
- **Hero tonen op**: Kies waar de hero wordt getoond:
  - Alle pagina's
  - Alleen homepage
  - Alleen pagina's
  - Alleen blog posts

### Content
- **Hero titel**: Hoofdtitel (HTML toegestaan, max 3 regels aanbevolen)
- **Hero subtitel**: Optionele subtitel boven de hoofdtitel
- **Hero beschrijving**: Beschrijvende tekst onder de titel

### Call-to-Action Buttons
- **CTA Button 1**: Primaire button
  - Tekst (laat leeg om te verbergen)
  - URL
  - Stijl (Primary, Secondary, Success, etc.)
- **CTA Button 2**: Secundaire button (optioneel)
  - Tekst
  - URL
  - Stijl

### Visuele Elementen
- **Hero afbeelding**: Afbeelding naast de tekst (afhankelijk van layout)
- **Hero achtergrond afbeelding**: Achtergrond voor de hele sectie
- **Hero achtergrondkleur**: Vaste kleur of transparant
- **Hero tekstkleur**: Pas tekstkleur aan voor leesbaarheid

### Layout & Styling
- **Hero hoogte**: 
  - Klein (300px)
  - Gemiddeld (500px) - standaard
  - Groot (700px)
  - Volledig scherm
  - Automatisch (past zich aan inhoud)

- **Hero layout**:
  - **Gecentreerd**: Alle content gecentreerd
  - **Links uitgelijnd**: Content links uitgelijnd
  - **Split - Tekst links / Afbeelding rechts**: Twee kolommen
  - **Split - Afbeelding links / Tekst rechts**: Twee kolommen omgekeerd

- **Hero container type**:
  - Container (vast)
  - Container Fluid (volledig)
  - Container XXL

- **Achtergrond overlay opacity**: Donkere overlay over achtergrondafbeelding (0-100%)

## Live Preview
Alle tekstuele wijzigingen zijn direct zichtbaar in de Customizer preview zonder de pagina te verversen.

## Per Pagina Uitschakelen
Elke pagina en post heeft een meta box in de sidebar: **"Hero Sectie Instellingen"**
- Vink "Hero sectie verbergen op deze pagina" aan om de globale hero te verbergen voor specifieke pagina's

## Gebruik met Widget Area
- Als de hero via Customizer **niet** geactiveerd is, wordt de originele hero widget area gebruikt
- Dit zorgt voor backwards compatibility met bestaande widgets

## Best Practices

### Tekst
- **Titel**: Houd kort en krachtig (max 10 woorden)
- **Subtitel**: Optioneel, gebruik voor categorisering
- **Beschrijving**: Max 2-3 zinnen voor leesbaarheid

### Afbeeldingen
- **Hero afbeelding**: Aanbevolen 800x600px of groter
- **Achtergrond afbeelding**: Minimaal 1920x1080px voor full-width
- Gebruik geoptimaliseerde afbeeldingen (WebP formaat aanbevolen)

### Kleuren
- Bij gebruik van achtergrondafbeelding: pas tekstkleur en overlay aan voor leesbaarheid
- Test altijd op mobiel voor contrast

### Layout Keuzes
- **Gecentreerd**: Beste voor korte, krachtige boodschappen
- **Links uitgelijnd**: Geschikt voor langere teksten
- **Split layouts**: Ideaal wanneer je een product/dienst visueel wilt tonen

## Responsive Gedrag
- Op tablet en mobiel passen layouts automatisch aan
- Split layouts worden gestapeld op mobiel
- Buttons worden full-width op mobiel
- Tekstgroottes schalen automatisch

## Technische Details

### Toegevoegde Bestanden
- `inc/customizer.php`: Hero sectie instellingen (vanaf regel ~850)
- `functions.php`: Hero render functies (`fwp_render_hero()`, `fwp_should_display_hero()`)
- `assets/css/custom.css`: Hero styling (`.fwp-hero` classes)
- `assets/js/customizer-preview.js`: Live preview JavaScript
- `header.php`: Hero rendering na navigatie

### Customizer Settings
Alle instellingen zijn opgeslagen als theme mods met prefix `fwp_hero_*`:
- `fwp_hero_enabled`
- `fwp_hero_title`
- `fwp_hero_subtitle`
- `fwp_hero_description`
- `fwp_hero_btn1_text`, `fwp_hero_btn1_url`, `fwp_hero_btn1_style`
- `fwp_hero_btn2_text`, `fwp_hero_btn2_url`, `fwp_hero_btn2_style`
- `fwp_hero_image` (attachment ID)
- `fwp_hero_bg_image` (attachment ID)
- `fwp_hero_bg_color`
- `fwp_hero_text_color`
- `fwp_hero_height`
- `fwp_hero_layout`
- `fwp_hero_container`
- `fwp_hero_overlay_opacity`
- `fwp_hero_display_on`

### Post Meta
- `_fwp_disable_hero`: Per pagina/post instelling om hero te verbergen

## Voorbeeld Configuratie

### Homepage Hero (Standaard)
```
Activeren: ✓
Tonen op: Alleen homepage
Titel: Welkom bij FectionWP Pro
Subtitel: Premium WordPress Theme
Beschrijving: Bootstrap 5.3 + Gutenberg + WooCommerce ready
Button 1: Meer informatie → /over-ons/
Button 2: Demo bekijken → /demo/
Layout: Split - Tekst links / Afbeelding rechts
Hoogte: Groot
```

### Product Landing Page
```
Activeren: ✓
Tonen op: Alle pagina's
Titel: Ontdek onze nieuwe collectie
Layout: Gecentreerd
Achtergrond afbeelding: [hero-bg.jpg]
Overlay opacity: 60%
Tekstkleur: #ffffff
Button 1 stijl: Light
Hoogte: Volledig scherm
```

## Support
Voor vragen of problemen, raadpleeg de theme documentatie of neem contact op met ApiCentraal support.
