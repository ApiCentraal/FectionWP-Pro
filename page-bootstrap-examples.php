<?php
/**
 * Template Name: Bootstrap Examples Index
 * Description: Selecteer en bekijk alle Bootstrap 5.3 examples binnen FectionWP Pro.
 * Gebruik ?example=slug om een specifieke example te tonen.
 *
 * @package FectionWP_Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$fwp_examples = array(
    'starter'               => array( 'label' => 'Starter Template',       'description' => 'Minimale basis met navbar en grid.' ),
    'grid'                  => array( 'label' => 'Grid',                   'description' => 'Layout demo voor kolommen en gutters.' ),
    'album'                 => array( 'label' => 'Album',                  'description' => 'Portfolio/kaartgrid met cards.' ),
    'pricing'               => array( 'label' => 'Pricing',                'description' => 'Prijstabellen met CTA.' ),
    'checkout'              => array( 'label' => 'Checkout',               'description' => 'Formulier-gedreven checkout flow.' ),
    'product'               => array( 'label' => 'Product',                'description' => 'Product detail + features.' ),
    'cover'                 => array( 'label' => 'Cover',                  'description' => 'Volledige hero cover met CTA.' ),
    'carousel'              => array( 'label' => 'Carousel',               'description' => 'Afbeeldingen/carousel met captions.' ),
    'blog'                  => array( 'label' => 'Blog',                   'description' => 'Magazine/blog landingspagina.' ),
    'dashboard'             => array( 'label' => 'Dashboard',              'description' => 'Admin dashboard met sidebar + cards.' ),
    'dashboard-rtl'         => array( 'label' => 'Dashboard RTL',          'description' => 'RTL-variant van dashboard.' ),
    'sign-in'               => array( 'label' => 'Sign-in',                'description' => 'Aanmeldformulier midden op de pagina.' ),
    'sticky-footer'         => array( 'label' => 'Sticky Footer',          'description' => 'Footer die onderaan blijft.' ),
    'sticky-footer-navbar'  => array( 'label' => 'Sticky Footer + Navbar', 'description' => 'Sticky footer met top navbar.' ),
    'navbar'                => array( 'label' => 'Navbar',                 'description' => 'Responsive navbar variaties.' ),
    'offcanvas'             => array( 'label' => 'Offcanvas Navbar',       'description' => 'Offcanvas navigatie voor mobiel.' ),
    'sidebars'              => array( 'label' => 'Sidebars',               'description' => 'Flexibele zijbalk layouts.' ),
    'headers'               => array( 'label' => 'Headers',                'description' => 'Diverse header layouts.' ),
    'footers'               => array( 'label' => 'Footers',                'description' => 'Footer variaties.' ),
    'heroes'                => array( 'label' => 'Heroes',                 'description' => 'Hero secties met CTA en visuals.' ),
    'features'              => array( 'label' => 'Features',               'description' => 'Feature grids en icon blocks.' ),
);

$selected_slug = isset( $_GET['example'] ) ? sanitize_key( wp_unslash( $_GET['example'] ) ) : '';
if ( $selected_slug && ! isset( $fwp_examples[ $selected_slug ] ) ) {
    $selected_slug = '';
}

get_header( $selected_slug === 'cover' ? 'landing' : null );
?>

<main class="bootstrap-examples py-5">
    <div class="container">
        <?php if ( ! $selected_slug ) : ?>
            <div class="text-center mb-5">
                <p class="text-uppercase fw-semibold small mb-2">Bootstrap 5.3 Examples</p>
                <h1 class="display-5 fw-bold mb-3">Kies een voorbeeld</h1>
                <p class="lead text-muted mb-0">Selecteer een example om het live te bekijken. Gebruik de knoppen hieronder.</p>
            </div>

            <div class="row g-3 example-index">
                <?php foreach ( $fwp_examples as $slug => $data ) : ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <h3 class="h5 fw-semibold mb-2"><?php echo esc_html( $data['label'] ); ?></h3>
                                <p class="text-muted small mb-4 flex-grow-1"><?php echo esc_html( $data['description'] ); ?></p>
                                <a class="btn btn-outline-primary stretched-link mt-auto" href="<?php echo esc_url( add_query_arg( 'example', $slug ) ); ?>">Bekijk</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <p class="text-uppercase fw-semibold small mb-1">Bootstrap 5.3</p>
                    <h1 class="h3 fw-bold mb-0"><?php echo esc_html( $fwp_examples[ $selected_slug ]['label'] ); ?></h1>
                    <p class="text-muted mb-0"><?php echo esc_html( $fwp_examples[ $selected_slug ]['description'] ); ?></p>
                </div>
                <a class="btn btn-outline-secondary" href="<?php echo esc_url( remove_query_arg( 'example' ) ); ?>">← Terug naar overzicht</a>
            </div>

            <div class="example-wrapper">
                <?php
                $template_path = locate_template( 'template-parts/examples/example-' . $selected_slug . '.php', false, false );
                if ( $template_path ) {
                    load_template( $template_path, true );
                } else {
                    echo '<div class="alert alert-warning">Example niet gevonden.</div>';
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
