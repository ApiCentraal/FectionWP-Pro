<?php
/**
 * Example: Product
 * 
 * Available $atts from Visual Builder:
 * - title: Product name
 * - subtitle: Product description
 * - price: Product price
 * - image: Product image URL
 * - btn_text: Primary button text
 * - btn2_text: Secondary button text
 */
$title     = isset( $atts['title'] ) ? $atts['title'] : 'Productnaam';
$subtitle  = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Korte beschrijving van het product met belangrijkste voordelen.';
$price     = isset( $atts['price'] ) ? $atts['price'] : '€49';
$image     = isset( $atts['image'] ) ? $atts['image'] : 'https://placehold.co/900x600';
$btn_text  = isset( $atts['btn_text'] ) ? $atts['btn_text'] : 'Koop nu';
$btn2_text = isset( $atts['btn2_text'] ) ? $atts['btn2_text'] : 'Probeer demo';
?>
<section class="example-product py-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-6">
            <img class="img-fluid rounded shadow" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-6 fw-bold"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="lead text-muted"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <div class="d-flex align-items-baseline gap-3 mb-3">
                <span class="h2 fw-bold mb-0"><?php echo esc_html( $price ); ?></span>
                <span class="text-muted">incl. btw</span>
            </div>
            <ul class="list-unstyled mb-4">
                <li class="d-flex align-items-center mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Feature één</li>
                <li class="d-flex align-items-center mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Feature twee</li>
                <li class="d-flex align-items-center mb-2"><i class="bi bi-check2-circle text-success me-2"></i> Feature drie</li>
            </ul>
            <div class="d-flex gap-2 flex-wrap">
                <?php if ( $btn_text ) : ?>
                    <button class="btn btn-primary btn-lg"><?php echo esc_html( $btn_text ); ?></button>
                <?php endif; ?>
                <?php if ( $btn2_text ) : ?>
                    <button class="btn btn-outline-secondary btn-lg"><?php echo esc_html( $btn2_text ); ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
