<?php
/**
 * Template part for pricing section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_query_var( 'block_title', 'Pricing' );
$subtitle    = get_query_var( 'block_subtitle', '' );
$description = get_query_var( 'block_description', '' );
$content     = get_query_var( 'block_content', '' );
?>

<div class="fwp-pricing">
    <div class="container px-4 py-5">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <?php if ( $subtitle ) : ?>
                <p class="text-primary fw-semibold mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <h2 class="display-6 fw-bold mb-3"><?php echo wp_kses_post( $title ); ?></h2>
                
                <?php if ( $description ) : ?>
                <p class="lead text-body-secondary"><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row row-cols-1 row-cols-md-3 g-4 text-center">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
</div>
