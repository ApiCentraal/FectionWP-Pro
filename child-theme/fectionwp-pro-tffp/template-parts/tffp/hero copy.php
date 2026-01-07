<?php
defined( 'ABSPATH' ) || exit;
?>
<section class="position-relative min-vh-100 d-flex align-items-center overflow-hidden pt-5">
  <div class="tffp-hero-deco position-absolute top-0 start-0 w-100 h-100">
    <i class="bi bi-stars position-absolute tffp-deco-1 tffp-animate-float text-primary" style="font-size: 2rem;"></i>
    <i class="bi bi-balloon-fill position-absolute tffp-deco-2 tffp-animate-float text-warning" style="font-size: 2.5rem;"></i>
    <i class="bi bi-stars position-absolute tffp-deco-3 tffp-animate-float text-secondary" style="font-size: 1.75rem;"></i>
    <i class="bi bi-stars position-absolute tffp-deco-4 tffp-animate-float text-warning" style="font-size: 1.5rem;"></i>
  </div>

  <div class="container py-5 position-relative" style="z-index: 1;">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="text-center">
          <h1 class="display-5 fw-bold mb-4" style="letter-spacing: -0.02em;">
            Heb je ooit een kinderfeestje gevierd bij McDonald’s? <span class="text-primary">Dan weet je hoe bijzonder zo’n feestje kan voelen!</span>
          </h1>
        </div>

        <div class="mx-auto fs-5 text-body-secondary" style="max-width: 52rem; line-height: 1.8;">
          <figure class="tffp-story-figure float-md-start me-md-4 mb-3 mt-2">
            <div class="tffp-story-media">
              <img
                class="tffp-story-img img-fluid"
                src="https://thefunkyfacepainter.nl/wp-content/uploads/2025/12/the-funky-face-painter-Romana-Tamara-Plet-mcdonalds-schminken-2.jpg"
                alt="Romana Plet – schminken"
                loading="lazy"
                decoding="async"
              />
            </div>
          </figure>

          <p class="mb-4">
            Een keukenrondleiding, de jarige die z’n eigen hamburger mocht maken, de ballenbak vol energie en natuurlijk schminken voor kinderen. Dat moment waarop een kind zichzelf in de spiegel ziet en straalt. 😍 Daar begon het voor mij.
          </p>

          <p class="mb-4">
            Tijdens mijn werk bij McDonald’s ontdekte ik mijn liefde voor professioneel schminken op kinderfeestjes in Amsterdam. Niet alleen omdat het creatief is, maar omdat ik zag wat het doet. Kinderen voelen zich zelfverzekerd, fantasierijk en even helemaal zichzelf.
          </p>

          <p class="mb-4">
            Terwijl ik afstudeerde als docent Beeldende Kunst en Vormgeving, bleef schminken de rode draad. Van kinderfeestjes thuis in Amsterdam, tot evenementen, festivals en bedrijfsfeesten met kinderen in Amsterdam en omgeving.
          </p>

          <p class="mb-4">
            Ik combineer professionele schmink met kunsteducatie en jarenlange ervaring op evenementen. Geen snelle schminkjes, maar momenten die blijven hangen, want schminken is geen extraatje. Het is een beleving. Een herinnering. Een moment dat blijft hangen voor kinderen én ouders.
          </p>

          <p class="mb-4">
            Op zoek naar een professionele schminkster in Amsterdam voor een kinderfeestje of event? Dan zit je hier helemaal goed.
          </p>

          <p class="mb-4">
            <strong class="text-primary">Ik ben Romana Plet, The Funky Facepainter | </strong> Voor super toffe kinderfeestjes in Amsterdam, groot en klein.
          </p>

          <div class="clearfix"></div>

          <div class="text-center">
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-5">
              <a class="btn btn-primary btn-lg px-4 py-3" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
                Boek Nu via WhatsApp
              </a>
              <a class="btn btn-outline-primary btn-lg px-4 py-3" href="<?php echo esc_url( home_url( '/kinderfeestjes/' ) ); ?>">
                Ontdek Onze Diensten
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
// Additional TFFP sections (reusable blocks).
get_template_part( 'template-parts/tffp/cta' );
get_template_part( 'template-parts/tffp/quote' );
get_template_part( 'template-parts/tffp/features' );
get_template_part( 'template-parts/tffp/pricing' );
get_template_part( 'template-parts/tffp/faq' );
get_template_part( 'template-parts/tffp/newsletter' );
?>
