# FectionWP Pro - Release v1.1.0

**Release Date:** January 6, 2026  
**Git Tag:** v1.1.0

## 📦 Downloads

### Parent Theme
- **Bestand:** `fectionwp-pro-v1.1.0.zip` (281 KB)
- **Installatie:** WordPress Admin → Appearance → Themes → Add New → Upload Theme

### Child Theme (The Funky Face Paint)
- **Bestand:** `fectionwp-pro-tffp-v1.1.0.zip` (41 KB)
- **Installatie:** Upload na parent theme, activeer child theme

## 🎉 Nieuwe Features

### Hero/Header Banner Systeem
Volledig configureerbaar via **Appearance → Customize → Hero / Header Banner**

**Content Opties:**
- Titel, subtitel, beschrijving (HTML support)
- Twee CTA buttons met eigen tekst, URL en Bootstrap stijlen
- Featured image en background image support

**Styling Opties:**
- Achtergrondkleur, tekstkleur, overlay opacity (0-100%)
- 5 hoogte opties: Small (300px), Medium (500px), Large (700px), Full viewport, Auto
- 4 layout types: Centered, Left-aligned, Split-left, Split-right
- Container types: container, container-fluid, container-xxl

**Weergave Controle:**
- Display rules: Alle pagina's, alleen homepage, alleen pages, alleen posts
- Per-pagina meta box om hero uit te schakelen
- Live preview in Customizer

### Site Title/Logo Styling Systeem
Uitgebreide text logo styling via **Appearance → Customize → Site Titel / Logo Styling**

**Typografie:**
- Font family, size (12-72px), weight, text transform, letter spacing
- Mobile-specifieke font size
- Tagline support met eigen font size (8-24px)

**Kleuren & Effecten:**
- Text color met hover state
- Optionele achtergrondkleur (badge effect)
- Padding (0-30px) en border radius (0-50px)
- Text shadow toggle

**6 Style Presets:**
1. **Minimal** - Light, uppercase, spaced
2. **Bold & Modern** - Heavy, large, tight
3. **Elegant** - Italic, medium, spaced
4. **Playful** - Bold, rounded corners
5. **Badge** - Padded, background, rounded
6. **Outlined** - Border, padding

*Note:* Text logo styling werkt alleen als er geen custom logo image is geüpload.

## 📚 Documentatie Verbeteringen

### Enhanced AI Agent Documentation
- **Bestand:** `.github/copilot-instructions.md` (558 regels)
- **Nieuwe secties:**
  - Block Editor Patterns & Gutenberg Development
  - Plugin Integration Hooks & APIs
  - Performance Optimization
  - Testing Workflows
  - Hero Section Configuration Workflow
  - Site Title/Logo Styling Workflow

### User Guides
Twee nieuwe complete gebruikershandleidingen:
- Hero Section configuratie en best practices
- Logo Styling opties en voorbeelden

## 🔧 Technische Verbeteringen

### Customizer Enhancements
- **Live Preview JavaScript:** Real-time updates voor alle hero en logo instellingen
- **Sanitization Functions:** Robuuste validatie voor alle nieuwe instellingen
- **Backward Compatibility:** Bestaande hero widget area blijft functioneel
- **Performance:** Geen extra HTTP requests, inline CSS injection

### CSS Improvements
- **Hero Classes:** `.fwp-hero` met modifiers voor alle layouts en hoogtes
- **Logo Classes:** `.site-title`, `.site-tagline` met responsive design
- **Bootstrap Integration:** Alle layouts gebruiken Bootstrap 5.3 grid systeem
- **CSS Variables:** Design tokens voor eenvoudige customization

### PHP Improvements
**Nieuwe Helper Functions:**
- `fwp_should_display_hero()` - Display logic voor hero sectie
- `fwp_render_hero()` - Complete HTML generatie voor hero
- `fwp_build_site_title_css()` - Dynamische CSS generatie voor logo
- `fwp_get_title_preset_css()` - Preset stijlen laden
- Meta box functies voor per-pagina hero controle

