<?php
defined( 'ABSPATH' ) || exit;

$title = (string) get_query_var( 'tffp_newsletter_title', __( 'Blijf op de hoogte', 'fectionwp-pro-tffp' ) );
$subtitle = (string) get_query_var( 'tffp_newsletter_subtitle', __( 'Ontvang af en toe inspiratie, acties en beschikbaarheid.', 'fectionwp-pro-tffp' ) );
$shortcode = trim( (string) get_query_var( 'tffp_newsletter_shortcode', '' ) );

$button_label = (string) get_query_var( 'tffp_newsletter_button_label', __( 'Aanmelden', 'fectionwp-pro-tffp' ) );
$placeholder  = (string) get_query_var( 'tffp_newsletter_placeholder', __( 'jij@voorbeeld.nl', 'fectionwp-pro-tffp' ) );

$form_action = trim( (string) get_query_var( 'tffp_newsletter_form_action', '' ) );
$form_method = (string) get_query_var( 'tffp_newsletter_form_method', 'post' );
$form_method = in_array( strtolower( $form_method ), array( 'get', 'post' ), true ) ? strtolower( $form_method ) : 'post';

$action_attr = $form_action ? $form_action : '';
?>

<section class="tffp-newsletter py-5 bg-body-tertiary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-9 col-xl-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
              <div class="col-12 col-lg-6">
                <h2 class="h3 mb-2"><?php echo esc_html( $title ); ?></h2>
                <p class="mb-0 text-body-secondary"><?php echo esc_html( $subtitle ); ?></p>
              </div>

              <div class="col-12 col-lg-6">
                <?php if ( $shortcode ) : ?>
                  <?php echo do_shortcode( $shortcode ); ?>
                <?php else : ?>
                  <form class="row g-2" method="<?php echo esc_attr( $form_method ); ?>" action="<?php echo esc_url( $action_attr ); ?>">
                    <div class="col-12 col-md">
                      <label class="visually-hidden" for="tffp-newsletter-email"><?php echo esc_html__( 'E-mailadres', 'fectionwp-pro-tffp' ); ?></label>
                      <input id="tffp-newsletter-email" type="email" name="email" class="form-control" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="email" required>
                    </div>
                    <div class="col-12 col-md-auto">
                      <button type="submit" class="btn btn-primary w-100">
                        <?php echo esc_html( $button_label ); ?>
                      </button>
                    </div>
                    <div class="col-12">
                      <small class="text-body-secondary">
                        <?php echo esc_html__( 'Geen spam. Afmelden kan altijd.', 'fectionwp-pro-tffp' ); ?>
                      </small>
                    </div>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
