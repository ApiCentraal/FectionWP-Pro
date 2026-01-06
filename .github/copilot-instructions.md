# FectionWP Pro – Copilot Instructions

## Big Picture
WordPress theme serving as **parent theme** for client sites. Uses Bootstrap 5.3 as UI framework with extensive customization support. Designed to work with companion plugins (FectionWP-Booking, FectionWP-Visual-Builder, FectionWP-Blocks).

**Core Philosophy:**
- **Bootstrap-first**: All layouts use Bootstrap grid system (`container`, `row`, `col-*`)
- **Server-side rendering**: No SPA, WordPress generates HTML per request
- **Modular includes**: `functions.php` orchestrates includes from `/inc/` directory
- **CSS variables over inline styles**: Design tokens in CSS custom properties, Bootstrap vars overlayed
- **PHP 8.1+**: Uses modern PHP syntax (typed properties, arrow functions where applicable)
- **WordPress 6.0+**: Leverages block editor, theme.json, Full Site Editing capabilities

## Active Migration: The Funky Face Paint
A React/Vite site is being migrated to WordPress using this theme as parent. See migration docs in workspace root:
- `MIGRATION_THE_FUNKY_FACE_PAINT.md` (comprehensive plan)
- `MIGRATION_TASKBOARD_THE_FUNKY_FACE_PAINT.md` (ticket breakdown)
- `MIGRATION_CHECKLIST_THE_FUNKY_FACE_PAINT.md` (DoD tracking)

Child theme location: `child-theme/fectionwp-pro-tffp/` (must be deployed as separate theme folder in WordPress).

## Architecture & Bootstrap Philosophy

This theme is **Bootstrap-first** with a modular include system:
- Bootstrap 5.3 via CDN (customizable via theme options)
- All templates use Bootstrap grid (`container`, `row`, `col-*`)
- Custom styling via CSS variables overlaying Bootstrap vars
- No Tailwind in production (React migration source uses Tailwind → must refactor to Bootstrap)

Key principle: **Bootstrap semantics** for layouts, **CSS variables** for design tokens, **custom CSS** only for unique gradients/animations.

## Theme Structure & Entrypoints

```
FectionWP-Pro/
├─ functions.php        # Main bootstrap, hooks, includes
├─ inc/                 # Modular includes (security, customizer, widgets, etc.)
│  ├─ customizer.php    # Theme options (colors, layout, integrations)
│  ├─ shortcodes.php    # Bootstrap component shortcodes
│  ├─ examples.php      # Example page system (see below)
│  ├─ patterns-examples.php # Gutenberg patterns for examples
│  └─ widgets/          # Custom widgets (social, recent posts)
├─ template-parts/      # Reusable template parts
│  ├─ content-*.php     # Post/page content templates
│  ├─ examples/         # Example layouts (Hero, CTA, Services, etc.)
│  └─ tffp/            # TFFP child theme specific parts (if applicable)
├─ page-*.php          # Page templates (fullwidth, landing, sections, etc.)
├─ child-theme/        # Child theme scaffolds
│  └─ fectionwp-pro-tffp/  # TFFP migration child theme
└─ assets/             # CSS/JS/images
```

### functions.php (2692 lines) — Entry Point
Lines 1-100 show the include structure. Notable sections:
- **Lines 15-50**: Includes (navwalker, customizer, shortcodes, widgets, plugin integrations)
- **Lines 60-120**: `fwp_setup()` — registers theme supports, menus, image sizes
- **Lines 300-500**: Asset enqueuing (Bootstrap CDN + custom CSS/JS)
- **Lines 800-1000**: Security hardening (CSP, disable XML-RPC, rate limiting)
- **Lines 1500-1800**: Bootstrap shortcodes (alerts, badges, cards, buttons)
- **Lines 2000+**: Helper functions (template tags, URL sanitization)

### inc/examples.php — Example Page System
Unique feature: Create pages from pre-built example layouts.
- Shortcode: `[fwp_example name="example-slug"]` loads template from `template-parts/examples/{slug}.php`
- Admin UI: Appearance → Example Pages (preview + one-click page creation)
- Also registered as Gutenberg patterns for block inserter

Usage for TFFP migration: Reference these examples for Bootstrap layout patterns before building custom templates.

