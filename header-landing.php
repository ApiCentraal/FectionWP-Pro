<?php
/**
 * Landing Page Header
 * 
 * Transparante header die over de hero sectie valt.
 * Wordt wit bij scrollen.
 * 
 * @package FectionWP_Pro
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
        /* Landing page header styles */
        .landing-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        .landing-header .navbar {
            background: transparent !important;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .landing-header.scrolled .navbar {
            background: rgba(255,255,255,0.98) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .landing-header .navbar-brand,
        .landing-header .nav-link {
            color: #fff !important;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .landing-header.scrolled .navbar-brand,
        .landing-header.scrolled .nav-link {
            color: #212529 !important;
            text-shadow: none;
        }
        .landing-header .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }
        .landing-header .navbar-toggler-icon {
            filter: invert(1);
        }
        .landing-header.scrolled .navbar-toggler {
            border-color: rgba(0,0,0,0.1);
        }
        .landing-header.scrolled .navbar-toggler-icon {
            filter: none;
        }
        
        /* Full-width sections */
        .fwp-section-full {
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            width: 100vw;
            max-width: 100vw;
        }
        
        /* Landing page main container override */
        body.page-template-page-landing .site-main {
            max-width: 100%;
            padding: 0;
            margin: 0;
        }
        body.page-template-page-landing .site-main.container,
        body.page-template-page-landing .site-main.container-fluid {
            max-width: 100%;
            padding-left: 0;
            padding-right: 0;
        }
        
        /* First hero section padding for navbar */
        .landing-content > *:first-child {
            padding-top: 80px;
        }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text visually-hidden-focusable" href="#main">
    <?php esc_html_e('Ga naar inhoud', 'fectionwp-pro'); ?>
</a>

<header class="landing-header" id="wrapper-navbar">
    <?php
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

    $logo_position = function_exists( 'fwp_get_navbar_logo_position' ) ? fwp_get_navbar_logo_position() : 'left';
    $navbar_show_logo = function_exists( 'fwp_navbar_show_logo' ) ? (bool) fwp_navbar_show_logo() : true;
    $menu_align    = function_exists( 'fwp_get_nav_menu_alignment' ) ? fwp_get_nav_menu_alignment() : 'right';

    $menu_align_class_map = array(
        'left'   => 'me-auto',
        'center' => 'mx-auto',
        'right'  => 'ms-auto',
    );
    $menu_align_class = $menu_align_class_map[ $menu_align ] ?? 'ms-auto';
    ?>

    <?php if ( $topbar_enabled && $topbar_content ) : ?>
        <div class="fwp-topbar<?php echo $topbar_scroll ? ' fwp-topbar--scrolling' : ''; ?>"<?php echo $topbar_style_attr ? ' style="' . esc_attr( $topbar_style_attr ) . '"' : ''; ?>>
            <div class="container py-1">
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
            <div class="container py-2">
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

    <nav class="navbar navbar-expand-lg" aria-label="<?php esc_attr_e('Hoofdnavigatie', 'fectionwp-pro'); ?>">
        <div class="container">
            <?php $render_brand_after_collapse = ( $navbar_show_logo && 'right' === $logo_position ); ?>

            <?php if ( ! $render_brand_after_collapse && $navbar_show_logo ) : ?>
                <div class="d-flex align-items-center<?php echo ( 'center' === $logo_position ) ? ' mx-lg-auto' : ''; ?>">
                    <?php fwp_the_custom_logo(); ?>
                </div>
            <?php endif; ?>
            
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#primaryMenu" 
                    aria-controls="primaryMenu" 
                    aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Menu openen', 'fectionwp-pro'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            
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
                <div class="d-flex align-items-center ms-lg-auto">
                    <?php fwp_the_custom_logo(); ?>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main class="site-main" id="main" role="main">

<script>
document.addEventListener('DOMContentLoaded', function() {
    var header = document.querySelector('.landing-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }
});
</script>