**Template Integration:**
- `header.php` integratie met fallback naar widget area
- Responsive design met automatische mobile adjustments

## 🎨 Child Theme Features (TFFP)

### Template Structuur
**Pagina Templates:**
- `front-page.php` - Homepage met custom layout
- `page-kinderfeestjes.php` - Kinderfeestjes pagina
- `page-festivals.php` - Festivals & evenementen
- `page-galerij.php` - Foto galerij met lightbox
- `page-glitter.php` - Glitter tattoos showcase
- `page-cadeaubon.php` - Cadeaubon pagina
- `page-contact.php` - Contact formulier
- `page-booking-confirmation.php` - Booking bevestiging
- `page-booking-cancelled.php` - Booking annulering

### Template Parts (template-parts/tffp/)
- `hero.php` - Custom hero sectie voor TFFP
- `kinderfeestjes.php` - Kinderfeestjes content sectie
- `festivals.php` - Festivals content sectie
- `galerij.php` - Galerij grid layout
- `glitter.php` - Glitter tattoos showcase
- `cadeaubon.php` - Cadeaubon informatie
- `contact.php` - Contact formulier integratie
- `testimonials.php` - Klant reviews carousel
- `stats.php` - Statistieken sectie
- `locations.php` - Locatie informatie
- `whatsapp-fab.php` - WhatsApp floating action button

### Styling Assets
**CSS Files:**
- `tffp.css` - Hoofd stylesheet met custom componenten
- `tffp-tokens.css` - Design tokens (OKLCH kleuren met sRGB fallbacks)
- `tffp-pbp-overrides.css` - FectionWP-Booking plugin styling overrides

**JavaScript Files:**
- `tffp-gallery.js` - Galerij lightbox functionaliteit
- `tffp-contact.js` - Contact formulier validatie

### Design System
**OKLCH Kleuren** (met hex fallbacks):
- Primary: `oklch(0.65 0.25 340)` - Magenta/roze
- Background: `oklch(0.995 0.01 90)` - Warm wit
- Modern color space met backward compatibility

**Typografie:**
- Heading Font: Fredoka (cursive, playful)
- Body Font: Inter (sans-serif, clean)

**Border Radius:**
- Consistent 1rem (16px) voor alle componenten

## 🔄 WordPress Migration Support

### TFFP Migratie Context
Child theme specifiek gebouwd voor **The Funky Face Paint** migratie van React/Vite naar WordPress.

**Migration Features:**
- Bootstrap-first refactor (Tailwind → Bootstrap 5.3)
- Server-side rendering (React SPA → WordPress templates)
- Component mapping (React components → PHP template parts)
- Asset optimization (bundled → CDN + minimal custom CSS)
- SEO improvements (client-side routing → WordPress permalinks)

**Migration Documentatie:**
- `MIGRATION_THE_FUNKY_FACE_PAINT.md` - Comprehensive plan
- `MIGRATION_TASKBOARD_THE_FUNKY_FACE_PAINT.md` - Ticket breakdown
- `MIGRATION_CHECKLIST_THE_FUNKY_FACE_PAINT.md` - Definition of Done tracking

## 📋 Systeemvereisten

- **WordPress:** 6.0 of hoger
- **PHP:** 8.1 of hoger (parent theme), 8.1+ aanbevolen (child theme)
- **Bootstrap:** 5.3.4 (via CDN, automatisch geladen)
- **Browsers:** 
  - Chrome/Edge 90+
  - Safari 15+
  - Firefox 90+
  - Geen IE11 support (Bootstrap 5 vereiste)

## 🚀 Installatie Instructies

### Parent Theme Installatie
1. Download `fectionwp-pro-v1.1.0.zip`
2. WordPress Admin → Appearance → Themes → Add New
3. Klik "Upload Theme" en selecteer het zip bestand
4. Klik "Install Now"
5. Activeer het theme (of wacht tot child theme installatie)

