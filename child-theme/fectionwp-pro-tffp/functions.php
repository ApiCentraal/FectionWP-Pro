<?php
/**
 * FectionWP Pro – TFFP (child theme)
 */

defined( 'ABSPATH' ) || exit;

function tffp_sanitize_checkbox( $value ): bool {
    return (bool) $value;
}

function tffp_font_choices(): array {
    return array(
        '' => __( 'Standaard (theme)', 'fectionwp-pro-tffp' ),

        // Google Fonts
        'google:Inter'       => __( 'Google: Inter', 'fectionwp-pro-tffp' ),
        'google:Fredoka'     => __( 'Google: Fredoka', 'fectionwp-pro-tffp' ),
        'google:Poppins'     => __( 'Google: Poppins', 'fectionwp-pro-tffp' ),
        'google:Roboto'      => __( 'Google: Roboto', 'fectionwp-pro-tffp' ),
        'google:Montserrat'  => __( 'Google: Montserrat', 'fectionwp-pro-tffp' ),

        // Microsoft/System fonts (no external loading)
        'microsoft:Segoe UI' => __( 'Microsoft: Segoe UI (systeem)', 'fectionwp-pro-tffp' ),
        'microsoft:Calibri'  => __( 'Microsoft: Calibri (systeem)', 'fectionwp-pro-tffp' ),
        'system:Arial'       => __( 'Systeem: Arial', 'fectionwp-pro-tffp' ),

        // Vendor-hosted fonts (e.g. Microsoft cloud fonts via your licensed stylesheet URL)
        'custom:external'    => __( 'Extern (eigen font-URL)', 'fectionwp-pro-tffp' ),
    );
}

function tffp_sanitize_font_choice( $value ): string {
    $value = is_string( $value ) ? $value : '';
    $choices = tffp_font_choices();
    return array_key_exists( $value, $choices ) ? $value : '';
}

function tffp_font_stack_from_choice( string $choice, string $slot = 'body' ): string {
    if ( '' === $choice ) {
        return '';
    }

    if ( str_starts_with( $choice, 'google:' ) ) {
        $family = trim( substr( $choice, strlen( 'google:' ) ) );
        return $family ? ( "'" . $family . "', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif" ) : '';
    }

    if ( str_starts_with( $choice, 'microsoft:' ) ) {
        $family = trim( substr( $choice, strlen( 'microsoft:' ) ) );
        return $family ? ( "'" . $family . "', system-ui, -apple-system, Arial, sans-serif" ) : '';
    }

    if ( 'system:Arial' === $choice ) {
        return "Arial, system-ui, -apple-system, 'Segoe UI', sans-serif";
    }

    if ( 'custom:external' === $choice ) {
        $mod_key = ( 'headings' === $slot ) ? 'tffp_custom_font_family_headings' : 'tffp_custom_font_family_body';
        $family = trim( (string) get_theme_mod( $mod_key, '' ) );
        return $family ? ( "'" . $family . "', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif" ) : '';
    }

    return '';
}

function tffp_google_font_family_from_choice( string $choice ): string {
    if ( ! str_starts_with( $choice, 'google:' ) ) {
        return '';
    }
    return trim( substr( $choice, strlen( 'google:' ) ) );
}

function tffp_google_font_query_for_family( string $family ): string {
    $family = trim( $family );
    if ( '' === $family ) {
        return '';
    }

    $map = array(
        'Inter'      => 'family=Inter:wght@400;600;700',
        'Fredoka'    => 'family=Fredoka:wght@400;500;600;700',
        'Poppins'    => 'family=Poppins:wght@400;600;700',
        'Roboto'     => 'family=Roboto:wght@400;500;700',
        'Montserrat' => 'family=Montserrat:wght@400;600;700',
    );

    return $map[ $family ] ?? ( 'family=' . rawurlencode( $family ) . ':wght@400;600;700' );
}

