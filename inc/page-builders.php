<?php
/**
 * Page Builder Integrations
 *
 * Ondersteuning voor populaire page builders zoals Elementor, Divi, Beaver Builder,
 * WPBakery Page Builder, Oxygen Builder en soortgelijke editors.
 *
 * Deze integratie zorgt voor:
 * - Theme support declaraties
 * - Container breedte compatibiliteit
 * - Lettertype en kleur synchronisatie
 * - Bootstrap grid compatibiliteit
 * - Full-width template ondersteuning
 * - CSS fixes voor elk builder systeem
 *
 * @package FectionWP_Pro
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// =============================================================================
// ELEMENTOR BUILDER SUPPORT
// =============================================================================

/**
 * Elementor Theme Support
 *
 * Registreert Elementor locaties en synchroniseert theme instellingen
 */
function fwp_elementor_support() {
	// Check if Elementor is active
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	// Registreer Elementor theme locations
	add_theme_support(
		'elementor',
		array(
			'settings' => array(
				'page_title_selector'   => '.entry-title',
				'default_generic_fonts' => 'Sans-serif',
			),
		)
	);

	// Elementor container width synchroniseren met Bootstrap container
	add_action(
		'elementor/init',
		function () {
			// Bootstrap container-xxl max-width: 1320px
			update_option( 'elementor_container_width', '1320' );
			update_option( 'elementor_stretched_section_container', '.container' );
		}
	);

	// Voeg Bootstrap klassen toe aan Elementor sections
	add_action(
		'elementor/frontend/section/before_render',
		function ( $element ) {
			$settings = $element->get_settings();

			// Als Bootstrap grid gewenst is, voeg klassen toe.
			if ( isset( $settings['fwp_bootstrap_grid'] ) && 'yes' === $settings['fwp_bootstrap_grid'] ) {
				$element->add_render_attribute( '_wrapper', 'class', 'container' );
			}
		}
	);

	// Synchroniseer theme kleuren met Elementor
	add_action( 'elementor/init', 'fwp_sync_elementor_colors' );

	// Synchroniseer theme fonts met Elementor
	add_action( 'elementor/init', 'fwp_sync_elementor_fonts' );
}
add_action( 'after_setup_theme', 'fwp_elementor_support' );

/**
 * Synchroniseer Bootstrap kleuren met Elementor
 */
function fwp_sync_elementor_colors() {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}

	// Haal theme kleuren op uit customizer
	$primary   = get_theme_mod( 'fwp_primary_color', '#0d6efd' );
	$secondary = get_theme_mod( 'fwp_secondary_color', '#6c757d' );
	$success   = get_theme_mod( 'fwp_success_color', '#198754' );
	$danger    = get_theme_mod( 'fwp_danger_color', '#dc3545' );
	$warning   = get_theme_mod( 'fwp_warning_color', '#ffc107' );
	$info      = get_theme_mod( 'fwp_info_color', '#0dcaf0' );

	// Registreer kleuren in Elementor
	$colors = array(
		array(
			'_id'   => 'fwp_primary',
			'title' => __( 'Bootstrap Primary', 'fectionwp-pro' ),
			'color' => $primary,
		),
		array(
			'_id'   => 'fwp_secondary',
			'title' => __( 'Bootstrap Secondary', 'fectionwp-pro' ),
			'color' => $secondary,
		),
		array(
			'_id'   => 'fwp_success',
			'title' => __( 'Bootstrap Success', 'fectionwp-pro' ),
			'color' => $success,
		),
		array(
			'_id'   => 'fwp_danger',
			'title' => __( 'Bootstrap Danger', 'fectionwp-pro' ),
			'color' => $danger,
		),
		array(
			'_id'   => 'fwp_warning',
			'title' => __( 'Bootstrap Warning', 'fectionwp-pro' ),
			'color' => $warning,
		),
		array(
			'_id'   => 'fwp_info',
			'title' => __( 'Bootstrap Info', 'fectionwp-pro' ),
			'color' => $info,
		),
	);

	update_option( 'elementor_scheme_color', $colors );
}

/**
 * Synchroniseer theme fonts met Elementor
 */
