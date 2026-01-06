# Site Titel / Logo Styling - Gebruikershandleiding

## Overzicht
De site titel (tekst logo) is nu volledig aanpasbaar via de WordPress Customizer. Dit geeft gebruikers volledige controle over hoe de site naam wordt weergegeven in de navigatiebalk.

**Let op:** Deze instellingen zijn alleen actief wanneer er **geen** custom logo afbeelding is geüpload. Om deze functionaliteit te gebruiken, verwijder eerst eventuele logo afbeeldingen via Uiterlijk → Aanpassen → Site-identiteit.

## Waar te vinden
**WordPress Admin → Uiterlijk → Aanpassen → Site Titel / Logo Styling**

## Beschikbare Opties

### Typografie
- **Lettertype**: Kies uit beschikbare Google Fonts, Microsoft fonts of system fonts
- **Lettergrootte**: 12-72px (standaard: 24px)
  - Responsive: past automatisch aan op kleinere schermen
- **Dikte**: Light (300) tot Black (900) - standaard Bold (700)
- **Tekst transformatie**:
  - Geen (origineel)
  - HOOFDLETTERS
  - kleine letters
  - Eerste Letter Hoofdletter
- **Letter spacing**: -5px tot 20px voor nauwkeurige spacing controle
  - Negatieve waarden: letters dichter bij elkaar
  - Positieve waarden: meer ruimte tussen letters

### Kleuren
- **Tekst kleur**: Primaire kleur van de site titel
- **Hover kleur**: Kleur wanneer muis over titel beweegt
- **Achtergrondkleur**: Optionele achtergrondkleur (voor badge/button effect)

### Layout & Effects
- **Padding**: 0-30px ruimte rondom de tekst
  - Vooral nuttig in combinatie met achtergrondkleur
- **Afronding hoeken**: 0-50px voor ronde hoeken
  - Creëert badge of pill effect
- **Tekst schaduw**: Subtiele schaduw voor depth
  - Automatisch toegepast als aangevinkt

### Mobiel
- **Mobiele lettergrootte**: Aparte grootte voor mobiele apparaten
  - Laat op 0 voor automatische aanpassing
  - Aanbevolen: 16-24px voor leesbaarheid

### Tagline (Slogan)
- **Tagline tonen**: Toon site tagline onder de titel
- **Tagline lettergrootte**: 8-24px (standaard: 12px)
- **Tagline bewerken**: Via Instellingen → Algemeen → Slogan

## Stijl Voorinstellingen

### Snel starten met presets
Kies een vooraf gedefinieerde stijl om direct te beginnen. Individuele instellingen overschrijven deze presets.

#### Beschikbare Presets:

**1. Minimalistisch**
- Light font weight (300)
- Uppercase
- Letter spacing: 2px
- Klein formaat (18px)
- Perfect voor: Clean, modern design

**2. Bold & Modern**
- Extra bold (900)
- Uppercase
- Groot formaat (32px)
- Negatieve letter spacing (-1px)
- Perfect voor: Statement, impact websites

**3. Elegant**
- Regular weight (400)
- Italic
- Medium formaat (28px)
- Lichte letter spacing (1px)
- Perfect voor: Luxe, premium brands

**4. Speels**
- Bold (700)
- Lowercase
- Medium formaat (26px)
- Ronde hoeken (8px)
- Perfect voor: Kinderwebsites, creatieve projecten

**5. Badge Stijl**
- Semi-bold (600)
- Padding + achtergrondkleur (primary)
- Wit tekstkleur
- Ronde hoeken (20px)
- Perfect voor: Call-to-action logo's

**6. Outlined**
- Bold (700)
- Border rondom
- Padding
- Lichte ronde hoeken (4px)
- Perfect voor: Retro, vintage designs

## Best Practices

### Leesbaarheid
- **Contrast**: Zorg voor voldoende contrast tussen tekst en achtergrond
- **Grootte**: Minimaal 16px op mobiel, 20-24px op desktop
- **Font weight**: Gebruik minimaal 500 voor kleine letters, 600-700 voor hoofdletters

### Mobiele Optimalisatie
- Test altijd op verschillende schermformaten
- Gebruik mobiele lettergrootte voor betere controle
- Houd tekst kort (max 25 karakters aanbevolen)

### Tagline Gebruik
- Houd tagline kort (max 50 karakters)
- Gebruik alleen als het waarde toevoegt
- Test of het niet te druk wordt in de navbar

