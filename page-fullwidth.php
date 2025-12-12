<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 * 
 * Pagina template zonder sidebar, content in container
 * 
 * @package FectionWP_Pro
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
        
        <?php
        wp_link_pages(array(
            'before' => '<nav class="page-links container mt-4">' . __('Pagina\'s:', 'fectionwp-pro'),
            'after'  => '</nav>',
        ));
        ?>
    </article>
    
    <?php
    if (comments_open() || get_comments_number()) {
        echo '<div class="container">';
        comments_template();
        echo '</div>';
    }
    ?>
    
<?php endwhile; ?>

<?php get_footer(); ?>