function fwp_sync_elementor_fonts() {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}

	// Haal theme fonts op
	$body_font    = get_theme_mod( 'fwp_body_font', 'System Default' );
	$heading_font = get_theme_mod( 'fwp_heading_font', 'System Default' );

	// Registreer fonts in Elementor
	$fonts = array(
		1 => array(
			'_id'         => '1',
			'title'       => __( 'Primary Heading', 'fectionwp-pro' ),
			'font_family' => $heading_font,
			'font_weight' => '600',
		),
		2 => array(
			'_id'         => '2',
			'title'       => __( 'Secondary Heading', 'fectionwp-pro' ),
			'font_family' => $heading_font,
			'font_weight' => '400',
		),
		3 => array(
			'_id'         => '3',
			'title'       => __( 'Body Text', 'fectionwp-pro' ),
			'font_family' => $body_font,
			'font_weight' => '400',
		),
		4 => array(
			'_id'         => '4',
			'title'       => __( 'Accent Text', 'fectionwp-pro' ),
			'font_family' => $body_font,
			'font_weight' => '500',
		),
	);

	update_option( 'elementor_scheme_typography', $fonts );
}

/**
 * Elementor canvas template support
 */
function fwp_elementor_canvas_compat() {
	// Voeg body class toe voor Elementor canvas
	add_filter(
		'body_class',
		function ( $classes ) {
			if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				$classes[] = 'elementor-page';
			}
			return $classes;
		}
	);
}
add_action( 'elementor/init', 'fwp_elementor_canvas_compat', 20 );

// =============================================================================
// DIVI BUILDER SUPPORT
// =============================================================================

/**
 * Divi Theme Support
 *
 * Compatibiliteit met Divi Builder
 */
function fwp_divi_support() {
	// Check if Divi is active
	if ( ! function_exists( 'et_divi_fonts_url' ) ) {
		return;
	}

	// Registreer Divi ondersteuning
	add_theme_support( 'et-divi-builder' );

	// Synchroniseer container breedte
	add_filter(
		'et_pb_section_content_width',
		function () {
			return '1320px'; // Bootstrap container-xxl
		}
	);

	// Schakel Divi's eigen Bootstrap uit (conflicteert met theme Bootstrap)
	add_filter(
		'et_builder_load_actions',
		function ( $actions ) {
			remove_action( 'wp_enqueue_scripts', 'et_builder_load_global_functions_script' );
			return $actions;
		}
	);

	// Voeg Bootstrap compatibiliteit toe aan Divi modules
	add_filter(
		'et_builder_module_wrapper_attributes',
		function ( $attrs, $props ) {
			// Voeg Bootstrap classes toe indien gewenst.
			if ( isset( $props['use_bootstrap_grid'] ) && 'on' === $props['use_bootstrap_grid'] ) {
				$attrs['class'] = isset( $attrs['class'] ) ? $attrs['class'] . ' row' : 'row';
			}
			return $attrs;
		},
		10,
		2
	);
}
add_action( 'after_setup_theme', 'fwp_divi_support' );

/**
 * Divi kleur synchronisatie
 */
function fwp_sync_divi_colors() {
	if ( ! function_exists( 'et_divi_fonts_url' ) ) {
		return;
	}

	$primary = get_theme_mod( 'fwp_primary_color', '#0d6efd' );

	// Update Divi accent color
	update_option(
		'et_divi',
		array_merge(
			get_option( 'et_divi', array() ),
			array( 'accent_color' => $primary )
		)
	);
}
add_action( 'customize_save_after', 'fwp_sync_divi_colors' );

// =============================================================================
// BEAVER BUILDER SUPPORT
// =============================================================================

/**
 * Beaver Builder Theme Support
 */