### Performance
- Gebruik system fonts voor snelste laadtijd
- Google Fonts worden automatisch geoptimaliseerd
- Alle styling is CSS-based (geen afbeeldingen = sneller)

## Voorbeelden

### Corporate/Professional
```
Lettertype: Open Sans / Inter
Grootte: 24px
Dikte: 600 (Semi-Bold)
Transformatie: Geen
Letter spacing: 0px
Kleur: #2c3e50
Hover: #3498db
```

### Creatief/Playful
```
Preset: Speels
Lettertype: Fredoka / Comic Sans MS
Grootte: 26px
Achtergrondkleur: #ff6b6b
Tekstkleur: #ffffff
Afronding: 12px
Padding: 8px
```

### Minimalistisch/Modern
```
Preset: Minimalistisch
Lettertype: Montserrat
Grootte: 18px
Dikte: 300 (Light)
Transformatie: Uppercase
Letter spacing: 3px
Kleur: #1a1a1a
```

### Luxe/Elegant
```
Preset: Elegant
Lettertype: Playfair Display
Grootte: 30px
Dikte: 400 (Regular)
Kleur: #8b7355
Letter spacing: 1px
Tekst schaduw: ✓
```

## Live Preview

Alle wijzigingen zijn **direct zichtbaar** in de Customizer preview (behalve font family en preset - deze vereisen refresh).

Dit betekent dat je:
- Kleur en grootte aanpassingen onmiddellijk ziet
- Verschillende spacing/padding waarden kunt testen
- Hover effecten kunt bekijken
- Mobiele weergave kunt controleren (met responsive preview)

## Technische Details

### CSS Classes
De volgende classes worden gebruikt:
- `.navbar-brand`: Container voor het logo
- `.site-title`: De site naam zelf
- `.site-tagline`: De tagline (indien getoond)

### Custom CSS Toevoegen
Voor gevorderde aanpassingen, gebruik Custom CSS:
```css
/* Gradient text effect */
.navbar-brand .site-title {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Animation on hover */
.navbar-brand:hover .site-title {
    transform: scale(1.05);
}

/* Shadow on scroll */
.sticky-top .navbar-brand .site-title {
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
```

### Customizer Settings
Alle instellingen worden opgeslagen als theme mods:
- `fwp_site_title_font`
- `fwp_site_title_font_size`
- `fwp_site_title_font_weight`
- `fwp_site_title_text_transform`
- `fwp_site_title_letter_spacing`
- `fwp_site_title_color`
- `fwp_site_title_hover_color`
- `fwp_site_title_bg_color`
- `fwp_site_title_padding`
- `fwp_site_title_border_radius`
- `fwp_site_title_text_shadow`
- `fwp_site_title_preset`
- `fwp_site_title_mobile_size`
- `fwp_show_tagline`
- `fwp_tagline_font_size`

## Compatibility

### Met Custom Logo Afbeeldingen
- Tekst logo instellingen worden **genegeerd** als een logo afbeelding is geüpload
- Verwijder de logo afbeelding om tekst styling te gebruiken
- Beide kunnen niet tegelijk actief zijn

### Met Child Themes
- Child themes kunnen deze instellingen overschrijven via CSS
- Custom presets kunnen toegevoegd worden in child theme's `functions.php`
- Alle settings zijn beschikbaar via `get_theme_mod()`

### Browser Support
- Alle moderne browsers (Chrome, Firefox, Safari, Edge)
- IE11: basis ondersteuning (geen gradient effects)
- Mobiele browsers: volledige ondersteuning

## Troubleshooting

### "Mijn wijzigingen zijn niet zichtbaar"
1. Check of er een custom logo afbeelding actief is
2. Clear browser cache (Ctrl+F5 / Cmd+Shift+R)
3. Check of cache plugin actief is → clear WordPress cache

### "Font wordt niet geladen"
1. Check internetverbinding (Google Fonts vereist online)
2. Kies een alternatief font family
3. Gebruik system fonts als fallback

### "Tagline wordt niet getoond"
1. Controleer of tagline is ingevuld (Instellingen → Algemeen)
2. Check of "Tagline tonen" is aangevinkt
3. Verify dat er geen custom logo afbeelding actief is

### "Tekst is onleesbaar"
1. Pas contrast aan (tekst vs achtergrond)
2. Vergroot lettergrootte
3. Verhoog font weight
4. Verwijder tekst schaduw

## Support
Voor verdere vragen of problemen, raadpleeg de theme documentatie of neem contact op met ApiCentraal support.
