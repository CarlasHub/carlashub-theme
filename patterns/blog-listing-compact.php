<?php
/**
 * Title: Blog — Listing Compact
 * Slug: carlashub/blog-listing-compact
 * Categories: carlashub-page-blog, carlashub-layout
 * Keywords: blog, listing
 */
?>
<!-- wp:group {"className":"section section--secondary is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--secondary is-style-editorial-wide">
  <!-- wp:query {"query":{"perPage":6,"postType":"post","order":"desc","orderBy":"date"}} -->
  <div class="wp-block-query">
    <!-- wp:post-template {"className":"post-cards post-cards--compact"} -->
      <!-- wp:columns {"className":"card card--compact"} -->
      <div class="wp-block-columns card card--compact">
        <!-- wp:column {"width":"30%"} -->
        <div class="wp-block-column" style="flex-basis:30%">
          <!-- wp:post-featured-image {"isLink":true,"sizeSlug":"medium"} /-->
        </div>
        <!-- /wp:column -->
        <!-- wp:column {"width":"70%"} -->
        <div class="wp-block-column" style="flex-basis:70%">
          <!-- wp:post-title {"isLink":true} /-->
          <!-- wp:template-part {"slug":"post-meta"} /-->
          <!-- wp:post-excerpt {"moreText":"View more →"} /-->
        </div>
        <!-- /wp:column -->
      </div>
      <!-- /wp:columns -->
    <!-- /wp:post-template -->

    <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
      <!-- wp:query-pagination-previous /-->
      <!-- wp:query-pagination-numbers /-->
      <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->