## Child Theme Development (TFFP Context)

### Setup Requirements
1. Child theme must be in `wp-content/themes/fectionwp-pro-tffp/` (separate from parent)
2. `style.css` must have `Template: fectionwp-pro` header (exact parent folder name)
3. Enqueue parent styles in child's `functions.php`:
   ```php
   wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
   ```

### Child Theme Workflow (TFFP Migration)
Located at: `child-theme/fectionwp-pro-tffp/`

**Design token override strategy:**
- File: `assets/css/tffp-tokens.css` (already scaffolded)
- Override Bootstrap vars using CSS custom properties:
  ```css
  :root {
    /* Hex fallbacks for older browsers */
    --bs-primary: #d946ef;
    --bs-body-bg: #fefdfb;
    
    /* OKLCH for modern browsers (Chrome 111+, Safari 15.4+, Firefox 113+) */
    --bs-primary: oklch(0.65 0.25 340);  /* TFFP primary */
    --bs-body-bg: oklch(0.995 0.01 90);  /* TFFP background */
    --bs-body-font-family: 'Inter', sans-serif;
    --bs-heading-font-family: 'Fredoka', cursive;
    --bs-border-radius: 1rem;  /* TFFP radius */
  }
  ```

**OKLCH note:** Browsers cascade to last valid declaration, so hex fallback is overridden when OKLCH is supported.

**Page template override:**
Create `page-{slug}.php` in child theme to override parent templates. Example:
- `page-kinderfeestjes.php` → handles `/kinderfeestjes/` route
- Load custom template parts from `template-parts/tffp/`

**Bootstrap-first refactor pattern (from Tailwind):**
1. Map layout: `container` + `row` + `col-{breakpoint}-{size}`
2. Replace Tailwind utilities with Bootstrap equivalents:
   - `pt-24` → `pt-5` or custom CSS if needed
   - `bg-gradient-to-r` → Bootstrap `.bg-gradient` or custom CSS
3. Component classes: `.card`, `.btn`, `.badge`, `.alert` (see `inc/shortcodes.php` for examples)
4. Custom gradients/animations: separate CSS file, not inline Tailwind

**Build tooling (optional):**
Child theme uses plain CSS by default (no build step required). If minification/bundling is desired:
```bash
# Optional Vite setup for child theme assets
cd child-theme/fectionwp-pro-tffp
npm init -y
npm install vite
# Configure vite.config.js to output to assets/
```
**Recommendation:** Start without build tools. Add only if performance profiling shows need.

## Block Editor Patterns & Gutenberg Development

### Pattern Registration System
Block patterns are registered via `inc/patterns-examples.php` using Bootstrap example templates:
```php
// Patterns wrap example shortcodes
register_block_pattern('fectionwp/example-heroes', array(
    'title'      => 'Example: Heroes',
    'categories' => array('fectionwp-examples'),
    'content'    => "<!-- wp:shortcode -->\n[fwp_example name=\"heroes\"]\n<!-- /wp:shortcode -->"
));
```

**Available in block inserter**: Search "Example: {name}" to insert pre-built layouts (Heroes, Grid, Album, Pricing, etc.)

### Custom Blocks (template-parts/blocks/)
Template parts accept query vars for dynamic content:
```php
// In template-parts/blocks/hero-centered.php
$title = get_query_var('block_title', 'Default Title');
$btn_text = get_query_var('block_btn_text', 'Get Started');

// Usage in page template
set_query_var('block_title', 'Welcome!');
get_template_part('template-parts/blocks/hero-centered');
```

**Block template parts**: `hero-centered.php`, `hero-split.php`, `cta.php`, `features-icons.php`, `pricing.php`, `testimonials.php`, `faq.php`, `stats.php`

### Gutenberg Customization
- **Editor styles**: `assets/css/editor-style.css` (loaded via `add_editor_style()`)
- **theme.json**: Defines Bootstrap color palette, typography scale, layout widths
- **Wide/full alignment**: Enabled via `add_theme_support('align-wide')`
- **Classic Editor fallback**: Page templates starting with `page-` force Classic Editor for shortcode compatibility

## Plugin Integration Hooks & APIs

