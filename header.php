<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content link voor accessibility -->
<a class="skip-link screen-reader-text visually-hidden-focusable" href="#main">
    <?php esc_html_e('Ga naar inhoud', 'fectionwp-pro'); ?>
</a>

<?php
$navbar_type   = fwp_get_navbar_type();
$container     = fwp_get_container_type();
$navbar_scheme = function_exists( 'fwp_get_navbar_scheme' ) ? fwp_get_navbar_scheme() : 'light';
$navbar_sticky = function_exists( 'fwp_get_navbar_sticky' ) ? (bool) fwp_get_navbar_sticky() : false;

$logo_position = function_exists( 'fwp_get_navbar_logo_position' ) ? fwp_get_navbar_logo_position() : 'left';
$navbar_show_logo = function_exists( 'fwp_navbar_show_logo' ) ? (bool) fwp_navbar_show_logo() : true;
$menu_align    = function_exists( 'fwp_get_nav_menu_alignment' ) ? fwp_get_nav_menu_alignment() : 'right';

$navbar_bg    = function_exists( 'fwp_get_navbar_bg_color' ) ? trim( (string) fwp_get_navbar_bg_color() ) : '';
$navbar_link  = function_exists( 'fwp_get_navbar_link_color' ) ? trim( (string) fwp_get_navbar_link_color() ) : '';
$navbar_hover = function_exists( 'fwp_get_navbar_link_hover_color' ) ? trim( (string) fwp_get_navbar_link_hover_color() ) : '';
$navbar_brand = function_exists( 'fwp_get_navbar_brand_color' ) ? trim( (string) fwp_get_navbar_brand_color() ) : '';

$menu_align_class_map = array(
    'left'   => 'me-auto',
    'center' => 'mx-auto',
    'right'  => 'ms-auto',
);
$menu_align_class = $menu_align_class_map[ $menu_align ] ?? 'ms-auto';

$navbar_classes = array( 'navbar', 'navbar-expand-lg' );
$navbar_classes[] = ( 'dark' === $navbar_scheme ) ? 'navbar-dark' : 'navbar-light';
if ( '' === $navbar_bg ) {
    $navbar_classes[] = ( 'dark' === $navbar_scheme ) ? 'bg-dark' : 'bg-light';
}

$navbar_style_parts = array();
if ( $navbar_bg ) {
    $navbar_style_parts[] = 'background-color:' . $navbar_bg;
}
if ( $navbar_link ) {
    $navbar_style_parts[] = '--bs-navbar-color:' . $navbar_link;
    $navbar_style_parts[] = '--bs-navbar-active-color:' . $navbar_link;
}
if ( $navbar_hover ) {
    $navbar_style_parts[] = '--bs-navbar-hover-color:' . $navbar_hover;
}
if ( $navbar_brand ) {
    $navbar_style_parts[] = '--bs-navbar-brand-color:' . $navbar_brand;
    $navbar_style_parts[] = '--bs-navbar-brand-hover-color:' . ( $navbar_hover ? $navbar_hover : $navbar_brand );
} elseif ( $navbar_link ) {
    $navbar_style_parts[] = '--bs-navbar-brand-color:' . $navbar_link;
    $navbar_style_parts[] = '--bs-navbar-brand-hover-color:' . ( $navbar_hover ? $navbar_hover : $navbar_link );
}
$navbar_style_attr = implode( ';', $navbar_style_parts );

$topbar_enabled = function_exists( 'fwp_topbar_enabled' ) ? (bool) fwp_topbar_enabled() : false;
$topbar_content = function_exists( 'fwp_get_topbar_content' ) ? trim( (string) fwp_get_topbar_content() ) : '';
$topbar_align   = function_exists( 'fwp_get_topbar_alignment' ) ? (string) fwp_get_topbar_alignment() : 'center';
$topbar_bg      = function_exists( 'fwp_get_topbar_bg_color' ) ? trim( (string) fwp_get_topbar_bg_color() ) : '';
$topbar_text    = function_exists( 'fwp_get_topbar_text_color' ) ? trim( (string) fwp_get_topbar_text_color() ) : '';
$topbar_link    = function_exists( 'fwp_get_topbar_link_color' ) ? trim( (string) fwp_get_topbar_link_color() ) : '';
$topbar_scroll  = function_exists( 'fwp_topbar_scrolling_enabled' ) ? (bool) fwp_topbar_scrolling_enabled() : true;
$topbar_dur     = function_exists( 'fwp_get_topbar_scroll_duration' ) ? (int) fwp_get_topbar_scroll_duration() : 18;
$topbar_font    = function_exists( 'fwp_get_topbar_font_stack' ) ? trim( (string) fwp_get_topbar_font_stack() ) : '';
$topbar_fz      = function_exists( 'fwp_get_topbar_font_size' ) ? (int) fwp_get_topbar_font_size() : 14;

