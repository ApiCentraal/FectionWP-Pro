<?php
defined( 'ABSPATH' ) || exit;

$title = (string) get_query_var( 'tffp_pricing_title', __( 'Pakketten & prijzen', 'fectionwp-pro-tffp' ) );
$subtitle = (string) get_query_var( 'tffp_pricing_subtitle', __( 'Indicatieve pakketten. Vraag gerust een offerte op maat aan.', 'fectionwp-pro-tffp' ) );

$plans = get_query_var( 'tffp_pricing_plans', array() );
if ( ! is_array( $plans ) || empty( $plans ) ) {
    $plans = array(
        array(
            'name'     => __( 'Mini', 'fectionwp-pro-tffp' ),
            'price'    => __( '€ 125', 'fectionwp-pro-tffp' ),
            'note'     => __( 'Kort feestje of kleine groep', 'fectionwp-pro-tffp' ),
            'features' => array(
                __( 'Schminken (± 1 uur)', 'fectionwp-pro-tffp' ),
                __( 'Mini designs', 'fectionwp-pro-tffp' ),
                __( 'Reiskosten in overleg', 'fectionwp-pro-tffp' ),
            ),
            'cta_label' => __( 'Offerte aanvragen', 'fectionwp-pro-tffp' ),
            'cta_url'   => home_url( '/contact/' ),
            'featured'  => false,
        ),
        array(
            'name'     => __( 'Populair', 'fectionwp-pro-tffp' ),
            'price'    => __( '€ 195', 'fectionwp-pro-tffp' ),
            'note'     => __( 'Meest gekozen voor kinderfeestjes', 'fectionwp-pro-tffp' ),
            'features' => array(
                __( 'Schminken (± 1,5 uur)', 'fectionwp-pro-tffp' ),
                __( 'Meer variatie designs', 'fectionwp-pro-tffp' ),
                __( 'Glitter accents mogelijk', 'fectionwp-pro-tffp' ),
            ),
            'cta_label' => __( 'Beschikbaarheid checken', 'fectionwp-pro-tffp' ),
            'cta_url'   => home_url( '/contact/' ),
            'featured'  => true,
        ),
        array(
            'name'     => __( 'Event', 'fectionwp-pro-tffp' ),
            'price'    => __( 'Op aanvraag', 'fectionwp-pro-tffp' ),
            'note'     => __( 'Festivals & bedrijfsfeesten', 'fectionwp-pro-tffp' ),
            'features' => array(
                __( 'Schminken + glittertattoos', 'fectionwp-pro-tffp' ),
                __( 'Hoge doorloop mogelijk', 'fectionwp-pro-tffp' ),
                __( 'Afstemming op locatie', 'fectionwp-pro-tffp' ),
            ),
            'cta_label' => __( 'Vraag een offerte', 'fectionwp-pro-tffp' ),
            'cta_url'   => home_url( '/contact/' ),
            'featured'  => false,
        ),
    );
}

$variant = (string) get_query_var( 'tffp_pricing_variant', 'light' );
$bg_class = ( 'light' === $variant ) ? 'bg-light' : 'bg-body-tertiary';
?>

<section class="tffp-pricing py-5 <?php echo esc_attr( $bg_class ); ?>">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="h1 mb-2"><?php echo esc_html( $title ); ?></h2>
      <p class="lead mb-0 text-body-secondary"><?php echo esc_html( $subtitle ); ?></p>
    </div>

    <div class="row g-3 g-lg-4 justify-content-center">
      <?php foreach ( $plans as $plan ) : ?>
        <?php
        if ( ! is_array( $plan ) ) {
            continue;
        }

        $name = isset( $plan['name'] ) ? (string) $plan['name'] : '';
        $price = isset( $plan['price'] ) ? (string) $plan['price'] : '';
        $note = isset( $plan['note'] ) ? (string) $plan['note'] : '';
        $features = isset( $plan['features'] ) && is_array( $plan['features'] ) ? $plan['features'] : array();
        $cta_label = isset( $plan['cta_label'] ) ? (string) $plan['cta_label'] : '';
        $cta_url = isset( $plan['cta_url'] ) ? (string) $plan['cta_url'] : '';
        $featured = ! empty( $plan['featured'] );

        if ( '' === trim( $name ) || '' === trim( $price ) ) {
            continue;
        }

        $card_class = $featured ? 'border-primary shadow' : 'border-0 shadow-sm';
        $btn_class = $featured ? 'btn btn-primary' : 'btn btn-outline-primary';
        ?>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card h-100 <?php echo esc_attr( $card_class ); ?>">
            <div class="card-body p-4 p-md-5 d-flex flex-column">
              <div class="d-flex align-items-baseline justify-content-between mb-2">
                <h3 class="h4 mb-0"><?php echo esc_html( $name ); ?></h3>
                <?php if ( $featured ) : ?>
                  <span class="badge text-bg-primary"><?php echo esc_html__( 'Populair', 'fectionwp-pro-tffp' ); ?></span>
                <?php endif; ?>
              </div>

              <?php if ( $note ) : ?>
                <p class="text-body-secondary mb-3"><?php echo esc_html( $note ); ?></p>
              <?php endif; ?>

              <p class="display-6 fw-semibold mb-3"><?php echo esc_html( $price ); ?></p>

              <?php if ( ! empty( $features ) ) : ?>
                <ul class="list-unstyled mb-4">
                  <?php foreach ( $features as $feat ) : ?>
                    <?php $feat = trim( (string) $feat ); ?>
                    <?php if ( '' === $feat ) { continue; } ?>
                    <li class="d-flex gap-2 mb-2">
                      <span class="text-primary" aria-hidden="true">•</span>
                      <span><?php echo esc_html( $feat ); ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <?php if ( $cta_url && $cta_label ) : ?>
                <div class="mt-auto">
                  <a class="<?php echo esc_attr( $btn_class ); ?> w-100" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