### FectionWP-Booking Plugin
**Shortcode integration:**
```php
// Embed booking form
do_shortcode('[pbp_booking_form]')

// Check if plugin active
if (shortcode_exists('pbp_booking_form')) {
    // Load booking-specific CSS
}
```

**Conditional asset loading** (child theme pattern):
```php
// Only load overrides when booking form present
$has_booking_form = has_shortcode($post->post_content, 'pbp_booking_form');
if ($has_booking_form && file_exists($override_path)) {
    wp_enqueue_style('tffp-pbp-overrides', $override_url, ['pbp-styles'], filemtime($override_path));
}
```

**Customizer sync**: Theme mod `pbp_style_*` options allow syncing primary color/radius/fonts with plugin via Customizer

**Plugin CPTs**: `pbp_booking`, `pbp_service`, `pbp_staff` (access via `get_posts()` with `post_type` arg)

### FectionWP-Visual-Builder Plugin
Theme provides foundation; plugin extends with drag-drop builder. No theme hooks required — plugin adds editor UI.

### FectionWP-Blocks Plugin
Extends Gutenberg with custom block types. Theme provides styling via `assets/css/blocks-editor.css`.

### Contact Form 7
Styling overrides in `inc/contact-form-7.php` for Bootstrap-styled forms:
```php
// Adds .row and .col-* classes to CF7 forms
add_filter('wpcf7_form_class_attr', 'fwp_cf7_form_class_attr');
```

### WooCommerce
Compatibility hooks in `inc/woocommerce.php`:
- Template overrides: Cart/checkout wrapped in Bootstrap containers
- Form styling: `add_filter('woocommerce_form_field_args')` adds Bootstrap classes
- Pagination: Bootstrap pagination markup via `woocommerce_pagination_args` filter

## Performance Optimization

### Asset Loading Strategy
**Dependency chain** (see `functions.php` lines 164-280):
```
CSS: bootstrap-css → fwp-style → fwp-custom → (child theme tokens)
JS:  bootstrap-js (footer) → fwp-theme (footer)
```

**CDN with versioning**: Bootstrap 5.3.4 loaded from jsDelivr CDN (no local fallback by default)

**Font optimization**:
```php
// Dynamic Google Fonts loading (only selected fonts)
$families = fwp_google_families_in_use(); // Gathers from Customizer choices
$google_url = 'https://fonts.googleapis.com/css2?' . implode('&', $queries) . '&display=swap';
wp_enqueue_style('fwp-google-fonts', $google_url);
```

**Inline CSS for typography**: CSS variables generated via `fwp_build_typography_css_vars()` and attached to `fwp-custom` handle (no separate HTTP request)

### Caching Considerations
**No built-in object caching** — theme relies on WordPress transients and page cache plugins:
- **Recommended plugins**: WP Super Cache, W3 Total Cache, or Cloudflare APO
- **Customizer preview**: Selective refresh enabled via `customize-selective-refresh-widgets` support
- **Query optimization**: No custom post queries stored in transients by default (add as needed)

**Child theme pattern for expensive queries**:
```php
// Cache gallery posts for 12 hours
$cache_key = 'tffp_gallery_posts';
$posts = get_transient($cache_key);
if (false === $posts) {
    $posts = get_posts(['post_type' => 'gallery', 'posts_per_page' => 50]);
    set_transient($cache_key, $posts, 12 * HOUR_IN_SECONDS);
}
```

### Security Hardening
**Implemented by default** (see `functions.php` lines 560-650):
- **XML-RPC disabled**: `add_filter('xmlrpc_enabled', '__return_false')`
- **WordPress version hidden**: `remove_action('wp_head', 'wp_generator')`
- **Emoji scripts removed**: Performance gain (~10KB saved)
- **CSP headers**: Optional via Customizer (Appearance → FectionWP Pro → Security)
- **Rate limiting**: Login attempt tracking (5 failures = temporary block)

### Performance Checklist
1. **Image optimization**: Use WebP format, lazy loading (`loading="lazy"` added automatically in WP 5.5+)
2. **Minification**: No build step by default — use plugin (Autoptimize, WP Rocket) or server-level compression
3. **Database cleanup**: Use WP-Optimize plugin for post revisions/transients
4. **CDN**: Bootstrap/fonts already on CDN; use CDN for uploads (Cloudflare, BunnyCDN)

