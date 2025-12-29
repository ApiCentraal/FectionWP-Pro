<?php
/**
 * Theme Customizer Configuration
 *
 * @package FectionWP_Pro
 * @since 0.1.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Add customizer settings
 */
function fwp_customize_register($wp_customize) {
    
    // =============================================================================
    // SECTION: Layout Settings
    // =============================================================================
    
    $wp_customize->add_section('fwp_layout_settings', array(
        'title'    => __('Layout Instellingen', 'fectionwp-pro'),
        'priority' => 30,
    ));
    
    // Container Type Setting
    $wp_customize->add_setting('fwp_container_type', array(
        'default'           => 'container',
        'sanitize_callback' => 'fwp_sanitize_container_type',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_container_type', array(
        'label'       => __('Container Type', 'fectionwp-pro'),
        'description' => __('Kies het type container voor de content.', 'fectionwp-pro'),
        'section'     => 'fwp_layout_settings',
        'type'        => 'select',
        'choices'     => array(
            'container'       => __('Container (vast)', 'fectionwp-pro'),
            'container-fluid' => __('Container Fluid (volledig)', 'fectionwp-pro'),
            'container-sm'    => __('Container SM (540px)', 'fectionwp-pro'),
            'container-md'    => __('Container MD (720px)', 'fectionwp-pro'),
            'container-lg'    => __('Container LG (960px)', 'fectionwp-pro'),
            'container-xl'    => __('Container XL (1140px)', 'fectionwp-pro'),
            'container-xxl'   => __('Container XXL (1320px)', 'fectionwp-pro'),
        ),
    ));
    
    // Sidebar Position Setting
    $wp_customize->add_setting('fwp_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'fwp_sanitize_sidebar_position',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_sidebar_position', array(
        'label'       => __('Sidebar Positie', 'fectionwp-pro'),
        'description' => __('Kies waar de sidebar moet verschijnen.', 'fectionwp-pro'),
        'section'     => 'fwp_layout_settings',
        'type'        => 'select',
        'choices'     => array(
            'none'  => __('Geen sidebar', 'fectionwp-pro'),
            'left'  => __('Links', 'fectionwp-pro'),
            'right' => __('Rechts', 'fectionwp-pro'),
        ),
    ));
    
    // =============================================================================
    // SECTION: Navigation Settings
    // =============================================================================
    
    $wp_customize->add_section('fwp_nav_settings', array(
        'title'    => __('Navigatie Instellingen', 'fectionwp-pro'),
        'priority' => 31,
    ));
    
    // Navbar Type Setting
    $wp_customize->add_setting('fwp_navbar_type', array(
        'default'           => 'standard',
        'sanitize_callback' => 'fwp_sanitize_navbar_type',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_navbar_type', array(
        'label'       => __('Navigatie Type', 'fectionwp-pro'),
        'description' => __('Kies het type navigatie menu.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
        'type'        => 'select',
        'choices'     => array(
            'standard'  => __('Standaard Collapse', 'fectionwp-pro'),
            'offcanvas' => __('Offcanvas (zijpaneel)', 'fectionwp-pro'),
        ),
    ));
    
    // Navbar Sticky Setting
    $wp_customize->add_setting('fwp_navbar_sticky', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_navbar_sticky', array(
        'label'       => __('Sticky Navbar', 'fectionwp-pro'),
        'description' => __('Laat de navbar boven blijven tijdens scrollen.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
        'type'        => 'checkbox',
    ));
    
    // Navbar Color Scheme
    $wp_customize->add_setting('fwp_navbar_scheme', array(
        'default'           => 'light',
        'sanitize_callback' => 'fwp_sanitize_navbar_scheme',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_navbar_scheme', array(
        'label'       => __('Navbar Kleurenschema', 'fectionwp-pro'),
        'description' => __('Kies het kleurenschema voor de navbar.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
        'type'        => 'select',
        'choices'     => array(
            'light' => __('Light (lichte achtergrond)', 'fectionwp-pro'),
            'dark'  => __('Dark (donkere achtergrond)', 'fectionwp-pro'),
        ),
    ));
    
    // =============================================================================
    // SECTION: Footer Settings
    // =============================================================================
    
    $wp_customize->add_section('fwp_footer_settings', array(
        'title'    => __('Footer Instellingen', 'fectionwp-pro'),
        'priority' => 32,
    ));
    
    // Footer Text Setting
    $wp_customize->add_setting('fwp_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_footer_text', array(
        'label'       => __('Footer Tekst', 'fectionwp-pro'),
        'description' => __('Aangepaste footer tekst (laat leeg voor standaard copyright).', 'fectionwp-pro'),
        'section'     => 'fwp_footer_settings',
        'type'        => 'textarea',
    ));
    
    // Show Back to Top Button
    $wp_customize->add_setting('fwp_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_back_to_top', array(
        'label'       => __('Toon "Terug naar boven" knop', 'fectionwp-pro'),
        'description' => __('Toon een knop om terug naar boven te scrollen.', 'fectionwp-pro'),
        'section'     => 'fwp_footer_settings',
        'type'        => 'checkbox',
    ));
    
    // =============================================================================
    // SECTION: Typography Settings
    // =============================================================================
    
    $wp_customize->add_section('fwp_typography_settings', array(
        'title'    => __('Typografie', 'fectionwp-pro'),
        'priority' => 33,
    ));
    
    // Base Font Size
    $wp_customize->add_setting('fwp_base_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_base_font_size', array(
        'label'       => __('Basis Lettergrootte (px)', 'fectionwp-pro'),
        'description' => __('Standaard lettergrootte voor de body tekst.', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Font families (Google + Microsoft/System + external vendor stylesheet)
    $font_choices = fwp_font_choices();

    $wp_customize->add_setting('fwp_font_body', array(
        'default'           => '',
        'sanitize_callback' => 'fwp_sanitize_font_choice',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_font_body', array(
        'label'       => __('Body font (global)', 'fectionwp-pro'),
        'description' => __('Kies het lettertype voor alle body tekst. “Standaard” gebruikt Bootstrap/thema defaults.', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'select',
        'choices'     => $font_choices,
    ));

    $wp_customize->add_setting('fwp_font_headings', array(
        'default'           => '',
        'sanitize_callback' => 'fwp_sanitize_font_choice',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_font_headings', array(
        'label'       => __('Headings font (global)', 'fectionwp-pro'),
        'description' => __('Kies het lettertype voor headings (H1–H6).', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'select',
        'choices'     => $font_choices,
    ));

    $wp_customize->add_setting('fwp_font_sitetitle', array(
        'default'           => '',
        'sanitize_callback' => 'fwp_sanitize_font_choice',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_font_sitetitle', array(
        'label'       => __('Sitetitle/Logo tekst font', 'fectionwp-pro'),
        'description' => __('Lettertype voor de sitetitle/brand in de header (navbar-brand). Laat leeg om de header/headings instellingen te volgen.', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'select',
        'choices'     => $font_choices,
    ));

    // External fonts (e.g. vendor-hosted / enterprise licensed)
    $wp_customize->add_setting('fwp_custom_font_css_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_custom_font_css_url', array(
        'label'       => __('Extern font stylesheet URL', 'fectionwp-pro'),
        'description' => __('Plak hier een URL naar een CSS stylesheet die jouw fonts definieert (@font-face). Alleen nodig als je “Extern (eigen font-URL)” selecteert. Gebruik alleen fonts/URL’s waarvoor je licentie hebt.', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'url',
    ));

    $wp_customize->add_setting('fwp_custom_font_family_body', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_custom_font_family_body', array(
        'label'       => __('Extern font family name (body)', 'fectionwp-pro'),
        'description' => __('Moet exact matchen met de font-family naam uit het externe stylesheet.', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'text',
    ));

    $wp_customize->add_setting('fwp_custom_font_family_headings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_custom_font_family_headings', array(
        'label'       => __('Extern font family name (headings)', 'fectionwp-pro'),
        'description' => __('Moet exact matchen met de font-family naam uit het externe stylesheet.', 'fectionwp-pro'),
        'section'     => 'fwp_typography_settings',
        'type'        => 'text',
    ));

    // Per-section overrides
    $section_choices = array('' => __('Overnemen van global', 'fectionwp-pro')) + array_diff_key($font_choices, array('' => true));

    $sections = array(
        'header'  => __('Header', 'fectionwp-pro'),
        'content' => __('Content', 'fectionwp-pro'),
        'footer'  => __('Footer', 'fectionwp-pro'),
    );

    foreach ( $sections as $key => $label ) {
        $wp_customize->add_setting('fwp_font_' . $key . '_body', array(
            'default'           => '',
            'sanitize_callback' => 'fwp_sanitize_font_choice',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control('fwp_font_' . $key . '_body', array(
            'label'   => sprintf( __('%s font (body)', 'fectionwp-pro'), $label ),
            'section' => 'fwp_typography_settings',
            'type'    => 'select',
            'choices' => $section_choices,
        ));

        $wp_customize->add_setting('fwp_font_' . $key . '_headings', array(
            'default'           => '',
            'sanitize_callback' => 'fwp_sanitize_font_choice',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control('fwp_font_' . $key . '_headings', array(
            'label'   => sprintf( __('%s font (headings)', 'fectionwp-pro'), $label ),
            'section' => 'fwp_typography_settings',
            'type'    => 'select',
            'choices' => $section_choices,
        ));
    }
    
    // =============================================================================
    // SECTION: Blog Settings
    // =============================================================================
    
    $wp_customize->add_section('fwp_blog_settings', array(
        'title'    => __('Blog Instellingen', 'fectionwp-pro'),
        'priority' => 34,
    ));
    
    // Show Author Box
    $wp_customize->add_setting('fwp_show_author_box', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_show_author_box', array(
        'label'       => __('Toon Auteur Box', 'fectionwp-pro'),
        'description' => __('Toon auteur informatie onder blog posts.', 'fectionwp-pro'),
        'section'     => 'fwp_blog_settings',
        'type'        => 'checkbox',
    ));
    
    // Show Related Posts
    $wp_customize->add_setting('fwp_show_related_posts', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_show_related_posts', array(
        'label'       => __('Toon Gerelateerde Posts', 'fectionwp-pro'),
        'description' => __('Toon gerelateerde posts onder blog posts.', 'fectionwp-pro'),
        'section'     => 'fwp_blog_settings',
        'type'        => 'checkbox',
    ));
    
    // Excerpt Length
    $wp_customize->add_setting('fwp_excerpt_length', array(
        'default'           => '55',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_excerpt_length', array(
        'label'       => __('Excerpt Lengte (woorden)', 'fectionwp-pro'),
        'description' => __('Aantal woorden in post excerpts.', 'fectionwp-pro'),
        'section'     => 'fwp_blog_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 5,
        ),
    ));
}
add_action('customize_register', 'fwp_customize_register');

// =============================================================================
// SANITIZATION FUNCTIONS
// =============================================================================

/**
 * Sanitize container type
 */
function fwp_sanitize_container_type($input) {
    $valid = array('container', 'container-fluid', 'container-sm', 'container-md', 'container-lg', 'container-xl', 'container-xxl');
    return in_array($input, $valid, true) ? $input : 'container';
}

/**
 * Sanitize sidebar position
 */
function fwp_sanitize_sidebar_position($input) {
    $valid = array('none', 'left', 'right');
    return in_array($input, $valid, true) ? $input : 'right';
}

/**
 * Sanitize navbar type
 */
function fwp_sanitize_navbar_type($input) {
    $valid = array('standard', 'offcanvas');
    return in_array($input, $valid, true) ? $input : 'standard';
}

/**
 * Sanitize navbar scheme
 */
function fwp_sanitize_navbar_scheme($input) {
    $valid = array('light', 'dark');
    return in_array($input, $valid, true) ? $input : 'light';
}

/**
 * Sanitize checkbox
 */
function fwp_sanitize_checkbox($input) {
    return (bool) $input;
}

/**
 * Sanitize font choice
 */
function fwp_sanitize_font_choice($input) {
    $input = is_string($input) ? $input : '';
    $choices = fwp_font_choices();
    return array_key_exists($input, $choices) ? $input : '';
}

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================

/**
 * Get container type from customizer
 * 
 * @return string Container class
 */
function fwp_get_container_type() {
    return get_theme_mod('fwp_container_type', 'container');
}

// =============================================================================
// TYPOGRAPHY HELPERS
// =============================================================================

function fwp_font_choices() {
    return array(
        '' => __('Standaard (Bootstrap/theme)', 'fectionwp-pro'),

        // Google Fonts
        'google:Inter'       => __('Google: Inter', 'fectionwp-pro'),
        'google:Fredoka'     => __('Google: Fredoka', 'fectionwp-pro'),
        'google:Poppins'     => __('Google: Poppins', 'fectionwp-pro'),
        'google:Roboto'      => __('Google: Roboto', 'fectionwp-pro'),
        'google:Montserrat'  => __('Google: Montserrat', 'fectionwp-pro'),

        // Microsoft/System fonts (no external loading)
        'microsoft:Segoe UI' => __('Microsoft: Segoe UI (systeem)', 'fectionwp-pro'),
        'microsoft:Calibri'  => __('Microsoft: Calibri (systeem)', 'fectionwp-pro'),
        'system:Arial'       => __('Systeem: Arial', 'fectionwp-pro'),

        // Vendor-hosted fonts (enterprise / licensed URL)
        'custom:external'    => __('Extern (eigen font-URL)', 'fectionwp-pro'),
    );
}

function fwp_font_stack_from_choice($choice, $slot = 'body') {
    $choice = is_string($choice) ? $choice : '';
    $slot = is_string($slot) ? $slot : 'body';

    if ('' === $choice) {
        return '';
    }

    if (str_starts_with($choice, 'google:')) {
        $family = trim(substr($choice, strlen('google:')));
        return $family ? ("'" . $family . "', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif") : '';
    }

    if (str_starts_with($choice, 'microsoft:')) {
        $family = trim(substr($choice, strlen('microsoft:')));
        return $family ? ("'" . $family . "', system-ui, -apple-system, Arial, sans-serif") : '';
    }

    if ('system:Arial' === $choice) {
        return "Arial, system-ui, -apple-system, 'Segoe UI', sans-serif";
    }

    if ('custom:external' === $choice) {
        $mod_key = ('headings' === $slot) ? 'fwp_custom_font_family_headings' : 'fwp_custom_font_family_body';
        $family = trim((string) get_theme_mod($mod_key, ''));
        return $family ? ("'" . $family . "', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif") : '';
    }

    return '';
}

function fwp_google_font_family_from_choice($choice) {
    if (!is_string($choice) || !str_starts_with($choice, 'google:')) {
        return '';
    }
    return trim(substr($choice, strlen('google:')));
}

function fwp_google_font_query_for_family($family) {
    $family = is_string($family) ? trim($family) : '';
    if ('' === $family) {
        return '';
    }

    $map = array(
        'Inter'      => 'family=Inter:wght@400;600;700',
        'Fredoka'    => 'family=Fredoka:wght@400;500;600;700',
        'Poppins'    => 'family=Poppins:wght@400;600;700',
        'Roboto'     => 'family=Roboto:wght@400;500;700',
        'Montserrat' => 'family=Montserrat:wght@400;600;700',
    );

    return $map[$family] ?? ('family=' . rawurlencode($family) . ':wght@400;600;700');
}

function fwp_google_families_in_use() {
    $keys = array(
        'fwp_font_body',
        'fwp_font_headings',
        'fwp_font_sitetitle',
        'fwp_font_header_body',
        'fwp_font_header_headings',
        'fwp_font_content_body',
        'fwp_font_content_headings',
        'fwp_font_footer_body',
        'fwp_font_footer_headings',
    );

    $families = array();
    foreach ($keys as $key) {
        $choice = (string) get_theme_mod($key, '');
        $family = fwp_google_font_family_from_choice($choice);
        if ($family) {
            $families[$family] = true;
        }
    }

    return array_keys($families);
}

function fwp_uses_external_fonts() {
    $url = trim((string) get_theme_mod('fwp_custom_font_css_url', ''));
    if ('' === $url) {
        return false;
    }

    $keys = array(
        'fwp_font_body',
        'fwp_font_headings',
        'fwp_font_sitetitle',
        'fwp_font_header_body',
        'fwp_font_header_headings',
        'fwp_font_content_body',
        'fwp_font_content_headings',
        'fwp_font_footer_body',
        'fwp_font_footer_headings',
    );

    foreach ($keys as $key) {
        if ('custom:external' === (string) get_theme_mod($key, '')) {
            return true;
        }
    }

    return false;
}

/**
 * Get sidebar position from customizer
 * 
 * @return string Sidebar position (none|left|right)
 */
function fwp_get_sidebar_position() {
    return get_theme_mod('fwp_sidebar_position', 'right');
}

/**
 * Check if sidebar should be displayed
 * 
 * @return bool
 */
function fwp_has_sidebar() {
    $position = fwp_get_sidebar_position();
    
    // No sidebar if position is 'none'
    if ($position === 'none') {
        return false;
    }
    
    // Check if sidebar has active widgets
    return is_active_sidebar('primary-sidebar');
}

/**
 * Get navbar type from customizer
 * 
 * @return string Navbar type (standard|offcanvas)
 */
function fwp_get_navbar_type() {
    return get_theme_mod('fwp_navbar_type', 'standard');
}

/**
 * Get navbar sticky setting
 * 
 * @return bool
 */
function fwp_get_navbar_sticky() {
    return get_theme_mod('fwp_navbar_sticky', false);
}

/**
 * Get navbar color scheme
 * 
 * @return string Navbar scheme (light|dark)
 */
function fwp_get_navbar_scheme() {
    return get_theme_mod('fwp_navbar_scheme', 'light');
}

/**
 * Check if back to top button should be shown
 * 
 * @return bool
 */
function fwp_show_back_to_top() {
    return get_theme_mod('fwp_back_to_top', true);
}

/**
 * Check if author box should be shown
 * 
 * @return bool
 */
function fwp_show_author_box() {
    return get_theme_mod('fwp_show_author_box', true);
}

/**
 * Check if related posts should be shown
 * 
 * @return bool
 */
function fwp_show_related_posts() {
    return get_theme_mod('fwp_show_related_posts', true);
}

/**
 * Get excerpt length
 * 
 * @return int
 */
function fwp_get_excerpt_length() {
    return get_theme_mod('fwp_excerpt_length', 55);
}

/**
 * Custom excerpt length
 */
function fwp_custom_excerpt_length($length) {
    return fwp_get_excerpt_length();
}
add_filter('excerpt_length', 'fwp_custom_excerpt_length', 999);

/**
 * Live preview JS for customizer
 */
function fwp_customize_preview_js() {
    $theme_version = wp_get_theme()->get('Version');
    wp_enqueue_script(
        'fwp-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview'),
        $theme_version,
        true
    );
}
add_action('customize_preview_init', 'fwp_customize_preview_js');
