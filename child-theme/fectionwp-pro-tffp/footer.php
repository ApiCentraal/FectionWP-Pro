</main><!-- /.site-main -->

<?php
/**
 * TFFP footer override (child theme)
 *
 * Replaces the parent theme footer with the TFFP layout.
 *
 * @package FectionWP_Pro_TFFP
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'fwp_get_container_type' ) ? fwp_get_container_type() : 'container';

$email = (string) get_theme_mod( 'tffp_contact_email', 'info@thefunkyfacepainter.nl' );
$email = sanitize_email( $email );

$phone_display = (string) get_theme_mod( 'tffp_contact_phone', '+31 6 24 835 453' );
$phone_digits  = preg_replace( '/\D+/', '', $phone_display );
$phone_tel     = $phone_digits ? ( '+' . ltrim( $phone_digits, '+' ) ) : '+31624835453';

$year = function_exists( 'wp_date' ) ? wp_date( 'Y' ) : date_i18n( 'Y' );
?>

<footer class="bg-body-tertiary py-5" id="colophon">
    <div class="<?php echo esc_attr( $container ); ?> py-4">
        <div class="text-center">
            <a class="d-inline-flex align-items-center justify-content-center gap-2 mb-4 text-decoration-none" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256" class="text-primary" aria-hidden="true" focusable="false">
                    <path d="M208,144a15.78,15.78,0,0,1-10.42,14.94L146,178l-19,51.62a15.92,15.92,0,0,1-29.88,0L78,178l-51.62-19a15.92,15.92,0,0,1,0-29.88L78,110l19-51.62a15.92,15.92,0,0,1,29.88,0L146,110l51.62,19A15.78,15.78,0,0,1,208,144ZM152,48h16V64a8,8,0,0,0,16,0V48h16a8,8,0,0,0,0-16H184V16a8,8,0,0,0-16,0V32H152a8,8,0,0,0,0,16Zm88,32h-8V72a8,8,0,0,0-16,0v8h-8a8,8,0,0,0,0,16h8v8a8,8,0,0,0,16,0V96h8a8,8,0,0,0,0-16Z"></path>
                </svg>
                <h3 class="h4 mb-0 fw-bold text-body"><?php echo esc_html__( 'The Funky Facepainter', 'fectionwp-pro-tffp' ); ?></h3>
            </a>

            <p class="text-body-secondary mb-4 mx-auto" style="max-width: 48rem;">
                <?php
                echo esc_html__(
                    'Professionele gezichtsschmink, glittertattoos en creatieve face art voor kinderfeestjes, festivals en evenementen door heel Nederland.',
                    'fectionwp-pro-tffp'
                );
                ?>
            </p>

            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'depth'          => 1,
                    'menu_class'     => 'list-inline mb-4',
                    'fallback_cb'    => false,
                    'link_before'    => '<span class="small text-body-secondary">',
                    'link_after'     => '</span>',
                ) );
                ?>
            <?php else : ?>
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                    <a class="small text-body-secondary link-primary-hover text-decoration-none" href="<?php echo esc_url( home_url( '/kinderfeestjes/' ) ); ?>"><?php echo esc_html__( 'Kinderfeestjes', 'fectionwp-pro-tffp' ); ?></a>
                    <a class="small text-body-secondary link-primary-hover text-decoration-none" href="<?php echo esc_url( home_url( '/festivals/' ) ); ?>"><?php echo esc_html__( 'Festivals & Events', 'fectionwp-pro-tffp' ); ?></a>
                    <a class="small text-body-secondary link-primary-hover text-decoration-none" href="<?php echo esc_url( home_url( '/glitter/' ) ); ?>"><?php echo esc_html__( 'Glitter & Mini Art', 'fectionwp-pro-tffp' ); ?></a>
                    <a class="small text-body-secondary link-primary-hover text-decoration-none" href="<?php echo esc_url( home_url( '/galerij/' ) ); ?>"><?php echo esc_html__( 'Galerij', 'fectionwp-pro-tffp' ); ?></a>
                    <a class="small text-body-secondary link-primary-hover text-decoration-none" href="<?php echo esc_url( home_url( '/cadeaubon/' ) ); ?>"><?php echo esc_html__( 'Cadeaubon', 'fectionwp-pro-tffp' ); ?></a>
                    <a class="small text-body-secondary link-primary-hover text-decoration-none" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html__( 'Contact', 'fectionwp-pro-tffp' ); ?></a>
                </div>
            <?php endif; ?>

            <hr class="my-4 mx-auto" style="max-width: 28rem;" />

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3 small text-body-secondary mb-4">
                <?php if ( $email ) : ?>
                    <a class="link-primary-hover text-decoration-none" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                <?php endif; ?>

                <?php if ( $email && $phone_digits ) : ?>
                    <span class="d-none d-sm-inline" aria-hidden="true">•</span>
                <?php endif; ?>

                <?php if ( $phone_digits ) : ?>
                    <a class="link-primary-hover text-decoration-none" href="tel:<?php echo esc_attr( $phone_tel ); ?>"><?php echo esc_html( $phone_display ); ?></a>
                <?php endif; ?>
            </div>

            <p class="small text-body-secondary mb-0 d-flex align-items-center justify-content-center gap-2">
                <?php
                echo esc_html( sprintf(
                    /* translators: %s is the current year */
                    __( '© %s The Funky Facepainter. Gemaakt met', 'fectionwp-pro-tffp' ),
                    $year
                ) );
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 256 256" class="text-primary" aria-hidden="true" focusable="false">
                    <path d="M240,102c0,70-103.79,126.66-108.21,129a8,8,0,0,1-7.58,0C119.79,228.66,16,172,16,102A62.07,62.07,0,0,1,78,40c20.65,0,38.73,8.88,50,23.89C139.27,48.88,157.35,40,178,40A62.07,62.07,0,0,1,240,102Z"></path>
                </svg>
            </p>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#page" class="back-to-top btn btn-primary" aria-label="<?php esc_attr_e( 'Terug naar boven', 'fectionwp-pro' ); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
    </svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
