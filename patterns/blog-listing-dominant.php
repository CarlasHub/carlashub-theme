<?php
/**
 * Title: Blog — Listing Dominant Lead
 * Slug: carlashub/blog-listing-dominant
 * Categories: carlashub-page-blog, carlashub-layout
 * Keywords: blog, listing
 */
?>
<!-- wp:group {"className":"section section--dominant is-style-editorial-full","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--dominant is-style-editorial-full">
  <!-- wp:query {"query":{"perPage":8,"postType":"post","order":"desc","orderBy":"date"}} -->
  <div class="wp-block-query">
    <!-- wp:post-template {"className":"post-cards post-cards--dominant is-style-cards"} -->
      <!-- wp:group {"className":"card"} -->
      <div class="wp-block-group card">
        <!-- wp:post-featured-image {"isLink":true,"sizeSlug":"large"} /-->
        <!-- wp:group {"className":"card__body","layout":{"type":"constrained"}} -->
        <div class="wp-block-group card__body">
          <!-- wp:post-title {"isLink":true} /-->
          <!-- wp:template-part {"slug":"post-meta"} /-->
          <!-- wp:post-excerpt {"moreText":"Read the essay"} /-->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->
    <!-- /wp:post-template -->

    <!-- wp:group {"className":"is-style-editorial-wide"} -->
    <div class="wp-block-group is-style-editorial-wide">
      <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"space-between"}} -->
        <!-- wp:query-pagination-previous /-->
        <!-- wp:query-pagination-numbers /-->
        <!-- wp:query-pagination-next /-->
      <!-- /wp:query-pagination -->
    </div>
    <!-- /wp:group -->

    <!-- wp:query-no-results -->
    <div class="wp-block-query-no-results">
      <!-- wp:heading {"level":3} --><h3>No posts found.</h3><!-- /wp:heading -->
      <!-- wp:paragraph --><p>Publish your first post to populate the journal.</p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:query-no-results -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->
