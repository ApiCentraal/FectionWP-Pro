<?php
/**
 * Front page template for FectionWP Pro theme.
 * Minimal `index.php` so WordPress can recognize and install the theme.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
else :
    echo '<p>No content found.</p>';
endif;

get_footer();