$utility_enabled   = function_exists( 'fwp_utilitybar_enabled' ) ? (bool) fwp_utilitybar_enabled() : false;
$utility_show_logo = function_exists( 'fwp_utilitybar_show_logo' ) ? (bool) fwp_utilitybar_show_logo() : true;
$utility_logo_pos  = function_exists( 'fwp_get_utilitybar_logo_position' ) ? (string) fwp_get_utilitybar_logo_position() : 'left';
$utility_icon_size = function_exists( 'fwp_get_utilitybar_icon_size' ) ? (int) fwp_get_utilitybar_icon_size() : 18;
$utility_item_gap  = function_exists( 'fwp_get_utilitybar_item_gap' ) ? (int) fwp_get_utilitybar_item_gap() : 4;
$utility_align     = function_exists( 'fwp_get_utilitybar_alignment' ) ? (string) fwp_get_utilitybar_alignment() : 'right';
$utility_bg        = function_exists( 'fwp_get_utilitybar_bg_color' ) ? trim( (string) fwp_get_utilitybar_bg_color() ) : '';
$utility_text      = function_exists( 'fwp_get_utilitybar_text_color' ) ? trim( (string) fwp_get_utilitybar_text_color() ) : '';
$utility_link      = function_exists( 'fwp_get_utilitybar_link_color' ) ? trim( (string) fwp_get_utilitybar_link_color() ) : '';

$utility_labels = function_exists( 'fwp_utilitybar_show_icon_labels' ) ? (bool) fwp_utilitybar_show_icon_labels() : false;

$utility_quick_love    = function_exists( 'fwp_utilitybar_quick_love_enabled' ) ? (bool) fwp_utilitybar_quick_love_enabled() : false;
$utility_quick_profile = function_exists( 'fwp_utilitybar_quick_profile_enabled' ) ? (bool) fwp_utilitybar_quick_profile_enabled() : false;
$utility_quick_search  = function_exists( 'fwp_utilitybar_quick_search_enabled' ) ? (bool) fwp_utilitybar_quick_search_enabled() : false;
$utility_quick_cart    = function_exists( 'fwp_utilitybar_quick_cart_enabled' ) ? (bool) fwp_utilitybar_quick_cart_enabled() : false;

$utility_profile_url = function_exists( 'fwp_get_utilitybar_profile_url' ) ? (string) fwp_get_utilitybar_profile_url() : '';
$utility_cart_url    = function_exists( 'fwp_get_utilitybar_cart_url' ) ? (string) fwp_get_utilitybar_cart_url() : '';

$utility_cart_count = 0;
if ( function_exists( 'WC' ) && WC() && isset( WC()->cart ) && WC()->cart ) {
    $utility_cart_count = (int) WC()->cart->get_cart_contents_count();
}

$utility_love_post_id = (int) get_queried_object_id();
$utility_love_count   = $utility_love_post_id ? (int) get_post_meta( $utility_love_post_id, '_fwp_love_count', true ) : 0;
$utility_love_count   = max( 0, $utility_love_count );

$topbar_align_map = array(
    'left'   => 'text-start',
    'center' => 'text-center',
    'right'  => 'text-end',
);
$topbar_text_class = $topbar_align_map[ $topbar_align ] ?? 'text-center';

$topbar_style_parts = array();
if ( $topbar_bg ) {
    $topbar_style_parts[] = 'background-color:' . $topbar_bg;
}
if ( $topbar_text ) {
    $topbar_style_parts[] = 'color:' . $topbar_text;
}
if ( $topbar_link ) {
    $topbar_style_parts[] = '--fwp-topbar-link-color:' . $topbar_link;
}
if ( $topbar_font ) {
    $topbar_style_parts[] = '--fwp-topbar-font-family:' . $topbar_font;
}
if ( $topbar_fz > 0 ) {
    $topbar_style_parts[] = '--fwp-topbar-font-size:' . $topbar_fz . 'px';
}
if ( $topbar_scroll && $topbar_dur > 0 ) {
    $topbar_style_parts[] = '--fwp-topbar-duration:' . $topbar_dur . 's';
}
$topbar_style_attr = implode( ';', $topbar_style_parts );

