<?php
/**
 * Title: Hero Split
 * Slug: carlashub/hero-split
 * Categories: carlashub-hero
 * Keywords: hero, split
 */
?>
<!-- wp:columns {"className":"hero hero--split"} -->
<div class="wp-block-columns hero hero--split">
  <!-- wp:column {"width":"55%"} -->
  <div class="wp-block-column" style="flex-basis:55%">
    <!-- wp:paragraph {"className":"eyebrow"} -->
    <p class="eyebrow">Studio of dark editorial craft</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":1} -->
    <h1>Design systems with a ceremonial edge.</h1>
    <!-- /wp:heading -->
    <!-- wp:paragraph {"fontSize":"lg"} -->
    <p class="has-lg-font-size">We build block themes, style systems, and immersive experiences that feel like heirlooms.</p>
    <!-- /wp:paragraph -->
    <!-- wp:buttons -->
    <div class="wp-block-buttons">
      <!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link">Book a consult</a></div>
      <!-- /wp:button -->
    <!-- wp:button {"className":"is-style-ghost"} -->
    <div class="wp-block-button is-style-ghost"><a class="wp-block-button__link">Browse services</a></div>
    <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:column -->

  <!-- wp:column {"width":"45%"} -->
  <div class="wp-block-column" style="flex-basis:45%">
    <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"hero__image"} -->
    <figure class="wp-block-image size-large hero__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-portrait.svg' ) ); ?>" alt=""/></figure>
    <!-- /wp:image -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->
