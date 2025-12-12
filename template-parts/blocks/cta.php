<?php
/**
 * Template part for call-to-action section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_query_var( 'block_title', 'Ready to get started?' );
$description = get_query_var( 'block_description', '' );
$btn_text    = get_query_var( 'block_btn_text', 'Get Started' );
$btn_url     = get_query_var( 'block_btn_url', '#' );
$btn2_text   = get_query_var( 'block_btn2_text', '' );
$btn2_url    = get_query_var( 'block_btn2_url', '#' );
$bg_class    = get_query_var( 'block_bg_class', 'bg-primary' );
$text_class  = get_query_var( 'block_text_class', 'text-white' );
?>

<div class="fwp-cta <?php echo esc_attr( $bg_class ); ?> <?php echo esc_attr( $text_class ); ?>">
    <div class="container px-4 py-5">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3"><?php echo wp_kses_post( $title ); ?></h2>
                
                <?php if ( $description ) : ?>
                <p class="lead opacity-75 mb-0"><?php echo wp_kses_post( $description ); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-4 text-lg-end">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?php if ( $btn_text ) : ?>
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-light btn-lg px-4">
                        <?php echo esc_html( $btn_text ); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ( $btn2_text ) : ?>
                    <a href="<?php echo esc_url( $btn2_url ); ?>" class="btn btn-outline-light btn-lg px-4">
                        <?php echo esc_html( $btn2_text ); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
