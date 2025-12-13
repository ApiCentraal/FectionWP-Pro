<?php
/**
 * Template Name: Welcome Page
 * A simple welcome/landing page template for site administrators to use.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="site-content" role="main" style="padding:3rem 1rem; max-width:1100px; margin:0 auto;">
  <header style="text-align:center; margin-bottom:2rem;">
    <h1 style="font-size:2.2rem; margin:0.2rem 0;">Welcome to FectionWP Pro</h1>
    <p style="color:#555; margin:0.5rem 0 1rem;">A modern, modular WordPress theme built with Bootstrap and powerful blocks.</p>
    <p style="margin:0; font-size:0.95rem"><strong>Version:</strong> 1.0.0 — <strong>Text Domain:</strong> fectionwp-pro</p>
  </header>

  <section style="display:grid; grid-template-columns:1fr; gap:1.25rem;">
    <article style="background:#fff; border:1px solid #eee; padding:1.25rem; border-radius:6px;">
      <h2>Quick Start</h2>
      <ul>
        <li>Activate the theme via <em>Appearance → Themes</em>.</li>
        <li>Create a new page and assign the <strong>Welcome Page</strong> template.</li>
        <li>Install and activate the recommended plugins: <em>FectionWP-Booking</em>, <em>FectionWP-Visual-Builder</em>, <em>FectionWP-Blocks</em>.</li>
        <li>Import starter content or use the Visual Builder to craft your pages quickly.</li>
      </ul>
    </article>

    <article style="background:#fff; border:1px solid #eee; padding:1.25rem; border-radius:6px;">
      <h2>Theme Features</h2>
      <ul>
        <li>Responsive layout powered by Bootstrap 5.3.</li>
        <li>Gutenberg block collection and modular template parts in <code>template-parts/</code>.</li>
        <li>WooCommerce ready and accessibility-conscious markup.</li>
        <li>Theme checks and code standards enforced via CI (PHPCS + WPCS + Theme Check).</li>
      </ul>
    </article>

    <article style="background:#fff; border:1px solid #eee; padding:1.25rem; border-radius:6px;">
      <h2>Recommended Plugins</h2>
      <p>For full functionality please install the following plugins:</p>
      <ol>
        <li>FectionWP-Booking — booking integration and calendars.</li>
        <li>FectionWP-Visual-Builder — visual page builder used by templates.</li>
        <li>FectionWP-Blocks — extra Gutenberg blocks used across the theme.</li>
      </ol>
    </article>

    <article style="background:#fff; border:1px solid #eee; padding:1.25rem; border-radius:6px;">
      <h2>Need Help?</h2>
      <p>If you need support or documentation, see the theme <a href="https://github.com/ApiCentraal/FectionWP-Pro#readme" target="_blank" rel="noopener">README</a> or contact FectionLabs.</p>
    </article>
  </section>

</main>

<?php
get_footer();
