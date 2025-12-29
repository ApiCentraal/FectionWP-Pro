# FectionWP Pro – Copilot Instructions

## Big Picture
WordPress theme serving as **parent theme** for client sites. Uses Bootstrap 5.3 as UI framework with extensive customization support. Designed to work with companion plugins (FectionWP-Booking, FectionWP-Visual-Builder, FectionWP-Blocks).

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

## Integration Points

### FectionWP-Booking Plugin
- Shortcode: `[pbp_booking_form]` embeds booking form
- Conditioned loading: Plugin only loads assets on pages with shortcode or `/customer-portal/` path
- Customizer integration: Primary color/radius/font can be synced with plugin via `pbp_style_*` options
- **CRITICAL**: Booking form replaces React BookingSection from TFFP migration

### Contact Form 7
Styling overrides in `inc/contact-form-7.php` for Bootstrap-styled forms.

### WooCommerce
Compatibility hooks in `inc/woocommerce.php` (template overrides, cart/checkout styling).

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

- **Local dev**: Use Local by Flywheel or XAMPP
- **PHP requirement**: 8.1+ (uses modern syntax, typed properties)
- **WordPress requirement**: 6.0+ (for block editor compatibility)
- **Browser targets**: Modern browsers (CSS Grid, Custom Properties, OKLCH via fallbacks)

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
