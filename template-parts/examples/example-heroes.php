<?php
/**
 * Example: Heroes
 * 
 * Available $atts from Visual Builder:
 * - title: Main hero title
 * - subtitle: Hero description
 * - btn_text: Button text
 * - btn_url: Button URL
 * - title2: Second hero title
 * - subtitle2: Second hero description
 */
$title     = isset( $atts['title'] ) ? $atts['title'] : 'Hero met jumbotron';
$subtitle  = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Gebruik dit voor snelle landing-calls.';
$btn_text  = isset( $atts['btn_text'] ) ? $atts['btn_text'] : 'Call to action';
$btn_url   = isset( $atts['btn_url'] ) ? $atts['btn_url'] : '#';
$title2    = isset( $atts['title2'] ) ? $atts['title2'] : 'Split hero';
$subtitle2 = isset( $atts['subtitle2'] ) ? $atts['subtitle2'] : 'Tekst links, beeld rechts. Handig voor product teasers.';
?>
<section class="example-heroes">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container py-5">
            <h1 class="display-5 fw-bold"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="col-md-8 fs-5 text-muted"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( $btn_text ) : ?>
                <a class="btn btn-primary btn-lg" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row align-items-center g-4 mb-4">
        <div class="col-lg-6">
            <h2 class="fw-bold"><?php echo esc_html( $title2 ); ?></h2>
            <?php if ( $subtitle2 ) : ?>
                <p class="text-muted"><?php echo esc_html( $subtitle2 ); ?></p>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="#">Meer info</a>
        </div>
        <div class="col-lg-6">
            <div class="ratio ratio-16x9 bg-body-tertiary rounded"></div>
        </div>
    </div>
</section>
