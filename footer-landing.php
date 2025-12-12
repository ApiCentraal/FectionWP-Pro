</main><!-- /.site-main -->

<?php
/**
 * Landing Page Footer
 * 
 * Minimale donkere footer voor landing pages.
 * 
 * @package FectionWP_Pro
 */
?>

<footer class="landing-footer bg-dark text-light py-4" id="colophon">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <div class="site-info text-muted">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
                </div>
            </div>
            
            <div class="col-md-6 text-center text-md-end">
                <?php if (has_nav_menu('footer')) : ?>
                <nav class="footer-navigation" aria-label="<?php esc_attr_e('Footer Menu', 'fectionwp-pro'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'list-inline mb-0',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
