<?php
defined( 'ABSPATH' ) || exit;

$page_id = (int) get_queried_object_id();
$title = trim( (string) get_the_title( $page_id ) );
if ( '' === $title ) {
    $title = __( 'Over ons', 'fectionwp-pro-tffp' );
}

$whatsapp_prefill = function_exists( 'tffp_get_whatsapp_prefill' ) ? tffp_get_whatsapp_prefill() : __( 'Hallo! Ik wil graag informatie over jullie diensten.', 'fectionwp-pro-tffp' );
$whatsapp_url = function_exists( 'tffp_get_whatsapp_url' ) ? tffp_get_whatsapp_url( $whatsapp_prefill ) : home_url( '/contact/' );

$page_content = '';
if ( $page_id ) {
  $raw = (string) get_post_field( 'post_content', $page_id );
  if ( '' !== trim( wp_strip_all_tags( $raw ) ) ) {
    $page_content = apply_filters( 'the_content', $raw );
  }
}
?>

<?php
set_query_var( 'tffp_story_badge', $title );
set_query_var( 'tffp_story_primary_url', $whatsapp_url );
set_query_var( 'tffp_story_primary_label', __( 'Boek nu via WhatsApp', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_story_secondary_url', home_url( '/kinderfeestjes/' ) );
set_query_var( 'tffp_story_secondary_label', __( 'Ontdek onze diensten', 'fectionwp-pro-tffp' ) );
get_template_part( 'template-parts/tffp/hero-story' );

set_query_var( 'tffp_story_badge', null );
set_query_var( 'tffp_story_primary_url', null );
set_query_var( 'tffp_story_primary_label', null );
set_query_var( 'tffp_story_secondary_url', null );
set_query_var( 'tffp_story_secondary_label', null );
?>

<?php if ( $page_content ) : ?>
  <section class="py-5 bg-body-tertiary">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
              <div class="entry-content">
                <?php echo $page_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php
set_query_var( 'tffp_features_title', __( 'Waar we voor staan', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_features_subtitle', __( 'Onze beloftes — zodat jij zorgeloos kunt genieten.', 'fectionwp-pro-tffp' ) );
set_query_var(
    'tffp_features_items',
    array(
        array(
            'icon'  => 'bi-shield-check',
            'title' => __( 'Huidvriendelijke kwaliteit', 'fectionwp-pro-tffp' ),
            'text'  => __( 'We werken met fijne, kindveilige materialen en letten op gevoelige huid.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'icon'  => 'bi-hand-thumbs-up',
            'title' => __( 'Rust & aandacht', 'fectionwp-pro-tffp' ),
            'text'  => __( 'We begeleiden kinderen rustig en zorgen dat iedereen zich prettig voelt.', 'fectionwp-pro-tffp' ),
        ),
        array(
            'icon'  => 'bi-lightning-charge',
            'title' => __( 'Snelle, strakke werkwijze', 'fectionwp-pro-tffp' ),
            'text'  => __( 'Perfect voor drukke momenten: een fijne flow zonder haastgevoel.', 'fectionwp-pro-tffp' ),
        ),
        array(
          'icon'  => 'bi-palette',
            'title' => __( 'Creativiteit op maat', 'fectionwp-pro-tffp' ),
            'text'  => __( 'Designs die passen bij jouw thema: van subtiel tot lekker over the top.', 'fectionwp-pro-tffp' ),
        ),
    )
);
set_query_var( 'tffp_features_variant', 'tertiary' );
get_template_part( 'template-parts/tffp/features' );

set_query_var( 'tffp_features_title', null );
set_query_var( 'tffp_features_subtitle', null );
set_query_var( 'tffp_features_items', null );
set_query_var( 'tffp_features_variant', null );
?>

<section class="py-5 bg-body">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="text-center mb-4">
          <span class="badge text-bg-primary mb-3">Werkwijze</span>
          <h2 class="h1 mb-3">Zo maken we het makkelijk</h2>
          <p class="lead text-body-secondary mb-0">In 3 stappen van idee naar een kleurrijk feestje.</p>
        </div>

        <div class="row g-3 g-md-4">
          <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 bg-primary bg-opacity-10" style="width: 3rem; height: 3rem;">
                  <span class="fw-bold text-primary">1</span>
                </div>
                <h3 class="h5">Vertel je plannen</h3>
                <p class="mb-0 text-body-secondary">Datum, locatie, aantal kinderen en gewenste stijl. Dan adviseren wij wat past.</p>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 bg-secondary bg-opacity-10" style="width: 3rem; height: 3rem;">
                  <span class="fw-bold text-secondary">2</span>
                </div>
                <h3 class="h5">We stemmen af</h3>
                <p class="mb-0 text-body-secondary">We spreken een planning af en bespreken opties zoals glittertattoos of mini-art.</p>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body p-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-3 bg-warning bg-opacity-10" style="width: 3rem; height: 3rem;">
                  <span class="fw-bold text-warning">3</span>
                </div>
                <h3 class="h5">Showtime!</h3>
                <p class="mb-0 text-body-secondary">Wij komen op locatie, zetten netjes op en zorgen voor stralende gezichten.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php
get_template_part( 'template-parts/tffp/stats' );

set_query_var( 'tffp_quote_badge', __( 'Waarom we dit doen', 'fectionwp-pro-tffp' ) );
set_query_var(
    'tffp_quote_text',
    __( '“Als een kind zichzelf in de spiegel ziet en begint te stralen — dán is onze missie geslaagd.”', 'fectionwp-pro-tffp' )
);
set_query_var( 'tffp_quote_author', __( '— The Funky Face Painter', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_quote_variant', 'light' );
get_template_part( 'template-parts/tffp/quote' );

set_query_var( 'tffp_quote_badge', null );
set_query_var( 'tffp_quote_text', null );
set_query_var( 'tffp_quote_author', null );
set_query_var( 'tffp_quote_variant', null );

get_template_part( 'template-parts/tffp/locations' );

set_query_var( 'tffp_cta_title', __( 'Zullen we samen iets moois maken?', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_cta_text', __( 'Vertel ons je datum en idee — dan denken we mee en maken we een passende planning.', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_cta_primary_label', __( 'Neem contact op', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_cta_primary_url', home_url( '/contact/' ) );
set_query_var( 'tffp_cta_secondary_label', __( 'Bekijk diensten', 'fectionwp-pro-tffp' ) );
set_query_var( 'tffp_cta_secondary_url', home_url( '/kinderfeestjes/' ) );
set_query_var( 'tffp_cta_variant', 'tertiary' );
get_template_part( 'template-parts/tffp/cta' );

set_query_var( 'tffp_cta_title', null );
set_query_var( 'tffp_cta_text', null );
set_query_var( 'tffp_cta_primary_label', null );
set_query_var( 'tffp_cta_primary_url', null );
set_query_var( 'tffp_cta_secondary_label', null );
set_query_var( 'tffp_cta_secondary_url', null );
set_query_var( 'tffp_cta_variant', null );
?>
