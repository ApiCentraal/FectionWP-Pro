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