function tffp_google_families_in_use(): array {
    $keys = array(
        'tffp_font_body' => 'google:Inter',
        'tffp_font_headings' => 'google:Fredoka',

        'tffp_font_section_hero' => '',
        'tffp_font_section_hero_headings' => '',
        'tffp_font_section_stats' => '',
        'tffp_font_section_stats_headings' => '',
        'tffp_font_section_testimonials' => '',
        'tffp_font_section_testimonials_headings' => '',
        'tffp_font_section_locations' => '',
        'tffp_font_section_locations_headings' => '',
    );

    $families = array();
    foreach ( $keys as $key => $default ) {
        $choice = (string) get_theme_mod( $key, $default );

        // If global is set to theme default, still include the theme’s default Google fonts.
        if ( '' === $choice && ( 'tffp_font_body' === $key || 'tffp_font_headings' === $key ) ) {
            $choice = (string) $default;
        }

        $family = tffp_google_font_family_from_choice( $choice );
        if ( $family ) {
            $families[ $family ] = true;
        }
    }

    return array_keys( $families );
}

function tffp_uses_external_fonts(): bool {
    $url = trim( (string) get_theme_mod( 'tffp_custom_font_css_url', '' ) );
    if ( '' === $url ) {
        return false;
    }

    $keys = array(
        'tffp_font_body',
        'tffp_font_headings',
        'tffp_font_section_hero',
        'tffp_font_section_hero_headings',
        'tffp_font_section_stats',
        'tffp_font_section_stats_headings',
        'tffp_font_section_testimonials',
        'tffp_font_section_testimonials_headings',
        'tffp_font_section_locations',
        'tffp_font_section_locations_headings',
    );

    foreach ( $keys as $key ) {
        if ( 'custom:external' === (string) get_theme_mod( $key, '' ) ) {
            return true;
        }
    }

    return false;
}

// Ensure menu locations exist (rendered by parent theme header).
add_action( 'after_setup_theme', function () {
    register_nav_menus( array(
        'primary' => __( 'Hoofdmenu', 'fectionwp-pro' ),
        'utility' => __( 'Top menu (logo/iconen)', 'fectionwp-pro' ),
        'footer'  => __( 'Footer Menu', 'fectionwp-pro' ),
    ) );
}, 20 );

// Prevent duplicate hero output: TFFP uses its own hero sections on key pages.
add_filter( 'fwp_render_hero_in_header', function ( $enabled, $context ) {
    if ( 'landing' === $context ) {
        $disable_parent_hero = (bool) get_theme_mod( 'tffp_disable_parent_hero_in_landing_header', true );
        return $disable_parent_hero ? false : $enabled;
    }

    if ( 'default' === $context ) {
        $disable_parent_hero = (bool) get_theme_mod( 'tffp_disable_parent_hero_in_default_header', false );
        return $disable_parent_hero ? false : $enabled;
    }

    return $enabled;
}, 10, 2 );

/**
 * Ensure the custom page templates are selectable in wp-admin.
 *
 * WordPress normally detects templates by scanning file headers. In some environments
 * (caching, unusual installs, theme packaging), the scan can be flaky. This forces the
 * templates into the dropdown as long as the files exist in the active (child) theme.
 */
function tffp_page_templates_map(): array {
    return array(
        'page-contact.php'       => __( 'Contact (TFFP)', 'fectionwp-pro-tffp' ),
        'page-galerij.php'       => __( 'Galerij (TFFP)', 'fectionwp-pro-tffp' ),
        'page-kinderfeestjes.php'=> __( 'Kinderfeestjes (TFFP)', 'fectionwp-pro-tffp' ),
        'page-festivals.php'     => __( 'Festivals (TFFP)', 'fectionwp-pro-tffp' ),
        'page-glitter.php'       => __( 'Glitter (TFFP)', 'fectionwp-pro-tffp' ),
        'page-cadeaubon.php'     => __( 'Cadeaubon (TFFP)', 'fectionwp-pro-tffp' ),
    );
}

add_filter( 'theme_page_templates', function ( $templates, $theme, $post, $post_type ) {
    if ( 'page' !== $post_type ) {
        return $templates;
    }

    $map = tffp_page_templates_map();
    foreach ( $map as $file => $label ) {
        if ( is_string( $file ) && is_string( $label ) && file_exists( get_stylesheet_directory() . '/' . $file ) ) {
            $templates[ $file ] = $label;
        }
    }

    return $templates;
}, 20, 4 );