function fwp_beaver_builder_support() {
	// Check if Beaver Builder is active
	if ( ! class_exists( 'FLBuilder' ) ) {
		return;
	}

	// Registreer theme support
	add_theme_support( 'fl-builder-content-full-width' );
	add_theme_support( 'fl-theme-builder-headers' );
	add_theme_support( 'fl-theme-builder-footers' );
	add_theme_support( 'fl-theme-builder-parts' );

	// Synchroniseer container breedte
	add_filter(
		'fl_builder_content_width',
		function () {
			return '1320'; // Bootstrap container-xxl
		}
	);

	// Voeg Bootstrap klassen toe aan Beaver Builder rijen
	add_filter(
		'fl_builder_row_custom_class',
		function ( $class, $settings ) {
			if ( isset( $settings->use_bootstrap_grid ) && 'yes' === $settings->use_bootstrap_grid ) {
				$class .= ' container';
			}
			return $class;
		},
		10,
		2
	);

	// Synchroniseer theme kleuren
	add_action( 'fl_builder_init_ui', 'fwp_sync_beaver_builder_colors' );
}
add_action( 'after_setup_theme', 'fwp_beaver_builder_support' );

/**
 * Synchroniseer kleuren met Beaver Builder
 */
function fwp_sync_beaver_builder_colors() {
	if ( ! class_exists( 'FLBuilder' ) ) {
		return;
	}

	$primary = get_theme_mod( 'fwp_primary_color', '#0d6efd' );

	// Voeg Bootstrap kleuren toe aan kleurpalet
	$colors = array(
		$primary,
		get_theme_mod( 'fwp_secondary_color', '#6c757d' ),
		get_theme_mod( 'fwp_success_color', '#198754' ),
		get_theme_mod( 'fwp_danger_color', '#dc3545' ),
		get_theme_mod( 'fwp_warning_color', '#ffc107' ),
		get_theme_mod( 'fwp_info_color', '#0dcaf0' ),
	);

	update_option( '_fl_builder_color_presets', $colors );
}

// =============================================================================
// WPBAKERY PAGE BUILDER (VISUAL COMPOSER) SUPPORT
// =============================================================================

/**
 * WPBakery Page Builder Theme Support
 */
function fwp_wpbakery_support() {
	// Check if WPBakery is active
	if ( ! function_exists( 'vc_set_as_theme' ) ) {
		return;
	}

	// Registreer als theme (vermindert notices)
	vc_set_as_theme( true );

	// Schakel frontend editor in
	vc_set_default_editor_post_types( array( 'page', 'post', 'portfolio' ) );

	// Synchroniseer container breedte
	if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
		add_filter( 'vc_settings_page_show_design_tabs', '__return_true' );
	}

	// Bootstrap compatibiliteit
	add_action(
		'vc_after_init',
		function () {
			// Update content area width
			if ( function_exists( 'vc_map' ) ) {
				vc_map_update(
					'vc_row',
					array(
						'content_area_width' => '1320px',
					)
				);
			}
		}
	);

	// Voeg Bootstrap klassen toe aan WPBakery rows
	add_filter(
		'vc_shortcodes_css_class',
		function ( $class, $tag ) {
			if ( 'vc_row' === $tag ) {
				$class .= ' container';
			}
			return $class;
		},
		10,
		2
	);
}
add_action( 'after_setup_theme', 'fwp_wpbakery_support' );

/**
 * WPBakery kleur synchronisatie
 */
function fwp_sync_wpbakery_colors() {
	if ( ! function_exists( 'vc_set_as_theme' ) ) {
		return;
	}

	// Synchroniseer hoofdkleur
	$primary = get_theme_mod( 'fwp_primary_color', '#0d6efd' );
	update_option( 'wpb_js_use_custom', '1' );
	update_option( 'wpb_js_custom_css', ':root { --vc-primary-color: ' . $primary . '; }' );
}
add_action( 'customize_save_after', 'fwp_sync_wpbakery_colors' );

// =============================================================================
// OXYGEN BUILDER SUPPORT
// =============================================================================

/**
 * Oxygen Builder Theme Support
 */
