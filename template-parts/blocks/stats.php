<?php
/**
 * Template part for statistics section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title   = get_query_var( 'block_title', '' );
$content = get_query_var( 'block_content', '' );
?>

<div class="fwp-stats bg-body-secondary">
    <div class="container px-4 py-5">
        <?php if ( $title ) : ?>
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-6 fw-bold"><?php echo wp_kses_post( $title ); ?></h2>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row row-cols-2 row-cols-md-4 g-4 text-center">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
</div>
