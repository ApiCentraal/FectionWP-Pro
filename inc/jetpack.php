<?php
/**
 * Jetpack Compatibility
 *
 * Ondersteuning voor Jetpack features met Bootstrap 5 styling.
 *
 * @package FectionWP_Pro
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Controleer of Jetpack actief is
 */
if (!class_exists('Jetpack')) {
    return;
}

// =============================================================================
// JETPACK SETUP
// =============================================================================

/**
 * Jetpack setup
 */
function fwp_jetpack_setup() {
    // Infinite Scroll
    add_theme_support('infinite-scroll', array(
        'container'      => 'main-content',
        'render'         => 'fwp_jetpack_infinite_scroll_render',
        'footer'         => 'page',
        'footer_widgets' => fwp_has_footer_widgets(),
        'wrapper'        => true,
        'posts_per_page' => get_option('posts_per_page'),
    ));

    // Responsive Videos
    add_theme_support('jetpack-responsive-videos');

    // Content Options
    add_theme_support('jetpack-content-options', array(
        'post-details'    => array(
            'stylesheet' => 'fwp-style',
            'date'       => '.posted-on',
            'categories' => '.cat-links',
            'tags'       => '.tags-links',
            'author'     => '.byline',
            'comment'    => '.comments-link',
        ),
        'featured-images' => array(
            'archive' => true,
            'post'    => true,
            'page'    => true,
        ),
    ));

    // Social Menu
    add_theme_support('jetpack-social-menu', 'svg');
}
add_action('after_setup_theme', 'fwp_jetpack_setup');

// =============================================================================
// INFINITE SCROLL
// =============================================================================

/**
 * Render functie voor Infinite Scroll posts
 */
function fwp_jetpack_infinite_scroll_render() {
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content', get_post_type());
    }
}

/**
 * Voeg Bootstrap spinner toe aan infinite scroll loader
 */
function fwp_jetpack_infinite_scroll_js_settings($settings) {
    $settings['text'] = sprintf(
        '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">%s</span></div></div>',
        esc_html__('Laden...', 'fectionwp-pro')
    );
    
    return $settings;
}
add_filter('infinite_scroll_js_settings', 'fwp_jetpack_infinite_scroll_js_settings');

// =============================================================================
// SOCIAL MENU
// =============================================================================

/**
 * Registreer social menu locatie
 */
function fwp_jetpack_register_social_menu() {
    register_nav_menus(array(
        'social' => __('Social Menu', 'fectionwp-pro'),
    ));
}
add_action('after_setup_theme', 'fwp_jetpack_register_social_menu');

/**
 * Render Jetpack Social Menu met Bootstrap styling
 *
 * Gebruik: <?php fwp_jetpack_social_menu(); ?>
 */
function fwp_jetpack_social_menu() {
    if (!function_exists('jetpack_social_menu')) {
        // Fallback als Jetpack social menu niet beschikbaar is
        if (has_nav_menu('social')) {
            wp_nav_menu(array(
                'theme_location' => 'social',
                'container'      => 'nav',
                'container_class' => 'social-navigation',
                'menu_class'     => 'list-inline social-links-menu mb-0',
                'depth'          => 1,
                'link_before'    => '<span class="visually-hidden">',
                'link_after'     => '</span>',
            ));
        }
        return;
    }

    jetpack_social_menu();
}

/**
 * Bootstrap classes voor social menu items
 */
function fwp_jetpack_social_menu_args($args) {
    if ($args['theme_location'] === 'social') {
        $args['menu_class']     = 'd-flex gap-2 list-unstyled mb-0';
        $args['container']      = 'nav';
        $args['container_class'] = 'social-navigation';
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'fwp_jetpack_social_menu_args');

/**
 * Voeg Bootstrap icon classes toe aan social links
 */
function fwp_jetpack_social_menu_link_attributes($atts, $item, $args, $depth) {
    if (isset($args->theme_location) && $args->theme_location === 'social') {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' ' : '';
        $atts['class'] .= 'text-body-secondary fs-5';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'fwp_jetpack_social_menu_link_attributes', 10, 4);

// =============================================================================
// SHARING BUTTONS
// =============================================================================

/**
 * Voeg Bootstrap classes toe aan sharing buttons container
 */
function fwp_jetpack_sharing_display($sharing_content, $sharing_display) {
    // Wrap in Bootstrap card
    $sharing_content = str_replace(
        'class="sharedaddy sd-sharing-enabled"',
        'class="sharedaddy sd-sharing-enabled card p-3 mb-3"',
        $sharing_content
    );
    
    return $sharing_content;
}
add_filter('jetpack_sharing_display', 'fwp_jetpack_sharing_display', 10, 2);

// =============================================================================
// RELATED POSTS
// =============================================================================

/**
 * Custom styling voor Jetpack Related Posts
 */
function fwp_jetpack_relatedposts_filter_options($options) {
    $options['size'] = array(
        'width'  => 350,
        'height' => 200,
    );
    return $options;
}
add_filter('jetpack_relatedposts_filter_options', 'fwp_jetpack_relatedposts_filter_options');

/**
 * Disable Jetpack Related Posts als we eigen implementatie gebruiken
 */
function fwp_disable_jetpack_related_posts() {
    // Uncomment om Jetpack related posts uit te schakelen
    // en onze eigen template-parts/related-posts.php te gebruiken
    // if (class_exists('Jetpack_RelatedPosts')) {
    //     $jprp = Jetpack_RelatedPosts::init();
    //     $callback = array($jprp, 'filter_add_target_to_dom');
    //     remove_filter('the_content', $callback, 40);
    // }
}
add_action('wp', 'fwp_disable_jetpack_related_posts', 20);

// =============================================================================
// LAZY IMAGES
// =============================================================================

/**
 * Voeg Bootstrap classes toe aan lazy-loaded images
 */
function fwp_jetpack_lazy_images_new_attributes($attributes) {
    if (isset($attributes['class'])) {
        $attributes['class'] .= ' img-fluid';
    }
    return $attributes;
}
add_filter('jetpack_lazy_images_new_attributes', 'fwp_jetpack_lazy_images_new_attributes');

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================

/**
 * Check of er footer widgets zijn (voor Infinite Scroll)
 */
function fwp_has_footer_widgets() {
    return is_active_sidebar('footer-1') || 
           is_active_sidebar('footer-2') || 
           is_active_sidebar('footer-3');
}

/**
 * Jetpack Likes styling aanpassen
 */
function fwp_jetpack_likes_style() {
    ?>
    <style>
        .sharedaddy .sd-like {
            margin-top: 1rem;
        }
        .sharedaddy .sd-like h3 {
            font-size: 0.875rem;
            color: var(--bs-secondary);
        }
    </style>
    <?php
}
add_action('wp_head', 'fwp_jetpack_likes_style');
