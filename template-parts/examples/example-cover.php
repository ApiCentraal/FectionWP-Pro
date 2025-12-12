<?php
/**
 * Example: Cover
 * 
 * Available $atts from Visual Builder:
 * - eyebrow: Small text above title
 * - title: Main headline
 * - subtitle: Description text
 * - btn_text: Primary button text
 * - btn_url: Primary button URL
 * - btn2_text: Secondary button text
 * - btn2_url: Secondary button URL
 */
$eyebrow   = isset( $atts['eyebrow'] ) ? $atts['eyebrow'] : 'Bootstrap 5.3 Cover';
$title     = isset( $atts['title'] ) ? $atts['title'] : 'Build fast, stay focused';
$subtitle  = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Maak een statement met een volle pagina hero. Gebruik de cover voor campagnes, launches of simpele landings.';
$btn_text  = isset( $atts['btn_text'] ) ? $atts['btn_text'] : 'Aan de slag';
$btn_url   = isset( $atts['btn_url'] ) ? $atts['btn_url'] : '#';
$btn2_text = isset( $atts['btn2_text'] ) ? $atts['btn2_text'] : 'Meer leren';
$btn2_url  = isset( $atts['btn2_url'] ) ? $atts['btn2_url'] : '#';
?>
<section class="example-cover d-flex align-items-center text-center text-bg-dark">
    <div class="example-cover__gradient"></div>
    <div class="container position-relative py-5">
        <?php if ( $eyebrow ) : ?>
            <p class="text-uppercase fw-semibold mb-2 small"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>
        <h1 class="display-4 fw-bold mb-3"><?php echo esc_html( $title ); ?></h1>
        <?php if ( $subtitle ) : ?>
            <p class="lead mb-4"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <?php if ( $btn_text ) : ?>
                <a class="btn btn-primary btn-lg px-4" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
            <?php endif; ?>
            <?php if ( $btn2_text ) : ?>
                <a class="btn btn-outline-light btn-lg px-4" href="<?php echo esc_url( $btn2_url ); ?>"><?php echo esc_html( $btn2_text ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>
