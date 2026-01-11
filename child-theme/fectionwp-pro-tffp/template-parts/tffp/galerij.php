<?php
defined( 'ABSPATH' ) || exit;

// Static gallery dataset (mirrors the React GallerySection).
$items = array(
  array( 'id' => 1,  'title' => 'Vlinder Prinses',     'category' => 'Dieren',     'customer' => 'Kinderen',     'emoji' => '🦋', 'gradient' => 'pink-purple-indigo' ),
  array( 'id' => 2,  'title' => 'Superheld Masker',   'category' => 'Superhelden','customer' => 'Kinderen',     'emoji' => '🦸', 'gradient' => 'blue-indigo-cyan' ),
  array( 'id' => 3,  'title' => 'Unicorn Droom',      'category' => 'Fantasy',    'customer' => 'Kinderen',     'emoji' => '🦄', 'gradient' => 'purple-pink-rose' ),
  array( 'id' => 4,  'title' => 'Leeuw Koning',       'category' => 'Dieren',     'customer' => 'Kinderen',     'emoji' => '🦁', 'gradient' => 'orange-amber-yellow' ),
  array( 'id' => 5,  'title' => 'Glitter Glam',       'category' => 'Glitter',    'customer' => 'Volwassenen',  'emoji' => '💎', 'gradient' => 'pink-rose-purple' ),
  array( 'id' => 6,  'title' => 'Tijger Strepen',     'category' => 'Dieren',     'customer' => 'Kinderen',     'emoji' => '🐅', 'gradient' => 'yellow-orange-red' ),
  array( 'id' => 7,  'title' => 'Prinses Kroon',      'category' => 'Prinsessen', 'customer' => 'Kinderen',     'emoji' => '👑', 'gradient' => 'pink-yellow-amber' ),
  array( 'id' => 8,  'title' => 'Spiderman Web',      'category' => 'Superhelden','customer' => 'Kinderen',     'emoji' => '🕷️', 'gradient' => 'red-rose-pink' ),
  array( 'id' => 9,  'title' => 'Regenboog Verf',     'category' => 'Fantasy',    'customer' => 'Kinderen',     'emoji' => '🌈', 'gradient' => 'green-emerald-teal' ),
  array( 'id' => 10, 'title' => 'Festival Sparkles',  'category' => 'Glitter',    'customer' => 'Volwassenen',  'emoji' => '🎭', 'gradient' => 'purple-indigo-blue' ),
  array( 'id' => 11, 'title' => 'Katje Cute',         'category' => 'Dieren',     'customer' => 'Kinderen',     'emoji' => '🐱', 'gradient' => 'indigo-purple-pink' ),
  array( 'id' => 12, 'title' => 'Ster Glitter',       'category' => 'Glitter',    'customer' => 'Kinderen',     'emoji' => '🎨', 'gradient' => 'yellow-amber-orange' ),
);

$categories = array( 'Alle', 'Dieren', 'Superhelden', 'Fantasy', 'Prinsessen', 'Glitter' );
$customer_types = array( 'Alle', 'Kinderen', 'Volwassenen' );
?>

<section class="tffp-page-pad-top py-5 py-lg-6 position-relative overflow-hidden" style="background:
  radial-gradient(circle at 25% 25%, var(--bs-primary-bg-subtle) 0%, transparent 55%),
  radial-gradient(circle at 75% 75%, var(--bs-secondary-bg-subtle) 0%, transparent 55%),
  var(--bs-body-bg);
">
  <div class="container position-relative">
    <div class="text-center mb-4 mb-lg-5">
      <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 mb-3">Galerij</span>
      <h1 class="display-5 fw-bold mb-3">Onze creaties</h1>
      <p class="lead mb-0">Bekijk een selectie van onze mooiste face paintings en blije klanten</p>
    </div>

    <div data-tffp-gallery>
      <div class="tffp-gallery-filters mb-4 mb-lg-5">
        <div class="d-flex flex-wrap justify-content-center gap-2" data-filter-group="category">
          <?php foreach ( $categories as $cat ) : ?>
            <button type="button" class="btn btn-sm btn-outline-primary" data-filter-value="<?php echo esc_attr( $cat ); ?>" aria-pressed="false">
              <?php echo esc_html( $cat ); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mt-3 align-items-center" data-filter-group="customer">
          <span class="small text-body-secondary me-1">Klanttype:</span>
          <?php foreach ( $customer_types as $type ) : ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-filter-value="<?php echo esc_attr( $type ); ?>" aria-pressed="false">
              <?php
              if ( 'Kinderen' === $type ) {
                  echo '👶 '; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              }
              if ( 'Volwassenen' === $type ) {
                  echo '👨 '; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
              }
              echo esc_html( $type );
              ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="tffp-gallery-grid">
        <?php foreach ( $items as $item ) : ?>
          <div
            class="tffp-gallery-item"
            data-gallery-item
            data-id="<?php echo esc_attr( (string) $item['id'] ); ?>"
            data-title="<?php echo esc_attr( (string) $item['title'] ); ?>"
            data-category="<?php echo esc_attr( (string) $item['category'] ); ?>"
            data-customer="<?php echo esc_attr( (string) $item['customer'] ); ?>"
            data-emoji="<?php echo esc_attr( (string) $item['emoji'] ); ?>"
            data-gradient="<?php echo esc_attr( (string) $item['gradient'] ); ?>"
          >
            <div class="tffp-gallery-card" data-gradient="<?php echo esc_attr( (string) $item['gradient'] ); ?>">
              <div class="tffp-gallery-emoji" aria-hidden="true"><?php echo esc_html( (string) $item['emoji'] ); ?></div>
              <div class="tffp-gallery-caption">
                <div class="tffp-gallery-title"><?php echo esc_html( (string) $item['title'] ); ?></div>
                <div class="tffp-gallery-subtitle"><?php echo esc_html( (string) $item['category'] ); ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <p class="text-center mt-4 mb-0">
        <span class="tffp-animate-pulse-gentle d-inline-block me-2" aria-hidden="true">💖</span>
        Meer dan <strong class="text-primary">1000+</strong> tevreden kinderen en volwassenen geschminkt
      </p>

      <div id="tffp-gallery-modal" class="tffp-gallery-modal d-none" role="dialog" aria-modal="true" aria-label="Galerij">
        <div class="tffp-gallery-modal__backdrop" data-modal-backdrop></div>
        <div class="tffp-gallery-modal__dialog" role="document">
          <button type="button" class="tffp-gallery-modal__close" data-modal-close aria-label="Sluiten">×</button>

          <div class="tffp-gallery-modal__stage" data-modal-stage>
            <div class="tffp-gallery-modal__emoji" data-modal-emoji aria-hidden="true"></div>
            <div class="tffp-gallery-modal__meta">
              <div class="tffp-gallery-modal__title" data-modal-title></div>
              <span class="badge bg-dark bg-opacity-25 border border-light border-opacity-25" data-modal-badge></span>
            </div>
            <button type="button" class="tffp-gallery-modal__nav tffp-gallery-modal__nav--prev" data-modal-prev aria-label="Vorige">‹</button>
            <button type="button" class="tffp-gallery-modal__nav tffp-gallery-modal__nav--next" data-modal-next aria-label="Volgende">›</button>
          </div>

          <div class="tffp-gallery-modal__dots" data-modal-dots aria-label="Navigatie"></div>
        </div>
      </div>
    </div>
  </div>
</section>
