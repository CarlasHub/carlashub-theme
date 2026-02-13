<?php
/**
 * Title: Services — Circular Card Grid
 * Slug: carlashub/services-circular
 * Categories: carlashub-page-home, carlashub-page-about, carlashub-layout
 * Keywords: services, cards
 */
?>
<!-- wp:group {"className":"services section section--dense is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group services section section--dense is-style-editorial-wide">
  <!-- wp:heading {"level":2} -->
  <h2>Services</h2>
  <!-- /wp:heading -->
  <!-- wp:columns {"className":"services__grid"} -->
  <div class="wp-block-columns services__grid">
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:group {"className":"card"} -->
      <div class="wp-block-group card">
        <!-- wp:image {"sizeSlug":"medium","linkDestination":"none","className":"is-style-ornament"} -->
        <figure class="wp-block-image size-medium is-style-ornament"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
        <!-- /wp:image -->
        <!-- wp:heading {"level":3} -->
        <h3>Editorial Design</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p>Layouts, typography, and content systems with cinematic structure.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:group {"className":"card"} -->
      <div class="wp-block-group card">
        <!-- wp:image {"sizeSlug":"medium","linkDestination":"none","className":"is-style-ornament"} -->
        <figure class="wp-block-image size-medium is-style-ornament"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
        <!-- /wp:image -->
        <!-- wp:heading {"level":3} -->
        <h3>Brand Strategy</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p>Positioning, messaging, and visual direction for modern studios.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:group {"className":"card"} -->
      <div class="wp-block-group card">
        <!-- wp:image {"sizeSlug":"medium","linkDestination":"none","className":"is-style-ornament"} -->
        <figure class="wp-block-image size-medium is-style-ornament"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
        <!-- /wp:image -->
        <!-- wp:heading {"level":3} -->
        <h3>Theme Development</h3>
        <!-- /wp:heading -->
        <!-- wp:paragraph -->
        <p>Block theme builds with reusable patterns and guided editing.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
