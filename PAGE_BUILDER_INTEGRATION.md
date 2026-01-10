# Page Builder Integratie - FectionWP Pro

## Overzicht

FectionWP Pro biedt complete ondersteuning voor de populairste WordPress page builders. Deze integratie zorgt voor naadloze compatibiliteit tussen het Bootstrap 5.3 theme framework en visual editors.

## Ondersteunde Page Builders

### ✅ Volledig Ondersteund

1. **Elementor** (gratis & Pro)
2. **Divi Builder** (Elegant Themes)
3. **Beaver Builder** (gratis & Pro)
4. **WPBakery Page Builder** (voorheen Visual Composer)
5. **Oxygen Builder**
6. **Brizy Builder**
7. **Thrive Architect**
8. **Gutenberg** (WordPress Block Editor) - uitgebreid

## Functionaliteit per Builder

### Elementor

**Geïntegreerde features:**
- ✅ Theme locations registratie
- ✅ Container breedte synchronisatie (1320px - Bootstrap XXL)
- ✅ Bootstrap kleurenpalet in Elementor interface
- ✅ Theme fonts synchronisatie
- ✅ Canvas template support
- ✅ Bootstrap grid optie voor sections

**Gebruik:**
1. Installeer Elementor via WordPress plugin directory
2. Activeer het thema - integratie is automatisch
3. Bootstrap kleuren zijn beschikbaar in het kleurenpalet
4. Canvas templates gebruiken automatisch full-width layout

**CSS variabelen:**
```css
--bs-primary → Elementor "Bootstrap Primary"
--bs-secondary → Elementor "Bootstrap Secondary"
--bs-success → Elementor "Bootstrap Success"
--bs-danger → Elementor "Bootstrap Danger"
--bs-warning → Elementor "Bootstrap Warning"
--bs-info → Elementor "Bootstrap Info"
```

### Divi Builder

**Geïntegreerde features:**
- ✅ Theme support declaratie
- ✅ Container breedte aanpassing (1320px)
- ✅ Bootstrap grid compatibiliteit
- ✅ Kleur synchronisatie met Customizer
- ✅ Divi's eigen Bootstrap uitgeschakeld (voorkomt conflicten)

**Gebruik:**
1. Installeer Divi theme of Divi Builder plugin
2. Activeer FectionWP Pro - Divi herkent automatisch de ondersteuning
3. Theme kleuren worden gesynchroniseerd met Divi's accent color
4. Bestaande Divi content kan worden geconverteerd met `inc/import-converter.php`

**Conversie van Divi naar FWP:**
```bash
# Via WP-CLI
php inc/import-converter.php export.xml

# Genereert:
# - funky-facepainter-import.php (import script)
# - funky-facepainter-report.md (conversie rapport)
```

### Beaver Builder

**Geïntegreerde features:**
- ✅ Content full-width support
- ✅ Theme Builder headers/footers/parts
- ✅ Container breedte synchronisatie
- ✅ Bootstrap grid optie voor rows
- ✅ Kleurenpalet synchronisatie

**Gebruik:**
1. Installeer Beaver Builder (lite of pro)
2. Theme support wordt automatisch herkend
3. Bootstrap kleuren verschijnen in het kleurenpalet
4. Gebruik `use_bootstrap_grid` setting voor Bootstrap layouts

### WPBakery Page Builder

**Geïntegreerde features:**
- ✅ Theme mode activatie (vermindert notices)
- ✅ Frontend editor support
- ✅ Content area width (1320px)
- ✅ Bootstrap container klassen op rows
- ✅ Custom CSS met theme variabelen

**Gebruik:**
1. Installeer WPBakery Page Builder plugin
2. Theme wordt automatisch als compatible herkend
3. Rows krijgen automatisch `.container` class
4. Custom CSS gebruikt `--vc-primary-color` variabele

### Oxygen Builder

