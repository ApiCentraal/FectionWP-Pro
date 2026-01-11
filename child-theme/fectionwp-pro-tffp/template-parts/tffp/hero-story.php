<?php
defined( 'ABSPATH' ) || exit;

$page_id = (int) get_queried_object_id();

$badge = (string) get_query_var( 'tffp_story_badge', '' );
$title = (string) get_query_var(
    'tffp_story_title',
    __( 'Heb je ooit een kinderfeestje gevierd bij McDonald’s?', 'fectionwp-pro-tffp' )
);
$highlight = (string) get_query_var(
    'tffp_story_highlight',
    __( 'Dan weet je hoe bijzonder zo’n feestje kan voelen!', 'fectionwp-pro-tffp' )
);

$primary_url = (string) get_query_var( 'tffp_story_primary_url', home_url( '/contact/' ) );
$primary_label = (string) get_query_var( 'tffp_story_primary_label', __( 'Boek nu via WhatsApp', 'fectionwp-pro-tffp' ) );

$secondary_url = (string) get_query_var( 'tffp_story_secondary_url', home_url( '/kinderfeestjes/' ) );
$secondary_label = (string) get_query_var( 'tffp_story_secondary_label', __( 'Ontdek onze diensten', 'fectionwp-pro-tffp' ) );

$image_alt = (string) get_query_var( 'tffp_story_image_alt', __( 'The Funky Face Painter – schminken', 'fectionwp-pro-tffp' ) );
$image_html = '';

if ( $page_id && has_post_thumbnail( $page_id ) ) {
    $image_html = get_the_post_thumbnail(
        $page_id,
        'large',
        array(
            'class' => 'tffp-story-img img-fluid',
            'loading' => 'lazy',
            'decoding' => 'async',
        )
    );
} else {
    $fallback_url = (string) get_query_var(
        'tffp_story_image_url',
        'https://thefunkyfacepainter.nl/wp-content/uploads/2025/12/the-funky-face-painter-Romana-Tamara-Plet-mcdonalds-schminken-2.jpg'
    );
    $fallback_url = esc_url( $fallback_url );

    if ( $fallback_url ) {
        $image_html = '<img class="tffp-story-img img-fluid" src="' . $fallback_url . '" alt="' . esc_attr( $image_alt ) . '" loading="lazy" decoding="async" />';
    }
}
?>

<section class="tffp-hero tffp-hero--story position-relative overflow-hidden pt-5 py-5">
  <div class="container py-4 py-lg-5 position-relative" style="z-index: 1;">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <?php if ( '' !== trim( $badge ) ) : ?>
          <div class="text-center mb-4">
            <span class="badge text-bg-primary px-3 py-2"><?php echo esc_html( $badge ); ?></span>
          </div>
        <?php endif; ?>

        <div class="text-center mb-4">
          <h1 class="display-5 fw-bold mb-0" style="letter-spacing: -0.02em;">
            <?php echo esc_html( $title ); ?>
            <span class="text-primary"><?php echo esc_html( ' ' . $highlight ); ?></span>
          </h1>
        </div>

        <div class="mx-auto fs-5 text-body-secondary" style="max-width: 52rem; line-height: 1.8;">
          <?php if ( $image_html ) : ?>
            <figure class="tffp-story-figure float-md-start me-md-4 mb-3 mt-2">
              <div class="tffp-story-media">
                <?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
              </div>
            </figure>
          <?php endif; ?>

          <p class="mb-4">
            Een keukenrondleiding, de jarige die z’n eigen hamburger mocht maken, de ballenbak vol energie en natuurlijk schminken.
            Dat moment waarop een kind zichzelf in de spiegel ziet en straalt — daar begon het voor mij.
          </p>

          <p class="mb-4">
            Tijdens mijn werk bij McDonald’s ontdekte ik mijn liefde voor professioneel schminken op kinderfeestjes in Amsterdam.
            Niet alleen omdat het creatief is, maar omdat ik zag wat het doet: kinderen voelen zich zelfverzekerd,
            fantasierijk en even helemaal zichzelf.
          </p>

          <p class="mb-4">
            Terwijl ik afstudeerde als docent Beeldende Kunst en Vormgeving, bleef schminken de rode draad.
            Van kinderfeestjes thuis in Amsterdam, tot evenementen, festivals en bedrijfsfeesten in Amsterdam en omgeving.
          </p>

          <p class="mb-4">
            Ik combineer professionele schmink met kunsteducatie en jarenlange ervaring op events.
            Geen snelle schminkjes, maar momenten die blijven hangen — want schminken is geen extraatje.
            Het is een beleving. Een herinnering.
          </p>

          <p class="mb-4">
            Op zoek naar een professionele schminkster in Amsterdam voor een kinderfeestje of event? Dan zit je hier helemaal goed.
          </p>

          <p class="mb-4">
            <strong class="text-primary">Ik ben Romana Plet, The Funky Face Painter</strong> — voor super toffe kinderfeestjes in Amsterdam, groot en klein.
          </p>

          <div class="clearfix"></div>

          <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
            <?php if ( $primary_url && $primary_label ) : ?>
              <a class="btn btn-primary btn-lg px-4 py-3" href="<?php echo esc_url( $primary_url ); ?>">
                <?php echo esc_html( $primary_label ); ?>
              </a>
            <?php endif; ?>

            <?php if ( $secondary_url && $secondary_label ) : ?>
              <a class="btn btn-outline-primary btn-lg px-4 py-3" href="<?php echo esc_url( $secondary_url ); ?>">
                <?php echo esc_html( $secondary_label ); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
