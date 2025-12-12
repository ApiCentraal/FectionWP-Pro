<?php
/**
 * Example: Features
 * 
 * Available $atts from Visual Builder:
 * - title: Section title
 * - subtitle: Section subtitle
 * - cols: Number of columns (2, 3, 4)
 * - items: Number of feature items
 * - icon: Bootstrap icon class (e.g., bi-star)
 */
$title    = isset( $atts['title'] ) ? $atts['title'] : 'Features';
$subtitle = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Grid met iconen en korte copy.';
$cols     = isset( $atts['cols'] ) ? intval( $atts['cols'] ) : 3;
$items    = isset( $atts['items'] ) ? intval( $atts['items'] ) : 6;
$icon     = isset( $atts['icon'] ) ? $atts['icon'] : 'bi-star';

$col_class = 'row-cols-md-' . $cols;
?>
<section class="example-features py-4">
    <div class="text-center mb-5">
        <h2 class="fw-bold"><?php echo esc_html( $title ); ?></h2>
        <?php if ( $subtitle ) : ?>
            <p class="text-muted"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <div class="row row-cols-1 <?php echo esc_attr( $col_class ); ?> g-4">
        <?php for ( $i = 1; $i <= $items; $i++ ) : ?>
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="mb-3"><i class="bi <?php echo esc_attr( $icon ); ?> fs-3 text-primary"></i></div>
                    <h3 class="h5 fw-bold">Feature <?php echo $i; ?></h3>
                    <p class="text-muted mb-0">Korte omschrijving van de feature.</p>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</section>