## Testing Workflows

### PHP Code Quality
**Composer dev dependencies** (see `composer.json`):
```json
{
  "require-dev": {
    "squizlabs/php_codesniffer": "^4.0",
    "wp-coding-standards/wpcs": "^2.3",
    "wp-theme-check/wp-theme-check": "^1.4"
  }
}
```

**Run quality checks**:
```bash
# Install dependencies
composer install

# Check WordPress Coding Standards
composer run-script phpcs
# Or manually: ./vendor/bin/phpcs --standard=WordPress inc/ functions.php

# Auto-fix coding standards
composer run-script phpcbf
# Or manually: ./vendor/bin/phpcbf --standard=WordPress inc/ functions.php
```

**Manual theme validation**:
```bash
# Install Theme Check plugin in WordPress admin
# Navigate to: Appearance → Theme Check
# Run automated tests for WordPress.org requirements
```

### Manual Testing Checklist
**Pre-deployment validation**:
1. **Activate theme** → check for PHP errors/warnings in debug.log
2. **Test all page templates**: Create test pages with each `page-*.php` template
3. **Navigation**: Verify Bootstrap 5 dropdowns work (primary menu with submenus)
4. **Responsive**: Test breakpoints (sm: 576px, md: 768px, lg: 992px, xl: 1200px, xxl: 1400px)
5. **Forms**: Test search form, comments, CF7 (if installed)
6. **Widget areas**: Add widgets to primary sidebar, footer columns (footer-1, footer-2, footer-3)
7. **Child theme overrides**: Verify child theme templates load correctly

**Child theme testing**:
```bash
# Verify parent theme reference
grep "Template:" child-theme/fectionwp-pro-tffp/style.css
# Output should be: Template: fectionwp-pro

# Check CSS load order in browser DevTools
# Network tab → Filter CSS → Verify: bootstrap → fwp-style → child tokens
```

### Automated Testing (Optional Setup)
**No tests included by default** — recommended setup:

**Unit tests** (PHPUnit):
```bash
# Install PHPUnit + WordPress test suite
composer require --dev phpunit/phpunit wp-phpunit/wp-phpunit
# Create tests/ directory with bootstrap.php
# Run: ./vendor/bin/phpunit tests/
```

**E2E tests** (Playwright/Cypress):
```bash
# For booking flow testing
npm install -D @playwright/test
# Create tests/e2e/booking.spec.js
# Test: form submission → database entry → email sent
```

**Visual regression** (Percy, Chromatic):
```bash
# Screenshot comparison for design parity
npm install -D @percy/cli
# Capture baseline: percy snapshot tests/fixtures/
```

### Browser Testing Priorities
**Primary targets** (Chrome/Edge Chromium 90+, Safari 15+, Firefox 90+):
- CSS Grid, Custom Properties, OKLCH colors (with sRGB fallbacks)
- Bootstrap 5.3 requirements (no IE11 support)

**Testing tools**:
- **BrowserStack/LambdaTest**: Cross-browser testing
- **Lighthouse CI**: Performance/accessibility audits (target: 90+ scores)
- **axe DevTools**: WCAG 2.1 AA compliance checks

## Naming Conventions & Code Style

**Function prefixes:**
- `fwp_` — theme functions (e.g., `fwp_setup()`, `fwp_get_container_type()`)
- `FWP_` — class names (e.g., `FWP_Shortcodes`, `FWP_Utility_Menu_Walker`)
- `pbp_` — booking plugin integration functions (when interfacing with FectionWP-Booking)

**File naming:**
- Template files: `page-{slug}.php` (e.g., `page-fullwidth.php`, `page-landing.php`)
- Template parts: `content-{type}.php` (e.g., `content-search.php`)
- Includes: `class-{name}.php` for classes, lowercase with hyphens otherwise
- Assets: kebab-case (e.g., `custom.css`, `cf7-bootstrap.css`)

**CSS class conventions:**
- Use Bootstrap utility classes first: `mt-5`, `text-center`, `d-flex`
- Custom classes: BEM-inspired but not strict (e.g., `.site-main`, `.navbar-brand`)
- Avoid `!important` — use CSS specificity or Bootstrap variable overrides

