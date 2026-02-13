<?php
/**
 * Title: Hero Centered
 * Slug: carlashub/hero-centered
 * Categories: carlashub-hero
 * Keywords: hero, intro
 */
?>
<!-- wp:group {"className":"hero hero--centered","layout":{"type":"constrained"}} -->
<div class="wp-block-group hero hero--centered">
  <!-- wp:paragraph {"className":"eyebrow"} -->
  <p class="eyebrow">Mystic strategy for modern brands</p>
  <!-- /wp:paragraph -->
  <!-- wp:heading {"level":1} -->
  <h1>Awaken your digital presence.</h1>
  <!-- /wp:heading -->
  <!-- wp:paragraph {"fontSize":"lg"} -->
  <p class="has-lg-font-size">CarlasHub blends editorial craft, ritual clarity, and systems thinking to build sites that feel alive.</p>
  <!-- /wp:paragraph -->
  <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
  <div class="wp-block-buttons">
    <!-- wp:button -->
    <div class="wp-block-button"><a class="wp-block-button__link">Begin the journey</a></div>
    <!-- /wp:button -->
    <!-- wp:button {"className":"is-style-ghost"} -->
    <div class="wp-block-button is-style-ghost"><a class="wp-block-button__link">View the portfolio</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
  <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"hero__image"} -->
  <figure class="wp-block-image size-large hero__image"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-hero.svg' ) ); ?>" alt=""/></figure>
  <!-- /wp:image -->
</div>
<!-- /wp:group -->
