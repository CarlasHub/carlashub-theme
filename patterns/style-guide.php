<?php
/**
 * Title: Style Guide — System Overview
 * Slug: carlashub/style-guide
 * Categories: carlashub-page-style
 * Keywords: style guide
 */
?>
<!-- wp:group {"className":"section section--dominant section--ornament is-style-editorial-full","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--dominant section--ornament is-style-editorial-full">
  <!-- wp:paragraph {"className":"eyebrow"} -->
  <p class="eyebrow">Editorial System</p>
  <!-- /wp:paragraph -->
  <!-- wp:heading {"level":1} -->
  <h1>Clarity is the craft.</h1>
  <!-- /wp:heading -->
  <!-- wp:paragraph -->
  <p>Use this page as a living demonstration of hierarchy. The system is designed to guide attention: dominant headlines, measured body copy, and deliberate rhythm between dense and quiet sections.</p>
  <!-- /wp:paragraph -->
  <!-- wp:paragraph -->
  <p>This is the long‑form body example. It should feel calm, measured, and editorial—never rushed. The line length remains narrow enough for focus, while the section itself remains dominant through spacing and ornament.</p>
  <!-- /wp:paragraph -->
  <!-- wp:paragraph -->
  <p>Hierarchy ladder in context:</p>
  <!-- /wp:paragraph -->
  <!-- wp:heading {"level":2} -->
  <h2>Heading Two</h2>
  <!-- /wp:heading -->
  <!-- wp:heading {"level":3} -->
  <h3>Heading Three</h3>
  <!-- /wp:heading -->
  <!-- wp:heading {"level":4} -->
  <h4>Heading Four</h4>
  <!-- /wp:heading -->
  <!-- wp:heading {"level":5} -->
  <h5>Heading Five</h5>
  <!-- /wp:heading -->
  <!-- wp:heading {"level":6} -->
  <h6>Heading Six</h6>
  <!-- /wp:heading -->
  <!-- wp:paragraph {"fontSize":"sm"} -->
  <p class="has-sm-font-size">Small text for metadata and subtle captions. <a href="#">Example link</a>.</p>
  <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"section section--dense is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--dense is-style-editorial-wide">
  <!-- wp:columns {"className":"content-split content-split--left"} -->
  <div class="wp-block-columns content-split content-split--left">
    <!-- wp:column {"width":"60%"} -->
    <div class="wp-block-column" style="flex-basis:60%">
      <!-- wp:heading {"level":2} --><h2>Dense vs breath</h2><!-- /wp:heading -->
      <!-- wp:paragraph --><p>This section is intentionally compact. Use it for sequences of information where the reader expects pace.</p><!-- /wp:paragraph -->
      <!-- wp:list --><ul><li>Strong H2 presence</li><li>Body text at readable line length</li><li>Lists support scanning</li></ul><!-- /wp:list -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"width":"40%"} -->
    <div class="wp-block-column" style="flex-basis:40%">
      <!-- wp:separator {"className":"is-style-sigil"} /-->
      <!-- wp:paragraph --><p>Use ornaments to anchor transitions, not as decoration.</p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"section section--breath section--asym is-style-editorial-narrow","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--breath section--asym is-style-editorial-narrow">
  <!-- wp:columns {"className":"content-split content-split--right"} -->
  <div class="wp-block-columns content-split content-split--right">
    <!-- wp:column {"width":"35%"} -->
    <div class="wp-block-column" style="flex-basis:35%">
      <!-- wp:paragraph {"className":"eyebrow"} --><p class="eyebrow">Quiet emphasis</p><!-- /wp:paragraph -->
      <!-- wp:heading {"level":3} --><h3>Subhead</h3><!-- /wp:heading -->
      <!-- wp:paragraph --><p>Secondary copy recedes without disappearing.</p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"width":"65%"} -->
    <div class="wp-block-column" style="flex-basis:65%">
      <!-- wp:heading {"level":2} --><h2>Open space makes the message feel expensive.</h2><!-- /wp:heading -->
      <!-- wp:paragraph --><p>This section demonstrates space as narrative breath. Use it to punctuate transitions between dense blocks and dominant moments.</p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"section section--secondary is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--secondary is-style-editorial-wide">
  <!-- wp:heading {"level":2} --><h2>Interface moments</h2><!-- /wp:heading -->
  <!-- wp:paragraph --><p>Buttons and forms appear within narrative contexts, not as isolated specimens.</p><!-- /wp:paragraph -->
  <!-- wp:buttons -->
  <div class="wp-block-buttons">
    <!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">Primary</a></div><!-- /wp:button -->
    <!-- wp:button {"className":"is-style-ghost"} --><div class="wp-block-button is-style-ghost"><a class="wp-block-button__link">Ghost</a></div><!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
  <!-- wp:search {"label":"Search","showLabel":false,"buttonText":"Search","buttonUseIcon":true,"className":"is-style-field"} /-->
  <!-- wp:html -->
  <form class="sample-form">
    <label>Name<br/><input type="text" placeholder="Your name"></label><br/>
    <label>Email<br/><input type="email" placeholder="name@example.com"></label><br/>
    <label>Topic<br/>
      <select>
        <option>Strategy</option>
        <option>Design</option>
        <option>Theme Build</option>
      </select>
    </label><br/>
    <label>Message<br/><textarea rows="4" placeholder="Tell us about your project"></textarea></label><br/>
    <label><input type="checkbox"> Subscribe to updates</label><br/>
    <label><input type="radio" name="priority"> Standard</label>
    <label><input type="radio" name="priority"> Priority</label><br/>
    <button type="submit">Submit</button>
  </form>
  <!-- /wp:html -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"section section--secondary section--asym is-style-editorial-wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--secondary section--asym is-style-editorial-wide">
  <!-- wp:columns -->
  <div class="wp-block-columns">
    <!-- wp:column {"width":"55%"} -->
    <div class="wp-block-column" style="flex-basis:55%">
      <!-- wp:heading {"level":2} --><h2>Cards & surfaces</h2><!-- /wp:heading -->
      <!-- wp:group {"className":"card"} -->
      <div class="wp-block-group card">
        <!-- wp:heading {"level":3} --><h3>Sample Card</h3><!-- /wp:heading -->
        <!-- wp:paragraph --><p>Cards carry secondary narratives and must feel crafted, not default.</p><!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"width":"45%"} -->
    <div class="wp-block-column" style="flex-basis:45%">
      <!-- wp:heading {"level":3} --><h3>Images & frames</h3><!-- /wp:heading -->
      <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"is-style-frame"} -->
      <figure class="wp-block-image size-large is-style-frame"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-hero.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
      <!-- wp:image {"sizeSlug":"medium","linkDestination":"none","className":"is-style-ornament"} -->
      <figure class="wp-block-image size-medium is-style-ornament"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-square.svg' ) ); ?>" alt=""/></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"section section--secondary is-style-editorial-full","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--secondary is-style-editorial-full">
  <!-- wp:heading {"level":2} --><h2>Query Loop cards</h2><!-- /wp:heading -->
  <!-- wp:query {"query":{"perPage":3,"postType":"post","order":"desc","orderBy":"date"}} -->
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
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"section section--quiet is-style-editorial-narrow","layout":{"type":"constrained"}} -->
<div class="wp-block-group section section--quiet is-style-editorial-narrow">
  <!-- wp:heading {"level":2} --><h2>Utilities & guidance</h2><!-- /wp:heading -->
  <!-- wp:paragraph --><p>Use styles consistently to maintain editorial rhythm across templates.</p><!-- /wp:paragraph -->
  <!-- wp:table -->
  <figure class="wp-block-table"><table><thead><tr><th>Utility</th><th>Purpose</th></tr></thead><tbody>
    <tr><td><code>.is-style-ghost</code></td><td>Secondary button treatment</td></tr>
    <tr><td><code>.is-style-frame</code></td><td>Structural image frame</td></tr>
    <tr><td><code>.is-style-veil</code></td><td>Overlay for covers</td></tr>
    <tr><td><code>.is-style-ornament</code></td><td>Anchored circular imagery</td></tr>
    <tr><td><code>.is-style-sigil</code></td><td>Divider ornament</td></tr>
    <tr><td><code>.is-style-editorial</code></td><td>Quote emphasis</td></tr>
    <tr><td><code>.is-style-ruled</code></td><td>Table borders</td></tr>
    <tr><td><code>.is-style-arc</code></td><td>Navigation spacing + caps</td></tr>
    <tr><td><code>.is-style-field</code></td><td>Search input styling</td></tr>
    <tr><td><code>.is-style-cards</code></td><td>Query Loop cards</td></tr>
  </tbody></table></figure>
  <!-- /wp:table -->

  <!-- wp:heading {"level":3} --><h3>Do / Avoid</h3><!-- /wp:heading -->
  <!-- wp:columns -->
  <div class="wp-block-columns">
    <!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"card"} --><div class="wp-block-group card"><!-- wp:heading {"level":4} --><h4>Do</h4><!-- /wp:heading --><!-- wp:list --><ul><li>One dominant headline</li><li>Asymmetry for rhythm</li><li>Ornaments that divide</li></ul><!-- /wp:list --></div><!-- /wp:group --></div><!-- /wp:column -->
    <!-- wp:column --><div class="wp-block-column"><!-- wp:group {"className":"card section--quiet"} --><div class="wp-block-group card section--quiet"><!-- wp:heading {"level":4} --><h4>Avoid</h4><!-- /wp:heading --><!-- wp:list --><ul><li>Uniform vertical rhythm</li><li>All content centered</li><li>Decoration without structure</li></ul><!-- /wp:list --></div><!-- /wp:group --></div><!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
