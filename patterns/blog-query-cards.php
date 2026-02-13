<?php
/**
 * Title: Blog — Query Loop Cards
 * Slug: carlashub/blog-query-cards
 * Categories: carlashub-page-blog, carlashub-layout
 * Keywords: blog, query
 */
?>
<!-- wp:group {"className":"blog-query section section--secondary is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group blog-query section section--secondary is-style-editorial-wide">
  <!-- wp:heading {"level":2} -->
  <h2>From the journal</h2>
  <!-- /wp:heading -->
  <!-- wp:query {"query":{"perPage":3,"postType":"post","order":"desc","orderBy":"date"}} -->
  <div class="wp-block-query">
    <!-- wp:post-template {"className":"post-cards is-style-cards"} -->
      <!-- wp:group {"className":"card"} -->
      <div class="wp-block-group card">
        <!-- wp:post-featured-image {"isLink":true,"sizeSlug":"large"} /-->
        <!-- wp:group {"className":"card__body","layout":{"type":"constrained"}} -->
        <div class="wp-block-group card__body">
          <!-- wp:post-title {"isLink":true} /-->
          <!-- wp:group {"className":"post-meta","layout":{"type":"flex","justifyContent":"left"}} -->
          <div class="wp-block-group post-meta">
            <!-- wp:post-date /-->
            <!-- wp:paragraph -->
            <p>·</p>
            <!-- /wp:paragraph -->
            <!-- wp:post-terms {"term":"category"} /-->
          </div>
          <!-- /wp:group -->
          <!-- wp:post-excerpt {"moreText":"Read the essay"} /-->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->
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
