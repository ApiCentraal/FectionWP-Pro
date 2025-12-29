<?php
/**
 * Front page (TFFP)
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php
get_template_part( 'template-parts/tffp/hero' );
get_template_part( 'template-parts/tffp/stats' );
get_template_part( 'template-parts/tffp/testimonials' );
get_template_part( 'template-parts/tffp/locations' );
?>

<?php
get_footer();
