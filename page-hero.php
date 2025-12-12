<?php
/**
 * Template Name: Page with Hero
 * Template Post Type: page
 * 
 * Pagina met full-width hero header (uitgelichte afbeelding).
 * Content verschijnt in container onder de hero.
 * 
 * Tip: Stel een Uitgelichte Afbeelding in voor de hero background.
 * 
 * @package FectionWP_Pro
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('page-with-hero'); ?>>
        
        <?php if (has_post_thumbnail()) : ?>
        <!-- Full-width Hero met Featured Image -->
        <header class="hero-header position-relative overflow-hidden">
            <div class="hero-image">
                <?php the_post_thumbnail('full', array(
                    'class' => 'w-100 object-fit-cover',
                    'style' => 'min-height: 400px; max-height: 70vh;'
                )); ?>
            </div>
            <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" 
                 style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5));">
                <div class="container text-center text-white">
                    <h1 class="display-3 fw-bold mb-3"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <p class="lead mb-0"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <?php else : ?>
        <!-- Fallback: Gradient Hero -->
        <header class="hero-header bg-primary text-white py-5">
            <div class="container text-center py-5">
                <h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="lead mb-0"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
        </header>
        <?php endif; ?>
        
        <!-- Content in Container -->
        <div class="entry-content container py-5">
            <?php the_content(); ?>
        </div>
        
        <?php
        wp_link_pages(array(
            'before' => '<nav class="page-links container mb-4">' . __('Pagina\'s:', 'fectionwp-pro'),
            'after'  => '</nav>',
        ));
        ?>
    </article>
    
    <?php
    if (comments_open() || get_comments_number()) {
        echo '<div class="container pb-5">';
        comments_template();
        echo '</div>';
    }
    ?>
    
<?php endwhile; ?>

<?php get_footer(); ?>
