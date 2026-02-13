<?php
/**
 * Title: About — Hero Split Framed
 * Slug: carlashub/hero-split-framed
 * Categories: carlashub-hero, carlashub-page-about
 * Keywords: hero, split
 */
?>
<!-- wp:columns {"className":"hero hero--split section section--dominant section--asym is-style-editorial-full"} -->
<div class="wp-block-columns hero hero--split section section--dominant section--asym is-style-editorial-full">
  <!-- wp:column {"width":"55%"} -->
  <div class="wp-block-column" style="flex-basis:55%">
    <!-- wp:paragraph {"className":"eyebrow"} -->
    <p class="eyebrow">Cinematic, modern, deliberate</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":1} -->
    <h1>Editorial clarity with a mystical edge.</h1>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"fontSize":"lg"} -->
    <p class="has-lg-font-size">A system of patterns, typography, and blocks designed for confident storytelling.</p>
    <!-- /wp:paragraph -->
    <!-- wp:buttons -->
    <div class="wp-block-buttons">
      <!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link">Explore services</a></div>
      <!-- /wp:button -->
      <!-- wp:button {"className":"is-style-ghost"} -->
      <div class="wp-block-button is-style-ghost"><a class="wp-block-button__link">See the portfolio</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:column -->

  <!-- wp:column {"width":"45%"} -->
  <div class="wp-block-column" style="flex-basis:45%">
    <!-- wp:group {"className":"is-style-frame"} -->
    <div class="wp-block-group is-style-frame">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"hero__image"} -->
      <figure class="wp-block-image size-large hero__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-portrait.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->
