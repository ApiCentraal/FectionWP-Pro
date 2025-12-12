<?php
/**
 * Template Name: Sections Layout
 * Template Post Type: page
 * 
 * Template met gradient hero en ruimte voor sectie shortcodes.
 * Ideaal voor service pagina's en about pages.
 * 
 * De hero toont automatisch de paginatitel en excerpt.
 * Voeg secties toe via shortcodes in de content editor.
 * 
 * @package FectionWP_Pro
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('sections-layout'); ?>>
        
        <?php if (has_post_thumbnail()) : ?>
        <!-- Hero met Featured Image -->
        <section class="section-hero position-relative">
            <div class="hero-bg">
                <?php the_post_thumbnail('full', array(
                    'class' => 'w-100 object-fit-cover',
                    'style' => 'height: 60vh; min-height: 400px;'
                )); ?>
            </div>
            <div class="hero-content position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                 style="background: linear-gradient(135deg, rgba(13,110,253,0.9) 0%, rgba(102,16,242,0.8) 100%);">
                <div class="container text-center text-white">
                    <h1 class="display-2 fw-bold mb-4"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <p class="lead fs-4 mb-4"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php else : ?>
        <!-- Gradient Hero -->
        <section class="section-hero py-5" style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
            <div class="container text-center text-white py-5">
                <h1 class="display-2 fw-bold mb-4"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="lead fs-4 mb-0"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- Main Content -->
        <div class="entry-content sections-content">
            <?php the_content(); ?>
        </div>
        
        <?php
        wp_link_pages(array(
            'before' => '<nav class="page-links container py-4">' . __('Pagina\'s:', 'fectionwp-pro'),
            'after'  => '</nav>',
        ));
        ?>
    </article>
    
<?php endwhile; ?>

<?php get_footer(); ?>
