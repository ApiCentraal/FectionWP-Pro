<?php
/**
 * Template part for features section with hanging icons
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title   = get_query_var( 'block_title', '' );
$content = get_query_var( 'block_content', '' );
?>

<div class="fwp-features fwp-features-hanging">
    <div class="container px-4 py-5">
        <?php if ( $title ) : ?>
        <h2 class="pb-2 border-bottom"><?php echo wp_kses_post( $title ); ?></h2>
        <?php endif; ?>
        
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    </div>
</div>
