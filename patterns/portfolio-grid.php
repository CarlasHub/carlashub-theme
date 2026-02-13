<?php
/**
 * Title: Portfolio — Grid
 * Slug: carlashub/portfolio-grid
 * Categories: carlashub-page-portfolio, carlashub-layout
 * Keywords: portfolio, grid
 */
?>
<!-- wp:group {"className":"portfolio section section--secondary is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group portfolio section section--secondary is-style-editorial-wide">
  <!-- wp:heading {"level":2} -->
  <h2>Portfolio</h2>
  <!-- /wp:heading -->
  <!-- wp:columns {"className":"portfolio__grid"} -->
  <div class="wp-block-columns portfolio__grid">
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"card__media"} -->
      <figure class="wp-block-image size-large card__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
      <!-- wp:heading {"level":3} -->
      <h3>Midnight Atelier</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Identity, editorial, web build.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"card__media"} -->
      <figure class="wp-block-image size-large card__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
      <!-- wp:heading {"level":3} -->
      <h3>Obsidian Studio</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Website system, strategy.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"card__media"} -->
      <figure class="wp-block-image size-large card__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
      <!-- wp:heading {"level":3} -->
      <h3>Velvet Archive</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p>Brand storytelling, copy.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
