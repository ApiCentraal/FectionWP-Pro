<?php
defined( 'ABSPATH' ) || exit;

$cities = array(
  'Amsterdam',
  'Rotterdam',
  'Utrecht',
  'Den Haag',
  'Eindhoven',
  'Tilburg',
  'Groningen',
  'Almere',
  'Breda',
  'Nijmegen',
  'Haarlem',
  'Arnhem',
  'Zaanstad',
  'Amersfoort',
  'Apeldoorn',
);
?>
<section class="tffp-locations py-5 bg-light">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge rounded-pill text-bg-secondary mb-3">Lokale Service</span>
      <h2 class="h1 mb-3">Waar Wij Actief Zijn</h2>
      <p class="lead mb-0">The Funky Face Painter verzorgt schminken door heel Nederland</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body p-4 p-md-5">
            <p class="text-center mb-4">
              The Funky Face Painter is actief in heel Nederland en omgeving.
              Wij verzorgen schminken voor kinderfeestjes, evenementen en
              festivals op locatie.
            </p>

            <div class="row g-2 g-md-3">
              <?php foreach ( $cities as $city ) : ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                  <div class="border rounded p-2 text-center h-100 bg-white">
                    <strong><?php echo esc_html( $city ); ?></strong>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="mt-4 p-3 rounded border bg-white">
              <p class="mb-0 text-center">
                <strong>Staat jouw stad er niet bij?</strong> Neem contact met ons op – we komen graag naar je toe!
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
