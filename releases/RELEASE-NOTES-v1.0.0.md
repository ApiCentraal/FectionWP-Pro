# FectionWP Pro - Release v1.0.0

**Release Date:** January 6, 2026  
**Git Tag:** v1.0.0

## 📦 Download

- **Parent Theme:** `fectionwp-pro-v1.0.0.zip` (281 KB)
- **Child Theme (TFFP):** `fectionwp-pro-tffp-v1.0.0.zip` (41 KB)

## 🎉 Major Features

### Hero/Header Banner System
- **Customizer Integration:** Appearance → Customize → Hero / Header Banner
- **Content Controls:** Title, subtitle, description with HTML support
- **Dual CTA Buttons:** Customizable text, URLs, and Bootstrap button styles
- **Image Support:** Featured image and background image options
- **Styling Options:** Background color, text color, overlay opacity (0-100%)
- **5 Height Options:** Small (300px), Medium (500px), Large (700px), Full viewport, Auto
- **4 Layout Types:** Centered, Left-aligned, Split-left, Split-right
- **Container Options:** container, container-fluid, container-xxl
- **Display Rules:** All pages, homepage only, pages only, posts only
- **Per-Page Control:** Meta box to disable hero on specific pages
- **Live Preview:** Real-time updates in Customizer

### Site Title/Logo Styling System
- **Typography Controls:** Font family, size (12-72px), weight, transform, letter spacing
- **Color Options:** Text color with hover state, optional background color
- **Visual Effects:** Padding (0-30px), border radius (0-50px), text shadow
- **Mobile Responsive:** Separate mobile font size
- **Tagline Support:** Show/hide with adjustable font size (8-24px)
- **6 Style Presets:**
  - Minimal (light, uppercase, spaced)
  - Bold & Modern (heavy, large, tight)
  - Elegant (italic, medium, spaced)
  - Playful (bold, rounded corners)
  - Badge (padded, background, rounded)
  - Outlined (border, padding)
- **Live Preview:** Instant visual feedback in Customizer

## 📚 Documentation

### Enhanced AI Agent Documentation
- **File:** `.github/copilot-instructions.md` (558 lines)
- **New Sections:**
  - Block Editor Patterns & Gutenberg Development
  - Plugin Integration Hooks & APIs (FectionWP-Booking, Visual Builder, Blocks)
  - Performance Optimization (asset loading, caching, security)
  - Testing Workflows (PHP code quality, manual testing, browser testing)
  - Hero Section Workflow
  - Site Title/Logo Styling Workflow

### User Guides
- `HERO_SECTION_GUIDE.md` - Complete guide for hero section configuration
- `SITE_TITLE_LOGO_GUIDE.md` - Complete guide for logo styling options

## 🔧 Technical Improvements

### Customizer Enhancements
- **Live Preview JavaScript:** Real-time updates for hero and logo settings
- **Sanitization Functions:** Robust validation for all new settings
- **Backward Compatibility:** Existing hero widget area still functional
- **Performance:** No additional HTTP requests, inline CSS injection

### CSS Improvements
- **Hero Classes:** `.fwp-hero` with modifiers for all layouts and heights
- **Logo Classes:** `.site-title`, `.site-tagline` with responsive design
- **Bootstrap Integration:** All layouts use Bootstrap grid system
- **CSS Variables:** Design tokens for easy customization

### PHP Improvements
- **Helper Functions:** 
  - `fwp_should_display_hero()` - Display logic
  - `fwp_render_hero()` - HTML generation
  - `fwp_build_site_title_css()` - Dynamic CSS generation
  - `fwp_get_title_preset_css()` - Preset styles
- **Meta Boxes:** Per-page hero control
- **Template Integration:** header.php integration with fallback support

## 🔄 Migration Support

- **TFFP Migration:** Child theme scaffold for The Funky Face Paint migration
- **Migration Docs:** Comprehensive guides in workspace root
- **Bootstrap-First:** All layouts follow Bootstrap 5.3 conventions
- **OKLCH Colors:** Modern color space with sRGB fallbacks

## 📋 Requirements

- **WordPress:** 6.0 or higher
- **PHP:** 8.1 or higher
- **Bootstrap:** 5.3.4 (loaded via CDN)
- **Browsers:** Modern browsers (Chrome 90+, Safari 15+, Firefox 90+)

## 📥 Installation

### Parent Theme
1. Download `fectionwp-pro-v1.0.0.zip`
2. WordPress Admin → Appearance → Themes → Add New → Upload Theme
3. Upload zip file and activate

### Child Theme (TFFP)
1. Ensure parent theme is installed first
2. Download `fectionwp-pro-tffp-v1.0.0.zip`
3. WordPress Admin → Appearance → Themes → Add New → Upload Theme
4. Upload zip file and activate child theme

## ⚙️ Configuration

### Hero Section Setup
1. Navigate to Appearance → Customize → Hero / Header Banner
2. Enable "Display Hero Section"
3. Configure content, images, colors, and layout
4. Set display rules (homepage, all pages, etc.)
5. Preview changes and publish

### Logo Styling Setup
1. Navigate to Appearance → Customize → Site Titel / Logo Styling
2. Adjust typography, colors, and effects
3. Try one of 6 presets or create custom styling
4. Preview changes and publish

**Note:** Logo styling only applies when no custom logo image is uploaded in Site Identity.

## 🐛 Known Issues

None reported for this release.

## 🔜 Coming Soon

- Visual Builder integration
- Additional block patterns
- WooCommerce deep integration
- Performance optimization plugins

## 📞 Support

- **GitHub Issues:** https://github.com/ApiCentraal/FectionWP-Pro/issues
- **Documentation:** See README.md and guide files in releases

## 🙏 Credits

- **Bootstrap:** v5.3.4 by Twitter
- **WordPress:** Theme follows WordPress coding standards
- **PHP_CodeSniffer:** Code quality with WPCS

---

**Previous Release:** v0.1.2  
**Changelog:** See git log for detailed commit history
