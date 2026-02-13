<?php
/**
 * Title: Portfolio — Featured Project
 * Slug: carlashub/featured-project
 * Categories: carlashub-page-portfolio
 * Keywords: featured, project
 */
?>
<!-- wp:columns {"className":"featured-project section section--dominant section--asym is-style-editorial-full"} -->
<div class="wp-block-columns featured-project section section--dominant section--asym is-style-editorial-full">
  <!-- wp:column {"width":"60%"} -->
  <div class="wp-block-column" style="flex-basis:60%">
    <!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-hero.svg' ) ); ?>" alt=""/></figure>
    <!-- /wp:image -->
  </div>
  <!-- /wp:column -->
  <!-- wp:column {"width":"40%"} -->
  <div class="wp-block-column" style="flex-basis:40%">
    <!-- wp:paragraph {"className":"eyebrow"} -->
    <p class="eyebrow">Featured project</p>
    <!-- /wp:paragraph -->
    <!-- wp:heading {"level":2} -->
    <h2>Ritual House</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph -->
    <p>An immersive editorial site that blends commerce with quiet narrative.</p>
    <!-- /wp:paragraph -->
    <!-- wp:list -->
    <ul><li>Block theme + pattern library</li><li>Copy framework and content system</li><li>Accessibility audit and refinements</li></ul>
    <!-- /wp:list -->
    <!-- wp:buttons -->
    <div class="wp-block-buttons">
      <!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link">View case study</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->
