<?php
/**
 * Template part for features section with icons
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_query_var( 'block_title', '' );
$subtitle    = get_query_var( 'block_subtitle', '' );
$columns     = get_query_var( 'block_columns', 3 );
$content     = get_query_var( 'block_content', '' );
?>

<div class="fwp-features fwp-features-icons">
    <div class="container px-4 py-5">
        <?php if ( $title || $subtitle ) : ?>
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <?php if ( $subtitle ) : ?>
                <p class="text-primary fw-semibold mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <?php if ( $title ) : ?>
                <h2 class="pb-2 border-bottom display-6 fw-bold"><?php echo wp_kses_post( $title ); ?></h2>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row g-4 py-3 row-cols-1 row-cols-md-2 row-cols-lg-<?php echo absint( $columns ); ?>">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
</div>
