<?php
/**
 * FectionWP Pro - functions.php
 * 
 * Thema setup, asset loading en security hardening
 *
 * @package FectionWP_Pro
 * @since 1.0.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// =============================================================================
// INCLUDES
// =============================================================================

// Nav Walker voor Bootstrap 5 dropdown menu's
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

// Theme Customizer instellingen
require_once get_template_directory() . '/inc/customizer.php';

// Bootstrap 5.3 Shortcodes
require_once get_template_directory() . '/inc/shortcodes.php';

// Custom Widgets
require_once get_template_directory() . '/inc/widgets/class-fwp-social-widget.php';
require_once get_template_directory() . '/inc/widgets/class-fwp-recent-posts-widget.php';

// User Profile Extensions (social media velden)
require_once get_template_directory() . '/inc/user-profile.php';

// Plugin Integraties (laden alleen als plugin actief is)
require_once get_template_directory() . '/inc/woocommerce.php';
require_once get_template_directory() . '/inc/jetpack.php';
require_once get_template_directory() . '/inc/contact-form-7.php';

// TGM Plugin Activation (aanbevolen plugins)
require_once get_template_directory() . '/inc/plugin-activation.php';

// Block patterns voor Bootstrap examples
require_once get_template_directory() . '/inc/patterns-examples.php';

/**
 * OPMERKING: Visual Builder en Blocks zijn nu aparte plugins:
 * - FectionWP Visual Builder (inc/visual-editor.php -> plugin)
 * - FectionWP Blocks (inc/blocks.php + inc/page-blocks.php -> plugin)
 * 
 * Installeer deze plugins via Appearance > Install Plugins
 */

// =============================================================================
// 1. THEMA SETUP
// =============================================================================

if (!function_exists('fwp_setup')) {
    /**
     * Initialiseert basisfunctionaliteit van het thema
     * 
     * Pipeline:
     * WordPress Init → after_setup_theme hook → fwp_setup()
     *   ├─→ title-tag support
     *   ├─→ post-thumbnails support
     *   ├─→ html5 support
     *   ├─→ custom-logo support
     *   ├─→ custom-header support
     *   ├─→ custom-background support
     *   ├─→ editor-styles support
     *   ├─→ align-wide support
     *   ├─→ responsive-embeds support
     *   ├─→ post-formats support
     *   └─→ register_nav_menus
     */
    function fwp_setup() {
        // Vertalingen laden
        load_theme_textdomain('fectionwp-pro', get_template_directory() . '/languages');

        // Laat WordPress de <title> tag beheren
        add_theme_support('title-tag');
        
        // Schakel uitgelichte afbeeldingen in
        add_theme_support('post-thumbnails');
        
        // HTML5 markup voor formulieren en galerijen
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        ));

        // Custom logo support
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 350,
            'flex-height' => true,
            'flex-width'  => true,
        ));

        // Custom header image support
        add_theme_support('custom-header', apply_filters('fwp_custom_header_args', array(
            'default-image'      => '',
            'default-text-color' => '000000',
            'width'              => 1920,
            'height'             => 500,
            'flex-height'        => true,
            'flex-width'         => true,
        )));

        // Custom background support
        add_theme_support('custom-background', apply_filters('fwp_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Gutenberg/Block Editor support
        add_theme_support('editor-styles');
        add_editor_style('assets/css/editor-style.css');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('wp-block-styles');

        // Post formats support
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
        ));

        // Selective refresh voor widgets in Customizer
        add_theme_support('customize-selective-refresh-widgets');

        // Automatische feed links
        add_theme_support('automatic-feed-links');
        
        // Registreer menu locaties
        register_nav_menus(array(
            'primary' => __('Hoofdmenu', 'fectionwp-pro'),
            'footer'  => __('Footer Menu', 'fectionwp-pro'),
        ));
    }
    add_action('after_setup_theme', 'fwp_setup');
}

// =============================================================================
// 2. ASSET LOADING
// =============================================================================

if (!function_exists('fwp_enqueue_assets')) {
    /**
     * Laadt CSS en JavaScript in de juiste volgorde
     * 
     * Pipeline:
     * wp_enqueue_scripts hook → fwp_enqueue_assets()
     * 
     * CSS Keten: bootstrap-css → fwp-style → fwp-custom
     * JS Keten:  bootstrap-js → fwp-theme
     */
    function fwp_enqueue_assets() {
        // ---------------------------------------------------------------------
        // CSS: Bootstrap → Theme → Custom
        // ---------------------------------------------------------------------
        
        // Bootstrap CSS via jsDelivr CDN
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css',
            array(),
            null
        );

        // Bootstrap Icons via jsDelivr CDN
        wp_enqueue_style(
            'bootstrap-icons',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
            array(),
            null
        );
        
        // Thema stylesheet (style.css) - afhankelijk van Bootstrap
        wp_enqueue_style(
            'fwp-style',
            get_stylesheet_uri(),
            array('bootstrap-css'),
            filemtime(get_template_directory() . '/style.css')
        );
        
        // Custom CSS - afhankelijk van thema stylesheet
        wp_enqueue_style(
            'fwp-custom',
            get_template_directory_uri() . '/assets/css/custom.css',
            array('fwp-style'),
            filemtime(get_template_directory() . '/assets/css/custom.css')
        );
        
        // ---------------------------------------------------------------------
        // JavaScript: Bootstrap Bundle (incl. Popper) → Theme
        // ---------------------------------------------------------------------
        
        // Bootstrap Bundle JS via jsDelivr CDN (in footer)
        wp_enqueue_script(
            'bootstrap-js',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js',
            array(),
            null,
            true // In footer laden
        );
        
        // Thema JavaScript - afhankelijk van Bootstrap
        wp_enqueue_script(
            'fwp-theme',
            get_template_directory_uri() . '/assets/js/theme.js',
            array('bootstrap-js'),
            filemtime(get_template_directory() . '/assets/js/theme.js'),
            true // In footer laden
        );
    }
    add_action('wp_enqueue_scripts', 'fwp_enqueue_assets');
}

// =============================================================================
// 3. SECURITY & PERFORMANCE CLEANUP
// =============================================================================

/**
 * Verwijdert onnodige meta tags en scripts
 * 
 * Pipeline:
 * init hook → fwp_cleanup_head()
 *   ├─→ Verbergt WordPress versie
 *   └─→ Verwijdert emoji scripts/styles
 */
