<?php
defined( 'ABSPATH' ) || exit;

$badge = (string) get_query_var( 'tffp_quote_badge', __( 'Quote', 'fectionwp-pro-tffp' ) );
$text = (string) get_query_var(
    'tffp_quote_text',
    __( '“Superleuk en professioneel! De kinderen vonden het geweldig en de schmink bleef de hele dag zitten.”', 'fectionwp-pro-tffp' )
);
$author = (string) get_query_var( 'tffp_quote_author', __( '— Een blije ouder', 'fectionwp-pro-tffp' ) );

$variant = (string) get_query_var( 'tffp_quote_variant', 'light' );
$bg_class = ( 'light' === $variant ) ? 'bg-light' : 'bg-body-tertiary';
?>

<section class="tffp-quote py-5 <?php echo esc_attr( $bg_class ); ?>">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="text-center mb-4">
          <span class="badge text-bg-secondary mb-3"><?php echo esc_html( $badge ); ?></span>
        </div>

        <figure class="mb-0">
          <blockquote class="blockquote text-center mb-3">
            <p class="display-6 mb-0"><?php echo esc_html( $text ); ?></p>
          </blockquote>
          <figcaption class="blockquote-footer text-center mb-0">
            <?php echo esc_html( $author ); ?>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>
