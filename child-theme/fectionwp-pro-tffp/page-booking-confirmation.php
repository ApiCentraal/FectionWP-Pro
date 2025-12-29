<?php
/**
 * Booking confirmation page (TFFP)
 *
 * Slug suggested: booking-confirmation
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex align-items-start gap-3">
            <div class="flex-shrink-0 d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10" style="width: 3.25rem; height: 3.25rem;">
              <i class="bi bi-check2-circle text-success" style="font-size: 1.6rem;"></i>
            </div>
            <div>
              <h1 class="h3 fw-bold mb-2">Boeking bevestigd</h1>
              <p class="text-body-secondary mb-0">
                Bedankt! Je betaling is gelukt en je boeking is ontvangen.
              </p>
            </div>
          </div>

          <hr class="my-4" />

          <p class="mb-4">
            Je ontvangt zo een bevestiging per e-mail. Heb je vragen of wil je iets wijzigen? Neem dan even contact op.
          </p>

          <div class="d-flex flex-column flex-sm-row gap-2">
            <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
            <a class="btn btn-outline-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Terug naar home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
