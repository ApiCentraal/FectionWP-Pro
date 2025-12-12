<?php
/**
 * Template Name: Landing Page
 * Template Post Type: page
 * 
 * Landing page template met transparante header over hero.
 * Full-width secties en container-based componenten.
 * 
 * Gebruik in Classic Editor:
 * - [hero-centered] voor full-width hero
 * - [features] voor feature grid in container
 * - [cta-banner] voor full-width call-to-action
 * - [pricing-table] voor prijzen in container
 * - [testimonials] voor reviews
 * - [faq] voor veelgestelde vragen
 * 
 * @package FectionWP_Pro
 */

get_header('landing'); ?>

<?php while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class('landing-page'); ?>>
        
        <div class="landing-content">
            <?php the_content(); ?>
        </div>
        
    </article>
    
<?php endwhile; ?>

<?php get_footer('landing'); ?>
