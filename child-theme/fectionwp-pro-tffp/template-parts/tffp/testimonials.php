<?php
defined( 'ABSPATH' ) || exit;

$testimonials = array(
  array(
    'name' => 'Marieke van den Berg',
    'location' => 'Amsterdam',
    'rating' => 5,
    'text' => 'The Funky Face Painter heeft het kinderfeestje van mijn dochter echt magisch gemaakt! De kinderen waren dolenthousiast en de schmink was prachtig. Zeer professioneel en vriendelijk. Echte aanrader!',
    'occasion' => 'Kinderfeestje',
    'customerType' => 'Kinderen',
  ),
  array(
    'name' => 'Sophie Janssen',
    'location' => 'Utrecht',
    'rating' => 5,
    'text' => 'Fantastische ervaring voor ons festival! Supersnel werken, prachtige designs en de bezoekers waren heel blij. Precies wat we zochten voor onze event. Zeker voor herhaling vatbaar!',
    'occasion' => 'Festival',
    'customerType' => 'Volwassenen',
  ),
  array(
    'name' => 'Linda de Vries',
    'location' => 'Rotterdam',
    'rating' => 5,
    'text' => 'Mijn zoon wilde een tijger zijn en het resultaat was waanzinnig goed! De schmink was huidvriendelijk en bleef de hele dag mooi. Alle kinderen wilden ook geschminkt worden. Top!',
    'occasion' => 'Kinderfeestje',
    'customerType' => 'Kinderen',
  ),
  array(
    'name' => 'Jasper Bakker',
    'location' => 'Den Haag',
    'rating' => 5,
    'text' => 'Voor onze bedrijfsdag perfect! De glitter face art was een groot succes bij jong en oud. Professioneel, creatief en heel gezellig. Onze collega\'s vonden het geweldig!',
    'occasion' => 'Bedrijfsevent',
    'customerType' => 'Volwassenen',
  ),
  array(
    'name' => 'Emma Visser',
    'location' => 'Haarlem',
    'rating' => 5,
    'text' => 'Wat een feest! De Funky Face Painter maakte van elk kind een echt kunstwerk. Super lieve begeleiding, geduldig en zeer getalenteerd. Alle ouders waren onder de indruk!',
    'occasion' => 'Kinderfeestje',
    'customerType' => 'Kinderen',
  ),
  array(
    'name' => 'Tom Smit',
    'location' => 'Eindhoven',
    'rating' => 5,
    'text' => 'We boekten The Funky Face Painter voor een winkelopening en het was een schot in de roos. Veel bezoekers kwamen speciaal voor de schmink. Uitstekende service en prachtig werk!',
    'occasion' => 'Winkelopening',
    'customerType' => 'Volwassenen',
  ),
);

$render_cards = function ( $items ) {
  ?>
  <div class="row g-3 g-lg-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
    <?php foreach ( $items as $t ) : ?>
      <div class="col">
        <div class="card h-100 border-2 shadow-sm">
          <div class="card-body p-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0" style="width: 6rem; height: 6rem; background: linear-gradient(135deg, color-mix(in oklch, var(--tffp-primary) 15%, transparent) 0%, transparent 100%); border-bottom-left-radius: 9999px; opacity: .6;"></div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex gap-1">
                <?php for ( $i = 0; $i < (int) $t['rating']; $i++ ) : ?>
                  <i class="bi bi-star-fill text-warning"></i>
                <?php endfor; ?>
              </div>
              <span class="badge text-bg-light border" style="background-color: color-mix(in oklch, var(--tffp-muted) 60%, white);">
                <?php echo esc_html( $t['occasion'] ); ?>
              </span>
            </div>

            <div class="mb-3">
              <i class="bi bi-quote text-primary" style="opacity: .25; font-size: 2rem;"></i>
            </div>

            <p class="text-body-secondary mb-4" style="line-height: 1.7;">
              &ldquo;<?php echo esc_html( $t['text'] ); ?>&rdquo;
            </p>

            <div class="border-top pt-3">
              <div class="fw-semibold"><?php echo esc_html( $t['name'] ); ?></div>
              <div class="small text-body-secondary"><?php echo esc_html( $t['location'] ); ?></div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php
};

$items_kinderen = array_values( array_filter( $testimonials, fn ( $t ) => 'Kinderen' === $t['customerType'] ) );
$items_volwassenen = array_values( array_filter( $testimonials, fn ( $t ) => 'Volwassenen' === $t['customerType'] ) );
?>
<section class="tffp-testimonials py-5 py-md-6">
  <div class="container py-4">
    <div class="text-center mb-5">
      <span class="badge rounded-pill px-3 py-2 mb-3" style="background-color: color-mix(in oklch, var(--tffp-accent) 15%, white); color: color-mix(in oklch, var(--tffp-accent) 70%, black); border: 1px solid color-mix(in oklch, var(--tffp-accent) 25%, white);">
        Klantbeoordelingen
      </span>
      <h2 class="display-6 fw-bold mb-3">
        <i class="bi bi-chat-quote-fill text-warning me-2"></i>
        Wat Onze Klanten Zeggen
      </h2>
      <p class="fs-5 text-body-secondary mb-0" style="max-width: 52rem; margin-inline: auto;">
        Honderden tevreden klanten gingen je voor. Lees hun ervaringen met The Funky Face Painter.
      </p>
    </div>

    <ul class="nav nav-pills justify-content-center gap-2 mb-4" id="tffp-testimonial-tabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tffp-tab-alle" data-bs-toggle="pill" data-bs-target="#tffp-pane-alle" type="button" role="tab" aria-controls="tffp-pane-alle" aria-selected="true">
          Alle
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tffp-tab-kinderen" data-bs-toggle="pill" data-bs-target="#tffp-pane-kinderen" type="button" role="tab" aria-controls="tffp-pane-kinderen" aria-selected="false">
          Kinderen
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="tffp-tab-volwassenen" data-bs-toggle="pill" data-bs-target="#tffp-pane-volwassenen" type="button" role="tab" aria-controls="tffp-pane-volwassenen" aria-selected="false">
          Volwassenen
        </button>
      </li>
    </ul>

    <div class="tab-content" id="tffp-testimonial-tab-content">
      <div class="tab-pane fade show active" id="tffp-pane-alle" role="tabpanel" aria-labelledby="tffp-tab-alle" tabindex="0">
        <?php $render_cards( $testimonials ); ?>
      </div>
      <div class="tab-pane fade" id="tffp-pane-kinderen" role="tabpanel" aria-labelledby="tffp-tab-kinderen" tabindex="0">
        <?php $render_cards( $items_kinderen ); ?>
      </div>
      <div class="tab-pane fade" id="tffp-pane-volwassenen" role="tabpanel" aria-labelledby="tffp-tab-volwassenen" tabindex="0">
        <?php $render_cards( $items_volwassenen ); ?>
      </div>
    </div>

    <div class="text-center mt-5">
      <div class="d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill border" style="background: linear-gradient(90deg, color-mix(in oklch, var(--tffp-primary) 12%, white), color-mix(in oklch, var(--tffp-accent) 12%, white), color-mix(in oklch, var(--tffp-secondary) 12%, white));">
        <span class="d-inline-flex gap-1">
          <?php for ( $i = 0; $i < 5; $i++ ) : ?>
            <i class="bi bi-star-fill text-warning"></i>
          <?php endfor; ?>
        </span>
        <span class="fw-semibold">5.0 Gemiddelde Score</span>
        <span class="text-body-secondary">• 100+ reviews</span>
      </div>
    </div>
  </div>
</section>
