<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text visually-hidden-focusable" href="#main">
    <?php esc_html_e( 'Ga naar inhoud', 'fectionwp-pro' ); ?>
</a>

<?php
$container = function_exists( 'fwp_get_container_type' ) ? fwp_get_container_type() : 'container';
$navbar_type = function_exists( 'fwp_get_navbar_type' ) ? fwp_get_navbar_type() : 'standard';

// On TFFP pages we want a truly full-width canvas. These templates handle their own containers.
$is_tffp_fullwidth = is_front_page() || is_page_template( array(
    'page-contact.php',
    'page-galerij.php',
    'page-kinderfeestjes.php',
    'page-festivals.php',
    'page-glitter.php',
    'page-cadeaubon.php',
) );

$main_classes = 'site-main mt-4';
if ( ! $is_tffp_fullwidth ) {
    $main_classes .= ' ' . $container;
}
?>

<header class="site-header" id="wrapper-navbar">
    <?php if ( $navbar_type === 'offcanvas' ) : ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="<?php esc_attr_e( 'Hoofdnavigatie', 'fectionwp-pro' ); ?>">
            <div class="<?php echo esc_attr( $container ); ?>">
                <?php fwp_the_custom_logo(); ?>

                <button class="navbar-toggler" type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#navbarOffcanvas"
                        aria-controls="navbarOffcanvas"
                        aria-expanded="false"
                        aria-label="<?php esc_attr_e( 'Menu openen', 'fectionwp-pro' ); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvas" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php bloginfo( 'name' ); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Menu sluiten', 'fectionwp-pro' ); ?>"></button>
                    </div>
                    <div class="offcanvas-body">
                        <?php
                        wp_nav_menu( array(
                            'theme_location'  => 'primary',
                            'container'       => false,
                            'menu_class'      => 'navbar-nav justify-content-end flex-grow-1',
                            'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'          => new WP_Bootstrap_Navwalker(),
                            'depth'           => 2,
                        ) );
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    <?php else : ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="<?php esc_attr_e( 'Hoofdnavigatie', 'fectionwp-pro' ); ?>">
            <div class="<?php echo esc_attr( $container ); ?>">
                <?php fwp_the_custom_logo(); ?>

                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#primaryMenu"
                        aria-controls="primaryMenu"
                        aria-expanded="false"
                        aria-label="<?php esc_attr_e( 'Menu openen', 'fectionwp-pro' ); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="primaryMenu">
                    <?php
                    wp_nav_menu( array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'menu_class'      => 'navbar-nav ms-auto mb-2 mb-lg-0',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                        'depth'           => 2,
                    ) );
                    ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>
</header>

<?php if ( is_active_sidebar( 'hero' ) ) : ?>
    <div id="wrapper-hero" class="hero-wrapper">
        <div class="<?php echo esc_attr( $container ); ?>">
            <?php dynamic_sidebar( 'hero' ); ?>
        </div>
    </div>
<?php endif; ?>

<main class="<?php echo esc_attr( $main_classes ); ?>" id="main" role="main">
