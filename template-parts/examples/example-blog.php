<?php
/**
 * Example: Blog
 * 
 * Available $atts from Visual Builder:
 * - about_title: Sidebar about title
 * - about_text: Sidebar about text
 * - posts: Number of posts to display
 * - show_sidebar: Show sidebar (yes/no)
 */
$about_title  = isset( $atts['about_title'] ) ? $atts['about_title'] : 'About';
$about_text   = isset( $atts['about_text'] ) ? $atts['about_text'] : 'Korte tekst over het blog of de auteur.';
$posts        = isset( $atts['posts'] ) ? intval( $atts['posts'] ) : 3;
$show_sidebar = ! isset( $atts['show_sidebar'] ) || $atts['show_sidebar'] !== 'no';

$main_col = $show_sidebar ? 'col-md-8' : 'col-12';
?>
<section class="example-blog">
    <div class="row g-5">
        <div class="<?php echo esc_attr( $main_col ); ?>">
            <?php for ( $i = 1; $i <= $posts; $i++ ) : ?>
            <article class="mb-4 pb-4 border-bottom">
                <h2 class="h4 fw-bold"><a class="link-body-emphasis text-decoration-none" href="#">Blogpost titel <?php echo $i; ?></a></h2>
                <p class="text-muted small mb-2">12 dec 2025 · 5 min</p>
                <p class="mb-2">Korte intro van de blogpost. Vervang dit door echte content.</p>
                <a href="#" class="link-primary">Lees meer →</a>
            </article>
            <?php endfor; ?>
        </div>
        <?php if ( $show_sidebar ) : ?>
        <div class="col-md-4">
            <div class="p-3 mb-4 bg-body-tertiary rounded">
                <h4 class="fw-semibold"><?php echo esc_html( $about_title ); ?></h4>
                <p class="mb-0"><?php echo esc_html( $about_text ); ?></p>
            </div>
            <div class="p-3">
                <h4 class="fw-semibold">Categorieën</h4>
                <ol class="list-unstyled mb-0">
                    <li><a href="#">Tech</a></li>
                    <li><a href="#">Design</a></li>
                    <li><a href="#">Nieuws</a></li>
                </ol>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