function fwp_oxygen_support() {
	// Check if Oxygen is active
	if ( ! defined( 'CT_VERSION' ) ) {
		return;
	}

	// Registreer theme support
	add_theme_support( 'oxygen-builder' );

	// Disable theme CSS voor Oxygen templates
	add_filter( 'oxygen_vsb_show_add_section_ui', '__return_true' );

	// Synchroniseer container breedte
	add_filter(
		'oxygen_default_content_width',
		function () {
			return '1320';
		}
	);

	// Voeg Bootstrap variabelen toe aan Oxygen
	add_action(
		'oxygen_enqueue_ui_scripts',
		function () {
			$primary = get_theme_mod( 'fwp_primary_color', '#0d6efd' );

			$custom_css = ':root {
            --oxy-primary: ' . $primary . ';
            --oxy-secondary: ' . get_theme_mod( 'fwp_secondary_color', '#6c757d' ) . ';
            --oxy-success: ' . get_theme_mod( 'fwp_success_color', '#198754' ) . ';
            --oxy-danger: ' . get_theme_mod( 'fwp_danger_color', '#dc3545' ) . ';
            --oxy-warning: ' . get_theme_mod( 'fwp_warning_color', '#ffc107' ) . ';
            --oxy-info: ' . get_theme_mod( 'fwp_info_color', '#0dcaf0' ) . ';
        }';

			wp_add_inline_style( 'oxygen-styles', $custom_css );
		}
	);
}
add_action( 'after_setup_theme', 'fwp_oxygen_support' );

// =============================================================================
// BRIZY BUILDER SUPPORT
// =============================================================================

/**
 * Brizy Builder Theme Support
 */
function fwp_brizy_support() {
	// Check if Brizy is active
	if ( ! class_exists( 'Brizy_Editor' ) ) {
		return;
	}

	// Registreer theme support
	add_theme_support( 'brizy' );

	// Synchroniseer container breedte
	add_filter(
		'brizy_container_max_width',
		function () {
			return 1320;
		}
	);

	// Voeg Bootstrap CSS variabelen toe
	add_action(
		'brizy_template_compile_page',
		function () {
			$primary = get_theme_mod( 'fwp_primary_color', '#0d6efd' );

			echo '<style id="fwp-brizy-vars">
        :root {
            --brz-primary: ' . esc_attr( $primary ) . ';
            --brz-secondary: ' . esc_attr( get_theme_mod( 'fwp_secondary_color', '#6c757d' ) ) . ';
        }
        </style>';
		}
	);
}
add_action( 'after_setup_theme', 'fwp_brizy_support' );

// =============================================================================
// THRIVE ARCHITECT SUPPORT
// =============================================================================

/**
 * Thrive Architect Theme Support
 */
function fwp_thrive_architect_support() {
	// Check if Thrive Architect is active
	if ( ! defined( 'TVE_VERSION' ) ) {
		return;
	}

	// Registreer theme support
	add_theme_support( 'thrive-architect' );

	// Synchroniseer container breedte
	add_filter(
		'tcb_content_width',
		function () {
			return '1320';
		}
	);

	// Bootstrap kleur integratie
	add_filter(
		'tcb_main_style_family_config',
		function ( $config ) {
			$config['colors'] = array(
				'primary'   => get_theme_mod( 'fwp_primary_color', '#0d6efd' ),
				'secondary' => get_theme_mod( 'fwp_secondary_color', '#6c757d' ),
				'success'   => get_theme_mod( 'fwp_success_color', '#198754' ),
				'danger'    => get_theme_mod( 'fwp_danger_color', '#dc3545' ),
			);
			return $config;
		}
	);
}
add_action( 'after_setup_theme', 'fwp_thrive_architect_support' );

// =============================================================================
// GUTENBERG (BLOCK EDITOR) ENHANCEMENTS
// =============================================================================

/**
 * Gutenberg/Block Editor verbeteringen voor page building
 */
