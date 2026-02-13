<?php
/**
 * Title: About — Portrait Bio
 * Slug: carlashub/about-portrait
 * Categories: carlashub-page-about
 * Keywords: about, portrait
 */
?>
<!-- wp:columns {"className":"about-portrait section section--secondary section--asym is-style-editorial-wide"} -->
<div class="wp-block-columns about-portrait section section--secondary section--asym is-style-editorial-wide">
  <!-- wp:column {"width":"45%"} -->
  <div class="wp-block-column" style="flex-basis:45%">
    <!-- wp:group {"className":"is-style-frame"} -->
    <div class="wp-block-group is-style-frame">
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
      <figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-portrait.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:column -->

  <!-- wp:column {"width":"55%"} -->
  <div class="wp-block-column" style="flex-basis:55%">
    <!-- wp:paragraph {"className":"eyebrow"} -->
    <p class="eyebrow">I am Elyse</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":2} -->
    <h2>Designer, strategist, ritual keeper.</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph -->
    <p>With a background in editorial design and digital systems, I craft sites that feel like private libraries: layered, intentional, and ready to be explored.</p>
    <!-- /wp:paragraph -->
    <!-- wp:buttons -->
    <div class="wp-block-buttons">
      <!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link">More about me</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->
