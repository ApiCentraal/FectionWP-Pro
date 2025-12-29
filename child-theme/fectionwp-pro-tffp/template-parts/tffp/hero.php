<?php
defined( 'ABSPATH' ) || exit;
?>
<section class="tffp-hero position-relative min-vh-100 d-flex align-items-center overflow-hidden pt-5">
  <div class="tffp-hero-deco position-absolute top-0 start-0 w-100 h-100">
    <i class="bi bi-stars position-absolute tffp-deco-1 tffp-animate-float text-primary" style="font-size: 2rem;"></i>
    <i class="bi bi-balloon-fill position-absolute tffp-deco-2 tffp-animate-float text-warning" style="font-size: 2.5rem;"></i>
    <i class="bi bi-stars position-absolute tffp-deco-3 tffp-animate-float text-secondary" style="font-size: 1.75rem;"></i>
    <i class="bi bi-stars position-absolute tffp-deco-4 tffp-animate-float text-warning" style="font-size: 1.5rem;"></i>
  </div>

  <div class="container py-5 position-relative" style="z-index: 1;">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9 text-center">
        <h1 class="display-3 fw-bold mb-4" style="letter-spacing: -0.02em;">
          Welkom bij <span class="text-primary">The Funky Face Painter</span>
        </h1>

        <p class="fs-4 text-body-secondary mb-4" style="line-height: 1.6;">
          Dé specialist in professionele gezichtsschmink, glittertattoos en creatieve face art voor kinderfeestjes,
          festivals en evenementen
        </p>

        <div class="mx-auto" style="max-width: 52rem;">
          <p class="fs-5 text-body-secondary mb-4" style="line-height: 1.8;">
            Van vrolijke unicorns en stoere tijgers tot stijlvolle glitter designs en mini face art: wij zorgen voor kleur,
            fun en een ervaring die kinderen én volwassenen niet vergeten. We werken uitsluitend met
            <strong class="text-primary"> kindveilige, huidvriendelijke schmink</strong>
            en zorgen altijd voor een ontspannen, hygiënische en professionele setting.
          </p>

          <p class="fs-5 text-body-secondary mb-0" style="line-height: 1.8;">
            Of het nu gaat om een kinderfeestje thuis, een festival, bedrijfsfeest of winkelopening:
            <strong class="text-secondary"> The Funky Face Painter</strong> maakt elk moment bijzonder.
          </p>
        </div>

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
</section>