function fwp_gutenberg_page_builder_features() {
	// Voeg Bootstrap klassen toe aan block editor
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Bootstrap Primary', 'fectionwp-pro' ),
				'slug'  => 'bs-primary',
				'color' => get_theme_mod( 'fwp_primary_color', '#0d6efd' ),
			),
			array(
				'name'  => __( 'Bootstrap Secondary', 'fectionwp-pro' ),
				'slug'  => 'bs-secondary',
				'color' => get_theme_mod( 'fwp_secondary_color', '#6c757d' ),
			),
			array(
				'name'  => __( 'Bootstrap Success', 'fectionwp-pro' ),
				'slug'  => 'bs-success',
				'color' => get_theme_mod( 'fwp_success_color', '#198754' ),
			),
			array(
				'name'  => __( 'Bootstrap Danger', 'fectionwp-pro' ),
				'slug'  => 'bs-danger',
				'color' => get_theme_mod( 'fwp_danger_color', '#dc3545' ),
			),
			array(
				'name'  => __( 'Bootstrap Warning', 'fectionwp-pro' ),
				'slug'  => 'bs-warning',
				'color' => get_theme_mod( 'fwp_warning_color', '#ffc107' ),
			),
			array(
				'name'  => __( 'Bootstrap Info', 'fectionwp-pro' ),
				'slug'  => 'bs-info',
				'color' => get_theme_mod( 'fwp_info_color', '#0dcaf0' ),
			),
			array(
				'name'  => __( 'Light', 'fectionwp-pro' ),
				'slug'  => 'bs-light',
				'color' => '#f8f9fa',
			),
			array(
				'name'  => __( 'Dark', 'fectionwp-pro' ),
				'slug'  => 'bs-dark',
				'color' => '#212529',
			),
		)
	);

	// Font sizes gebaseerd op Bootstrap typografie
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => __( 'Small', 'fectionwp-pro' ),
				'size' => 14,
				'slug' => 'small',
			),
			array(
				'name' => __( 'Normal', 'fectionwp-pro' ),
				'size' => 16,
				'slug' => 'normal',
			),
			array(
				'name' => __( 'Medium', 'fectionwp-pro' ),
				'size' => 20,
				'slug' => 'medium',
			),
			array(
				'name' => __( 'Large', 'fectionwp-pro' ),
				'size' => 24,
				'slug' => 'large',
			),
			array(
				'name' => __( 'Extra Large', 'fectionwp-pro' ),
				'size' => 32,
				'slug' => 'extra-large',
			),
		)
	);

	// Schakel custom kleuren en font sizes in
	add_theme_support( 'disable-custom-colors', false );
	add_theme_support( 'disable-custom-font-sizes', false );

	// Editor content width (Bootstrap container)
	add_theme_support( 'editor-content-width', 1320 );
}
add_action( 'after_setup_theme', 'fwp_gutenberg_page_builder_features' );

// =============================================================================
// ALGEMENE PAGE BUILDER UTILITIES
// =============================================================================

/**
 * Detecteer of een page builder actief is
 */
function fwp_is_page_builder_active() {
	return (
		did_action( 'elementor/loaded' ) ||
		function_exists( 'et_divi_fonts_url' ) ||
		class_exists( 'FLBuilder' ) ||
		function_exists( 'vc_set_as_theme' ) ||
		defined( 'CT_VERSION' ) ||
		class_exists( 'Brizy_Editor' ) ||
		defined( 'TVE_VERSION' )
	);
}

/**
 * Detecteer of huidige pagina een page builder gebruikt
 *
 * @param int|null $post_id Post ID to check.
 * @return string|false Builder name or false.
 */
function fwp_is_page_builder_used( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	// Elementor check
	if ( did_action( 'elementor/loaded' ) ) {
		if ( get_post_meta( $post_id, '_elementor_edit_mode', true ) === 'builder' ) {
			return 'elementor';
		}
	}

	// Divi check
	if ( function_exists( 'et_pb_is_pagebuilder_used' ) ) {
		if ( et_pb_is_pagebuilder_used( $post_id ) ) {
			return 'divi';
		}
	}

	// Beaver Builder check
	if ( class_exists( 'FLBuilder' ) ) {
		if ( get_post_meta( $post_id, '_fl_builder_enabled', true ) ) {
			return 'beaver';
		}
	}

	// WPBakery check
	if ( function_exists( 'vc_is_page_editable' ) ) {
		if ( get_post_meta( $post_id, '_wpb_vc_js_status', true ) === 'true' ) {
			return 'wpbakery';
		}
	}

	// Oxygen check
	if ( defined( 'CT_VERSION' ) ) {
		if ( get_post_meta( $post_id, 'ct_builder_shortcodes', true ) ) {
			return 'oxygen';
		}
	}

	// Brizy check
	if ( class_exists( 'Brizy_Editor' ) ) {
		if ( get_post_meta( $post_id, 'brizy_post_uid', true ) ) {
			return 'brizy';
		}
	}

	// Thrive Architect check
	if ( defined( 'TVE_VERSION' ) ) {
		if ( get_post_meta( $post_id, 'tcb_editor_enabled', true ) ) {
			return 'thrive';
		}
	}

	return false;
}

