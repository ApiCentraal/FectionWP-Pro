<?php
/**
 * Template part for testimonials section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title   = get_query_var( 'block_title', 'What Our Customers Say' );
$content = get_query_var( 'block_content', '' );
?>

<div class="fwp-testimonials bg-body-tertiary">
    <div class="container px-4 py-5">
        <?php if ( $title ) : ?>
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-6 fw-bold"><?php echo wp_kses_post( $title ); ?></h2>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
</div>