**WordPress hooks priority:**
- Default (10) for most theme hooks
- Priority 20+ for child theme overrides to ensure parent loads first
- Priority 100+ for late-binding or cleanup hooks

## Common Workflows

### Creating a New Page Template
```php
<?php
/*
Template Name: My Custom Template
Template Post Type: page, post
*/

get_header(); ?>

<div class="container my-5">
  <div class="row">
    <div class="col-lg-8">
      <?php
      while (have_posts()) : the_post();
        get_template_part('template-parts/content', 'page');
      endwhile;
      ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
```

### Configuring Hero Section via Customizer
The theme includes a powerful hero section system configurable via Customizer:
```
WordPress Admin → Appearance → Customize → Hero / Header Banner
```

**Features:**
- Enable/disable globally with per-page override (meta box in editor)
- Display rules (all pages, homepage only, pages only, posts only)
- Content: Title, subtitle, description (HTML supported)
- Dual CTA buttons with customizable text, URL, and Bootstrap styles
- Featured image and background image support
- Colors: Background, text, overlay opacity (0-100%)
- 5 height options: small (300px), medium (500px), large (700px), full viewport, auto
- 4 layouts: centered, left-aligned, split-left, split-right
- Container types: container, container-fluid, container-xxl
- Live preview for all text/color changes

**Per-page control:**
Each page/post has a meta box to disable hero for that specific page while keeping global settings.

### Customizing Site Title/Logo Styling
Complete control over text logo appearance via Customizer:
```
WordPress Admin → Appearance → Customize → Site Titel / Logo Styling
```

**Typography:**
- Font family selection from available fonts
- Font size (12-72px with live preview)
- Font weight (300-900)
- Text transform (uppercase, lowercase, capitalize)
- Letter spacing (-5px to 20px)

**Colors & Effects:**
- Text color with hover state
- Optional background color (badge effect)
- Padding (0-30px) and border radius (0-50px)
- Text shadow toggle
- Mobile-specific font size

**Tagline Support:**
- Show/hide site tagline below title
- Adjustable tagline font size (8-24px)
- Flexbox-based responsive layout

**6 Style Presets:**
- Minimal (light, uppercase, spaced)
- Bold & Modern (heavy, large, tight)
- Elegant (italic, medium, spaced)
- Playful (bold, rounded corners)
- Badge (padded, background, rounded)
- Outlined (border, padding)

Note: Text logo styling only applies when no custom logo image is uploaded.

### Adding Bootstrap Shortcodes
See `inc/shortcodes.php` lines 100-500 for examples. Pattern:
```php
add_shortcode('fwp_alert', function($atts, $content = null) {
  $atts = shortcode_atts(['type' => 'primary'], $atts);
  return '<div class="alert alert-' . esc_attr($atts['type']) . '">' . do_shortcode($content) . '</div>';
});
```

### Custom CSS/JS Enqueuing (Child Theme)
In child theme's `functions.php`:
```php
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style('tffp-tokens', get_stylesheet_directory_uri() . '/assets/css/tffp-tokens.css', ['fwp-style'], '1.0.0');
}, 20); // After parent theme styles
```

## Security & Performance Notes

- **CSP headers**: Enabled via theme options (Customizer → Security)
- **Rate limiting**: Login attempts tracked, blocks after 5 failures
- **XML-RPC disabled** by default (security hardening)
- **Asset optimization**: Bootstrap loaded from CDN with SRI hash, local fallback available
- **No jQuery** in modern pages (vanilla JS preferred, Bootstrap 5 is jQuery-free)

## Key Files for Reference

- Bootstrap grid examples: `template-parts/examples/example-grid.php`
- Hero sections: `template-parts/examples/example-hero-*.php`
- Navigation walker: `inc/class-wp-bootstrap-navwalker.php` (Bootstrap 5 dropdown menus)
- Customizer settings: `inc/customizer.php` (lines 50-300 for color/layout options)
- Security helpers: `functions.php` lines 800-1000

## Testing & Development

- **Local dev**: Use Local by Flywheel or XAMPP (dev container with Ubuntu 24.04 available)
- **PHP requirement**: 8.1+ (uses modern syntax, typed properties)
- **WordPress requirement**: 6.0+ (for block editor compatibility)
- **Browser targets**: Modern browsers (CSS Grid, Custom Properties, OKLCH via fallbacks)

