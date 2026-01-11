<?php
defined( 'ABSPATH' ) || exit;

$post_id = (int) get_queried_object_id();
if ( ! $post_id || ! is_singular( 'page' ) || is_front_page() ) {
    return;
}

$enabled = (bool) get_post_meta( $post_id, '_tffp_page_hero_enabled', true );
if ( ! $enabled ) {
    return;
}

$badge = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_badge', true ) );
$title = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_title', true ) );
$text  = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_text', true ) );

if ( '' === $title ) {
    $title = (string) get_the_title( $post_id );
}

$primary_label = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_primary_label', true ) );
$primary_url   = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_primary_url', true ) );

$secondary_label = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_secondary_label', true ) );
$secondary_url   = trim( (string) get_post_meta( $post_id, '_tffp_page_hero_secondary_url', true ) );

$align = (string) get_post_meta( $post_id, '_tffp_page_hero_align', true );
if ( '' === $align ) {
    $align = 'center';
}
$align = in_array( $align, array( 'center', 'left' ), true ) ? $align : 'center';

$text_align_class = ( 'left' === $align ) ? 'text-start' : 'text-center';
$cta_justify_class = ( 'left' === $align ) ? 'justify-content-start' : 'justify-content-center';
?>

<section class="tffp-page-hero position-relative overflow-hidden py-5">
  <div class="container py-4 py-lg-5 position-relative" style="z-index: 1;">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9 <?php echo esc_attr( $text_align_class ); ?>">
        <?php if ( '' !== $badge ) : ?>
          <span class="badge text-bg-primary mb-3"><?php echo esc_html( $badge ); ?></span>
        <?php endif; ?>

        <?php if ( '' !== $title ) : ?>
          <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -0.02em;">
            <?php echo esc_html( $title ); ?>
          </h1>
        <?php endif; ?>

        <?php if ( '' !== $text ) : ?>
          <p class="lead text-body-secondary mb-4" style="line-height: 1.7; max-width: 52rem; margin-inline: auto;">
            <?php echo esc_html( $text ); ?>
          </p>
        <?php endif; ?>

        <?php if ( ( $primary_label && $primary_url ) || ( $secondary_label && $secondary_url ) ) : ?>
          <div class="d-flex flex-column flex-sm-row <?php echo esc_attr( $cta_justify_class ); ?> gap-3 mt-4">
            <?php if ( $primary_label && $primary_url ) : ?>
              <a class="btn btn-primary btn-lg px-4 py-3" href="<?php echo esc_url( $primary_url ); ?>">
                <?php echo esc_html( $primary_label ); ?>
              </a>
            <?php endif; ?>

            <?php if ( $secondary_label && $secondary_url ) : ?>
              <a class="btn btn-outline-primary btn-lg px-4 py-3" href="<?php echo esc_url( $secondary_url ); ?>">
                <?php echo esc_html( $secondary_label ); ?>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
