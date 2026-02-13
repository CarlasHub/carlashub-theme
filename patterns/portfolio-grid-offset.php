<?php
/**
 * Title: Portfolio — Offset Grid
 * Slug: carlashub/portfolio-grid-offset
 * Categories: carlashub-page-portfolio, carlashub-layout
 * Keywords: portfolio, grid
 */
?>
<!-- wp:group {"className":"section section--secondary section--asym is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--secondary section--asym is-style-editorial-wide">
  <!-- wp:columns {"className":"portfolio__grid portfolio__grid--offset"} -->
  <div class="wp-block-columns portfolio__grid portfolio__grid--offset">
    <!-- wp:column {"width":"40%"} -->
    <div class="wp-block-column" style="flex-basis:40%">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"card__media"} -->
      <figure class="wp-block-image size-large card__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
      <!-- wp:heading {"level":3} --><h3>Ink Ritual</h3><!-- /wp:heading -->
      <!-- wp:paragraph --><p>Editorial identity, brand system.</p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"width":"60%"} -->
    <div class="wp-block-column" style="flex-basis:60%">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"card__media"} -->
      <figure class="wp-block-image size-large card__media"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-hero.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
      <!-- wp:heading {"level":3} --><h3>Midnight Atelier</h3><!-- /wp:heading -->
      <!-- wp:paragraph --><p>Website system, narrative structure.</p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
