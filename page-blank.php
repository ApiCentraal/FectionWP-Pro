<?php
/**
 * Template Name: Blank Canvas
 * Template Post Type: page
 * 
 * Volledig lege template zonder header en footer.
 * Ideaal voor custom landing pages of embedded content.
 * 
 * Let op: Bootstrap CSS en JS worden nog steeds geladen.
 * 
 * @package FectionWP_Pro
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('blank-canvas'); ?>>
<?php wp_body_open(); ?>

<?php while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>
    
<?php endwhile; ?>

<?php wp_footer(); ?>
</body>
</html>
