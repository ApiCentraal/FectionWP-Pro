<?php
/**
 * Template part for split hero section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_query_var( 'block_title', 'Split Hero Section' );
$description = get_query_var( 'block_description', '' );
$btn_text    = get_query_var( 'block_btn_text', 'Primary Action' );
$btn_url     = get_query_var( 'block_btn_url', '#' );
$btn2_text   = get_query_var( 'block_btn2_text', 'Secondary' );
$btn2_url    = get_query_var( 'block_btn2_url', '#' );
$image       = get_query_var( 'block_image', '' );
$reverse     = get_query_var( 'block_reverse', false );
?>

<div class="fwp-hero fwp-hero-split">
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row <?php echo $reverse ? 'flex-lg-row-reverse' : ''; ?> align-items-center g-5 py-5">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">
                    <?php echo wp_kses_post( $title ); ?>
                </h1>
                
                <?php if ( $description ) : ?>
                <p class="lead">
                    <?php echo wp_kses_post( $description ); ?>
                </p>
                <?php endif; ?>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <?php if ( $btn_text ) : ?>
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-primary btn-lg px-4 me-md-2">
                        <?php echo esc_html( $btn_text ); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ( $btn2_text ) : ?>
                    <a href="<?php echo esc_url( $btn2_url ); ?>" class="btn btn-outline-secondary btn-lg px-4">
                        <?php echo esc_html( $btn2_text ); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ( $image ) : ?>
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="<?php echo esc_url( $image ); ?>" class="d-block mx-lg-auto img-fluid" alt="<?php echo esc_attr( $title ); ?>" width="700" height="500" loading="lazy">
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
