<?php
/**
 * Example: Carousel
 * 
 * Available $atts from Visual Builder:
 * - slides: Number of slides (3, 5, 7)
 * - autoplay: Enable autoplay (yes/no)
 * - show_captions: Show captions (yes/no)
 * - show_indicators: Show indicators (yes/no)
 */
$slides          = isset( $atts['slides'] ) ? intval( $atts['slides'] ) : 3;
$autoplay        = ! isset( $atts['autoplay'] ) || $atts['autoplay'] !== 'no';
$show_captions   = ! isset( $atts['show_captions'] ) || $atts['show_captions'] !== 'no';
$show_indicators = ! isset( $atts['show_indicators'] ) || $atts['show_indicators'] !== 'no';

$carousel_id = 'fwpCarousel' . wp_rand( 1000, 9999 );
$ride_attr   = $autoplay ? 'data-bs-ride="carousel"' : '';
?>
<section class="example-carousel">
    <div id="<?php echo esc_attr( $carousel_id ); ?>" class="carousel slide mb-4" <?php echo $ride_attr; ?>>
        <?php if ( $show_indicators ) : ?>
        <div class="carousel-indicators">
            <?php for ( $i = 0; $i < $slides; $i++ ) : ?>
                <button type="button" data-bs-target="#<?php echo esc_attr( $carousel_id ); ?>" data-bs-slide-to="<?php echo $i; ?>" <?php echo $i === 0 ? 'class="active" aria-current="true"' : ''; ?> aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        <div class="carousel-inner rounded shadow">
            <?php for ( $i = 1; $i <= $slides; $i++ ) : ?>
            <div class="carousel-item<?php echo $i === 1 ? ' active' : ''; ?>">
                <img src="https://placehold.co/1200x500?text=Slide+<?php echo $i; ?>" class="d-block w-100" alt="Slide <?php echo $i; ?>" loading="lazy">
                <?php if ( $show_captions ) : ?>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Slide <?php echo $i; ?></h5>
                    <p>Beschrijving van slide <?php echo $i; ?>.</p>
                </div>
                <?php endif; ?>
            </div>
            <?php endfor; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo esc_attr( $carousel_id ); ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo esc_attr( $carousel_id ); ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