### Development Commands

**PHP Code Quality:**
```bash
# Install composer dependencies (PHPCS with WordPress standards)
composer install

# Check PHP syntax/standards
composer run-script phpcs

# Auto-fix coding standards
composer run-script phpcbf
```

**Theme Check:**
```bash
# Via WP-CLI (if installed)
wp theme is-installed fectionwp-pro

# Manual: Install Theme Check plugin in WordPress admin
# Then: Appearance → Theme Check
```

**No build tooling required** by default — theme uses CDN Bootstrap and plain CSS. Optional Vite setup documented for child themes only.

### Testing Workflows

**Manual testing checklist:**
1. Activate theme and check for PHP errors/warnings
2. Test all page templates (create test pages with each template)
3. Verify menu displays correctly (Bootstrap dropdowns)
4. Check responsive behavior (Bootstrap breakpoints: sm, md, lg, xl, xxl)
5. Test forms (search, comments, Contact Form 7 if installed)
6. Verify child theme overrides work correctly

**Child theme testing:**
```bash
# Check if child theme properly extends parent
grep "Template:" style.css  # Should match parent folder name exactly

# Verify parent styles load first
# In browser DevTools: Network tab → check CSS load order
```

**Browser testing priorities:**
- Chrome/Edge (Chromium) - primary
- Safari/iOS Safari - secondary
- Firefox - secondary
- IE11 - not supported (Bootstrap 5 requirement)

## Migration-Specific Notes (TFFP → WP)

**URL conventions**: WordPress uses trailing slashes. Set up redirects:
- `/kinderfeestjes` → 301 → `/kinderfeestjes/`
- `/admin` → 302 → `/wp-admin/`

**Asset conflicts**: Do NOT load Tailwind CSS in production. Bootstrap + custom tokens only.

**React component mapping** (source → target):
- `Hero.tsx` → `template-parts/tffp/hero.php`
- `BookingSection.tsx` → `[pbp_booking_form]` shortcode
- `GallerySection.tsx` → Bootstrap grid + lightbox JS
- `TestimonialsSection.tsx` → Bootstrap carousel or custom template part

**Design parity checklist**:
1. OKLCH colors → CSS vars (with sRGB fallbacks for older browsers)
2. Fredoka + Inter fonts → enqueue via Google Fonts or local
3. 1rem border radius → `--bs-border-radius`
4. Gradient backgrounds → custom CSS (not Bootstrap native)
5. Framer Motion animations → CSS animations or lightweight JS (reduce bundle size)

## WordPress Deployment

### Parent Theme Deployment
```bash
# From FectionWP-Pro root
# Exclude development files
rsync -av --exclude='node_modules' \
  --exclude='.git' \
  --exclude='.github' \
  --exclude='*.md' \
  --exclude='child-theme' \
  ./ user@server:/path/to/wp-content/themes/fectionwp-pro/
```

### Child Theme Deployment (TFFP)
```bash
# Deploy child theme separately
cd child-theme/fectionwp-pro-tffp
rsync -av --exclude='node_modules' \
  --exclude='.git' \
  ./ user@server:/path/to/wp-content/themes/fectionwp-pro-tffp/
```

**Post-deployment checklist:**
1. SSH into server and verify file permissions (644 for files, 755 for directories)
2. Activate child theme in WordPress admin
3. Clear all caches (WordPress object cache, page cache, CDN)
4. Test critical paths: homepage, booking form, contact page
5. Check browser console for JS/CSS errors
6. Verify redirects are active (test `/kinderfeestjes` → `/kinderfeestjes/`)
7. Run Lighthouse audit on production URLs

**Database considerations:**
- Theme activation doesn't migrate database
- Export/import via WP-CLI or plugins (All-in-One WP Migration, WP Migrate DB)
- Search-replace domain URLs after migration

**Environment configs:**
```php
// wp-config.php - recommended constants for production
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
define('DISALLOW_FILE_EDIT', true);  // Disable theme/plugin editor
define('AUTOMATIC_UPDATER_DISABLED', true);  // Control updates manually
```