### Child Theme Installatie (TFFP)
1. **Vereiste:** Parent theme moet eerst geïnstalleerd zijn
2. Download `fectionwp-pro-tffp-v1.1.0.zip`
3. WordPress Admin → Appearance → Themes → Add New
4. Upload child theme zip bestand
5. **Activeer child theme** (niet parent theme)
6. Verifieer: Dashboard moet "FectionWP Pro – TFFP" tonen als actief theme

### Post-Installatie Configuratie

**Hero Sectie Activeren:**
1. Appearance → Customize → Hero / Header Banner
2. Check "Display Hero Section"
3. Configureer content, kleuren, en layout
4. Selecteer display rules
5. Klik "Publish"

**Logo Styling Aanpassen:**
1. Appearance → Customize → Site Titel / Logo Styling
2. Kies een preset of custom instellingen
3. Pas typografie en kleuren aan
4. Preview in real-time
5. Klik "Publish"

**TFFP Specifieke Setup:**
1. Upload TFFP logo via Appearance → Customize → Site Identity
2. Configureer kleuren in `tffp-tokens.css` indien nodig
3. Test alle pagina templates (kinderfeestjes, festivals, etc.)
4. Verifieer WhatsApp FAB werkt op mobiele devices

## 🔌 Plugin Integratie

### FectionWP-Booking Plugin
**Shortcode:** `[pbp_booking_form]`

**Styling Overrides:**
- `assets/css/tffp-pbp-overrides.css` past booking formulier aan
- Matcht TFFP design tokens (kleuren, border radius, fonts)
- Automatisch geladen wanneer shortcode aanwezig is

### Contact Form 7
- Bootstrap 5 styling automatisch toegepast
- `.row` en `.col-*` classes voor responsive forms
- Custom validation styling

### WooCommerce (optioneel)
- Cart/checkout templates met Bootstrap containers
- Form field styling met Bootstrap classes
- Pagination met Bootstrap markup

## 🐛 Known Issues

Geen bekende issues voor deze release.

## 🔜 Roadmap

**Volgende releases:**
- Visual Builder integratie diepgang
- Aanvullende block patterns
- WooCommerce product page templates
- Performance optimization plugins
- A/B testing voor hero variants

## 📞 Support & Documentatie

- **GitHub Repository:** https://github.com/ApiCentraal/FectionWP-Pro
- **Issues:** https://github.com/ApiCentraal/FectionWP-Pro/issues
- **Documentation:** Zie README.md en guide bestanden in releases folder
- **AI Agent Docs:** `.github/copilot-instructions.md` voor development

## 🙏 Credits

- **Bootstrap:** v5.3.4 by Twitter
- **WordPress:** Theme volgt WordPress Coding Standards
- **PHP_CodeSniffer:** Code quality met WPCS
- **Google Fonts:** Fredoka & Inter typografie

## 📝 Changelog

### v1.1.0 (January 6, 2026)
- ✨ Hero/Header Banner systeem met Customizer integratie
- ✨ Site Title/Logo styling met 6 presets
- ✨ Live preview voor hero en logo customization
- ✨ Per-pagina hero controle via meta boxes
- 📚 Enhanced AI agent documentation (4 nieuwe secties)
- 📚 User guides voor hero en logo features
- 🔧 Dynamic CSS generation voor logo styling
- 🔧 Sanitization functions voor alle nieuwe settings
- 🐛 Backward compatibility behouden
- 🎨 Child theme TFFP complete template structuur

### v1.0.0 (January 6, 2026)
- 🎉 Eerste stable release
- 🎨 Bootstrap 5.3 integratie
- 📦 Example pages systeem
- 🔌 Plugin integration hooks
- 🎯 Gutenberg patterns

### v0.1.2 (Previous)
- Beta release met basis functionaliteit

---

**Download Links:**
- Parent Theme: `releases/fectionwp-pro-v1.1.0.zip`
- Child Theme: `releases/fectionwp-pro-tffp-v1.1.0.zip`

**Git Tag:** `v1.1.0`
