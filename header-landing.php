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
    <nav class="navbar navbar-expand-lg" aria-label="<?php esc_attr_e('Hoofdnavigatie', 'fectionwp-pro'); ?>">
        <div class="container">
            <?php fwp_the_custom_logo(); ?>
            
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
                    'menu_class'      => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'          => new WP_Bootstrap_Navwalker(),
                    'depth'           => 2,
                ));
                ?>
            </div>
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
