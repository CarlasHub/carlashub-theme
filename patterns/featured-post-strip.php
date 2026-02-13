<?php
/**
 * Title: Blog — Featured Post Strip
 * Slug: carlashub/featured-post-strip
 * Categories: carlashub-page-blog, carlashub-layout
 * Keywords: featured, post
 */
?>
<!-- wp:group {"className":"featured-post-strip section section--dominant section--asym is-style-editorial-full","layout":{"type":"constrained"}} -->
<div class="wp-block-group featured-post-strip section section--dominant section--asym is-style-editorial-full">
  <!-- wp:heading {"level":2} -->
  <h2>Featured Story</h2>
  <!-- /wp:heading -->
  <!-- wp:query {"query":{"perPage":1,"postType":"post","order":"desc","orderBy":"date"}} -->
  <div class="wp-block-query">
    <!-- wp:post-template -->
      <!-- wp:columns {"className":"featured-post"} -->
      <div class="wp-block-columns featured-post">
        <!-- wp:column {"width":"45%"} -->
        <div class="wp-block-column" style="flex-basis:45%">
          <!-- wp:post-featured-image {"isLink":true,"sizeSlug":"large"} /-->
        </div>
        <!-- /wp:column -->
        <!-- wp:column {"width":"55%"} -->
        <div class="wp-block-column" style="flex-basis:55%">
          <!-- wp:group {"className":"card"} -->
          <div class="wp-block-group card">
            <!-- wp:post-title {"isLink":true} /-->
            <!-- wp:group {"className":"post-meta","layout":{"type":"flex","justifyContent":"left"}} -->
            <div class="wp-block-group post-meta">
              <!-- wp:post-date /-->
              <!-- wp:paragraph --><p>·</p><!-- /wp:paragraph -->
              <!-- wp:post-terms {"term":"category"} /-->
            </div>
            <!-- /wp:group -->
            <!-- wp:post-excerpt {"moreText":"Read the story"} /-->
            <!-- wp:buttons -->
            <div class="wp-block-buttons">
              <!-- wp:button -->
              <div class="wp-block-button"><a class="wp-block-button__link">Read more</a></div>
              <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
      </div>
      <!-- /wp:columns -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->
