<?php
/**
 * Booking cancelled page (TFFP)
 *
 * Slug suggested: booking-cancelled
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
            <div class="flex-shrink-0 d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10" style="width: 3.25rem; height: 3.25rem;">
              <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 1.5rem;"></i>
            </div>
            <div>
              <h1 class="h3 fw-bold mb-2">Betaling geannuleerd</h1>
              <p class="text-body-secondary mb-0">
                Je hebt de betaling geannuleerd. Er is geen boeking afgerond.
              </p>
            </div>
          </div>

          <hr class="my-4" />

          <p class="mb-4">
            Wil je het opnieuw proberen of liever even overleggen? Dat kan altijd.
          </p>

          <div class="d-flex flex-column flex-sm-row gap-2">
            <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Opnieuw boeken / contact</a>
            <a class="btn btn-outline-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Terug naar home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