$utility_align_class_map = array(
    'left'   => 'me-auto',
    'center' => 'mx-auto',
    'right'  => 'ms-auto',
);
$utility_menu_align_class = $utility_align_class_map[ $utility_align ] ?? 'ms-auto';

$utility_layout = array(
    'container_class' => 'd-flex align-items-center gap-3',
    'brand_class'     => 'fwp-utilitybar__brand',
    'nav_class'       => trim( 'nav ' . $utility_menu_align_class . ' align-items-center' ),
    'brand_first'     => true,
);

if ( ! $utility_show_logo ) {
    $utility_layout['brand_first'] = true;
} else {
    if ( 'right' === $utility_logo_pos ) {
        $utility_layout['brand_first'] = false;
        if ( 'left' === $utility_align ) {
            $utility_layout['brand_class'] .= ' ms-auto';
            $utility_layout['nav_class'] = 'nav align-items-center';
        } elseif ( 'center' === $utility_align ) {
            $utility_layout['nav_class'] = 'nav mx-auto align-items-center';
        } else {
            $utility_layout['nav_class'] = 'nav ms-auto align-items-center';
            $utility_layout['brand_class'] .= ' ms-3';
        }
    } elseif ( 'center' === $utility_logo_pos ) {
        $utility_layout['container_class'] .= ' position-relative';
        $utility_layout['brand_class']     .= ' position-absolute start-50 translate-middle-x';
        $utility_layout['brand_first']      = true;

        // Avoid overlap: when logo is centered, force nav to the right.
        $utility_layout['nav_class'] = ( 'left' === $utility_align )
            ? 'nav align-items-center'
            : 'nav ms-auto align-items-center';
    } else {
        // left (default)
        $utility_layout['brand_first'] = true;
        if ( 'left' === $utility_align ) {
            $utility_layout['nav_class'] = 'nav ms-3 align-items-center';
        } elseif ( 'center' === $utility_align ) {
            $utility_layout['nav_class'] = 'nav mx-auto align-items-center';
        } else {
            $utility_layout['nav_class'] = 'nav ms-auto align-items-center';
        }
    }
}

$utility_style_parts = array();
if ( $utility_bg ) {
    $utility_style_parts[] = 'background-color:' . $utility_bg;
}
if ( $utility_text ) {
    $utility_style_parts[] = 'color:' . $utility_text;
}
if ( $utility_link ) {
    $utility_style_parts[] = '--fwp-utilitybar-link-color:' . $utility_link;
}
if ( $utility_icon_size > 0 ) {
    $utility_style_parts[] = '--fwp-utilitybar-icon-size:' . $utility_icon_size . 'px';
}
if ( $utility_item_gap >= 0 ) {
    $utility_style_parts[] = '--fwp-utilitybar-gap:' . $utility_item_gap . 'px';
}
$utility_style_attr = implode( ';', $utility_style_parts );

$header_classes = array( 'site-header' );
if ( $navbar_sticky && $topbar_enabled && $topbar_content ) {
    $header_classes[] = 'sticky-top';
}
?>

