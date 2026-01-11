<?php
defined( 'ABSPATH' ) || exit;

$suitable_for = array(
  'Festivals & pop-ups',
  'Bedrijfsfeesten',
  'Winkelopeningen',
  'Open dagen & activaties',
);
?>
<section class="tffp-page-pad-top py-5 py-lg-6 position-relative overflow-hidden" style="background:
  radial-gradient(circle at 20% 30%, var(--bs-primary-bg-subtle) 0%, transparent 55%),
  radial-gradient(circle at 80% 70%, var(--bs-secondary-bg-subtle) 0%, transparent 55%),
  var(--bs-body-bg);
">
  <div class="container position-relative">
    <div class="text-center mb-4 mb-lg-5">
      <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 mb-3">Face Painting Events</span>
      <h1 class="display-5 fw-bold mb-3">Festivals &amp; Events</h1>
      <p class="lead mb-0">Professionele face painting met maximale uitstraling en snelle doorloop</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-9">
        <div class="card border-2">
          <div class="card-body p-4 p-lg-5">
            <p class="mb-4">
              Voor festivals, bedrijfsfeesten en evenementen biedt <strong class="text-primary">The Funky Face Painter</strong>
              professionele face painting met maximale uitstraling en snelle doorloop.
            </p>

            <p class="mb-4">
              Onze event-service is perfect voor grote bezoekersstromen, merkactivaties en publieksbeleving.
              Van subtiele glitter eyes tot opvallende festival designs – alles is mogelijk.
            </p>

            <div class="bg-body-tertiary p-4 mb-4">
              <h2 class="h4 mb-3">Geschikt voor:</h2>
              <div class="row g-2">
                <?php foreach ( $suitable_for as $item ) : ?>
                  <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center gap-2">
                      <span class="text-secondary fw-bold" aria-hidden="true">✓</span>
                      <span><?php echo esc_html( $item ); ?></span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="p-4 border border-secondary-subtle" style="background: linear-gradient(135deg, var(--bs-secondary-bg-subtle), var(--bs-primary-bg-subtle));">
              <p class="mb-0"><strong class="text-secondary">Extra mogelijk:</strong> Ook branding, kleurenthema's en logo-integratie zijn mogelijk.</p>
            </div>
          </div>
        </div>

        <div class="text-center mt-4 mt-lg-5">
          <a class="btn btn-secondary btn-lg" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Vraag Event Offerte Aan</a>
        </div>
      </div>
    </div>
  </div>
</section>
