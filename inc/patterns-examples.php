<?php
/**
 * Register block patterns for Bootstrap examples.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', function () {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    $category = 'fectionwp-examples';
    register_block_pattern_category( $category, array(
        'label' => __( 'FectionWP Examples', 'fectionwp-pro' ),
    ) );

    $examples = array(
        'starter' => 'Starter',
        'grid' => 'Grid',
        'album' => 'Album',
        'pricing' => 'Pricing',
        'checkout' => 'Checkout',
        'product' => 'Product',
        'cover' => 'Cover',
        'carousel' => 'Carousel',
        'blog' => 'Blog',
        'dashboard' => 'Dashboard',
        'dashboard-rtl' => 'Dashboard RTL',
        'sign-in' => 'Sign-in',
        'sticky-footer' => 'Sticky Footer',
        'sticky-footer-navbar' => 'Sticky Footer + Navbar',
        'navbar' => 'Navbar',
        'offcanvas' => 'Offcanvas Navbar',
        'sidebars' => 'Sidebars',
        'headers' => 'Headers',
        'footers' => 'Footers',
        'heroes' => 'Heroes',
        'features' => 'Features',
    );

    foreach ( $examples as $slug => $label ) {
        $name = 'fectionwp/example-' . $slug;
        register_block_pattern( $name, array(
            'title'      => sprintf( __( 'Example: %s', 'fectionwp-pro' ), $label ),
            'categories' => array( $category ),
            'content'    => sprintf( "<!-- wp:shortcode -->\n[fwp_example name=\"%s\"]\n<!-- /wp:shortcode -->", esc_attr( $slug ) ),
        ) );
    }
} );