<header class="<?php echo esc_attr( implode( ' ', array_filter( $header_classes ) ) ); ?>" id="wrapper-navbar">

    <?php if ( $topbar_enabled && $topbar_content ) : ?>
        <div class="fwp-topbar<?php echo $topbar_scroll ? ' fwp-topbar--scrolling' : ''; ?>"<?php echo $topbar_style_attr ? ' style="' . esc_attr( $topbar_style_attr ) . '"' : ''; ?>>
            <div class="<?php echo esc_attr( $container ); ?> py-1">
                <?php if ( $topbar_scroll ) : ?>
                    <div class="fwp-topbar__inner" aria-label="<?php esc_attr_e( 'Nieuwsbalk', 'fectionwp-pro' ); ?>">
                        <div class="fwp-topbar__track">
                            <div class="fwp-topbar__item"><?php echo wp_kses_post( $topbar_content ); ?></div>
                            <div class="fwp-topbar__item" aria-hidden="true"><?php echo wp_kses_post( $topbar_content ); ?></div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="<?php echo esc_attr( $topbar_text_class ); ?>">
                        <?php echo wp_kses_post( $topbar_content ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( $utility_enabled && ( $utility_show_logo || has_nav_menu( 'utility' ) ) ) : ?>
        <div class="fwp-utilitybar" aria-label="<?php esc_attr_e( 'Top menu', 'fectionwp-pro' ); ?>"<?php echo $utility_style_attr ? ' style="' . esc_attr( $utility_style_attr ) . '"' : ''; ?>>
            <div class="<?php echo esc_attr( $container ); ?> py-2">
                <div class="<?php echo esc_attr( $utility_layout['container_class'] ); ?>">
                    <?php if ( $utility_show_logo && $utility_layout['brand_first'] ) : ?>
                        <div class="<?php echo esc_attr( $utility_layout['brand_class'] ); ?>">
                            <?php fwp_the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( has_nav_menu( 'utility' ) ) : ?>
                        <?php
                        $utility_args = array(
                            'theme_location'  => 'utility',
                            'container'       => false,
                            'menu_class'      => $utility_layout['nav_class'],
                            'fallback_cb'     => false,
                            'depth'           => 1,
                        );
                        if ( class_exists( 'FWP_Utility_Menu_Walker' ) ) {
                            $utility_args['walker'] = new FWP_Utility_Menu_Walker();
                        }
                        wp_nav_menu( $utility_args );
                        ?>
                    <?php endif; ?>

                    <?php if ( $utility_quick_love || $utility_quick_profile || $utility_quick_search || $utility_quick_cart ) : ?>
                        <div class="fwp-utilitybar__extras ms-2">
                            <?php if ( $utility_quick_love && $utility_love_post_id ) : ?>
                                <button type="button" class="nav-link fwp-utilitybar__link fwp-love-button" data-post-id="<?php echo esc_attr( (string) $utility_love_post_id ); ?>" aria-pressed="false">
                                    <i class="bi bi-heart" aria-hidden="true"></i>
                                    <?php if ( $utility_labels ) : ?>
                                        <span class="fwp-utilitybar__label"><?php esc_html_e( 'Love', 'fectionwp-pro' ); ?></span>
                                    <?php else : ?>
                                        <span class="visually-hidden"><?php esc_html_e( 'Love', 'fectionwp-pro' ); ?></span>
                                    <?php endif; ?>
                                    <span class="fwp-utilitybar__count badge rounded-pill text-bg-primary<?php echo $utility_love_count ? '' : ' d-none'; ?>"><?php echo esc_html( (string) $utility_love_count ); ?></span>
                                </button>
                            <?php endif; ?>

                            <?php if ( $utility_quick_profile && $utility_profile_url ) : ?>
                                <a class="nav-link fwp-utilitybar__link" href="<?php echo esc_url( $utility_profile_url ); ?>">
                                    <i class="bi bi-person" aria-hidden="true"></i>
                                    <?php if ( $utility_labels ) : ?>
                                        <span class="fwp-utilitybar__label"><?php esc_html_e( 'Mijn profiel', 'fectionwp-pro' ); ?></span>
                                    <?php else : ?>
                                        <span class="visually-hidden"><?php esc_html_e( 'Mijn profiel', 'fectionwp-pro' ); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>

                            <?php if ( $utility_quick_search ) : ?>
                                <div class="fwp-utilitybar__search position-relative">
                                    <a href="#" class="nav-link fwp-utilitybar__link search-toggle" aria-label="<?php esc_attr_e( 'Zoeken', 'fectionwp-pro' ); ?>">
                                        <i class="bi bi-search" aria-hidden="true"></i>
                                        <?php if ( $utility_labels ) : ?>
                                            <span class="fwp-utilitybar__label"><?php esc_html_e( 'Zoeken', 'fectionwp-pro' ); ?></span>
                                        <?php else : ?>
                                            <span class="visually-hidden"><?php esc_html_e( 'Zoeken', 'fectionwp-pro' ); ?></span>
                                        <?php endif; ?>
                                    </a>
                                    <form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <label class="visually-hidden" for="fwp-utility-search"><?php esc_html_e( 'Zoeken', 'fectionwp-pro' ); ?></label>
                                        <div class="input-group input-group-sm">
                                            <input id="fwp-utility-search" type="search" class="form-control search-field" placeholder="<?php echo esc_attr_x( 'Zoeken…', 'placeholder', 'fectionwp-pro' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                            <button class="btn btn-primary" type="submit"><?php esc_html_e( 'Zoek', 'fectionwp-pro' ); ?></button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>

                            <?php if ( $utility_quick_cart && $utility_cart_url ) : ?>
                                <a class="nav-link fwp-utilitybar__link" href="<?php echo esc_url( $utility_cart_url ); ?>">
                                    <i class="bi bi-cart" aria-hidden="true"></i>
                                    <?php if ( $utility_labels ) : ?>
                                        <span class="fwp-utilitybar__label"><?php esc_html_e( 'Winkelwagen', 'fectionwp-pro' ); ?></span>
                                    <?php else : ?>
                                        <span class="visually-hidden"><?php esc_html_e( 'Winkelwagen', 'fectionwp-pro' ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $utility_cart_count > 0 ) : ?>
                                        <span class="fwp-utilitybar__count badge rounded-pill text-bg-primary"><?php echo esc_html( (string) $utility_cart_count ); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $utility_show_logo && ! $utility_layout['brand_first'] ) : ?>
                        <div class="<?php echo esc_attr( $utility_layout['brand_class'] ); ?>">
                            <?php fwp_the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($navbar_type === 'offcanvas') : ?>
    <!-- Offcanvas Navbar -->
    <nav class="<?php echo esc_attr( implode( ' ', array_filter( $navbar_classes ) ) ); ?><?php echo ( $navbar_sticky && ! ( $topbar_enabled && $topbar_content ) ) ? ' sticky-top' : ''; ?>" aria-label="<?php esc_attr_e('Hoofdnavigatie', 'fectionwp-pro'); ?>"<?php echo $navbar_style_attr ? ' style="' . esc_attr( $navbar_style_attr ) . '"' : ''; ?>>
        <div class="<?php echo esc_attr( $container ); ?>">
            <!-- Brand/Logo -->
            <?php if ( $navbar_show_logo ) : ?>
                <div class="d-flex align-items-center<?php echo ( 'center' === $logo_position ) ? ' mx-lg-auto' : ''; ?>">
                    <?php fwp_the_custom_logo(); ?>
                </div>
            <?php endif; ?>
            
            <!-- Offcanvas Toggle -->
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#navbarOffcanvas" 
                    aria-controls="navbarOffcanvas" 
                    aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Menu openen', 'fectionwp-pro'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Offcanvas Menu -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvas" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php bloginfo('name'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Menu sluiten', 'fectionwp-pro'); ?>"></button>
                </div>
                <div class="offcanvas-body">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'menu_class'      => 'navbar-nav ' . $menu_align_class . ' justify-content-end flex-grow-1',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                        'depth'           => 2,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </nav>
    
    <?php else : ?>
    <!-- Collapse Navbar (standaard) -->
    <nav class="<?php echo esc_attr( implode( ' ', array_filter( $navbar_classes ) ) ); ?><?php echo ( $navbar_sticky && ! ( $topbar_enabled && $topbar_content ) ) ? ' sticky-top' : ''; ?>" aria-label="<?php esc_attr_e('Hoofdnavigatie', 'fectionwp-pro'); ?>"<?php echo $navbar_style_attr ? ' style="' . esc_attr( $navbar_style_attr ) . '"' : ''; ?>>
        <div class="<?php echo esc_attr( $container ); ?>">
            <?php $render_brand_after_collapse = ( $navbar_show_logo && 'right' === $logo_position ); ?>

            <?php if ( ! $render_brand_after_collapse ) : ?>
                <!-- Brand/Logo -->
                <?php if ( $navbar_show_logo ) : ?>
                    <div class="d-flex align-items-center<?php echo ( 'center' === $logo_position ) ? ' mx-lg-auto' : ''; ?>">
                        <?php fwp_the_custom_logo(); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#primaryMenu" 
                    aria-controls="primaryMenu" 
                    aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Menu openen', 'fectionwp-pro'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="primaryMenu">
                <?php
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'container'       => false,
                    'menu_class'      => 'navbar-nav ' . $menu_align_class . ' mb-2 mb-lg-0',
                    'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'          => new WP_Bootstrap_Navwalker(),
                    'depth'           => 2,
                ));
                ?>
            </div>

            <?php if ( $render_brand_after_collapse ) : ?>
                <!-- Brand/Logo (rechts) -->
                <div class="d-flex align-items-center ms-lg-auto">
                    <?php fwp_the_custom_logo(); ?>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>
</header>

<?php
// Render hero section from Customizer (if enabled)
if (function_exists('fwp_render_hero')) {
    fwp_render_hero();
}

// Hero widget area (indien widgets aanwezig en hero niet via Customizer)
if (!get_theme_mod('fwp_hero_enabled', false) && is_active_sidebar('hero')) : ?>
<div id="wrapper-hero" class="hero-wrapper">
    <div class="<?php echo esc_attr(fwp_get_container_type()); ?>">
        <?php dynamic_sidebar('hero'); ?>
    </div>
</div>
<?php endif; ?>

<main class="site-main <?php echo esc_attr(fwp_get_container_type()); ?> mt-4" id="main" role="main">
