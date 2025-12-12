<?php
/**
 * Example: Album
 * 
 * Available $atts from Visual Builder:
 * - title: Section title
 * - subtitle: Section subtitle
 * - cols: Number of columns (2, 3, 4)
 * - items: Number of items to display
 */
$title    = isset( $atts['title'] ) ? $atts['title'] : 'Album example';
$subtitle = isset( $atts['subtitle'] ) ? $atts['subtitle'] : 'Een lichte grid met kaarten, ideaal voor portfolio of cases.';
$cols     = isset( $atts['cols'] ) ? intval( $atts['cols'] ) : 3;
$items    = isset( $atts['items'] ) ? intval( $atts['items'] ) : 9;

$col_class = 'row-cols-md-' . $cols;
?>
<section class="example-album">
    <div class="text-center mb-5">
        <h1 class="display-6 fw-bold"><?php echo esc_html( $title ); ?></h1>
        <?php if ( $subtitle ) : ?>
            <p class="lead text-muted"><?php echo esc_html( $subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 <?php echo esc_attr( $col_class ); ?> g-4">
        <?php for ( $i = 1; $i <= $items; $i++ ) : ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img class="card-img-top" src="https://placehold.co/600x400?text=Album+<?php echo $i; ?>" alt="Album item <?php echo $i; ?>" loading="lazy">
                <div class="card-body d-flex flex-column">
                    <p class="card-text">Korte omschrijving voor kaart <?php echo $i; ?>. Vervang door je eigen content.</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                    </div>
                </div>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</section>
