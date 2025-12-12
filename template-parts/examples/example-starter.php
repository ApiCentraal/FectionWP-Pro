<?php
/**
 * Example: Starter
 * 
 * Available $atts from Visual Builder:
 * - title: Main title
 * - subtitle: Description text
 * - btn_text: Primary button text
 * - btn2_text: Secondary button text
 * - image: Hero image URL
 */
$title     = isset( $atts['title'] ) ? $atts['title'] : 'A starter template for your next project';
$subtitle  = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Snel beginnen met een simpele navbar, grid en knoppen. Pas de tekst en call-to-action aan.';
$btn_text  = isset( $atts['btn_text'] ) ? $atts['btn_text'] : 'Primary';
$btn2_text = isset( $atts['btn2_text'] ) ? $atts['btn2_text'] : 'Secondary';
$image     = isset( $atts['image'] ) ? $atts['image'] : 'https://placehold.co/700x450';
?>
<div class="example-starter">
    <header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
            <span class="fw-bold">Bootstrap Starter</span>
        </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link">FAQ</a></li>
            <li class="nav-item"><a href="#" class="nav-link">About</a></li>
        </ul>
    </header>

    <div class="row align-items-center g-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold lh-1 mb-3"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="lead"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <?php if ( $btn_text ) : ?>
                    <button type="button" class="btn btn-primary btn-lg px-4 me-md-2"><?php echo esc_html( $btn_text ); ?></button>
                <?php endif; ?>
                <?php if ( $btn2_text ) : ?>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4"><?php echo esc_html( $btn2_text ); ?></button>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="<?php echo esc_url( $image ); ?>" class="d-block mx-lg-auto img-fluid rounded" alt="" loading="lazy">
        </div>
    </div>
</div>
