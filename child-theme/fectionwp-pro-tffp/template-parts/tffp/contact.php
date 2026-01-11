<?php
defined( 'ABSPATH' ) || exit;

$whatsapp_number = function_exists( 'tffp_get_whatsapp_number' ) ? tffp_get_whatsapp_number() : '31612345678';
$whatsapp_prefill = function_exists( 'tffp_get_whatsapp_prefill' ) ? tffp_get_whatsapp_prefill() : __( 'Hallo! Ik wil graag informatie over jullie diensten.', 'fectionwp-pro-tffp' );
$whatsapp_url = function_exists( 'tffp_get_whatsapp_url' ) ? tffp_get_whatsapp_url( $whatsapp_prefill ) : ( 'https://wa.me/' . rawurlencode( $whatsapp_number ) );

$contact_email = (string) get_theme_mod( 'tffp_contact_email', 'info@thefunkyfacepainter.nl' );
$contact_email = sanitize_email( $contact_email );

$contact_phone_display = (string) get_theme_mod( 'tffp_contact_phone', '+31 6 1234 5678' );
$contact_phone_display = trim( wp_strip_all_tags( $contact_phone_display ) );

$contact_phone_href = preg_replace( '/\D+/', '', $contact_phone_display );
if ( $contact_phone_href ) {
    // Assume NL when number starts with 0.
    if ( '0' === substr( $contact_phone_href, 0, 1 ) ) {
        $contact_phone_href = '31' . ltrim( $contact_phone_href, '0' );
    }
    $contact_phone_href = '+' . $contact_phone_href;
}
?>
<section class="py-5">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge text-bg-primary mb-3">Online Boeken</span>
      <h1 class="mb-3">Boek Je Afspraak</h1>
      <p class="lead mb-0">
        Plan eenvoudig je face painting sessie. Kies je service, selecteer een datum
        en tijd, en wij zorgen voor de rest!
      </p>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="card">
          <div class="card-body">
            <?php
            // FectionWP-Booking plugin integration.
            if ( shortcode_exists( 'pbp_booking_form' ) ) {
                echo do_shortcode( '[pbp_booking_form]' );
            } else {
                echo '<p class="mb-0">Booking plugin niet actief of shortcode ontbreekt.</p>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge text-bg-secondary mb-3">Contact &amp; Boeken</span>
      <h2 class="h1 mb-3">Neem Contact Op</h2>
      <p class="lead mb-0">
        Klaar om te boeken of een offerte aan te vragen? Neem eenvoudig
        contact op via WhatsApp of e-mail. Wij reageren snel en denken graag
        met je mee.
      </p>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-12 col-lg-5">
        <div class="card h-100">
          <div class="card-body">
            <h3 class="h4 mb-4">Contactgegevens</h3>

            <div class="mb-4">
              <div class="d-flex align-items-start gap-3">
                <div class="flex-grow-1">
                  <p class="fw-semibold mb-1">WhatsApp</p>
                  <p class="text-body-secondary mb-2"><?php echo esc_html( $contact_phone_display ?: '+31 6 1234 5678' ); ?></p>
                  <a class="link-primary" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer">Direct een bericht sturen →</a>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <p class="fw-semibold mb-1">E-mail</p>
              <?php if ( $contact_email ) : ?>
                <a class="text-body-secondary link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="mailto:<?php echo esc_attr( $contact_email ); ?>">
                  <?php echo esc_html( $contact_email ); ?>
                </a>
              <?php else : ?>
                <p class="text-body-secondary mb-0">—</p>
              <?php endif; ?>
            </div>

            <div class="mb-4">
              <p class="fw-semibold mb-1">Telefoon</p>
              <?php if ( $contact_phone_display && $contact_phone_href ) : ?>
                <a class="text-body-secondary link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="tel:<?php echo esc_attr( $contact_phone_href ); ?>">
                  <?php echo esc_html( $contact_phone_display ); ?>
                </a>
              <?php else : ?>
                <p class="text-body-secondary mb-0"><?php echo esc_html( $contact_phone_display ?: '—' ); ?></p>
              <?php endif; ?>
            </div>

            <div class="p-3 border bg-light">
              <p class="mb-0">
                <strong>Snel antwoord nodig?</strong> WhatsApp is de snelste manier om contact met ons op te nemen!
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-5">
        <div class="card h-100">
          <div class="card-body">
            <h3 class="h4 mb-4">Stuur Een Bericht</h3>

            <form id="tffp-whatsapp-form" data-whatsapp-number="<?php echo esc_attr( $whatsapp_number ); ?>" novalidate>
              <div class="mb-3">
                <label class="form-label" for="tffp-contact-name">Naam *</label>
                <input class="form-control" id="tffp-contact-name" type="text" autocomplete="name" required />
              </div>

              <div class="mb-3">
                <label class="form-label" for="tffp-contact-email">E-mail *</label>
                <input class="form-control" id="tffp-contact-email" type="email" autocomplete="email" required />
              </div>

              <div class="mb-3">
                <label class="form-label" for="tffp-contact-phone">Telefoon</label>
                <input class="form-control" id="tffp-contact-phone" type="tel" autocomplete="tel" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="tffp-contact-message">Bericht *</label>
                <textarea class="form-control" id="tffp-contact-message" rows="5" required placeholder="Vertel ons over je event of vraag..."></textarea>
              </div>

              <div id="tffp-whatsapp-error" class="alert alert-danger d-none" role="alert"></div>
              <div id="tffp-whatsapp-success" class="alert alert-success d-none" role="status">
                <?php echo esc_html__( 'WhatsApp geopend. Je kunt je bericht nu versturen.', 'fectionwp-pro-tffp' ); ?>
              </div>

              <button type="submit" class="btn btn-primary w-100">Verstuur via WhatsApp</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_template_part( 'template-parts/tffp/locations' );
?>
