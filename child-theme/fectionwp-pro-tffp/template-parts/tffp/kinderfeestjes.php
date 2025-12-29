<?php
defined( 'ABSPATH' ) || exit;

$benefits = array(
  'Professionele, huidveilige schmink',
  'Glitterdetails en glittertattoos',
  'Geschikt voor alle leeftijden',
  'Op- en afbouw inbegrepen',
  'Rustige en vrolijke begeleiding',
);
?>
<section class="tffp-hero tffp-page-pad-top py-5 py-lg-6 position-relative overflow-hidden">
  <div class="tffp-hero-deco position-absolute top-0 start-0 w-100 h-100">
    <span class="position-absolute tffp-deco-1 tffp-animate-float text-primary fw-bold">✦</span>
    <span class="position-absolute tffp-deco-2 tffp-animate-float text-secondary fw-bold">★</span>
    <span class="position-absolute tffp-deco-3 tffp-animate-float text-primary fw-bold">✿</span>
  </div>

  <div class="container position-relative">
    <div class="text-center mb-4 mb-lg-5">
      <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 mb-3">Schminken Kinderfeestje</span>
      <h1 class="display-5 fw-bold mb-3">Kinderfeestjes</h1>
      <p class="lead mb-0">Een kinderfeestje wordt pas écht compleet met professionele gezichtsschmink</p>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-12 col-lg-6">
        <div class="card h-100 border-2">
          <div class="card-body p-4 p-lg-5">
            <h2 class="h4 mb-3">Wat We Bieden</h2>
            <p class="mb-3">
              <strong class="text-primary">The Funky Face Painter</strong> verzorgt schminken voor kinderfeestjes bij jou thuis of op locatie.
            </p>
            <p class="mb-0">
              Kinderen mogen zelf hun favoriete ontwerp kiezen: van prinsessen en superhelden tot dieren en fantasiefiguren.
              Dankzij onze ervaring werken we snel, gezellig en altijd kindvriendelijk.
            </p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card h-100 border-2">
          <div class="card-body p-4 p-lg-5">
            <h2 class="h4 mb-4">Waarom Kiezen Voor Ons?</h2>
            <ul class="list-unstyled mb-0">
              <?php foreach ( $benefits as $benefit ) : ?>
                <li class="d-flex align-items-start gap-2 mb-3">
                  <span class="text-primary fw-bold" aria-hidden="true">✓</span>
                  <span><?php echo esc_html( $benefit ); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-5">
      <p class="h5 text-secondary mb-3">Wij maken van elk kinderfeestje een kleurrijke herinnering.</p>
      <a class="btn btn-primary btn-lg" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Vraag een Offerte Aan</a>
    </div>
  </div>
</section>