function fwp_cleanup_head() {
    // Verberg WordPress versie (security)
    remove_action('wp_head', 'wp_generator');
    
    // Verwijder emoji scripts (performance)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'fwp_cleanup_head');

// =============================================================================
// 4. WIDGET AREAS
// =============================================================================

if (!function_exists('fwp_widgets_init')) {
    /**
     * Registreert widget gebieden (sidebars)
     * 
     * Pipeline:
     * widgets_init hook → fwp_widgets_init()
     *   ├─→ Registreert 'primary-sidebar'
     *   ├─→ Registreert 'footer-1'
     *   ├─→ Registreert 'footer-2'
     *   └─→ Registreert 'footer-3'
     */
    function fwp_widgets_init() {
        // Primaire sidebar (naast content)
        register_sidebar(array(
            'name'          => __('Primaire Sidebar', 'fectionwp-pro'),
            'id'            => 'primary-sidebar',
            'description'   => __('Widgets in deze sidebar verschijnen naast de content.', 'fectionwp-pro'),
            'before_widget' => '<div id="%1$s" class="widget card mb-3 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="card-header"><h5 class="widget-title mb-0">',
            'after_title'   => '</h5></div>',
        ));

        // Footer widget kolom 1
        register_sidebar(array(
            'name'          => __('Footer Kolom 1', 'fectionwp-pro'),
            'id'            => 'footer-1',
            'description'   => __('Eerste kolom in de footer.', 'fectionwp-pro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        // Footer widget kolom 2
        register_sidebar(array(
            'name'          => __('Footer Kolom 2', 'fectionwp-pro'),
            'id'            => 'footer-2',
            'description'   => __('Tweede kolom in de footer.', 'fectionwp-pro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        // Footer widget kolom 3
        register_sidebar(array(
            'name'          => __('Footer Kolom 3', 'fectionwp-pro'),
            'id'            => 'footer-3',
            'description'   => __('Derde kolom in de footer.', 'fectionwp-pro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        // Hero/Header widget area
        register_sidebar(array(
            'name'          => __('Hero Sectie', 'fectionwp-pro'),
            'id'            => 'hero',
            'description'   => __('Hero sectie boven de content, ideaal voor een banner of call-to-action.', 'fectionwp-pro'),
            'before_widget' => '<div id="%1$s" class="hero-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="hero-title">',
            'after_title'   => '</h2>',
        ));

        // Registreer custom widgets
        register_widget('FWP_Social_Widget');
        register_widget('FWP_Recent_Posts_Widget');
    }
    add_action('widgets_init', 'fwp_widgets_init');
}

// =============================================================================
// 5. HELPER FUNCTIES
// =============================================================================

/**
 * Toont het custom logo of de site titel
 *
 * Pipeline:
 * header.php → fwp_the_custom_logo()
 *   ├─→ has_custom_logo() → the_custom_logo()
 *   └─→ fallback → site titel link
 */
function fwp_the_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        if (is_front_page() && is_home()) {
            echo '<h1 class="navbar-brand mb-0"><a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a></h1>';
        } else {
            echo '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a>';
        }
    }
}

/**
 * Toont de footer site info
 *
 * Pipeline:
 * footer.php → fwp_site_info()
 *   ├─→ Customizer override check
 *   └─→ Default copyright tekst
 */
function fwp_site_info() {
    $site_info = get_theme_mod('fwp_footer_text', '');
    
    if (!empty($site_info)) {
        echo wp_kses_post($site_info);
    } else {
        printf(
            '&copy; %1$s %2$s',
            date('Y'),
            get_bloginfo('name')
        );
    }
}

// =============================================================================
// 8. CLASSIC EDITOR VOOR PAGE TEMPLATES
// =============================================================================

/**
 * Forceer Classic Editor voor pagina's met onze custom templates
 * Dit zorgt ervoor dat shortcode content bewerkbaar is
 */
function fwp_use_classic_editor_for_templates($use_block_editor, $post) {
    if ($post && $post->post_type === 'page') {
        $template = get_page_template_slug($post->ID);
        $our_templates = array(
            'page-fullwidth.php',
            'page-landing.php',
            'page-hero.php',
            'page-sections.php',
            'page-blank.php',
            'page-demo.php',
        );
        
        if (in_array($template, $our_templates)) {
            return false; // Gebruik Classic Editor
        }
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post', 'fwp_use_classic_editor_for_templates', 10, 2);

/**
 * Voeg een "Edit with Classic Editor" link toe in de admin bar
 */
function fwp_add_classic_editor_link($wp_admin_bar) {
    global $post;
    
    if (!is_admin() && is_page() && current_user_can('edit_posts')) {
        $template = get_page_template_slug($post->ID);
        if ($template && strpos($template, 'page-') === 0) {
            $wp_admin_bar->add_node(array(
                'id'    => 'edit-classic',
                'title' => __('Bewerken (Classic)', 'fectionwp-pro'),
                'href'  => admin_url('post.php?post=' . $post->ID . '&action=edit&classic-editor'),
                'meta'  => array('class' => 'ab-item'),
            ));
        }
    }
}
add_action('admin_bar_menu', 'fwp_add_classic_editor_link', 100);

/**
 * Toon shortcode hulp in de editor sidebar
 */
function fwp_add_shortcode_help_metabox() {
    $screens = array('page');
    
    foreach ($screens as $screen) {
        add_meta_box(
            'fwp_shortcode_help',
            __('📦 Page Blocks', 'fectionwp-pro'),
            'fwp_shortcode_help_callback',
            $screen,
            'side',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'fwp_add_shortcode_help_metabox');

/**
 * Shortcode Builder - Drag & Drop met bewerkbare velden
 */
function fwp_shortcode_help_callback($post) {
    ?>
    <style>
        #fwp_shortcode_help .inside { padding: 0 !important; }
        .fwp-builder { font-size: 12px; }
        .fwp-tabs { display: flex; border-bottom: 1px solid #c3c4c7; background: #f6f7f7; }
        .fwp-tab { flex: 1; padding: 8px 4px; text-align: center; cursor: pointer; border: none; background: none; font-size: 11px; color: #50575e; }
        .fwp-tab:hover { background: #fff; }
        .fwp-tab.active { background: #fff; border-bottom: 2px solid #2271b1; color: #2271b1; font-weight: 600; }
        .fwp-panel { display: none; padding: 10px; max-height: 400px; overflow-y: auto; }
        .fwp-panel.active { display: block; }
        
        .fwp-block { 
            background: #fff; 
            border: 1px solid #c3c4c7; 
            border-radius: 4px; 
            margin-bottom: 8px; 
            cursor: grab;
            transition: all 0.2s;
        }
        .fwp-block:hover { border-color: #2271b1; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .fwp-block.dragging { opacity: 0.5; cursor: grabbing; }
        .fwp-block-header { 
            display: flex; 
            align-items: center; 
            padding: 8px 10px; 
            background: #f6f7f7; 
            border-radius: 3px 3px 0 0;
            cursor: pointer;
        }
        .fwp-block-header:hover { background: #e9e9e9; }
        .fwp-block-icon { margin-right: 8px; font-size: 14px; }
        .fwp-block-title { flex: 1; font-weight: 500; }
        .fwp-block-toggle { color: #787c82; transition: transform 0.2s; }
        .fwp-block.open .fwp-block-toggle { transform: rotate(180deg); }
        .fwp-block-type { font-size: 9px; background: #e0e0e0; padding: 2px 5px; border-radius: 3px; margin-left: 5px; }
        .fwp-block-type.full { background: #2271b1; color: #fff; }
        
        .fwp-block-form { display: none; padding: 10px; border-top: 1px solid #e0e0e0; }
        .fwp-block.open .fwp-block-form { display: block; }
        .fwp-field { margin-bottom: 10px; }
        .fwp-field label { display: block; font-weight: 500; margin-bottom: 3px; font-size: 11px; color: #1d2327; }
        .fwp-field input, .fwp-field textarea, .fwp-field select { 
            width: 100%; 
            padding: 5px 8px; 
            border: 1px solid #c3c4c7; 
            border-radius: 3px; 
            font-size: 12px;
        }
        .fwp-field input:focus, .fwp-field textarea:focus { border-color: #2271b1; outline: none; box-shadow: 0 0 0 1px #2271b1; }
        .fwp-field textarea { min-height: 50px; resize: vertical; }
        .fwp-field-hint { font-size: 10px; color: #787c82; margin-top: 2px; }
        
        .fwp-block-actions { display: flex; gap: 6px; margin-top: 10px; }
        .fwp-btn { 
            flex: 1;
            padding: 6px 10px; 
            border: none; 
            border-radius: 3px; 
            cursor: pointer; 
            font-size: 11px;
            font-weight: 500;
        }
        .fwp-btn-primary { background: #2271b1; color: #fff; }
        .fwp-btn-primary:hover { background: #135e96; }
        .fwp-btn-secondary { background: #f0f0f1; color: #50575e; }
        .fwp-btn-secondary:hover { background: #e0e0e0; }
        
        .fwp-drag-hint { 
            text-align: center; 
            padding: 15px; 
            color: #787c82; 
            font-size: 11px;
            background: #f9f9f9;
            border-top: 1px dashed #c3c4c7;
        }
        .fwp-drag-hint span { font-size: 16px; display: block; margin-bottom: 5px; }
        
        /* Drop zone styling */
        .mce-edit-area.fwp-drop-active { background: #e7f5fe !important; }
        #content.fwp-drop-active { background: #e7f5fe !important; border-color: #2271b1 !important; }
    </style>
    
    <div class="fwp-builder">
        <div class="fwp-tabs">
            <button type="button" class="fwp-tab active" data-tab="heroes">🎯 Heroes</button>
            <button type="button" class="fwp-tab" data-tab="sections">📦 Secties</button>
            <button type="button" class="fwp-tab" data-tab="content">📝 Content</button>
            <button type="button" class="fwp-tab" data-tab="elements">🧩 Elementen</button>
            <button type="button" class="fwp-tab" data-tab="commerce">🛒 Commerce</button>
        </div>
        
        <!-- Heroes Tab -->
        <div class="fwp-panel active" data-panel="heroes">
            
            <!-- Hero Centered -->
            <div class="fwp-block" draggable="true" data-shortcode="hero-centered">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🎯</span>
                    <span class="fwp-block-title">Hero Centered</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Gecentreerde hero met titel, tekst en optionele afbeelding.</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Welkom bij ons" placeholder="Hoofdtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="" placeholder="Optionele kleine tekst boven titel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Korte beschrijving">Ontdek wat wij voor u kunnen betekenen.</textarea>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Meer info" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#contact" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Secundaire button tekst (optioneel)</label>
                        <input type="text" name="btn2_text" value="" placeholder="Tweede button">
                    </div>
                    <div class="fwp-field">
                        <label>Secundaire button URL</label>
                        <input type="text" name="btn2_url" value="" placeholder="https://...">
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Achtergrond afbeelding URL</label>
                        <input type="text" name="bg_image" value="" placeholder="URL naar achtergrondafbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Achtergrondkleur</label>
                        <select name="bg_color">
                            <option value="">Standaard (gradient)</option>
                            <option value="primary">Primary (blauw)</option>
                            <option value="dark">Donker</option>
                            <option value="light">Licht</option>
                            <option value="gradient-purple">Gradient Paars</option>
                            <option value="gradient-green">Gradient Groen</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Overlay donkerheid</label>
                        <select name="overlay">
                            <option value="">Geen overlay</option>
                            <option value="light">Licht (30%)</option>
                            <option value="medium" selected>Medium (50%)</option>
                            <option value="dark">Donker (70%)</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Hoogte</label>
                        <select name="height">
                            <option value="small">Klein (50vh)</option>
                            <option value="medium" selected>Medium (70vh)</option>
                            <option value="large">Groot (90vh)</option>
                            <option value="full">Volledig scherm (100vh)</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Tekst uitlijning</label>
                        <select name="align">
                            <option value="center" selected>Gecentreerd</option>
                            <option value="left">Links</option>
                            <option value="right">Rechts</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Hero Split -->
            <div class="fwp-block" draggable="true" data-shortcode="hero-split">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">◐</span>
                    <span class="fwp-block-title">Hero Split</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Twee-koloms hero met tekst links en afbeelding rechts (of omgekeerd).</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Over Ons" placeholder="Hoofdtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="" placeholder="Kleine tekst boven titel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Uitgebreide tekst">Wij zijn een team van professionals die u graag helpen.</textarea>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Afbeelding URL</label>
                        <input type="text" name="image" value="" placeholder="URL naar afbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding positie</label>
                        <select name="image_position">
                            <option value="right" selected>Rechts</option>
                            <option value="left">Links</option>
                        </select>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Lees meer" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Secundaire button tekst</label>
                        <input type="text" name="btn2_text" value="" placeholder="Tweede button (optioneel)">
                    </div>
                    <div class="fwp-field">
                        <label>Secundaire button URL</label>
                        <input type="text" name="btn2_url" value="" placeholder="https://...">
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Achtergrondkleur</label>
                        <select name="bg_color">
                            <option value="" selected>Wit</option>
                            <option value="light">Lichtgrijs</option>
                            <option value="dark">Donker</option>
                            <option value="primary">Primary</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Verticale uitlijning</label>
                        <select name="valign">
                            <option value="center" selected>Midden</option>
                            <option value="top">Boven</option>
                            <option value="bottom">Onder</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Hero Video -->
            <div class="fwp-block" draggable="true" data-shortcode="hero-video">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🎬</span>
                    <span class="fwp-block-title">Hero Video</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Hero met video achtergrond (MP4 of YouTube).</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Video Hero" placeholder="Hoofdtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="" placeholder="Subtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Korte tekst"></textarea>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Video URL (MP4)</label>
                        <input type="text" name="video_url" value="" placeholder="https://example.com/video.mp4">
                    </div>
                    <div class="fwp-field">
                        <label>Of YouTube ID</label>
                        <input type="text" name="youtube_id" value="" placeholder="dQw4w9WgXcQ">
                    </div>
                    <div class="fwp-field">
                        <label>Fallback afbeelding</label>
                        <input type="text" name="poster" value="" placeholder="URL voor mobiel/fallback">
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Bekijk meer" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Overlay donkerheid</label>
                        <select name="overlay">
                            <option value="light">Licht</option>
                            <option value="medium" selected>Medium</option>
                            <option value="dark">Donker</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Hoogte</label>
                        <select name="height">
                            <option value="medium">Medium (70vh)</option>
                            <option value="large">Groot (90vh)</option>
                            <option value="full" selected>Volledig scherm</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Hero Dark -->
            <div class="fwp-block" draggable="true" data-shortcode="hero-dark">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🌙</span>
                    <span class="fwp-block-title">Hero Dark</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Donkere hero met lichte tekst, perfect voor contrast.</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Donkere Hero" placeholder="Hoofdtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="Stijlvol en modern" placeholder="Subtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Optionele beschrijving"></textarea>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Start nu" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Secundaire button tekst</label>
                        <input type="text" name="btn2_text" value="" placeholder="Tweede button (outline)">
                    </div>
                    <div class="fwp-field">
                        <label>Secundaire button URL</label>
                        <input type="text" name="btn2_url" value="" placeholder="https://...">
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Achtergrond afbeelding</label>
                        <input type="text" name="bg_image" value="" placeholder="URL voor achtergrond">
                    </div>
                    <div class="fwp-field">
                        <label>Achtergrond stijl</label>
                        <select name="bg_style">
                            <option value="solid" selected>Solid donker</option>
                            <option value="gradient">Gradient donker</option>
                            <option value="pattern">Met patroon</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Hoogte</label>
                        <select name="height">
                            <option value="small">Klein (50vh)</option>
                            <option value="medium" selected>Medium (70vh)</option>
                            <option value="large">Groot (90vh)</option>
                            <option value="full">Volledig scherm</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Hero Minimal -->
            <div class="fwp-block" draggable="true" data-shortcode="hero-minimal">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">✨</span>
                    <span class="fwp-block-title">Hero Minimal</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Minimalistische hero met alleen tekst, clean design.</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Simpel & Krachtig" placeholder="Hoofdtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Korte beschrijving">Less is more. Wij focussen op wat echt belangrijk is.</textarea>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Button tekst (optioneel)</label>
                        <input type="text" name="btn_text" value="" placeholder="Laat leeg voor geen button">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Achtergrond</label>
                        <select name="bg_color">
                            <option value="white" selected>Wit</option>
                            <option value="light">Lichtgrijs</option>
                            <option value="cream">Crème</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Tekst kleur</label>
                        <select name="text_color">
                            <option value="dark" selected>Donker</option>
                            <option value="muted">Gedempt</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Padding</label>
                        <select name="padding">
                            <option value="small">Klein</option>
                            <option value="medium" selected>Medium</option>
                            <option value="large">Groot</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Hero Parallax -->
            <div class="fwp-block" draggable="true" data-shortcode="hero-parallax">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🏔️</span>
                    <span class="fwp-block-title">Hero Parallax</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Hero met parallax scroll effect op de achtergrond.</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Parallax Hero" placeholder="Hoofdtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="" placeholder="Subtitel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Tekst"></textarea>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Achtergrond afbeelding (verplicht)</label>
                        <input type="text" name="bg_image" value="" placeholder="URL naar grote afbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Parallax snelheid</label>
                        <select name="speed">
                            <option value="slow">Langzaam</option>
                            <option value="medium" selected>Medium</option>
                            <option value="fast">Snel</option>
                        </select>
                    </div>
                    <hr style="margin:10px 0;border-color:#e0e0e0;">
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Ontdek" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Overlay</label>
                        <select name="overlay">
                            <option value="light">Licht</option>
                            <option value="medium" selected>Medium</option>
                            <option value="dark">Donker</option>
                            <option value="gradient">Gradient</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Hoogte</label>
                        <select name="height">
                            <option value="medium">Medium (70vh)</option>
                            <option value="large" selected>Groot (90vh)</option>
                            <option value="full">Volledig scherm</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Sections Tab -->
        <div class="fwp-panel" data-panel="sections">
            
            <!-- Features -->
            <div class="fwp-block" draggable="true" data-shortcode="features">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">⭐</span>
                    <span class="fwp-block-title">Features</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Sectie titel</label>
                        <input type="text" name="title" value="Onze Features" placeholder="Sectie titel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="Wat wij bieden" placeholder="Kleine tekst boven titel">
                    </div>
                    <div class="fwp-field">
                        <label>Aantal kolommen</label>
                        <select name="columns">
                            <option value="2">2 kolommen</option>
                            <option value="3" selected>3 kolommen</option>
                            <option value="4">4 kolommen</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Feature 1 - Icon (bi-naam)</label>
                        <input type="text" name="f1_icon" value="bi-star" placeholder="bi-star">
                    </div>
                    <div class="fwp-field">
                        <label>Feature 1 - Titel</label>
                        <input type="text" name="f1_title" value="Kwaliteit" placeholder="Feature titel">
                    </div>
                    <div class="fwp-field">
                        <label>Feature 1 - Beschrijving</label>
                        <input type="text" name="f1_desc" value="Hoogwaardige producten en diensten." placeholder="Korte beschrijving">
                    </div>
                    <hr style="margin: 10px 0; border-color: #e0e0e0;">
                    <div class="fwp-field">
                        <label>Feature 2 - Icon</label>
                        <input type="text" name="f2_icon" value="bi-lightning" placeholder="bi-lightning">
                    </div>
                    <div class="fwp-field">
                        <label>Feature 2 - Titel</label>
                        <input type="text" name="f2_title" value="Snelheid" placeholder="Feature titel">
                    </div>
                    <div class="fwp-field">
                        <label>Feature 2 - Beschrijving</label>
                        <input type="text" name="f2_desc" value="Razendsnelle levering en service." placeholder="Korte beschrijving">
                    </div>
                    <hr style="margin: 10px 0; border-color: #e0e0e0;">
                    <div class="fwp-field">
                        <label>Feature 3 - Icon</label>
                        <input type="text" name="f3_icon" value="bi-shield-check" placeholder="bi-shield-check">
                    </div>
                    <div class="fwp-field">
                        <label>Feature 3 - Titel</label>
                        <input type="text" name="f3_title" value="Veiligheid" placeholder="Feature titel">
                    </div>
                    <div class="fwp-field">
                        <label>Feature 3 - Beschrijving</label>
                        <input type="text" name="f3_desc" value="Uw gegevens zijn veilig bij ons." placeholder="Korte beschrijving">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Pricing -->
            <div class="fwp-block" draggable="true" data-shortcode="pricing-table">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">💰</span>
                    <span class="fwp-block-title">Prijstabel</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Sectie titel</label>
                        <input type="text" name="title" value="Onze Prijzen" placeholder="Sectie titel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="Kies uw plan" placeholder="Subtitel">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Plan 1 - Naam</label>
                        <input type="text" name="p1_title" value="Starter" placeholder="Plan naam">
                    </div>
                    <div class="fwp-field">
                        <label>Plan 1 - Prijs (€)</label>
                        <input type="text" name="p1_price" value="9" placeholder="Prijs zonder €">
                    </div>
                    <div class="fwp-field">
                        <label>Plan 1 - Features (komma-gescheiden)</label>
                        <input type="text" name="p1_features" value="5 projecten,Email support,1GB opslag" placeholder="Feature 1,Feature 2">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Plan 2 - Naam (featured)</label>
                        <input type="text" name="p2_title" value="Professional" placeholder="Plan naam">
                    </div>
                    <div class="fwp-field">
                        <label>Plan 2 - Prijs (€)</label>
                        <input type="text" name="p2_price" value="29" placeholder="Prijs zonder €">
                    </div>
                    <div class="fwp-field">
                        <label>Plan 2 - Features</label>
                        <input type="text" name="p2_features" value="Onbeperkt projecten,Priority support,50GB opslag,API toegang" placeholder="Feature 1,Feature 2">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Plan 3 - Naam</label>
                        <input type="text" name="p3_title" value="Enterprise" placeholder="Plan naam">
                    </div>
                    <div class="fwp-field">
                        <label>Plan 3 - Prijs (€)</label>
                        <input type="text" name="p3_price" value="99" placeholder="Prijs zonder €">
                    </div>
                    <div class="fwp-field">
                        <label>Plan 3 - Features</label>
                        <input type="text" name="p3_features" value="Alles in Pro,Dedicated support,Onbeperkte opslag,Custom integraties" placeholder="Feature 1,Feature 2">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="fwp-block" draggable="true" data-shortcode="stats">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📊</span>
                    <span class="fwp-block-title">Statistieken</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Sectie titel (optioneel)</label>
                        <input type="text" name="title" value="" placeholder="Onze cijfers">
                    </div>
                    <div class="fwp-field">
                        <label>Stat 1 - Nummer</label>
                        <input type="text" name="s1_num" value="500+" placeholder="100+">
                    </div>
                    <div class="fwp-field">
                        <label>Stat 1 - Label</label>
                        <input type="text" name="s1_label" value="Tevreden klanten" placeholder="Klanten">
                    </div>
                    <div class="fwp-field">
                        <label>Stat 2 - Nummer</label>
                        <input type="text" name="s2_num" value="1000+" placeholder="50+">
                    </div>
                    <div class="fwp-field">
                        <label>Stat 2 - Label</label>
                        <input type="text" name="s2_label" value="Projecten" placeholder="Projecten">
                    </div>
                    <div class="fwp-field">
                        <label>Stat 3 - Nummer</label>
                        <input type="text" name="s3_num" value="99%" placeholder="99%">
                    </div>
                    <div class="fwp-field">
                        <label>Stat 3 - Label</label>
                        <input type="text" name="s3_label" value="Tevredenheid" placeholder="Tevredenheid">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- CTA Banner -->
            <div class="fwp-block" draggable="true" data-shortcode="cta-banner">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📢</span>
                    <span class="fwp-block-title">Call-to-Action Banner</span>
                    <span class="fwp-block-type full">full-width</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Klaar om te beginnen?" placeholder="CTA titel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Korte tekst">Neem vandaag nog contact met ons op voor een vrijblijvende offerte.</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Neem contact op" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#contact" placeholder="https://...">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Content Tab -->
        <div class="fwp-panel" data-panel="content">
            
            <!-- Testimonials -->
            <div class="fwp-block" draggable="true" data-shortcode="testimonials">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">💬</span>
                    <span class="fwp-block-title">Testimonials</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Sectie titel</label>
                        <input type="text" name="title" value="Wat klanten zeggen" placeholder="Sectie titel">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Review 1 - Tekst</label>
                        <textarea name="t1_content" placeholder="Review tekst">Uitstekende service en snelle levering!</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Review 1 - Naam</label>
                        <input type="text" name="t1_author" value="Jan de Vries" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Review 1 - Functie</label>
                        <input type="text" name="t1_role" value="Ondernemer" placeholder="Functie/Bedrijf">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Review 2 - Tekst</label>
                        <textarea name="t2_content" placeholder="Review tekst">Zeer professioneel team, aanrader!</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Review 2 - Naam</label>
                        <input type="text" name="t2_author" value="Maria Jansen" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Review 2 - Functie</label>
                        <input type="text" name="t2_role" value="Marketing Manager" placeholder="Functie/Bedrijf">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- FAQ -->
            <div class="fwp-block" draggable="true" data-shortcode="faq">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">❓</span>
                    <span class="fwp-block-title">FAQ</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Sectie titel</label>
                        <input type="text" name="title" value="Veelgestelde vragen" placeholder="Sectie titel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <input type="text" name="description" value="Hier vindt u antwoorden op de meest gestelde vragen." placeholder="Intro tekst">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Vraag 1</label>
                        <input type="text" name="q1" value="Hoe kan ik bestellen?" placeholder="Vraag">
                    </div>
                    <div class="fwp-field">
                        <label>Antwoord 1</label>
                        <textarea name="a1" placeholder="Antwoord">U kunt eenvoudig bestellen via onze website of telefonisch contact opnemen.</textarea>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Vraag 2</label>
                        <input type="text" name="q2" value="Wat zijn de levertijden?" placeholder="Vraag">
                    </div>
                    <div class="fwp-field">
                        <label>Antwoord 2</label>
                        <textarea name="a2" placeholder="Antwoord">Wij leveren binnen 2-3 werkdagen in heel Nederland.</textarea>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Vraag 3</label>
                        <input type="text" name="q3" value="Kan ik retourneren?" placeholder="Vraag">
                    </div>
                    <div class="fwp-field">
                        <label>Antwoord 3</label>
                        <textarea name="a3" placeholder="Antwoord">Ja, u heeft 30 dagen bedenktijd met gratis retourneren.</textarea>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Team -->
            <div class="fwp-block" draggable="true" data-shortcode="team">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">👥</span>
                    <span class="fwp-block-title">Team</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Sectie titel</label>
                        <input type="text" name="title" value="Ons Team" placeholder="Sectie titel">
                    </div>
                    <div class="fwp-field">
                        <label>Subtitel</label>
                        <input type="text" name="subtitle" value="De mensen achter ons succes" placeholder="Subtitel">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Lid 1 - Naam</label>
                        <input type="text" name="m1_name" value="Jan Bakker" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Lid 1 - Functie</label>
                        <input type="text" name="m1_role" value="Directeur" placeholder="Functie">
                    </div>
                    <div class="fwp-field">
                        <label>Lid 1 - Foto URL</label>
                        <input type="text" name="m1_image" value="" placeholder="URL naar foto">
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="fwp-field">
                        <label>Lid 2 - Naam</label>
                        <input type="text" name="m2_name" value="Lisa de Jong" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Lid 2 - Functie</label>
                        <input type="text" name="m2_role" value="Designer" placeholder="Functie">
                    </div>
                    <div class="fwp-field">
                        <label>Lid 2 - Foto URL</label>
                        <input type="text" name="m2_image" value="" placeholder="URL naar foto">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Elements Tab -->
        <div class="fwp-panel" data-panel="elements">
            
            <!-- Cards Grid -->
            <div class="fwp-block" draggable="true" data-shortcode="cards">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🃏</span>
                    <span class="fwp-block-title">Cards Grid</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Responsive grid met kaarten voor producten, diensten of content.</p>
                    <div class="fwp-field">
                        <label>Kolommen</label>
                        <select name="columns">
                            <option value="2">2 kolommen</option>
                            <option value="3" selected>3 kolommen</option>
                            <option value="4">4 kolommen</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Kaart stijl</label>
                        <select name="style">
                            <option value="default" selected>Standaard</option>
                            <option value="shadow">Met schaduw</option>
                            <option value="border">Met rand</option>
                            <option value="hover">Hover effect</option>
                        </select>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Card 1 - Afbeelding URL</label>
                        <input type="text" name="c1_image" value="" placeholder="URL naar afbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Card 1 - Titel</label>
                        <input type="text" name="c1_title" value="Card Titel" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Card 1 - Tekst</label>
                        <input type="text" name="c1_text" value="Korte beschrijving van deze card." placeholder="Beschrijving">
                    </div>
                    <div class="fwp-field">
                        <label>Card 1 - Link URL</label>
                        <input type="text" name="c1_url" value="#" placeholder="https://...">
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Card 2 - Afbeelding URL</label>
                        <input type="text" name="c2_image" value="" placeholder="URL naar afbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Card 2 - Titel</label>
                        <input type="text" name="c2_title" value="Card Titel" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Card 2 - Tekst</label>
                        <input type="text" name="c2_text" value="Korte beschrijving van deze card." placeholder="Beschrijving">
                    </div>
                    <div class="fwp-field">
                        <label>Card 2 - Link URL</label>
                        <input type="text" name="c2_url" value="#" placeholder="https://...">
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Card 3 - Afbeelding URL</label>
                        <input type="text" name="c3_image" value="" placeholder="URL naar afbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Card 3 - Titel</label>
                        <input type="text" name="c3_title" value="Card Titel" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Card 3 - Tekst</label>
                        <input type="text" name="c3_text" value="Korte beschrijving van deze card." placeholder="Beschrijving">
                    </div>
                    <div class="fwp-field">
                        <label>Card 3 - Link URL</label>
                        <input type="text" name="c3_url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Icon Box -->
            <div class="fwp-block" draggable="true" data-shortcode="icon-box">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📦</span>
                    <span class="fwp-block-title">Icon Box</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Enkele box met icon, titel en tekst.</p>
                    <div class="fwp-field">
                        <label>Icon (Bootstrap Icons)</label>
                        <input type="text" name="icon" value="bi-star-fill" placeholder="bi-star-fill">
                    </div>
                    <div class="fwp-field">
                        <label>Icon kleur</label>
                        <select name="icon_color">
                            <option value="primary" selected>Primary (blauw)</option>
                            <option value="success">Success (groen)</option>
                            <option value="danger">Danger (rood)</option>
                            <option value="warning">Warning (geel)</option>
                            <option value="info">Info (cyan)</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Feature Titel" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Tekst</label>
                        <textarea name="text" placeholder="Beschrijving">Korte beschrijving van deze feature.</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Link URL (optioneel)</label>
                        <input type="text" name="url" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Uitlijning</label>
                        <select name="align">
                            <option value="center" selected>Gecentreerd</option>
                            <option value="left">Links</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Button -->
            <div class="fwp-block" draggable="true" data-shortcode="button">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🔘</span>
                    <span class="fwp-block-title">Button</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="text" value="Klik hier" placeholder="Button label">
                    </div>
                    <div class="fwp-field">
                        <label>URL</label>
                        <input type="text" name="url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Stijl</label>
                        <select name="style">
                            <option value="primary" selected>Primary (blauw)</option>
                            <option value="secondary">Secondary (grijs)</option>
                            <option value="success">Success (groen)</option>
                            <option value="danger">Danger (rood)</option>
                            <option value="warning">Warning (geel)</option>
                            <option value="outline-primary">Outline Primary</option>
                            <option value="outline-dark">Outline Dark</option>
                            <option value="link">Link stijl</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Grootte</label>
                        <select name="size">
                            <option value="sm">Klein</option>
                            <option value="md" selected>Medium</option>
                            <option value="lg">Groot</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Icon (optioneel)</label>
                        <input type="text" name="icon" value="" placeholder="bi-arrow-right">
                    </div>
                    <div class="fwp-field">
                        <label>Open in nieuw tabblad</label>
                        <select name="target">
                            <option value="_self" selected>Nee</option>
                            <option value="_blank">Ja</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Accordion -->
            <div class="fwp-block" draggable="true" data-shortcode="accordion">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📑</span>
                    <span class="fwp-block-title">Accordion</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Inklapbare secties, ideaal voor FAQ of content organisatie.</p>
                    <div class="fwp-field">
                        <label>Eerste item open</label>
                        <select name="open_first">
                            <option value="true" selected>Ja</option>
                            <option value="false">Nee</option>
                        </select>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Item 1 - Titel</label>
                        <input type="text" name="a1_title" value="Eerste sectie" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Item 1 - Inhoud</label>
                        <textarea name="a1_content" placeholder="Inhoud">Dit is de inhoud van de eerste sectie.</textarea>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Item 2 - Titel</label>
                        <input type="text" name="a2_title" value="Tweede sectie" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Item 2 - Inhoud</label>
                        <textarea name="a2_content" placeholder="Inhoud">Dit is de inhoud van de tweede sectie.</textarea>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Item 3 - Titel</label>
                        <input type="text" name="a3_title" value="Derde sectie" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Item 3 - Inhoud</label>
                        <textarea name="a3_content" placeholder="Inhoud">Dit is de inhoud van de derde sectie.</textarea>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="fwp-block" draggable="true" data-shortcode="tabs">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📂</span>
                    <span class="fwp-block-title">Tabs</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Tabbladen voor het organiseren van content.</p>
                    <div class="fwp-field">
                        <label>Tab stijl</label>
                        <select name="style">
                            <option value="tabs" selected>Tabs</option>
                            <option value="pills">Pills</option>
                            <option value="underline">Underline</option>
                        </select>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Tab 1 - Titel</label>
                        <input type="text" name="t1_title" value="Tab 1" placeholder="Tab naam">
                    </div>
                    <div class="fwp-field">
                        <label>Tab 1 - Inhoud</label>
                        <textarea name="t1_content" placeholder="Inhoud">Inhoud van het eerste tabblad.</textarea>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Tab 2 - Titel</label>
                        <input type="text" name="t2_title" value="Tab 2" placeholder="Tab naam">
                    </div>
                    <div class="fwp-field">
                        <label>Tab 2 - Inhoud</label>
                        <textarea name="t2_content" placeholder="Inhoud">Inhoud van het tweede tabblad.</textarea>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Tab 3 - Titel</label>
                        <input type="text" name="t3_title" value="Tab 3" placeholder="Tab naam">
                    </div>
                    <div class="fwp-field">
                        <label>Tab 3 - Inhoud</label>
                        <textarea name="t3_content" placeholder="Inhoud">Inhoud van het derde tabblad.</textarea>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Alert -->
            <div class="fwp-block" draggable="true" data-shortcode="alert">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">⚠️</span>
                    <span class="fwp-block-title">Alert</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Type</label>
                        <select name="type">
                            <option value="info" selected>Info (blauw)</option>
                            <option value="success">Success (groen)</option>
                            <option value="warning">Warning (geel)</option>
                            <option value="danger">Danger (rood)</option>
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Titel (optioneel)</label>
                        <input type="text" name="title" value="" placeholder="Alert titel">
                    </div>
                    <div class="fwp-field">
                        <label>Bericht</label>
                        <textarea name="message" placeholder="Alert tekst">Dit is een belangrijk bericht voor de bezoeker.</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Wegklikbaar</label>
                        <select name="dismissible">
                            <option value="false" selected>Nee</option>
                            <option value="true">Ja</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="fwp-block" draggable="true" data-shortcode="progress">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📊</span>
                    <span class="fwp-block-title">Progress Bar</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Label</label>
                        <input type="text" name="label" value="Voortgang" placeholder="Label tekst">
                    </div>
                    <div class="fwp-field">
                        <label>Percentage</label>
                        <input type="number" name="value" value="75" min="0" max="100" placeholder="0-100">
                    </div>
                    <div class="fwp-field">
                        <label>Kleur</label>
                        <select name="color">
                            <option value="primary" selected>Primary (blauw)</option>
                            <option value="success">Success (groen)</option>
                            <option value="warning">Warning (geel)</option>
                            <option value="danger">Danger (rood)</option>
                            <option value="info">Info (cyan)</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Toon percentage</label>
                        <select name="show_percent">
                            <option value="true" selected>Ja</option>
                            <option value="false">Nee</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Gestreept</label>
                        <select name="striped">
                            <option value="false" selected>Nee</option>
                            <option value="true">Ja</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Image Gallery -->
            <div class="fwp-block" draggable="true" data-shortcode="gallery">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🖼️</span>
                    <span class="fwp-block-title">Afbeelding Galerij</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Grid galerij met lightbox effect.</p>
                    <div class="fwp-field">
                        <label>Kolommen</label>
                        <select name="columns">
                            <option value="2">2 kolommen</option>
                            <option value="3" selected>3 kolommen</option>
                            <option value="4">4 kolommen</option>
                            <option value="6">6 kolommen</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Lightbox</label>
                        <select name="lightbox">
                            <option value="true" selected>Ja</option>
                            <option value="false">Nee</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding 1 URL</label>
                        <input type="text" name="img1" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding 2 URL</label>
                        <input type="text" name="img2" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding 3 URL</label>
                        <input type="text" name="img3" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding 4 URL</label>
                        <input type="text" name="img4" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding 5 URL</label>
                        <input type="text" name="img5" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-field">
                        <label>Afbeelding 6 URL</label>
                        <input type="text" name="img6" value="" placeholder="https://...">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Timeline -->
            <div class="fwp-block" draggable="true" data-shortcode="timeline">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📅</span>
                    <span class="fwp-block-title">Timeline</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Verticale tijdlijn voor geschiedenis of stappen.</p>
                    <div class="fwp-field">
                        <label>Event 1 - Datum</label>
                        <input type="text" name="e1_date" value="2024" placeholder="Datum">
                    </div>
                    <div class="fwp-field">
                        <label>Event 1 - Titel</label>
                        <input type="text" name="e1_title" value="Oprichting" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Event 1 - Beschrijving</label>
                        <textarea name="e1_desc" placeholder="Beschrijving">Ons bedrijf werd opgericht.</textarea>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Event 2 - Datum</label>
                        <input type="text" name="e2_date" value="2025" placeholder="Datum">
                    </div>
                    <div class="fwp-field">
                        <label>Event 2 - Titel</label>
                        <input type="text" name="e2_title" value="Groei" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Event 2 - Beschrijving</label>
                        <textarea name="e2_desc" placeholder="Beschrijving">Uitbreiding naar nieuwe markten.</textarea>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Event 3 - Datum</label>
                        <input type="text" name="e3_date" value="Nu" placeholder="Datum">
                    </div>
                    <div class="fwp-field">
                        <label>Event 3 - Titel</label>
                        <input type="text" name="e3_title" value="Vandaag" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Event 3 - Beschrijving</label>
                        <textarea name="e3_desc" placeholder="Beschrijving">Marktleider in onze sector.</textarea>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Counter -->
            <div class="fwp-block" draggable="true" data-shortcode="counter">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🔢</span>
                    <span class="fwp-block-title">Animated Counter</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Geanimeerde teller die omhoog telt bij scrollen.</p>
                    <div class="fwp-field">
                        <label>Eindwaarde</label>
                        <input type="text" name="value" value="1000" placeholder="1000">
                    </div>
                    <div class="fwp-field">
                        <label>Prefix (voor getal)</label>
                        <input type="text" name="prefix" value="" placeholder="€">
                    </div>
                    <div class="fwp-field">
                        <label>Suffix (na getal)</label>
                        <input type="text" name="suffix" value="+" placeholder="+">
                    </div>
                    <div class="fwp-field">
                        <label>Label</label>
                        <input type="text" name="label" value="Klanten" placeholder="Label onder getal">
                    </div>
                    <div class="fwp-field">
                        <label>Duur (ms)</label>
                        <input type="number" name="duration" value="2000" placeholder="2000">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Divider -->
            <div class="fwp-block" draggable="true" data-shortcode="divider">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">➖</span>
                    <span class="fwp-block-title">Divider</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Stijl</label>
                        <select name="style">
                            <option value="solid" selected>Lijn</option>
                            <option value="dashed">Gestreept</option>
                            <option value="dotted">Gestippeld</option>
                            <option value="double">Dubbel</option>
                            <option value="gradient">Gradient</option>
                            <option value="icon">Met icon</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Icon (alleen bij icon stijl)</label>
                        <input type="text" name="icon" value="bi-diamond-fill" placeholder="bi-diamond-fill">
                    </div>
                    <div class="fwp-field">
                        <label>Breedte</label>
                        <select name="width">
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <option value="100" selected>100%</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Marge</label>
                        <select name="margin">
                            <option value="small">Klein</option>
                            <option value="medium" selected>Medium</option>
                            <option value="large">Groot</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Spacer -->
            <div class="fwp-block" draggable="true" data-shortcode="spacer">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">↕️</span>
                    <span class="fwp-block-title">Spacer</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Hoogte</label>
                        <select name="height">
                            <option value="20">20px</option>
                            <option value="40">40px</option>
                            <option value="60" selected>60px</option>
                            <option value="80">80px</option>
                            <option value="100">100px</option>
                            <option value="150">150px</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Commerce Tab -->
        <div class="fwp-panel" data-panel="commerce">
            
            <!-- Product Card -->
            <div class="fwp-block" draggable="true" data-shortcode="product-card">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🛍️</span>
                    <span class="fwp-block-title">Product Card</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Enkele product kaart met afbeelding, prijs en koop-knop.</p>
                    <div class="fwp-field">
                        <label>Product afbeelding</label>
                        <input type="text" name="image" value="" placeholder="URL naar afbeelding">
                    </div>
                    <div class="fwp-field">
                        <label>Product naam</label>
                        <input type="text" name="title" value="Product Naam" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Korte beschrijving</label>
                        <textarea name="description" placeholder="Beschrijving">Korte productbeschrijving.</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Prijs</label>
                        <input type="text" name="price" value="€49,99" placeholder="€49,99">
                    </div>
                    <div class="fwp-field">
                        <label>Oude prijs (optioneel)</label>
                        <input type="text" name="old_price" value="" placeholder="€69,99">
                    </div>
                    <div class="fwp-field">
                        <label>Badge (optioneel)</label>
                        <select name="badge">
                            <option value="" selected>Geen</option>
                            <option value="sale">Sale</option>
                            <option value="new">Nieuw</option>
                            <option value="hot">Hot</option>
                            <option value="limited">Limited</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Bestel nu" placeholder="Button tekst">
                    </div>
                    <div class="fwp-field">
                        <label>Button URL</label>
                        <input type="text" name="btn_url" value="#" placeholder="https://...">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="fwp-block" draggable="true" data-shortcode="products-grid">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🏪</span>
                    <span class="fwp-block-title">Products Grid</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Grid met meerdere producten.</p>
                    <div class="fwp-field">
                        <label>Sectie titel</label>
                        <input type="text" name="title" value="Onze Producten" placeholder="Sectie titel">
                    </div>
                    <div class="fwp-field">
                        <label>Kolommen</label>
                        <select name="columns">
                            <option value="2">2 kolommen</option>
                            <option value="3" selected>3 kolommen</option>
                            <option value="4">4 kolommen</option>
                        </select>
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Product 1 - Naam</label>
                        <input type="text" name="p1_title" value="Product 1" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Product 1 - Prijs</label>
                        <input type="text" name="p1_price" value="€29,99" placeholder="€29,99">
                    </div>
                    <div class="fwp-field">
                        <label>Product 1 - Afbeelding</label>
                        <input type="text" name="p1_image" value="" placeholder="URL">
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Product 2 - Naam</label>
                        <input type="text" name="p2_title" value="Product 2" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Product 2 - Prijs</label>
                        <input type="text" name="p2_price" value="€39,99" placeholder="€39,99">
                    </div>
                    <div class="fwp-field">
                        <label>Product 2 - Afbeelding</label>
                        <input type="text" name="p2_image" value="" placeholder="URL">
                    </div>
                    <hr style="margin:10px 0;">
                    <div class="fwp-field">
                        <label>Product 3 - Naam</label>
                        <input type="text" name="p3_title" value="Product 3" placeholder="Naam">
                    </div>
                    <div class="fwp-field">
                        <label>Product 3 - Prijs</label>
                        <input type="text" name="p3_price" value="€49,99" placeholder="€49,99">
                    </div>
                    <div class="fwp-field">
                        <label>Product 3 - Afbeelding</label>
                        <input type="text" name="p3_image" value="" placeholder="URL">
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="fwp-block" draggable="true" data-shortcode="contact-form">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">✉️</span>
                    <span class="fwp-block-title">Contact Formulier</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Simpel contactformulier met email verzending.</p>
                    <div class="fwp-field">
                        <label>Formulier titel</label>
                        <input type="text" name="title" value="Neem contact op" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Email ontvanger</label>
                        <input type="email" name="email" value="" placeholder="uw@email.nl">
                    </div>
                    <div class="fwp-field">
                        <label>Succes bericht</label>
                        <input type="text" name="success_msg" value="Bedankt! We nemen spoedig contact op." placeholder="Succes bericht">
                    </div>
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Verstuur" placeholder="Button tekst">
                    </div>
                    <div class="fwp-field">
                        <label>Velden</label>
                        <select name="fields">
                            <option value="simple" selected>Simpel (naam, email, bericht)</option>
                            <option value="extended">Uitgebreid (+ telefoon, onderwerp)</option>
                            <option value="full">Volledig (+ bedrijf, adres)</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="fwp-block" draggable="true" data-shortcode="newsletter">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">📧</span>
                    <span class="fwp-block-title">Newsletter Signup</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <p style="font-size:11px;color:#666;margin:0 0 10px;background:#f5f5f5;padding:8px;border-radius:4px;">Email aanmeld formulier voor nieuwsbrief.</p>
                    <div class="fwp-field">
                        <label>Titel</label>
                        <input type="text" name="title" value="Schrijf je in voor onze nieuwsbrief" placeholder="Titel">
                    </div>
                    <div class="fwp-field">
                        <label>Beschrijving</label>
                        <textarea name="description" placeholder="Beschrijving">Ontvang het laatste nieuws en exclusieve aanbiedingen.</textarea>
                    </div>
                    <div class="fwp-field">
                        <label>Placeholder tekst</label>
                        <input type="text" name="placeholder" value="Uw e-mailadres" placeholder="Placeholder">
                    </div>
                    <div class="fwp-field">
                        <label>Button tekst</label>
                        <input type="text" name="btn_text" value="Inschrijven" placeholder="Button tekst">
                    </div>
                    <div class="fwp-field">
                        <label>Stijl</label>
                        <select name="style">
                            <option value="inline" selected>Inline</option>
                            <option value="stacked">Gestapeld</option>
                            <option value="boxed">Boxed</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Achtergrond</label>
                        <select name="bg_color">
                            <option value="" selected>Geen</option>
                            <option value="light">Licht</option>
                            <option value="dark">Donker</option>
                            <option value="primary">Primary</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            <div class="fwp-block" draggable="true" data-shortcode="social-links">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🔗</span>
                    <span class="fwp-block-title">Social Links</span>
                    <span class="fwp-block-type">inline</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Facebook URL</label>
                        <input type="text" name="facebook" value="" placeholder="https://facebook.com/...">
                    </div>
                    <div class="fwp-field">
                        <label>Instagram URL</label>
                        <input type="text" name="instagram" value="" placeholder="https://instagram.com/...">
                    </div>
                    <div class="fwp-field">
                        <label>Twitter/X URL</label>
                        <input type="text" name="twitter" value="" placeholder="https://x.com/...">
                    </div>
                    <div class="fwp-field">
                        <label>LinkedIn URL</label>
                        <input type="text" name="linkedin" value="" placeholder="https://linkedin.com/...">
                    </div>
                    <div class="fwp-field">
                        <label>YouTube URL</label>
                        <input type="text" name="youtube" value="" placeholder="https://youtube.com/...">
                    </div>
                    <div class="fwp-field">
                        <label>Stijl</label>
                        <select name="style">
                            <option value="icons" selected>Alleen icons</option>
                            <option value="buttons">Buttons</option>
                            <option value="rounded">Rounded</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Grootte</label>
                        <select name="size">
                            <option value="sm">Klein</option>
                            <option value="md" selected>Medium</option>
                            <option value="lg">Groot</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
            <!-- Map -->
            <div class="fwp-block" draggable="true" data-shortcode="map">
                <div class="fwp-block-header">
                    <span class="fwp-block-icon">🗺️</span>
                    <span class="fwp-block-title">Google Maps</span>
                    <span class="fwp-block-type">container</span>
                    <span class="fwp-block-toggle">▼</span>
                </div>
                <div class="fwp-block-form">
                    <div class="fwp-field">
                        <label>Google Maps Embed URL of Adres</label>
                        <input type="text" name="location" value="" placeholder="Straat 1, Amsterdam">
                    </div>
                    <div class="fwp-field">
                        <label>Hoogte</label>
                        <select name="height">
                            <option value="300">300px</option>
                            <option value="400" selected>400px</option>
                            <option value="500">500px</option>
                        </select>
                    </div>
                    <div class="fwp-field">
                        <label>Zoom level</label>
                        <select name="zoom">
                            <option value="12">Wijk (12)</option>
                            <option value="14" selected>Straat (14)</option>
                            <option value="16">Gebouw (16)</option>
                        </select>
                    </div>
                    <div class="fwp-block-actions">
                        <button type="button" class="fwp-btn fwp-btn-primary fwp-insert">➕ Invoegen</button>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="fwp-drag-hint">
            <span>✋</span>
            Sleep een blok naar de editor<br>of klik om te openen en aan te passen
        </div>
    </div>
    
    <script>
    (function() {
        // Tab switching
        document.querySelectorAll('.fwp-tab').forEach(function(tab) {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.fwp-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.fwp-panel').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                document.querySelector('.fwp-panel[data-panel="' + this.dataset.tab + '"]').classList.add('active');
            });
        });
        
        // Toggle block form
        document.querySelectorAll('.fwp-block-header').forEach(function(header) {
            header.addEventListener('click', function(e) {
                if (!e.target.classList.contains('fwp-insert') && !e.target.classList.contains('fwp-btn')) {
                    this.parentElement.classList.toggle('open');
                }
            });
        });
        
        // Build shortcode from form
        function buildShortcode(block) {
            var type = block.dataset.shortcode;
            var form = block.querySelector('.fwp-block-form');
            var shortcode = '';
            
            switch(type) {
                case 'hero-centered':
                case 'hero-split':
                case 'hero-dark':
                case 'hero-video':
                case 'hero-minimal':
                case 'hero-parallax':
                    shortcode = '[' + type;
                    form.querySelectorAll('input, textarea, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            // Skip if it's a select with empty/default value
                            if (input.tagName === 'SELECT') {
                                var selectedOption = input.options[input.selectedIndex];
                                if (selectedOption.value === '' || selectedOption.value === input.querySelector('option').value) {
                                    // Check if it's the first/default option
                                    if (input.selectedIndex === 0 && !selectedOption.value) return;
                                }
                            }
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                    
                case 'features':
                    var title = form.querySelector('[name="title"]').value;
                    var subtitle = form.querySelector('[name="subtitle"]').value;
                    var columns = form.querySelector('[name="columns"]').value;
                    shortcode = '[features title="' + title + '" subtitle="' + subtitle + '" columns="' + columns + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var icon = form.querySelector('[name="f'+i+'_icon"]').value;
                        var ftitle = form.querySelector('[name="f'+i+'_title"]').value;
                        var desc = form.querySelector('[name="f'+i+'_desc"]').value;
                        if (ftitle) {
                            shortcode += '  [feature icon="' + icon + '" title="' + ftitle + '" description="' + desc + '"]\n';
                        }
                    }
                    shortcode += '[/features]';
                    break;
                    
                case 'pricing-table':
                    var title = form.querySelector('[name="title"]').value;
                    var subtitle = form.querySelector('[name="subtitle"]').value;
                    shortcode = '[pricing-table title="' + title + '" subtitle="' + subtitle + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var ptitle = form.querySelector('[name="p'+i+'_title"]').value;
                        var price = form.querySelector('[name="p'+i+'_price"]').value;
                        var features = form.querySelector('[name="p'+i+'_features"]').value;
                        if (ptitle) {
                            var featured = i === 2 ? ' featured="true"' : '';
                            shortcode += '  [pricing-card title="' + ptitle + '" price="' + price + '" features="' + features + '"' + featured + ' btn_text="Kies plan" btn_url="#"]\n';
                        }
                    }
                    shortcode += '[/pricing-table]';
                    break;
                    
                case 'stats':
                    var title = form.querySelector('[name="title"]').value;
                    shortcode = '[stats' + (title ? ' title="' + title + '"' : '') + ']\n';
                    for (var i = 1; i <= 3; i++) {
                        var num = form.querySelector('[name="s'+i+'_num"]').value;
                        var label = form.querySelector('[name="s'+i+'_label"]').value;
                        if (num) {
                            shortcode += '  [stat number="' + num + '" label="' + label + '"]\n';
                        }
                    }
                    shortcode += '[/stats]';
                    break;
                    
                case 'cta-banner':
                    shortcode = '[cta-banner';
                    form.querySelectorAll('input, textarea').forEach(function(input) {
                        if (input.value.trim()) {
                            shortcode += ' ' + input.name + '="' + input.value.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                    
                case 'testimonials':
                    var title = form.querySelector('[name="title"]').value;
                    shortcode = '[testimonials title="' + title + '"]\n';
                    for (var i = 1; i <= 2; i++) {
                        var content = form.querySelector('[name="t'+i+'_content"]').value;
                        var author = form.querySelector('[name="t'+i+'_author"]').value;
                        var role = form.querySelector('[name="t'+i+'_role"]').value;
                        if (content) {
                            shortcode += '  [testimonial content="' + content.replace(/"/g, '\\"') + '" author="' + author + '" role="' + role + '"]\n';
                        }
                    }
                    shortcode += '[/testimonials]';
                    break;
                    
                case 'faq':
                    var title = form.querySelector('[name="title"]').value;
                    var desc = form.querySelector('[name="description"]').value;
                    shortcode = '[faq title="' + title + '" description="' + desc + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var q = form.querySelector('[name="q'+i+'"]').value;
                        var a = form.querySelector('[name="a'+i+'"]').value;
                        if (q) {
                            shortcode += '  [faq-item question="' + q.replace(/"/g, '\\"') + '" answer="' + a.replace(/"/g, '\\"') + '"]\n';
                        }
                    }
                    shortcode += '[/faq]';
                    break;
                    
                case 'team':
                    var title = form.querySelector('[name="title"]').value;
                    var subtitle = form.querySelector('[name="subtitle"]').value;
                    shortcode = '[team title="' + title + '" subtitle="' + subtitle + '"]\n';
                    for (var i = 1; i <= 2; i++) {
                        var name = form.querySelector('[name="m'+i+'_name"]').value;
                        var role = form.querySelector('[name="m'+i+'_role"]').value;
                        var image = form.querySelector('[name="m'+i+'_image"]').value;
                        if (name) {
                            shortcode += '  [team-member name="' + name + '" role="' + role + '"' + (image ? ' image="' + image + '"' : '') + ']\n';
                        }
                    }
                    shortcode += '[/team]';
                    break;
                
                // Elements - Cards
                case 'cards':
                    var columns = form.querySelector('[name="columns"]').value;
                    var style = form.querySelector('[name="style"]').value;
                    shortcode = '[cards columns="' + columns + '" style="' + style + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var cimage = form.querySelector('[name="c'+i+'_image"]').value;
                        var ctitle = form.querySelector('[name="c'+i+'_title"]').value;
                        var ctext = form.querySelector('[name="c'+i+'_text"]').value;
                        var curl = form.querySelector('[name="c'+i+'_url"]').value;
                        if (ctitle) {
                            shortcode += '  [card' + (cimage ? ' image="' + cimage + '"' : '') + ' title="' + ctitle + '" text="' + ctext + '" url="' + curl + '"]\n';
                        }
                    }
                    shortcode += '[/cards]';
                    break;
                
                // Elements - Icon Box, Button, Alert, Progress, Counter, Divider, Spacer
                case 'icon-box':
                case 'button':
                case 'alert':
                case 'progress':
                case 'counter':
                case 'divider':
                case 'spacer':
                    shortcode = '[' + type;
                    form.querySelectorAll('input, textarea, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                
                // Elements - Accordion
                case 'accordion':
                    var openFirst = form.querySelector('[name="open_first"]').value;
                    shortcode = '[accordion open_first="' + openFirst + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var atitle = form.querySelector('[name="a'+i+'_title"]').value;
                        var acontent = form.querySelector('[name="a'+i+'_content"]').value;
                        if (atitle) {
                            shortcode += '  [accordion-item title="' + atitle + '"]' + acontent + '[/accordion-item]\n';
                        }
                    }
                    shortcode += '[/accordion]';
                    break;
                
                // Elements - Tabs
                case 'tabs':
                    var tabStyle = form.querySelector('[name="style"]').value;
                    shortcode = '[tabs style="' + tabStyle + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var ttitle = form.querySelector('[name="t'+i+'_title"]').value;
                        var tcontent = form.querySelector('[name="t'+i+'_content"]').value;
                        if (ttitle) {
                            shortcode += '  [tab title="' + ttitle + '"]' + tcontent + '[/tab]\n';
                        }
                    }
                    shortcode += '[/tabs]';
                    break;
                
                // Elements - Gallery
                case 'gallery':
                    var gcolumns = form.querySelector('[name="columns"]').value;
                    var lightbox = form.querySelector('[name="lightbox"]').value;
                    shortcode = '[gallery columns="' + gcolumns + '" lightbox="' + lightbox + '"]\n';
                    for (var i = 1; i <= 6; i++) {
                        var imgUrl = form.querySelector('[name="img'+i+'"]').value;
                        if (imgUrl) {
                            shortcode += '  [gallery-image src="' + imgUrl + '"]\n';
                        }
                    }
                    shortcode += '[/gallery]';
                    break;
                
                // Elements - Timeline
                case 'timeline':
                    shortcode = '[timeline]\n';
                    for (var i = 1; i <= 3; i++) {
                        var edate = form.querySelector('[name="e'+i+'_date"]').value;
                        var etitle = form.querySelector('[name="e'+i+'_title"]').value;
                        var edesc = form.querySelector('[name="e'+i+'_desc"]').value;
                        if (etitle) {
                            shortcode += '  [timeline-item date="' + edate + '" title="' + etitle + '"]' + edesc + '[/timeline-item]\n';
                        }
                    }
                    shortcode += '[/timeline]';
                    break;
                
                // Commerce - Product Card
                case 'product-card':
                    shortcode = '[product-card';
                    form.querySelectorAll('input, textarea, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                
                // Commerce - Products Grid
                case 'products-grid':
                    var pgtitle = form.querySelector('[name="title"]').value;
                    var pgcolumns = form.querySelector('[name="columns"]').value;
                    shortcode = '[products-grid title="' + pgtitle + '" columns="' + pgcolumns + '"]\n';
                    for (var i = 1; i <= 3; i++) {
                        var prodTitle = form.querySelector('[name="p'+i+'_title"]').value;
                        var prodPrice = form.querySelector('[name="p'+i+'_price"]').value;
                        var prodImage = form.querySelector('[name="p'+i+'_image"]').value;
                        if (prodTitle) {
                            shortcode += '  [product title="' + prodTitle + '" price="' + prodPrice + '"' + (prodImage ? ' image="' + prodImage + '"' : '') + ']\n';
                        }
                    }
                    shortcode += '[/products-grid]';
                    break;
                
                // Commerce - Contact Form
                case 'contact-form':
                    shortcode = '[contact-form';
                    form.querySelectorAll('input, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                
                // Commerce - Newsletter
                case 'newsletter':
                    shortcode = '[newsletter';
                    form.querySelectorAll('input, textarea, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                
                // Commerce - Social Links
                case 'social-links':
                    shortcode = '[social-links';
                    form.querySelectorAll('input, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                
                // Commerce - Map
                case 'map':
                    shortcode = '[map';
                    form.querySelectorAll('input, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
                    break;
                
                // Default fallback
                default:
                    shortcode = '[' + type;
                    form.querySelectorAll('input, textarea, select').forEach(function(input) {
                        var val = input.value.trim();
                        if (val && input.name) {
                            shortcode += ' ' + input.name + '="' + val.replace(/"/g, '\\"') + '"';
                        }
                    });
                    shortcode += ']';
            }
            
            return shortcode;
        }
        
        // Insert into editor
        function insertIntoEditor(shortcode) {
            if (typeof tinymce !== 'undefined' && tinymce.activeEditor && !tinymce.activeEditor.isHidden()) {
                tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode + '\n\n');
            } else {
                var textarea = document.getElementById('content');
                if (textarea) {
                    var start = textarea.selectionStart;
                    var end = textarea.selectionEnd;
                    var text = textarea.value;
                    textarea.value = text.substring(0, start) + shortcode + '\n\n' + text.substring(end);
                    textarea.selectionStart = textarea.selectionEnd = start + shortcode.length + 2;
                    textarea.focus();
                }
            }
        }
        
        // Insert button click
        document.querySelectorAll('.fwp-insert').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var block = this.closest('.fwp-block');
                var shortcode = buildShortcode(block);
                insertIntoEditor(shortcode);
                block.classList.remove('open');
            });
        });
        
        // Drag and drop
        var draggedBlock = null;
        
        document.querySelectorAll('.fwp-block').forEach(function(block) {
            block.addEventListener('dragstart', function(e) {
                draggedBlock = this;
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'copy';
                e.dataTransfer.setData('text/plain', buildShortcode(this));
                
                // Highlight drop zones
                var content = document.getElementById('content');
                if (content) content.classList.add('fwp-drop-active');
                var mceArea = document.querySelector('.mce-edit-area');
                if (mceArea) mceArea.classList.add('fwp-drop-active');
            });
            
            block.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                draggedBlock = null;
                
                // Remove highlights
                document.querySelectorAll('.fwp-drop-active').forEach(function(el) {
                    el.classList.remove('fwp-drop-active');
                });
            });
        });
        
        // Allow drop on editor
        setTimeout(function() {
            var dropTargets = [document.getElementById('content')];
            var iframe = document.querySelector('#content_ifr');
            if (iframe) {
                try {
                    dropTargets.push(iframe.contentDocument.body);
                } catch(e) {}
            }
            
            dropTargets.forEach(function(target) {
                if (!target) return;
                
                target.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'copy';
                });
                
                target.addEventListener('drop', function(e) {
                    e.preventDefault();
                    var shortcode = e.dataTransfer.getData('text/plain');
                    if (shortcode) {
                        insertIntoEditor(shortcode);
                    }
                });
            });
        }, 1000);
        
    })();
    </script>
    <?php
}
