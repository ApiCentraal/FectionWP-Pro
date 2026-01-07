<?php
defined( 'ABSPATH' ) || exit;

$title = (string) get_query_var( 'tffp_cta_title', __( 'Klaar om te boeken?', 'fectionwp-pro-tffp' ) );
$text  = (string) get_query_var( 'tffp_cta_text', __( 'Stuur een bericht of vraag vrijblijvend een offerte aan. We reageren snel.', 'fectionwp-pro-tffp' ) );

$primary_label = (string) get_query_var( 'tffp_cta_primary_label', __( 'Neem contact op', 'fectionwp-pro-tffp' ) );
$primary_url   = (string) get_query_var( 'tffp_cta_primary_url', home_url( '/contact/' ) );

$secondary_label = (string) get_query_var( 'tffp_cta_secondary_label', __( 'Bekijk galerij', 'fectionwp-pro-tffp' ) );
$secondary_url   = (string) get_query_var( 'tffp_cta_secondary_url', home_url( '/galerij/' ) );

$variant = (string) get_query_var( 'tffp_cta_variant', 'tertiary' );
$bg_class = match ( $variant ) {
    'light'   => 'bg-light',
    'body'    => 'bg-body',
    default   => 'bg-body-tertiary',
};
?>

<section class="tffp-cta py-5 <?php echo esc_attr( $bg_class ); ?>">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
              <div class="col-12 col-lg-7">
                <h2 class="h3 mb-2"><?php echo esc_html( $title ); ?></h2>
                <p class="mb-0 text-body-secondary"><?php echo esc_html( $text ); ?></p>
              </div>

              <div class="col-12 col-lg-5">
                <div class="d-grid gap-2 d-sm-flex justify-content-lg-end">
                  <?php if ( $primary_url && $primary_label ) : ?>
                    <a class="btn btn-primary" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( $primary_label ); ?></a>
                  <?php endif; ?>

                  <?php if ( $secondary_url && $secondary_label ) : ?>
                    <a class="btn btn-outline-primary" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