**Geïntegreerde features:**
- ✅ Theme support declaratie
- ✅ Content width synchronisatie
- ✅ CSS variabelen voor alle Bootstrap kleuren
- ✅ Theme CSS disable voor Oxygen templates

**Gebruik:**
1. Installeer Oxygen Builder
2. Theme support is automatisch actief
3. Gebruik CSS variabelen: `--oxy-primary`, `--oxy-secondary`, etc.
4. Oxygen templates overschrijven theme styling

### Brizy Builder

**Geïntegreerde features:**
- ✅ Theme support
- ✅ Container max-width (1320px)
- ✅ Bootstrap CSS variabelen

**Gebruik:**
1. Installeer Brizy Builder
2. Container breedte wordt automatisch gesynchroniseerd
3. Gebruik `--brz-primary` en `--brz-secondary` in custom CSS

### Thrive Architect

**Geïntegreerde features:**
- ✅ Theme support declaratie
- ✅ Content width synchronisatie
- ✅ Bootstrap kleuren in style family config

**Gebruik:**
1. Installeer Thrive Architect
2. Theme kleuren worden automatisch geïntegreerd
3. Bootstrap primary, secondary, success en danger kleuren beschikbaar

### Gutenberg (Block Editor)

**Uitgebreide features:**
- ✅ Bootstrap kleurenpalet (8 kleuren)
- ✅ Bootstrap typografie schaal (5 sizes)
- ✅ Custom kleuren toegestaan
- ✅ Custom font sizes toegestaan
- ✅ Editor content width (1320px)

**Gebruik:**
1. Automatisch actief in WordPress
2. Kleurenpalet bevat alle Bootstrap kleuren
3. Font sizes: Small (14px) tot Extra Large (32px)
4. Ideaal voor content-gerichte pagina's

## Automatische Detectie

### Builder Detection

Het theme detecteert automatisch welke builder actief is:

```php
// Check of een builder actief is
if (fwp_is_page_builder_active()) {
    // Algemene builder aanwezig
}

// Check welke builder op huidige pagina wordt gebruikt
$builder = fwp_is_page_builder_used();
// Returns: 'elementor', 'divi', 'beaver', 'wpbakery', 'oxygen', 'brizy', 'thrive', of false
```

### Body Classes

Pagina's met active builders krijgen automatisch classes:
```html
<body class="fwp-page-builder-active fwp-builder-elementor">
```

### Layout Aanpassingen

Voor builder pagina's wordt automatisch:
- Sidebar uitgeschakeld
- Full-width container gebruikt
- Theme padding verwijderd
- Container klassen aangepast

## Kleur Synchronisatie

### Customizer → Builders

Theme kleuren uit de Customizer worden automatisch gesynchroniseerd:

**Customizer locatie:**
```
Appearance → Customize → Colors → Bootstrap Theme Colors
```