// Optional debug: visit /wp-admin/?tffp_debug_templates=1 as admin.
add_action( 'admin_notices', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( ! isset( $_GET['tffp_debug_templates'] ) ) {
        return;
    }

    $theme = wp_get_theme();
    $templates = $theme->get_page_templates();

    echo '<div class="notice notice-info"><p><strong>TFFP template debug</strong></p>';
    echo '<p>Active theme: <code>' . esc_html( $theme->get( 'Name' ) ) . '</code></p>';
    echo '<p>Stylesheet: <code>' . esc_html( $theme->get_stylesheet() ) . '</code> | Template: <code>' . esc_html( $theme->get_template() ) . '</code></p>';
    echo '<p>Detected page templates: <code>' . esc_html( implode( ', ', array_keys( $templates ) ) ) . '</code></p>';
    echo '</div>';
} );

/**
 * Theme options (Customizer)
 *
 * Keep it minimal: WhatsApp number + default message + contact email/phone.
 */
add_action( 'customize_register', function ( $wp_customize ) {
    $wp_customize->add_section( 'tffp_header', array(
        'title'    => __( 'TFFP Header', 'fectionwp-pro-tffp' ),
        'priority' => 161,
    ) );

    $wp_customize->add_setting( 'tffp_disable_parent_hero_in_landing_header', array(
        'default'           => true,
        'sanitize_callback' => 'tffp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'tffp_disable_parent_hero_in_landing_header', array(
        'label'       => __( 'Hero tonen in landing header', 'fectionwp-pro-tffp' ),
        'description' => __( 'Toont de hero uit de parent Customizer ook op templates met de landing header. Zet dit uit als je een eigen hero/intro gebruikt en dubbele content wilt voorkomen.', 'fectionwp-pro-tffp' ),
        'section'     => 'tffp_header',
        'type'        => 'checkbox',
        'priority'    => 10,
    ) );

    $wp_customize->add_setting( 'tffp_disable_parent_hero_in_default_header', array(
        'default'           => false,
        'sanitize_callback' => 'tffp_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'tffp_disable_parent_hero_in_default_header', array(
        'label'       => __( 'Hero tonen in standaard header', 'fectionwp-pro-tffp' ),
        'description' => __( 'Toont de hero uit de parent Customizer ook op templates met de standaard header. Zet dit uit als je een eigen hero/intro gebruikt en dubbele content wilt voorkomen.', 'fectionwp-pro-tffp' ),
        'section'     => 'tffp_header',
        'type'        => 'checkbox',
        'priority'    => 20,
    ) );

    $wp_customize->add_section( 'tffp_contact', array(
        'title'    => __( 'TFFP Contact', 'fectionwp-pro-tffp' ),
        'priority' => 160,
    ) );

    $wp_customize->add_setting( 'tffp_whatsapp_number', array(
        'default'           => '31612345678',
        'sanitize_callback' => function ( $value ) {
            $value = preg_replace( '/\D+/', '', (string) $value );
            return $value;
        },
    ) );

    $wp_customize->add_control( 'tffp_whatsapp_number', array(
        'type'        => 'text',
        'section'     => 'tffp_contact',
        'label'       => __( 'WhatsApp number (digits only)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Example: 31612345678 (no +, no spaces).', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_whatsapp_prefill', array(
        'default'           => __( 'Hallo! Ik wil graag informatie over jullie diensten.', 'fectionwp-pro-tffp' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_whatsapp_prefill', array(
        'type'        => 'text',
        'section'     => 'tffp_contact',
        'label'       => __( 'WhatsApp default message', 'fectionwp-pro-tffp' ),
        'description' => __( 'Used for the WhatsApp button and floating action button.', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_contact_email', array(
        'default'           => 'info@thefunkyfacepainter.nl',
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'tffp_contact_email', array(
        'type'    => 'email',
        'section' => 'tffp_contact',
        'label'   => __( 'Contact email', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_contact_phone', array(
        'default'           => '+31 6 1234 5678',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_contact_phone', array(
        'type'        => 'text',
        'section'     => 'tffp_contact',
        'label'       => __( 'Contact phone (display)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Shown on the contact page. For the WhatsApp link, the digits-only WhatsApp number is used.', 'fectionwp-pro-tffp' ),
    ) );

    // Typography (Google + Microsoft/System) - per section
    $wp_customize->add_section( 'tffp_typography', array(
        'title'    => __( 'TFFP Typography', 'fectionwp-pro-tffp' ),
        'priority' => 161,
    ) );

    $choices = tffp_font_choices();

    $wp_customize->add_setting( 'tffp_font_body', array(
        'default'           => 'google:Inter',
        'sanitize_callback' => 'tffp_sanitize_font_choice',
    ) );

    $wp_customize->add_control( 'tffp_font_body', array(
        'type'    => 'select',
        'section' => 'tffp_typography',
        'label'   => __( 'Body font (global)', 'fectionwp-pro-tffp' ),
        'choices' => $choices,
    ) );

    $wp_customize->add_setting( 'tffp_font_headings', array(
        'default'           => 'google:Fredoka',
        'sanitize_callback' => 'tffp_sanitize_font_choice',
    ) );

    $wp_customize->add_control( 'tffp_font_headings', array(
        'type'    => 'select',
        'section' => 'tffp_typography',
        'label'   => __( 'Headings font (global)', 'fectionwp-pro-tffp' ),
        'choices' => $choices,
    ) );

    $wp_customize->add_setting( 'tffp_custom_font_css_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'tffp_custom_font_css_url', array(
        'type'        => 'url',
        'section'     => 'tffp_typography',
        'label'       => __( 'Extern font stylesheet URL', 'fectionwp-pro-tffp' ),
        'description' => __( 'Plak hier een URL naar een CSS stylesheet die jouw fonts definieert (@font-face). Alleen nodig als je “Extern (eigen font-URL)” kiest. Gebruik alleen fonts/URL’s waarvoor je licentie hebt.', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_custom_font_family_body', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_custom_font_family_body', array(
        'type'        => 'text',
        'section'     => 'tffp_typography',
        'label'       => __( 'Extern font family name (body)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Moet exact matchen met de font-family naam uit het externe stylesheet.', 'fectionwp-pro-tffp' ),
    ) );

    $wp_customize->add_setting( 'tffp_custom_font_family_headings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'tffp_custom_font_family_headings', array(
        'type'        => 'text',
        'section'     => 'tffp_typography',
        'label'       => __( 'Extern font family name (headings)', 'fectionwp-pro-tffp' ),
        'description' => __( 'Moet exact matchen met de font-family naam uit het externe stylesheet.', 'fectionwp-pro-tffp' ),
    ) );

    $section_choices = array( '' => __( 'Overnemen van global', 'fectionwp-pro-tffp' ) ) + array_diff_key( $choices, array( '' => true ) );
    $sections = array(
        'hero'         => __( 'Hero', 'fectionwp-pro-tffp' ),
        'stats'        => __( 'Stats', 'fectionwp-pro-tffp' ),
        'testimonials' => __( 'Testimonials', 'fectionwp-pro-tffp' ),
        'locations'    => __( 'Locations', 'fectionwp-pro-tffp' ),
    );

    foreach ( $sections as $key => $label ) {
        $wp_customize->add_setting( 'tffp_font_section_' . $key, array(
            'default'           => '',
            'sanitize_callback' => 'tffp_sanitize_font_choice',
        ) );

        $wp_customize->add_control( 'tffp_font_section_' . $key, array(
            'type'    => 'select',
            'section' => 'tffp_typography',
            'label'   => sprintf( __( '%s section font (body)', 'fectionwp-pro-tffp' ), $label ),
            'choices' => $section_choices,
        ) );

        $wp_customize->add_setting( 'tffp_font_section_' . $key . '_headings', array(
            'default'           => '',
            'sanitize_callback' => 'tffp_sanitize_font_choice',
        ) );

        $wp_customize->add_control( 'tffp_font_section_' . $key . '_headings', array(
            'type'    => 'select',
            'section' => 'tffp_typography',
            'label'   => sprintf( __( '%s section font (headings)', 'fectionwp-pro-tffp' ), $label ),
            'choices' => $section_choices,
        ) );
    }
} );

function tffp_get_whatsapp_number(): string {
    $number = get_theme_mod( 'tffp_whatsapp_number', '31612345678' );
    $number = preg_replace( '/\D+/', '', (string) $number );
    return $number ?: '31612345678';
}

function tffp_get_whatsapp_prefill(): string {
    $prefill = (string) get_theme_mod( 'tffp_whatsapp_prefill', __( 'Hallo! Ik wil graag informatie over jullie diensten.', 'fectionwp-pro-tffp' ) );
    return trim( wp_strip_all_tags( $prefill ) );
}

function tffp_get_whatsapp_url( string $message ): string {
    $number = tffp_get_whatsapp_number();
    $message = trim( wp_strip_all_tags( $message ) );
    return 'https://wa.me/' . rawurlencode( $number ) . '?text=' . rawurlencode( $message );
}

/**
 * Enqueue TFFP token overrides + custom styles.
 *
 * Parent theme laadt Bootstrap + `fwp-style` (child style.css) + `fwp-custom`.
 * Hier voegen we TFFP assets toe na `fwp-custom`.
 */
add_action( 'wp_enqueue_scripts', function () {
    $child_dir = get_stylesheet_directory();
    $child_uri = get_stylesheet_directory_uri();

    // Google Fonts (dynamic based on Customizer).
    $families = tffp_google_families_in_use();
    $queries = array();
    foreach ( $families as $family ) {
        $q = tffp_google_font_query_for_family( $family );
        if ( $q ) {
            $queries[] = $q;
        }
    }

    if ( ! empty( $queries ) ) {
        $google_url = 'https://fonts.googleapis.com/css2?' . implode( '&', $queries ) . '&display=swap';
        wp_enqueue_style( 'tffp-google-fonts', $google_url, array(), null );
    } else {
        // Keep dependency chain intact without loading external resources.
        wp_register_style( 'tffp-google-fonts', false, array(), null );
        wp_enqueue_style( 'tffp-google-fonts' );
    }

    // External vendor stylesheet (e.g. Microsoft cloud fonts via your licensed URL)
    if ( tffp_uses_external_fonts() ) {
        $external_url = trim( (string) get_theme_mod( 'tffp_custom_font_css_url', '' ) );
        if ( $external_url ) {
            wp_enqueue_style( 'tffp-external-fonts', $external_url, array(), null );
        }
    }
    if ( ! wp_style_is( 'tffp-external-fonts', 'enqueued' ) ) {
        wp_register_style( 'tffp-external-fonts', false, array(), null );
        wp_enqueue_style( 'tffp-external-fonts' );
    }

    $tokens_path = $child_dir . '/assets/css/tffp-tokens.css';
    if ( file_exists( $tokens_path ) ) {
        wp_enqueue_style(
            'tffp-tokens',
            $child_uri . '/assets/css/tffp-tokens.css',
            array( 'fwp-custom', 'tffp-google-fonts', 'tffp-external-fonts' ),
            filemtime( $tokens_path )
        );
    }

    $tffp_path = $child_dir . '/assets/css/tffp.css';
    if ( file_exists( $tffp_path ) ) {
        wp_enqueue_style(
            'tffp-style',
            $child_uri . '/assets/css/tffp.css',
            array( 'tffp-tokens' ),
            filemtime( $tffp_path )
        );
    }

    // Inject typography variables (global + per section)
    $inline_handle = wp_style_is( 'tffp-style', 'enqueued' ) ? 'tffp-style' : 'tffp-tokens';
    $inline_css = '';

    $body_choice = (string) get_theme_mod( 'tffp_font_body', 'google:Inter' );
    $head_choice = (string) get_theme_mod( 'tffp_font_headings', 'google:Fredoka' );
    $body_stack  = tffp_font_stack_from_choice( $body_choice ?: 'google:Inter', 'body' );
    $head_stack  = tffp_font_stack_from_choice( $head_choice ?: 'google:Fredoka', 'headings' );

    if ( $body_stack || $head_stack ) {
        $inline_css .= ':root{';
        if ( $body_stack ) {
            $inline_css .= '--tffp-font-body:' . $body_stack . ';';
            $inline_css .= '--bs-font-sans-serif:' . $body_stack . ';';
        }
        if ( $head_stack ) {
            $inline_css .= '--tffp-font-heading:' . $head_stack . ';';
        }
        $inline_css .= "}\n";
    }

    $section_map = array(
        'hero'         => '.tffp-hero',
        'stats'        => '.tffp-stats',
        'testimonials' => '.tffp-testimonials',
        'locations'    => '.tffp-locations',
    );

    foreach ( $section_map as $key => $selector ) {
        $section_body_choice = (string) get_theme_mod( 'tffp_font_section_' . $key, '' );
        $section_head_choice = (string) get_theme_mod( 'tffp_font_section_' . $key . '_headings', '' );

        $section_body_stack = tffp_font_stack_from_choice( $section_body_choice, 'body' );
        $section_head_stack = tffp_font_stack_from_choice( $section_head_choice, 'headings' );

        if ( ! $section_body_stack && ! $section_head_stack ) {
            continue;
        }

        $inline_css .= $selector . '{';
        if ( $section_body_stack ) {
            $inline_css .= '--tffp-section-font:' . $section_body_stack . ';';
        }
        if ( $section_head_stack ) {
            $inline_css .= '--tffp-section-heading-font:' . $section_head_stack . ';';
        }
        $inline_css .= "}\n";
    }

    if ( $inline_css ) {
        wp_add_inline_style( $inline_handle, $inline_css );
    }

    // If FectionWP-Booking booking form is present, load overrides AFTER plugin CSS.
    // Plugin handle: `pbp-public-css` (see plugin bootstrap file).
    // Note: booking form may be rendered via templates (not page content), so also allow the contact template.
    $has_booking_form = false;
    if ( function_exists( 'has_shortcode' ) ) {
        global $post;
        $has_booking_form = is_a( $post, 'WP_Post' ) && has_shortcode( (string) $post->post_content, 'pbp_booking_form' );
    }
    if ( $has_booking_form || is_page_template( 'page-contact.php' ) ) {
        $pbp_overrides_path = $child_dir . '/assets/css/tffp-pbp-overrides.css';
        if ( file_exists( $pbp_overrides_path ) ) {
            wp_enqueue_style(
                'tffp-pbp-overrides',
                $child_uri . '/assets/css/tffp-pbp-overrides.css',
                array( 'pbp-public-css', 'tffp-style' ),
                filemtime( $pbp_overrides_path )
            );
        }
    }

    // Minimal JS for the WhatsApp contact form on the contact page.
    if ( is_page_template( 'page-contact.php' ) ) {
        $contact_js = $child_dir . '/assets/js/tffp-contact.js';
        if ( file_exists( $contact_js ) ) {
            wp_enqueue_script(
                'tffp-contact',
                $child_uri . '/assets/js/tffp-contact.js',
                array(),
                filemtime( $contact_js ),
                true
            );
        }
    }

    // Minimal JS for the React-like gallery UI on the gallery page.
    if ( is_page_template( 'page-galerij.php' ) ) {
        $gallery_js = $child_dir . '/assets/js/tffp-gallery.js';
        if ( file_exists( $gallery_js ) ) {
            wp_enqueue_script(
                'tffp-gallery',
                $child_uri . '/assets/js/tffp-gallery.js',
                array(),
                filemtime( $gallery_js ),
                true
            );
        }
    }
}, 30 );

// Force FectionWP-Booking public assets on pages where the booking form is rendered via PHP templates.
// The plugin conditionally enqueues assets by scanning post_content for the shortcode.
add_filter( 'fectionwp_booking_load_assets', function ( $should_load ) {
    if ( $should_load ) {
        return true;
    }

    if ( is_page_template( 'page-contact.php' ) ) {
        return true;
    }

    return false;
} );

// Redirect legacy SPA admin route to WordPress admin.
add_action( 'template_redirect', function () {
    if ( is_admin() ) {
        return;
    }

    if ( empty( $_SERVER['REQUEST_URI'] ) ) {
        return;
    }

    $request_path = wp_parse_url( home_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), PHP_URL_PATH );
    if ( ! is_string( $request_path ) ) {
        return;
    }

    $site_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
    $site_path = is_string( $site_path ) ? rtrim( $site_path, '/' ) : '';

    // Normalize and compare against the install base path.
    $relative = $request_path;
    if ( '' !== $site_path && str_starts_with( $relative, $site_path ) ) {
        $relative = substr( $relative, strlen( $site_path ) );
    }

    $relative = '/' . ltrim( $relative, '/' );

    if ( '/admin' === rtrim( $relative, '/' ) ) {
        wp_safe_redirect( admin_url(), 302 );
        exit;
    }
}, 1 );

// Global WhatsApp floating action button.
add_action( 'wp_footer', function () {
    if ( is_admin() ) {
        return;
    }

    get_template_part( 'template-parts/tffp/whatsapp-fab' );
}, 50 );

// Resource hints for Google Fonts.
add_filter( 'wp_resource_hints', function ( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        if ( empty( tffp_google_families_in_use() ) ) {
            return $urls;
        }
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}, 10, 2 );
