<?php
defined( 'ABSPATH' ) || exit;

$title = (string) get_query_var( 'tffp_features_title', __( 'Waarom kiezen voor ons?', 'fectionwp-pro-tffp' ) );
$subtitle = (string) get_query_var( 'tffp_features_subtitle', __( 'Een paar redenen waarom klanten ons boeken voor feestjes en events.', 'fectionwp-pro-tffp' ) );

$items = get_query_var( 'tffp_features_items', array() );
if ( ! is_array( $items ) || empty( $items ) ) {
    $items = array(
        array(
            'icon'  => 'bi-stars',
            'title' => __( 'Creatieve designs', 'fectionwp-pro-tffp' ),
            'text'  => __( 'Van snelle mini-art tot uitgebreide face paint: altijd passend bij je thema.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'icon'  => 'bi-clock',
            'title' => __( 'Snel & professioneel', 'fectionwp-pro-tffp' ),
            'text'  => __( 'Strakke planning, fijne flow en aandacht voor ieder kind.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'icon'  => 'bi-shield-check',
            'title' => __( 'Huidvriendelijke materialen', 'fectionwp-pro-tffp' ),
            'text'  => __( 'We werken met kwalitatieve, huidvriendelijke schmink en glitters.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'icon'  => 'bi-geo-alt',
            'title' => __( 'Op locatie in NL', 'fectionwp-pro-tffp' ),
            'text'  => __( 'Beschikbaar door heel Nederland voor kinderfeestjes, festivals en events.', 'fectionwp-pro-tffp' ),
        ),
    );
}

$variant = (string) get_query_var( 'tffp_features_variant', 'body' );
$bg_class = match ( $variant ) {
    'light'   => 'bg-light',
    'tertiary'=> 'bg-body-tertiary',
    default   => 'bg-body',
};
?>

<section class="tffp-features py-5 <?php echo esc_attr( $bg_class ); ?>">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="h1 mb-2"><?php echo esc_html( $title ); ?></h2>
      <p class="lead mb-0 text-body-secondary"><?php echo esc_html( $subtitle ); ?></p>
    </div>

    <div class="row g-3 g-md-4">
      <?php foreach ( $items as $item ) : ?>
        <?php
        if ( ! is_array( $item ) ) {
            continue;
        }

        $icon  = isset( $item['icon'] ) ? trim( (string) $item['icon'] ) : '';
        $it_title = isset( $item['title'] ) ? (string) $item['title'] : '';
        $it_text  = isset( $item['text'] ) ? (string) $item['text'] : '';

        if ( '' === trim( $it_title ) || '' === trim( $it_text ) ) {
            continue;
        }
        ?>

        <div class="col-12 col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
              <?php if ( $icon ) : ?>
                <div class="mb-3 text-primary" aria-hidden="true">
                  <i class="bi <?php echo esc_attr( $icon ); ?>" style="font-size: 1.5rem;"></i>
                </div>
              <?php endif; ?>

              <h3 class="h5 mb-2"><?php echo esc_html( $it_title ); ?></h3>
              <p class="mb-0 text-body-secondary"><?php echo esc_html( $it_text ); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
