<?php
defined( 'ABSPATH' ) || exit;

$title = (string) get_query_var( 'tffp_faq_title', __( 'Veelgestelde vragen', 'fectionwp-pro-tffp' ) );
$subtitle = (string) get_query_var( 'tffp_faq_subtitle', __( 'Snel antwoord op de meest voorkomende vragen.', 'fectionwp-pro-tffp' ) );

$items = get_query_var( 'tffp_faq_items', array() );
if ( ! is_array( $items ) || empty( $items ) ) {
    $items = array(
        array(
            'q' => __( 'Hoe lang duurt schminken op een kinderfeestje?', 'fectionwp-pro-tffp' ),
            'a' => __( 'Meestal 1 tot 2 uur, afhankelijk van het aantal kinderen en de gewenste ontwerpen.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'q' => __( 'Voor welke leeftijden is het geschikt?', 'fectionwp-pro-tffp' ),
            'a' => __( 'Voor vrijwel alle leeftijden. We passen de ontwerpen aan op leeftijd en wensen.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'q' => __( 'Werken jullie door heel Nederland?', 'fectionwp-pro-tffp' ),
            'a' => __( 'Ja. We komen op locatie en stemmen reiskosten/afstand vooraf af.', 'fectionwp-pro-tffp' ),
        ),
    );
}

$accordion_id = function_exists( 'wp_unique_id' ) ? wp_unique_id( 'tffp-faq-' ) : uniqid( 'tffp-faq-', false );
$accordion_id = preg_replace( '/[^a-zA-Z0-9\-_]/', '', (string) $accordion_id );

$variant = (string) get_query_var( 'tffp_faq_variant', 'light' );
$bg_class = ( 'light' === $variant ) ? 'bg-light' : 'bg-body-tertiary';
?>

<section class="tffp-faq py-5 <?php echo esc_attr( $bg_class ); ?>">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="h1 mb-2"><?php echo esc_html( $title ); ?></h2>
      <p class="lead mb-0 text-body-secondary"><?php echo esc_html( $subtitle ); ?></p>
    </div>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="accordion" id="<?php echo esc_attr( $accordion_id ); ?>">
          <?php foreach ( $items as $index => $item ) : ?>
            <?php
            $question = isset( $item['q'] ) ? (string) $item['q'] : '';
            $answer   = isset( $item['a'] ) ? (string) $item['a'] : '';

            if ( '' === trim( $question ) || '' === trim( $answer ) ) {
                continue;
            }

            $item_id = $accordion_id . '-' . (int) $index;
            $heading_id = $item_id . '-heading';
            $collapse_id = $item_id . '-collapse';
            $is_first = ( 0 === (int) $index );
            ?>

            <div class="accordion-item">
              <h3 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
                <button class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
                  <?php echo esc_html( $question ); ?>
                </button>
              </h3>

              <div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-bs-parent="#<?php echo esc_attr( $accordion_id ); ?>">
                <div class="accordion-body">
                  <?php echo wp_kses_post( wpautop( $answer ) ); ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
