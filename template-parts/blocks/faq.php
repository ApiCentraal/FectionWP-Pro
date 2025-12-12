<?php
/**
 * Template part for FAQ section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_query_var( 'block_title', 'Frequently Asked Questions' );
$description = get_query_var( 'block_description', '' );
$content     = get_query_var( 'block_content', '' );
$accordion_id = 'faq-' . wp_unique_id();
?>

<div class="fwp-faq">
    <div class="container px-4 py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if ( $title ) : ?>
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold"><?php echo wp_kses_post( $title ); ?></h2>
                    
                    <?php if ( $description ) : ?>
                    <p class="lead text-body-secondary"><?php echo wp_kses_post( $description ); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="accordion" id="<?php echo esc_attr( $accordion_id ); ?>">
                    <?php 
                    // Pass accordion ID to child items
                    set_query_var( 'accordion_id', $accordion_id );
                    echo wp_kses_post( $content ); 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