**Beschikbare kleuren:**
- Primary (default: #0d6efd)
- Secondary (default: #6c757d)
- Success (default: #198754)
- Danger (default: #dc3545)
- Warning (default: #ffc107)
- Info (default: #0dcaf0)
- Light (default: #f8f9fa)
- Dark (default: #212529)

**Wanneer gesynchroniseerd:**
- Bij theme activatie
- Bij Customizer save
- Bij builder initialisatie

## CSS Compatibiliteit

### Automatische Fixes

Het theme bevat CSS fixes voor:
- Uitgeschakelde padding op `.site-main`
- Full-width `.entry-content`
- Stretched sections (Elementor)
- Row margins (WPBakery)
- Bootstrap grid compatibiliteit

### Custom CSS Toevoegen

Voor builder-specifieke styling:

```css
/* Alleen voor Elementor pagina's */
.fwp-builder-elementor .custom-class {
    /* styles */
}

/* Alleen voor Divi pagina's */
.fwp-builder-divi .custom-class {
    /* styles */
}

/* Voor alle builder pagina's */
.fwp-page-builder-active .custom-class {
    /* styles */
}
```

## Admin Features

### Admin Notice

Bij eerste activatie verschijnt een notice:
```
FectionWP Pro: Page builder ondersteuning geactiveerd! 
Bootstrap kleuren en instellingen zijn gesynchroniseerd.
```

### Admin Bar Indicator

Op builder pagina's toont de admin bar een indicator:
```
[Layout Icon] Elementor
```

Gebruik: Snel zien welke builder actief is op de huidige pagina.

## Troubleshooting

### Container Breedte Klopt Niet

**Probleem:** Builder gebruikt niet de juiste container breedte.

**Oplossing:**
1. Ga naar builder settings
2. Zoek naar "content width" of "container width"
3. Stel in op 1320 (pixels)
4. Of laat theme automatisch synchroniseren bij reload

### Kleuren Worden Niet Gesynchroniseerd

**Probleem:** Theme kleuren verschijnen niet in builder.

**Oplossing:**
1. Sla een willekeurige setting op in Customizer
2. Deactiveer en reactiveer het theme
3. Clear builder cache (indien beschikbaar)
4. Herlaad builder editor

### Sidebar Verschijnt op Builder Pagina

**Probleem:** Theme sidebar interfereert met builder layout.

**Oplossing:**
- Automatisch: Theme detecteert builder en schakelt sidebar uit
- Manueel: Kies "Full Width" template in page attributes
- Check: `fwp_is_page_builder_used()` moet true returnen

### Bootstrap Conflicteert met Builder CSS

**Probleem:** Builder styling wordt overschreven door Bootstrap.

**Oplossing:**
1. Voor Divi: Divi's eigen Bootstrap wordt automatisch uitgeschakeld
2. Voor andere builders: Gebruik specifieke CSS classes
3. Builder CSS heeft meestal hogere specificiteit
4. Check conflict in browser DevTools

### Full-Width Werkt Niet in Elementor

**Probleem:** Stretched sections zijn niet full-width.

**Oplossing:**
```css
/* Voeg toe aan custom CSS */
.elementor-section-stretched {
    width: 100vw !important;
    left: 50% !important;
    margin-left: -50vw !important;
}
```

## Performance Overwegingen

### Builder Assets

Builders laden hun eigen assets. Om performance te optimaliseren:

1. **Gebruik builder's asset optimization:**
   - Elementor: Settings → Performance
   - Beaver Builder: Settings → Performance
   - WPBakery: Disable unused elements

2. **Minimaliseer unused features:**
   - Schakel widgets/modules uit die je niet gebruikt
   - Gebruik builder's minification opties

3. **Caching:**
   - Gebruik caching plugin (WP Rocket, W3 Total Cache)
   - Clear cache na builder wijzigingen
   - Builder-specific cache clearing indien beschikbaar

### Bootstrap Loading

Theme laadt Bootstrap 5.3 via CDN. Builders laden mogelijk eigen frameworks:
- Divi: Eigen builder framework (Bootstrap uitgeschakeld door theme)
- Elementor: Geen Bootstrap conflict
- Beaver Builder: Eigen grid systeem (compatibel)
- WPBakery: Bootstrap 3 (conflict mogelijk - theme helpt)

## Development Hooks

### Filters

```php
// Wijzig container type voor builders
add_filter('fwp_container_type', function($type) {
    if (fwp_is_page_builder_used()) {
        return 'container-fluid';
    }
    return $type;
});

// Verberg sidebar voor specifieke builder
add_filter('fwp_show_sidebar', function($show) {
    if (fwp_is_page_builder_used() === 'elementor') {
        return false;
    }
    return $show;
});

// Custom body classes
add_filter('body_class', function($classes) {
    if (fwp_is_page_builder_used()) {
        $classes[] = 'my-custom-builder-class';
    }
    return $classes;
});
```

### Actions

```php
// Na builder initialisatie
add_action('elementor/init', function() {
    // Custom Elementor setup
});

// Voor builder rendering
add_action('fl_builder_before_render_content', function() {
    // Custom Beaver Builder setup
});
```

## Best Practices

### 1. Builder Keuze

- **Content-heavy sites:** Gutenberg (snelst, best SEO)
- **Landing pages:** Elementor, Beaver Builder
- **Advanced layouts:** Oxygen, Divi
- **Bestaande Divi site:** Gebruik converter tool

### 2. Bootstrap Integratie

✅ **Wel doen:**
- Gebruik Bootstrap kleuren via Customizer
- Sync kleuren na wijzigingen
- Test op mobiel (Bootstrap breakpoints)
- Gebruik Bootstrap utilities in custom CSS

❌ **Niet doen:**
- Bootstrap classes mengen met builder's eigen grid
- Inline styles gebruiken (gebruik CSS variabelen)
- Theme Bootstrap uitschakelen
- Builder's container width handmatig overschrijven

### 3. Performance

- Gebruik builder's native components waar mogelijk
- Minimaliseer custom CSS
- Test pagina snelheid met GTmetrix/Lighthouse
- Enable builder asset optimization

### 4. Onderhoud

- Update builders regelmatig
- Test na theme updates
- Clear cache na wijzigingen
- Backup voor grote wijzigingen

## Migratie van Andere Themes

### Van Divi Theme naar FectionWP Pro

```bash
# 1. Export Divi site
# WordPress Admin → Tools → Export → Pages

# 2. Converteer met converter tool
php inc/import-converter.php export.xml

# 3. Importeer met WP-CLI
wp eval-file funky-facepainter-import.php

# 4. Activeer FectionWP Pro
# 5. Review en test alle pagina's
```

### Van Elementor Theme naar FectionWP Pro

1. Backup site volledig
2. Activeer FectionWP Pro
3. Test Elementor pagina's - blijven werken
4. Pas kleuren aan in Customizer
5. Heractiveer Elementor om sync te forceren

### Van Genesis naar FectionWP Pro + Builder

1. Export content (WordPress → Tools → Export)
2. Activeer FectionWP Pro
3. Installeer gewenste builder
4. Herbouw layouts met builder
5. Redirect oude URL's indien nodig

## FAQ

**Q: Kan ik meerdere builders tegelijk gebruiken?**
A: Technisch wel, maar niet aanbevolen. Kies één builder voor consistentie en performance.

**Q: Werkt de conversie tool voor alle Divi sites?**
A: De tool converteert common Divi modules. Complex custom Divi modules vereisen handmatige aanpassing.

**Q: Moet ik Bootstrap kennen om builders te gebruiken?**
A: Nee, builders hebben drag-drop interfaces. Bootstrap kennis helpt wel voor custom CSS.

**Q: Conflicteert FectionWP Visual Builder met deze builders?**
A: Nee, FectionWP Visual Builder is complementair. Je kunt kiezen welke je per pagina gebruikt.

**Q: Kan ik theme kleuren wijzigen na builder setup?**
A: Ja, wijzig in Customizer en sla op. Builders synchroniseren automatisch bij reload.

**Q: Werken builder templates met dit theme?**
A: Ja, alle builder templates (headers, footers, popups) worden ondersteund.

## Support

Voor vragen over page builder integratie:
- Check FectionWP Pro documentatie
- Bezoek builder's eigen documentatie
- Neem contact op via support kanalen
- Check WordPress.org forums

## Changelog

### v1.1.0 (2024)
- ✨ Initiële release page builder integratie
- ✅ Ondersteuning voor 7 populaire builders
- ✅ Automatische kleur/font synchronisatie
- ✅ Divi naar FWP converter tool
- ✅ Admin indicators en notices
- ✅ CSS compatibiliteit fixes
- ✅ Uitgebreide documentatie

---

**FectionWP Pro** - Bootstrap 5.3 WordPress Theme met Visual Builder Integratie
