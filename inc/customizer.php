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

    // Font families (shared choices) – needed by multiple sections (e.g. Topbar).
    $font_choices = fwp_font_choices();
    
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

    // Logo position (left/center/right)
    $wp_customize->add_setting('fwp_navbar_logo_position', array(
        'default'           => 'left',
        'sanitize_callback' => 'fwp_sanitize_navbar_logo_position',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_navbar_logo_position', array(
        'label'       => __('Logo positie', 'fectionwp-pro'),
        'description' => __('Kies waar het logo/brand in de navbar staat (desktop).', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __('Links', 'fectionwp-pro'),
            'center' => __('Midden', 'fectionwp-pro'),
            'right'  => __('Rechts', 'fectionwp-pro'),
        ),
    ));

    // Show/hide logo in main navbar
    $wp_customize->add_setting('fwp_navbar_show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_navbar_show_logo', array(
        'label'       => __('Logo tonen in hoofdmenu', 'fectionwp-pro'),
        'description' => __('Zet uit om het logo/brand in de navbar te verbergen (handig als je het logo alleen in de utility bar wilt).', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
        'type'        => 'checkbox',
    ));

    // Menu alignment (left/center/right)
    $wp_customize->add_setting('fwp_nav_menu_alignment', array(
        'default'           => 'right',
        'sanitize_callback' => 'fwp_sanitize_nav_menu_alignment',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_nav_menu_alignment', array(
        'label'       => __('Menu uitlijning', 'fectionwp-pro'),
        'description' => __('Kies hoe de menu items uitlijnen in de navbar (desktop).', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __('Links', 'fectionwp-pro'),
            'center' => __('Midden', 'fectionwp-pro'),
            'right'  => __('Rechts', 'fectionwp-pro'),
        ),
    ));

    // Navbar colors
    $wp_customize->add_setting('fwp_navbar_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_navbar_bg_color', array(
        'label'       => __('Navbar achtergrondkleur', 'fectionwp-pro'),
        'description' => __('Laat leeg om Bootstrap/thema default te gebruiken.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
    )));

    $wp_customize->add_setting('fwp_navbar_link_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_navbar_link_color', array(
        'label'       => __('Navbar link kleur', 'fectionwp-pro'),
        'description' => __('Kleur voor menu links in de navbar. Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
    )));

    $wp_customize->add_setting('fwp_navbar_link_hover_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_navbar_link_hover_color', array(
        'label'       => __('Navbar link hover kleur', 'fectionwp-pro'),
        'description' => __('Hover/active kleur voor menu links. Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
    )));

    $wp_customize->add_setting('fwp_navbar_brand_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_navbar_brand_color', array(
        'label'       => __('Navbar logo/brand kleur', 'fectionwp-pro'),
        'description' => __('Kleur voor logo/brand (vooral relevant bij tekst-logo). Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_nav_settings',
    )));
    
    // =============================================================================
    // SECTION: Site Title / Logo Styling
    // =============================================================================
    
    $wp_customize->add_section('fwp_logo_styling', array(
        'title'       => __('Site Titel / Logo Styling', 'fectionwp-pro'),
        'description' => __('Pas de styling van de site titel (tekst logo) aan. Deze instellingen zijn alleen zichtbaar als er geen custom logo afbeelding is geüpload.', 'fectionwp-pro'),
        'priority'    => 32,
    ));
    
    // Site Title Font Family
    $wp_customize->add_setting('fwp_site_title_font', array(
        'default'           => '',
        'sanitize_callback' => 'fwp_sanitize_font_choice',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_font', array(
        'label'       => __('Lettertype', 'fectionwp-pro'),
        'description' => __('Kies een lettertype voor de site titel. Laat leeg voor thema default.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'select',
        'choices'     => $font_choices,
    ));
    
    // Site Title Font Size
    $wp_customize->add_setting('fwp_site_title_font_size', array(
        'default'           => 24,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_font_size', array(
        'label'       => __('Lettergrootte (px)', 'fectionwp-pro'),
        'description' => __('Grootte van de site titel in pixels.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 72,
            'step' => 1,
        ),
    ));
    
    // Site Title Font Weight
    $wp_customize->add_setting('fwp_site_title_font_weight', array(
        'default'           => '700',
        'sanitize_callback' => 'fwp_sanitize_font_weight',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_font_weight', array(
        'label'       => __('Dikte', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'select',
        'choices'     => array(
            '300' => __('Light (300)', 'fectionwp-pro'),
            '400' => __('Normal (400)', 'fectionwp-pro'),
            '500' => __('Medium (500)', 'fectionwp-pro'),
            '600' => __('Semi-Bold (600)', 'fectionwp-pro'),
            '700' => __('Bold (700)', 'fectionwp-pro'),
            '800' => __('Extra Bold (800)', 'fectionwp-pro'),
            '900' => __('Black (900)', 'fectionwp-pro'),
        ),
    ));
    
    // Site Title Text Transform
    $wp_customize->add_setting('fwp_site_title_text_transform', array(
        'default'           => 'none',
        'sanitize_callback' => 'fwp_sanitize_text_transform',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_text_transform', array(
        'label'       => __('Tekst transformatie', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'select',
        'choices'     => array(
            'none'       => __('Geen', 'fectionwp-pro'),
            'uppercase'  => __('HOOFDLETTERS', 'fectionwp-pro'),
            'lowercase'  => __('kleine letters', 'fectionwp-pro'),
            'capitalize' => __('Eerste Letter Hoofdletter', 'fectionwp-pro'),
        ),
    ));
    
    // Site Title Letter Spacing
    $wp_customize->add_setting('fwp_site_title_letter_spacing', array(
        'default'           => 0,
        'sanitize_callback' => 'fwp_sanitize_letter_spacing',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_letter_spacing', array(
        'label'       => __('Letter spacing (px)', 'fectionwp-pro'),
        'description' => __('Ruimte tussen letters. 0 = normaal, negatieve waarden = dichter bij elkaar.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => -5,
            'max'  => 20,
            'step' => 0.5,
        ),
    ));
    
    // Site Title Color (Main)
    $wp_customize->add_setting('fwp_site_title_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_site_title_color', array(
        'label'       => __('Tekst kleur', 'fectionwp-pro'),
        'description' => __('Kleur voor de site titel. Laat leeg voor navbar default.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
    )));
    
    // Site Title Hover Color
    $wp_customize->add_setting('fwp_site_title_hover_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_site_title_hover_color', array(
        'label'       => __('Hover kleur', 'fectionwp-pro'),
        'description' => __('Kleur wanneer de cursor over de titel beweegt.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
    )));
    
    // Site Title Background Color
    $wp_customize->add_setting('fwp_site_title_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_site_title_bg_color', array(
        'label'       => __('Achtergrondkleur', 'fectionwp-pro'),
        'description' => __('Optionele achtergrondkleur achter de titel (voor badge/button effect).', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
    )));
    
    // Site Title Padding
    $wp_customize->add_setting('fwp_site_title_padding', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_padding', array(
        'label'       => __('Padding (px)', 'fectionwp-pro'),
        'description' => __('Ruimte rondom de tekst (vooral nuttig met achtergrondkleur).', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 30,
            'step' => 1,
        ),
    ));
    
    // Site Title Border Radius
    $wp_customize->add_setting('fwp_site_title_border_radius', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_border_radius', array(
        'label'       => __('Afronding hoeken (px)', 'fectionwp-pro'),
        'description' => __('Ronde hoeken (vooral nuttig met achtergrondkleur).', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
    ));
    
    // Site Title Shadow
    $wp_customize->add_setting('fwp_site_title_text_shadow', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_text_shadow', array(
        'label'       => __('Tekst schaduw', 'fectionwp-pro'),
        'description' => __('Voeg een subtiele schaduw toe aan de tekst.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'checkbox',
    ));
    
    // Site Title Style Preset
    $wp_customize->add_setting('fwp_site_title_preset', array(
        'default'           => 'none',
        'sanitize_callback' => 'fwp_sanitize_title_preset',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_site_title_preset', array(
        'label'       => __('Stijl voorinstelling', 'fectionwp-pro'),
        'description' => __('Kies een vooraf gedefinieerde stijl. Individuele instellingen overschrijven deze preset.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'select',
        'choices'     => array(
            'none'      => __('Geen (custom)', 'fectionwp-pro'),
            'minimal'   => __('Minimalistisch', 'fectionwp-pro'),
            'bold'      => __('Bold & Modern', 'fectionwp-pro'),
            'elegant'   => __('Elegant', 'fectionwp-pro'),
            'playful'   => __('Speels', 'fectionwp-pro'),
            'badge'     => __('Badge stijl', 'fectionwp-pro'),
            'outlined'  => __('Outlined', 'fectionwp-pro'),
        ),
    ));
    
    // Mobile specific settings
    $wp_customize->add_setting('fwp_site_title_mobile_size', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_site_title_mobile_size', array(
        'label'       => __('Mobiele lettergrootte (px)', 'fectionwp-pro'),
        'description' => __('Aparte grootte voor mobiel. Laat op 0 voor automatisch.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 48,
            'step' => 1,
        ),
    ));
    
    // Show tagline option
    $wp_customize->add_setting('fwp_show_tagline', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_show_tagline', array(
        'label'       => __('Tagline tonen', 'fectionwp-pro'),
        'description' => __('Toon de site tagline onder de titel.', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'checkbox',
    ));
    
    // Tagline font size
    $wp_customize->add_setting('fwp_tagline_font_size', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_tagline_font_size', array(
        'label'       => __('Tagline lettergrootte (px)', 'fectionwp-pro'),
        'section'     => 'fwp_logo_styling',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 8,
            'max'  => 24,
            'step' => 1,
        ),
    ));
    
    // =============================================================================
    // SECTION: Topbar Settings (existing section continues below)
    // =============================================================================

    // =============================================================================
    // SECTION: Topbar / News bar
    // =============================================================================

    $wp_customize->add_section('fwp_topbar_settings', array(
        'title'    => __('Topbar / Nieuwsbalk', 'fectionwp-pro'),
        'priority' => 31.5,
    ));

    $wp_customize->add_setting('fwp_topbar_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_enabled', array(
        'label'       => __('Topbar inschakelen', 'fectionwp-pro'),
        'description' => __('Toon een smalle balk boven de navbar (bijv. nieuws/actie).', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_topbar_scrolling', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_scrolling', array(
        'label'       => __('Scrolling (marquee)', 'fectionwp-pro'),
        'description' => __('Laat de topbar tekst automatisch scrollen. Let op: bij “Verminderde beweging” in het OS wordt scrollen automatisch uitgeschakeld.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_topbar_scroll_duration', array(
        'default'           => 18,
        'sanitize_callback' => 'fwp_sanitize_topbar_scroll_duration',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_scroll_duration', array(
        'label'       => __('Scroll snelheid (seconden)', 'fectionwp-pro'),
        'description' => __('Hoe hoger, hoe langzamer. Bijvoorbeeld 18–30 seconden.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 8,
            'max'  => 60,
            'step' => 1,
        ),
    ));

    // Topbar typography
    $wp_customize->add_setting('fwp_topbar_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'fwp_sanitize_font_choice',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_font_family', array(
        'label'       => __('Topbar font', 'fectionwp-pro'),
        'description' => __('Lettertype voor de topbar. “Standaard” volgt de globale body font.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'select',
        'choices'     => $font_choices,
    ));

    $wp_customize->add_setting('fwp_topbar_font_size', array(
        'default'           => 14,
        'sanitize_callback' => 'fwp_sanitize_topbar_font_size',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_font_size', array(
        'label'       => __('Topbar fontgrootte (px)', 'fectionwp-pro'),
        'description' => __('Bijv. 12–16px. Wordt toegepast op de topbar (ook bij scrolling).', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 20,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('fwp_topbar_content', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_content', array(
        'label'       => __('Topbar content', 'fectionwp-pro'),
        'description' => __('Tekst/HTML toegestaan (bijv. link). Voorbeeld: <a href="/contact/">Nu boeken</a>.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'textarea',
    ));

    $wp_customize->add_setting('fwp_topbar_alignment', array(
        'default'           => 'center',
        'sanitize_callback' => 'fwp_sanitize_topbar_alignment',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_topbar_alignment', array(
        'label'       => __('Topbar uitlijning', 'fectionwp-pro'),
        'description' => __('Uitlijning van de topbar tekst.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __('Links', 'fectionwp-pro'),
            'center' => __('Midden', 'fectionwp-pro'),
            'right'  => __('Rechts', 'fectionwp-pro'),
        ),
    ));

    $wp_customize->add_setting('fwp_topbar_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_topbar_bg_color', array(
        'label'       => __('Topbar achtergrondkleur', 'fectionwp-pro'),
        'description' => __('Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
    )));

    $wp_customize->add_setting('fwp_topbar_text_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_topbar_text_color', array(
        'label'       => __('Topbar tekstkleur', 'fectionwp-pro'),
        'description' => __('Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
    )));

    $wp_customize->add_setting('fwp_topbar_link_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_topbar_link_color', array(
        'label'       => __('Topbar link kleur', 'fectionwp-pro'),
        'description' => __('Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_topbar_settings',
    )));

    // =============================================================================
    // SECTION: Utility bar / Top menu (logo/iconen)
    // =============================================================================

    $wp_customize->add_section('fwp_utilitybar_settings', array(
        'title'    => __('Utility bar / Top menu', 'fectionwp-pro'),
        'priority' => 31.7,
    ));

    $wp_customize->add_setting('fwp_utilitybar_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_enabled', array(
        'label'       => __('Utility bar inschakelen', 'fectionwp-pro'),
        'description' => __('Toon een extra balk tussen de topbar/nieuwsbalk en het hoofdmenu (bijv. logo + iconen/links).', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_show_logo', array(
        'label'       => __('Logo tonen in utility bar', 'fectionwp-pro'),
        'description' => __('Handig als je het hoofdmenu compacter wilt houden (logo boven, menu eronder).', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_logo_position', array(
        'default'           => 'left',
        'sanitize_callback' => 'fwp_sanitize_utilitybar_logo_position',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_logo_position', array(
        'label'       => __('Logo positie in utility bar', 'fectionwp-pro'),
        'description' => __('Links/midden/rechts (op desktop).', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __('Links', 'fectionwp-pro'),
            'center' => __('Midden', 'fectionwp-pro'),
            'right'  => __('Rechts', 'fectionwp-pro'),
        ),
    ));

    $wp_customize->add_setting('fwp_utilitybar_show_icon_labels', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_show_icon_labels', array(
        'label'       => __('Iconen: tekstlabels tonen', 'fectionwp-pro'),
        'description' => __('Als uit: menu-items met een bi-* class worden als “alleen icoon” gerenderd (titel blijft toegankelijk voor screenreaders).', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_icon_size', array(
        'default'           => 18,
        'sanitize_callback' => 'fwp_sanitize_utilitybar_icon_size',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_icon_size', array(
        'label'       => __('Iconen grootte (px)', 'fectionwp-pro'),
        'description' => __('Bijv. 16–24px.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 32,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('fwp_utilitybar_item_gap', array(
        'default'           => 4,
        'sanitize_callback' => 'fwp_sanitize_utilitybar_item_gap',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_item_gap', array(
        'label'       => __('Spacing tussen items (px)', 'fectionwp-pro'),
        'description' => __('Afstand tussen iconen/links in het utility menu.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 24,
            'step' => 1,
        ),
    ));

    // Quick icons (standard utility actions)
    $wp_customize->add_setting('fwp_utilitybar_quick_love', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_quick_love', array(
        'label'       => __('Standaard icoon: Love (likes)', 'fectionwp-pro'),
        'description' => __('Toont een hart-icoon waarmee bezoekers een “like” kunnen geven op de huidige pagina/post.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_quick_profile', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_quick_profile', array(
        'label'       => __('Standaard icoon: Mijn profiel', 'fectionwp-pro'),
        'description' => __('Linkt naar een “mijn account/profiel” pagina. Met WooCommerce actief wordt automatisch “Mijn account” gebruikt als je geen pagina kiest.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_profile_page', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_profile_page', array(
        'label'       => __('Profiel pagina (optioneel)', 'fectionwp-pro'),
        'description' => __('Kies een pagina als target voor “Mijn profiel”. Laat leeg om auto-detect te gebruiken (WooCommerce) of anders login.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'dropdown-pages',
    ));

    $wp_customize->add_setting('fwp_utilitybar_quick_search', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_quick_search', array(
        'label'       => __('Standaard icoon: Zoeken', 'fectionwp-pro'),
        'description' => __('Toont een zoek-icoon met een dropdown zoekveld in de utility bar.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_quick_cart', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_quick_cart', array(
        'label'       => __('Standaard icoon: Winkelwagen', 'fectionwp-pro'),
        'description' => __('Linkt naar de winkelwagen. Met WooCommerce actief wordt de WooCommerce winkelwagen URL gebruikt als je geen pagina kiest.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'checkbox',
    ));

    $wp_customize->add_setting('fwp_utilitybar_cart_page', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_cart_page', array(
        'label'       => __('Winkelwagen pagina (optioneel)', 'fectionwp-pro'),
        'description' => __('Kies een pagina als target voor “Winkelwagen”. Laat leeg om auto-detect te gebruiken (WooCommerce) of fallback.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'dropdown-pages',
    ));

    $wp_customize->add_setting('fwp_utilitybar_alignment', array(
        'default'           => 'right',
        'sanitize_callback' => 'fwp_sanitize_utilitybar_alignment',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_utilitybar_alignment', array(
        'label'       => __('Menu/iconen uitlijning', 'fectionwp-pro'),
        'description' => __('Uitlijning van de utility menu items (vooral relevant als je het logo uitzet).', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __('Links', 'fectionwp-pro'),
            'center' => __('Midden', 'fectionwp-pro'),
            'right'  => __('Rechts', 'fectionwp-pro'),
        ),
    ));

    $wp_customize->add_setting('fwp_utilitybar_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_utilitybar_bg_color', array(
        'label'       => __('Utility bar achtergrondkleur', 'fectionwp-pro'),
        'description' => __('Laat leeg voor transparant/default.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
    )));

    $wp_customize->add_setting('fwp_utilitybar_text_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_utilitybar_text_color', array(
        'label'       => __('Utility bar tekstkleur', 'fectionwp-pro'),
        'description' => __('Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
    )));

    $wp_customize->add_setting('fwp_utilitybar_link_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_utilitybar_link_color', array(
        'label'       => __('Utility bar link/icon kleur', 'fectionwp-pro'),
        'description' => __('Kleur voor links/iconen in de utility bar. Laat leeg voor default.', 'fectionwp-pro'),
        'section'     => 'fwp_utilitybar_settings',
    )));
    
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
    
    // =============================================================================
    // SECTION: Hero / Header Banner
    // =============================================================================
    
    $wp_customize->add_section('fwp_hero_settings', array(
        'title'       => __('Hero / Header Banner', 'fectionwp-pro'),
        'description' => __('Configureer een vaste hero sectie die wordt getoond boven de hoofdcontent (na het menu).', 'fectionwp-pro'),
        'priority'    => 29,
    ));
    
    // Enable Hero Section
    $wp_customize->add_setting('fwp_hero_enabled', array(
        'default'           => false,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_hero_enabled', array(
        'label'       => __('Hero sectie activeren', 'fectionwp-pro'),
        'description' => __('Toon een vaste hero sectie op alle pagina\'s (tenzij uitgeschakeld per pagina).', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'checkbox',
        'priority'    => 1,
    ));
    
    // Hero Display On
    $wp_customize->add_setting('fwp_hero_display_on', array(
        'default'           => 'all',
        'sanitize_callback' => 'fwp_sanitize_hero_display',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_hero_display_on', array(
        'label'       => __('Hero tonen op', 'fectionwp-pro'),
        'description' => __('Kies waar de hero sectie wordt getoond.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'priority'    => 2,
        'choices'     => array(
            'all'       => __('Alle pagina\'s', 'fectionwp-pro'),
            'frontpage' => __('Alleen homepage', 'fectionwp-pro'),
            'pages'     => __('Alleen pagina\'s', 'fectionwp-pro'),
            'posts'     => __('Alleen blog posts', 'fectionwp-pro'),
        ),
    ));

    // Render hero in landing header (header-landing.php)
    $wp_customize->add_setting('fwp_hero_render_in_landing_header', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_hero_render_in_landing_header', array(
        'label'       => __('Hero tonen in landing header', 'fectionwp-pro'),
        'description' => __('Alleen van toepassing op templates die de landing header gebruiken (zoals Landing/Demo). Zet dit uit als je daar een eigen hero/intro gebruikt en dubbele content wilt voorkomen.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'checkbox',
        'priority'    => 3,
    ));

    // Render hero in default header (header.php)
    $wp_customize->add_setting('fwp_hero_render_in_default_header', array(
        'default'           => true,
        'sanitize_callback' => 'fwp_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_hero_render_in_default_header', array(
        'label'       => __('Hero tonen in standaard header', 'fectionwp-pro'),
        'description' => __('Alleen van toepassing op templates die de standaard header gebruiken. Zet dit uit als je elders (bijv. per template) zelf een hero/intro in de content renderert en dubbele content wilt voorkomen.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'checkbox',
        'priority'    => 4,
    ));

    // Hero Type
    $wp_customize->add_setting('fwp_hero_type', array(
        'default'           => 'standard',
        'sanitize_callback' => function ( $value ) {
            $value = is_string( $value ) ? $value : '';
            return in_array( $value, array( 'standard', 'carousel' ), true ) ? $value : 'standard';
        },
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('fwp_hero_type', array(
        'label'       => __('Hero type', 'fectionwp-pro'),
        'description' => __('Kies het type hero: standaard hero of Bootstrap carrousel.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'priority'    => 5,
        'choices'     => array(
            'standard' => __('Standaard', 'fectionwp-pro'),
            'carousel' => __('Carrousel (Bootstrap)', 'fectionwp-pro'),
        ),
    ));

    // Carousel slides (global defaults)
    $wp_customize->add_setting('fwp_hero_carousel_slide1_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'fwp_hero_carousel_slide1_image', array(
        'label'       => __('Carrousel slide 1 - Afbeelding', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'mime_type'   => 'image',
        'priority'    => 40,
    )));

    $wp_customize->add_setting('fwp_hero_carousel_slide1_heading', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide1_heading', array(
        'label'       => __('Carrousel slide 1 - Titel', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
        'priority'    => 41,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide1_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide1_text', array(
        'label'       => __('Carrousel slide 1 - Tekst', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'textarea',
        'priority'    => 42,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide1_btn_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide1_btn_text', array(
        'label'       => __('Carrousel slide 1 - Button tekst', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
        'priority'    => 43,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide1_btn_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide1_btn_url', array(
        'label'       => __('Carrousel slide 1 - Button URL', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'url',
        'priority'    => 44,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide1_btn_style', array(
        'default'           => 'primary',
        'sanitize_callback' => 'fwp_sanitize_button_style',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide1_btn_style', array(
        'label'       => __('Carrousel slide 1 - Button stijl', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'priority'    => 45,
        'choices'     => array(
            'primary'   => __('Primary', 'fectionwp-pro'),
            'secondary' => __('Secondary', 'fectionwp-pro'),
            'success'   => __('Success', 'fectionwp-pro'),
            'danger'    => __('Danger', 'fectionwp-pro'),
            'warning'   => __('Warning', 'fectionwp-pro'),
            'info'      => __('Info', 'fectionwp-pro'),
            'light'     => __('Light', 'fectionwp-pro'),
            'dark'      => __('Dark', 'fectionwp-pro'),
            'outline-primary' => __('Outline Primary', 'fectionwp-pro'),
            'outline-secondary' => __('Outline Secondary', 'fectionwp-pro'),
        ),
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide2_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'fwp_hero_carousel_slide2_image', array(
        'label'       => __('Carrousel slide 2 - Afbeelding', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'mime_type'   => 'image',
        'priority'    => 50,
    )));

    $wp_customize->add_setting('fwp_hero_carousel_slide2_heading', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide2_heading', array(
        'label'       => __('Carrousel slide 2 - Titel', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
        'priority'    => 51,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide2_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide2_text', array(
        'label'       => __('Carrousel slide 2 - Tekst', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'textarea',
        'priority'    => 52,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide2_btn_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide2_btn_text', array(
        'label'       => __('Carrousel slide 2 - Button tekst', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
        'priority'    => 53,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide2_btn_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide2_btn_url', array(
        'label'       => __('Carrousel slide 2 - Button URL', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'url',
        'priority'    => 54,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide2_btn_style', array(
        'default'           => 'primary',
        'sanitize_callback' => 'fwp_sanitize_button_style',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide2_btn_style', array(
        'label'       => __('Carrousel slide 2 - Button stijl', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'priority'    => 55,
        'choices'     => array(
            'primary'   => __('Primary', 'fectionwp-pro'),
            'secondary' => __('Secondary', 'fectionwp-pro'),
            'success'   => __('Success', 'fectionwp-pro'),
            'danger'    => __('Danger', 'fectionwp-pro'),
            'warning'   => __('Warning', 'fectionwp-pro'),
            'info'      => __('Info', 'fectionwp-pro'),
            'light'     => __('Light', 'fectionwp-pro'),
            'dark'      => __('Dark', 'fectionwp-pro'),
            'outline-primary' => __('Outline Primary', 'fectionwp-pro'),
            'outline-secondary' => __('Outline Secondary', 'fectionwp-pro'),
        ),
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide3_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'fwp_hero_carousel_slide3_image', array(
        'label'       => __('Carrousel slide 3 - Afbeelding', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'mime_type'   => 'image',
        'priority'    => 60,
    )));

    $wp_customize->add_setting('fwp_hero_carousel_slide3_heading', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide3_heading', array(
        'label'       => __('Carrousel slide 3 - Titel', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
        'priority'    => 61,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide3_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide3_text', array(
        'label'       => __('Carrousel slide 3 - Tekst', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'textarea',
        'priority'    => 62,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide3_btn_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide3_btn_text', array(
        'label'       => __('Carrousel slide 3 - Button tekst', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
        'priority'    => 63,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide3_btn_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide3_btn_url', array(
        'label'       => __('Carrousel slide 3 - Button URL', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'url',
        'priority'    => 64,
    ));

    $wp_customize->add_setting('fwp_hero_carousel_slide3_btn_style', array(
        'default'           => 'primary',
        'sanitize_callback' => 'fwp_sanitize_button_style',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('fwp_hero_carousel_slide3_btn_style', array(
        'label'       => __('Carrousel slide 3 - Button stijl', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'priority'    => 65,
        'choices'     => array(
            'primary'   => __('Primary', 'fectionwp-pro'),
            'secondary' => __('Secondary', 'fectionwp-pro'),
            'success'   => __('Success', 'fectionwp-pro'),
            'danger'    => __('Danger', 'fectionwp-pro'),
            'warning'   => __('Warning', 'fectionwp-pro'),
            'info'      => __('Info', 'fectionwp-pro'),
            'light'     => __('Light', 'fectionwp-pro'),
            'dark'      => __('Dark', 'fectionwp-pro'),
            'outline-primary' => __('Outline Primary', 'fectionwp-pro'),
            'outline-secondary' => __('Outline Secondary', 'fectionwp-pro'),
        ),
    ));
    
    // Hero Title
    $wp_customize->add_setting('fwp_hero_title', array(
        'default'           => __('Welkom op onze website', 'fectionwp-pro'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_title', array(
        'label'       => __('Hero titel', 'fectionwp-pro'),
        'description' => __('Hoofdtitel in de hero sectie. HTML toegestaan.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'textarea',
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('fwp_hero_subtitle', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_subtitle', array(
        'label'       => __('Hero subtitel', 'fectionwp-pro'),
        'description' => __('Optionele subtitel boven de hoofdtitel.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
    ));
    
    // Hero Description
    $wp_customize->add_setting('fwp_hero_description', array(
        'default'           => __('Ontdek wat wij voor u kunnen betekenen', 'fectionwp-pro'),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_description', array(
        'label'       => __('Hero beschrijving', 'fectionwp-pro'),
        'description' => __('Beschrijvende tekst onder de titel.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'textarea',
    ));
    
    // Hero CTA Button 1 - Text
    $wp_customize->add_setting('fwp_hero_btn1_text', array(
        'default'           => __('Meer informatie', 'fectionwp-pro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_btn1_text', array(
        'label'       => __('CTA Button 1 - Tekst', 'fectionwp-pro'),
        'description' => __('Tekst voor de primaire call-to-action button. Laat leeg om te verbergen.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
    ));
    
    // Hero CTA Button 1 - URL
    $wp_customize->add_setting('fwp_hero_btn1_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_btn1_url', array(
        'label'       => __('CTA Button 1 - URL', 'fectionwp-pro'),
        'description' => __('Link voor de primaire button.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'url',
    ));
    
    // Hero CTA Button 1 - Style
    $wp_customize->add_setting('fwp_hero_btn1_style', array(
        'default'           => 'primary',
        'sanitize_callback' => 'fwp_sanitize_button_style',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_btn1_style', array(
        'label'       => __('CTA Button 1 - Stijl', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'choices'     => array(
            'primary'   => __('Primary', 'fectionwp-pro'),
            'secondary' => __('Secondary', 'fectionwp-pro'),
            'success'   => __('Success', 'fectionwp-pro'),
            'danger'    => __('Danger', 'fectionwp-pro'),
            'warning'   => __('Warning', 'fectionwp-pro'),
            'info'      => __('Info', 'fectionwp-pro'),
            'light'     => __('Light', 'fectionwp-pro'),
            'dark'      => __('Dark', 'fectionwp-pro'),
            'outline-primary' => __('Outline Primary', 'fectionwp-pro'),
        ),
    ));
    
    // Hero CTA Button 2 - Text
    $wp_customize->add_setting('fwp_hero_btn2_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_btn2_text', array(
        'label'       => __('CTA Button 2 - Tekst', 'fectionwp-pro'),
        'description' => __('Tekst voor de secundaire button (optioneel).', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'text',
    ));
    
    // Hero CTA Button 2 - URL
    $wp_customize->add_setting('fwp_hero_btn2_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_btn2_url', array(
        'label'       => __('CTA Button 2 - URL', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'url',
    ));
    
    // Hero CTA Button 2 - Style
    $wp_customize->add_setting('fwp_hero_btn2_style', array(
        'default'           => 'outline-primary',
        'sanitize_callback' => 'fwp_sanitize_button_style',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_btn2_style', array(
        'label'       => __('CTA Button 2 - Stijl', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'choices'     => array(
            'primary'   => __('Primary', 'fectionwp-pro'),
            'secondary' => __('Secondary', 'fectionwp-pro'),
            'outline-primary'   => __('Outline Primary', 'fectionwp-pro'),
            'outline-secondary' => __('Outline Secondary', 'fectionwp-pro'),
        ),
    ));
    
    // Hero Featured Image
    $wp_customize->add_setting('fwp_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'fwp_hero_image', array(
        'label'       => __('Hero afbeelding', 'fectionwp-pro'),
        'description' => __('Optionele afbeelding naast de tekst (rechts of links afhankelijk van layout).', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'mime_type'   => 'image',
    )));
    
    // Hero Background Image
    $wp_customize->add_setting('fwp_hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'fwp_hero_bg_image', array(
        'label'       => __('Hero achtergrond afbeelding', 'fectionwp-pro'),
        'description' => __('Achtergrond afbeelding voor de hele hero sectie.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'mime_type'   => 'image',
    )));
    
    // Hero Background Color
    $wp_customize->add_setting('fwp_hero_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_hero_bg_color', array(
        'label'       => __('Hero achtergrondkleur', 'fectionwp-pro'),
        'description' => __('Laat leeg voor transparant/standaard thema achtergrond.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
    )));
    
    // Hero Text Color
    $wp_customize->add_setting('fwp_hero_text_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'fwp_hero_text_color', array(
        'label'       => __('Hero tekstkleur', 'fectionwp-pro'),
        'description' => __('Kleur voor de hero tekst. Laat leeg voor standaard.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
    )));
    
    // Hero Height
    $wp_customize->add_setting('fwp_hero_height', array(
        'default'           => 'medium',
        'sanitize_callback' => 'fwp_sanitize_hero_height',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_height', array(
        'label'       => __('Hero hoogte', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'choices'     => array(
            'small'    => __('Klein (300px)', 'fectionwp-pro'),
            'medium'   => __('Gemiddeld (500px)', 'fectionwp-pro'),
            'large'    => __('Groot (700px)', 'fectionwp-pro'),
            'full'     => __('Volledig scherm', 'fectionwp-pro'),
            'auto'     => __('Automatisch (inhoud bepaalt)', 'fectionwp-pro'),
        ),
    ));
    
    // Hero Layout
    $wp_customize->add_setting('fwp_hero_layout', array(
        'default'           => 'centered',
        'sanitize_callback' => 'fwp_sanitize_hero_layout',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_layout', array(
        'label'       => __('Hero layout', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'choices'     => array(
            'centered'    => __('Gecentreerd', 'fectionwp-pro'),
            'left'        => __('Links uitgelijnd', 'fectionwp-pro'),
            'split-left'  => __('Split - Tekst links / Afbeelding rechts', 'fectionwp-pro'),
            'split-right' => __('Split - Afbeelding links / Tekst rechts', 'fectionwp-pro'),
        ),
    ));
    
    // Hero Container Type
    $wp_customize->add_setting('fwp_hero_container', array(
        'default'           => 'container',
        'sanitize_callback' => 'fwp_sanitize_container_type',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('fwp_hero_container', array(
        'label'       => __('Hero container type', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'select',
        'choices'     => array(
            'container'       => __('Container (vast)', 'fectionwp-pro'),
            'container-fluid' => __('Container Fluid (volledig)', 'fectionwp-pro'),
            'container-xxl'   => __('Container XXL', 'fectionwp-pro'),
        ),
    ));
    
    // Hero Overlay Opacity (for background images)
    $wp_customize->add_setting('fwp_hero_overlay_opacity', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('fwp_hero_overlay_opacity', array(
        'label'       => __('Achtergrond overlay opacity', 'fectionwp-pro'),
        'description' => __('Donkere overlay over de achtergrondafbeelding (0-100%). Alleen van toepassing als achtergrond afbeelding is ingesteld.', 'fectionwp-pro'),
        'section'     => 'fwp_hero_settings',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
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
 * Sanitize navbar logo position
 */
function fwp_sanitize_navbar_logo_position($input) {
    $valid = array('left', 'center', 'right');
    return in_array($input, $valid, true) ? $input : 'left';
}

/**
 * Sanitize menu alignment
 */
function fwp_sanitize_nav_menu_alignment($input) {
    $valid = array('left', 'center', 'right');
    return in_array($input, $valid, true) ? $input : 'right';
}

/**
 * Sanitize topbar alignment
 */
function fwp_sanitize_topbar_alignment($input) {
    $valid = array('left', 'center', 'right');
    return in_array($input, $valid, true) ? $input : 'center';
}

/**
 * Sanitize utility bar alignment
 */
function fwp_sanitize_utilitybar_alignment($input) {
    $valid = array('left', 'center', 'right');
    return in_array($input, $valid, true) ? $input : 'right';
}

/**
 * Sanitize utility bar logo position
 */
function fwp_sanitize_utilitybar_logo_position($input) {
    $valid = array('left', 'center', 'right');
    return in_array($input, $valid, true) ? $input : 'left';
}

/**
 * Sanitize utility bar icon size (px)
 */
function fwp_sanitize_utilitybar_icon_size($input) {
    $value = absint($input);
    if ($value < 12) {
        return 12;
    }
    if ($value > 32) {
        return 32;
    }
    return $value;
}

/**
 * Sanitize utility bar item gap (px)
 */
function fwp_sanitize_utilitybar_item_gap($input) {
    $value = absint($input);
    if ($value > 24) {
        return 24;
    }
    return $value;
}

/**
 * Sanitize topbar scroll duration
 */
function fwp_sanitize_topbar_scroll_duration($input) {
    $value = absint($input);
    if ($value < 8) {
        return 8;
    }
    if ($value > 60) {
        return 60;
    }
    return $value;
}

/**
 * Sanitize topbar font size
 */
function fwp_sanitize_topbar_font_size($input) {
    $value = absint($input);
    if ($value < 10) {
        return 10;
    }
    if ($value > 20) {
        return 20;
    }
    return $value;
}

/**
 * Sanitize checkbox
 */
function fwp_sanitize_checkbox($input) {
    return (bool) $input;
}

/**
 * Sanitize hero display options
 */
function fwp_sanitize_hero_display($input) {
    $valid = array('all', 'frontpage', 'pages', 'posts');
    return in_array($input, $valid, true) ? $input : 'all';
}

/**
 * Sanitize hero height
 */
function fwp_sanitize_hero_height($input) {
    $valid = array('small', 'medium', 'large', 'full', 'auto');
    return in_array($input, $valid, true) ? $input : 'medium';
}

/**
 * Sanitize hero layout
 */
function fwp_sanitize_hero_layout($input) {
    $valid = array('centered', 'left', 'split-left', 'split-right');
    return in_array($input, $valid, true) ? $input : 'centered';
}

/**
 * Sanitize button style
 */
function fwp_sanitize_button_style($input) {
    $valid = array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'outline-primary', 'outline-secondary');
    return in_array($input, $valid, true) ? $input : 'primary';
}

/**
 * Sanitize font weight
 */
function fwp_sanitize_font_weight($input) {
    $valid = array('300', '400', '500', '600', '700', '800', '900');
    return in_array($input, $valid, true) ? $input : '400';
}

/**
 * Sanitize text transform
 */
function fwp_sanitize_text_transform($input) {
    $valid = array('none', 'uppercase', 'lowercase', 'capitalize');
    return in_array($input, $valid, true) ? $input : 'none';
}

/**
 * Sanitize letter spacing
 */
function fwp_sanitize_letter_spacing($input) {
    $val = floatval($input);
    return ($val >= -5 && $val <= 20) ? $val : 0;
}

/**
 * Sanitize title preset
 */
function fwp_sanitize_title_preset($input) {
    $valid = array('none', 'minimal', 'bold', 'elegant', 'playful', 'badge', 'outlined');
    return in_array($input, $valid, true) ? $input : 'none';
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
 * Get navbar logo position
 *
 * @return string left|center|right
 */
function fwp_get_navbar_logo_position() {
    return get_theme_mod('fwp_navbar_logo_position', 'left');
}

/**
 * Show logo/brand in main navbar
 *
 * @return bool
 */
function fwp_navbar_show_logo() {
    return (bool) get_theme_mod('fwp_navbar_show_logo', true);
}

/**
 * Get menu alignment
 *
 * @return string left|center|right
 */
function fwp_get_nav_menu_alignment() {
    return get_theme_mod('fwp_nav_menu_alignment', 'right');
}

/**
 * Navbar colors (hex or empty)
 */
function fwp_get_navbar_bg_color() {
    return (string) get_theme_mod('fwp_navbar_bg_color', '');
}

function fwp_get_navbar_link_color() {
    return (string) get_theme_mod('fwp_navbar_link_color', '');
}

function fwp_get_navbar_link_hover_color() {
    return (string) get_theme_mod('fwp_navbar_link_hover_color', '');
}

function fwp_get_navbar_brand_color() {
    return (string) get_theme_mod('fwp_navbar_brand_color', '');
}

// =============================================================================
// TOPBAR HELPERS
// =============================================================================

function fwp_topbar_enabled() {
    return (bool) get_theme_mod('fwp_topbar_enabled', false);
}

function fwp_get_topbar_content() {
    return (string) get_theme_mod('fwp_topbar_content', '');
}

function fwp_get_topbar_alignment() {
    return (string) get_theme_mod('fwp_topbar_alignment', 'center');
}

function fwp_get_topbar_bg_color() {
    return (string) get_theme_mod('fwp_topbar_bg_color', '');
}

function fwp_get_topbar_text_color() {
    return (string) get_theme_mod('fwp_topbar_text_color', '');
}

function fwp_get_topbar_link_color() {
    return (string) get_theme_mod('fwp_topbar_link_color', '');
}

function fwp_topbar_scrolling_enabled() {
    return (bool) get_theme_mod('fwp_topbar_scrolling', true);
}

function fwp_get_topbar_scroll_duration() {
    return (int) get_theme_mod('fwp_topbar_scroll_duration', 18);
}

function fwp_get_topbar_font_family_choice() {
    return (string) get_theme_mod('fwp_topbar_font_family', '');
}

function fwp_get_topbar_font_stack() {
    $choice = fwp_get_topbar_font_family_choice();
    return fwp_font_stack_from_choice($choice, 'body');
}

function fwp_get_topbar_font_size() {
    return (int) get_theme_mod('fwp_topbar_font_size', 14);
}

// =============================================================================
// UTILITY BAR HELPERS
// =============================================================================

function fwp_utilitybar_enabled() {
    return (bool) get_theme_mod('fwp_utilitybar_enabled', false);
}

function fwp_utilitybar_show_logo() {
    return (bool) get_theme_mod('fwp_utilitybar_show_logo', true);
}

function fwp_get_utilitybar_logo_position() {
    return (string) get_theme_mod('fwp_utilitybar_logo_position', 'left');
}

function fwp_utilitybar_show_icon_labels() {
    return (bool) get_theme_mod('fwp_utilitybar_show_icon_labels', false);
}

function fwp_get_utilitybar_icon_size() {
    return (int) get_theme_mod('fwp_utilitybar_icon_size', 18);
}

function fwp_get_utilitybar_item_gap() {
    return (int) get_theme_mod('fwp_utilitybar_item_gap', 4);
}

function fwp_get_utilitybar_alignment() {
    return (string) get_theme_mod('fwp_utilitybar_alignment', 'right');
}

function fwp_get_utilitybar_bg_color() {
    return (string) get_theme_mod('fwp_utilitybar_bg_color', '');
}

function fwp_get_utilitybar_text_color() {
    return (string) get_theme_mod('fwp_utilitybar_text_color', '');
}

function fwp_get_utilitybar_link_color() {
    return (string) get_theme_mod('fwp_utilitybar_link_color', '');
}

function fwp_utilitybar_quick_love_enabled() {
    return (bool) get_theme_mod('fwp_utilitybar_quick_love', false);
}

function fwp_utilitybar_quick_profile_enabled() {
    return (bool) get_theme_mod('fwp_utilitybar_quick_profile', false);
}

function fwp_utilitybar_quick_search_enabled() {
    return (bool) get_theme_mod('fwp_utilitybar_quick_search', false);
}

function fwp_utilitybar_quick_cart_enabled() {
    return (bool) get_theme_mod('fwp_utilitybar_quick_cart', false);
}

function fwp_get_utilitybar_profile_url() {
    $page_id = absint( get_theme_mod( 'fwp_utilitybar_profile_page', 0 ) );
    if ( $page_id ) {
        $url = get_permalink( $page_id );
        return $url ? $url : '';
    }

    if ( function_exists( 'wc_get_page_permalink' ) ) {
        $url = wc_get_page_permalink( 'myaccount' );
        if ( $url ) {
            return $url;
        }
    }

    return wp_login_url();
}

function fwp_get_utilitybar_cart_url() {
    $page_id = absint( get_theme_mod( 'fwp_utilitybar_cart_page', 0 ) );
    if ( $page_id ) {
        $url = get_permalink( $page_id );
        return $url ? $url : '';
    }

    if ( function_exists( 'wc_get_cart_url' ) ) {
        $url = wc_get_cart_url();
        if ( $url ) {
            return $url;
        }
    }

    return home_url( '/winkelwagen/' );
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
