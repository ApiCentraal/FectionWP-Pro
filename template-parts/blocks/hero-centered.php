<?php
/**
 * Template part for centered hero section
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = get_query_var( 'block_title', 'Welcome to Our Site' );
$subtitle    = get_query_var( 'block_subtitle', '' );
$description = get_query_var( 'block_description', '' );
$btn_text    = get_query_var( 'block_btn_text', 'Get Started' );
$btn_url     = get_query_var( 'block_btn_url', '#' );
$btn2_text   = get_query_var( 'block_btn2_text', '' );
$btn2_url    = get_query_var( 'block_btn2_url', '#' );
$image       = get_query_var( 'block_image', '' );
$bg_class    = get_query_var( 'block_bg_class', 'bg-body-tertiary' );
?>

<div class="fwp-hero fwp-hero-centered <?php echo esc_attr( $bg_class ); ?>">
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <?php if ( $image ) : ?>
            <div class="col-10 col-sm-8 col-lg-6 mx-auto">
                <img src="<?php echo esc_url( $image ); ?>" class="d-block mx-lg-auto img-fluid" alt="<?php echo esc_attr( $title ); ?>" width="700" height="500" loading="lazy">
            </div>
            <?php endif; ?>
            
            <div class="<?php echo $image ? 'col-lg-6' : 'col-lg-8 mx-auto'; ?> text-center <?php echo $image ? 'text-lg-start' : ''; ?>">
                <?php if ( $subtitle ) : ?>
                <p class="lead text-primary fw-semibold mb-2"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                
                <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">
                    <?php echo wp_kses_post( $title ); ?>
                </h1>
                
                <?php if ( $description ) : ?>
                <p class="lead">
                    <?php echo wp_kses_post( $description ); ?>
                </p>
                <?php endif; ?>
                
                <div class="d-grid gap-2 d-md-flex <?php echo $image ? 'justify-content-md-start' : 'justify-content-md-center'; ?>">
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
        </div>
    </div>
</div>