/**
 * Body class voor page builder detectie
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function fwp_page_builder_body_class( $classes ) {
	$builder = fwp_is_page_builder_used();

	if ( $builder ) {
		$classes[] = 'fwp-page-builder-active';
		$classes[] = 'fwp-builder-' . $builder;
	}

	return $classes;
}
add_filter( 'body_class', 'fwp_page_builder_body_class' );

/**
 * Schakel theme layout uit voor page builder paginas
 */
function fwp_disable_theme_layout_for_builders() {
	if ( fwp_is_page_builder_used() && is_singular() ) {
		// Verberg sidebar voor page builder paginas
		add_filter( 'fwp_show_sidebar', '__return_false' );

		// Gebruik full-width container
		add_filter(
			'fwp_container_type',
			function () {
				return 'container-fluid';
			}
		);
	}
}
add_action( 'wp', 'fwp_disable_theme_layout_for_builders' );

/**
 * Admin notice voor page builder ondersteuning
 */
function fwp_page_builder_admin_notice() {
	$builder = fwp_is_page_builder_active();

	if ( $builder && current_user_can( 'edit_theme_options' ) ) {
		$screen = get_current_screen();

		if ( $screen && 'themes' === $screen->id ) {
			echo '<div class="notice notice-success is-dismissible">';
			echo '<p><strong>' . esc_html__( 'FectionWP Pro:', 'fectionwp-pro' ) . '</strong> ';
			echo esc_html__( 'Page builder ondersteuning geactiveerd! Bootstrap kleuren en instellingen zijn gesynchroniseerd.', 'fectionwp-pro' );
			echo '</p>';
			echo '</div>';
		}
	}
}
add_action( 'admin_notices', 'fwp_page_builder_admin_notice' );

/**
 * Voeg page builder informatie toe aan admin bar
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
 */
function fwp_page_builder_admin_bar( $wp_admin_bar ) {
	if ( ! is_admin_bar_showing() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$builder = fwp_is_page_builder_used();

	if ( $builder && is_singular() ) {
		$builder_names = array(
			'elementor' => 'Elementor',
			'divi'      => 'Divi',
			'beaver'    => 'Beaver Builder',
			'wpbakery'  => 'WPBakery',
			'oxygen'    => 'Oxygen',
			'brizy'     => 'Brizy',
			'thrive'    => 'Thrive Architect',
		);

		$wp_admin_bar->add_node(
			array(
				'id'    => 'fwp-page-builder',
				'title' => sprintf(
					'<span class="ab-icon dashicons-layout"></span> %s',
					isset( $builder_names[ $builder ] ) ? $builder_names[ $builder ] : $builder
				),
				'meta'  => array(
					'class' => 'fwp-page-builder-indicator',
					'title' => __( 'Deze pagina gebruikt een page builder', 'fectionwp-pro' ),
				),
			)
		);
	}
}
add_action( 'admin_bar_menu', 'fwp_page_builder_admin_bar', 100 );

/**
 * CSS fixes voor page builder compatibiliteit
 */
function fwp_page_builder_compat_css() {
	?>
	<style id="fwp-page-builder-compat">
	/* Algemene page builder compatibiliteit */
	.fwp-page-builder-active .site-main {
		padding: 0;
	}

	.fwp-page-builder-active .entry-content {
		max-width: 100%;
	}

	/* Elementor specifiek */
	.fwp-builder-elementor .elementor-section-stretched {
		width: 100% !important;
		left: 0 !important;
	}

	/* Divi specifiek */
	.fwp-builder-divi #et-main-area {
		padding-top: 0;
	}

	/* Beaver Builder specifiek */
	.fwp-builder-beaver .fl-builder-content {
		margin: 0;
	}

	/* WPBakery specifiek */
	.fwp-builder-wpbakery .vc_row {
		margin-left: 0;
		margin-right: 0;
	}

	/* Bootstrap grid compatibiliteit voor alle builders */
	.page-builder-container .container,
	.page-builder-container .container-fluid {
		padding-left: 15px;
		padding-right: 15px;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'fwp_page_builder_compat_css', 100 );
