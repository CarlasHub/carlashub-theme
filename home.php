<?php
/**
 * Blog index template.
 *
 * @package CarlasHub_V2
 */

get_header();

$metrics       = carlashub_v2_get_site_metrics();
$archive_posts = get_posts(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<header class="panel archive-header">
			<p class="eyebrow"><?php esc_html_e( 'Journal', 'carlashub-v2' ); ?></p>
			<h1><?php single_post_title(); ?></h1>
			<p class="section-intro"><?php esc_html_e( 'Latest posts, notes, and project write-ups.', 'carlashub-v2' ); ?></p>
			<div class="meta-row">
				<span class="meta-pill"><strong><?php echo esc_html( number_format_i18n( $metrics['posts'] ) ); ?></strong>&nbsp;<?php esc_html_e( 'Articles', 'carlashub-v2' ); ?></span>
				<span class="meta-pill"><strong><?php echo esc_html( number_format_i18n( $metrics['categories'] ) ); ?></strong>&nbsp;<?php esc_html_e( 'Topics', 'carlashub-v2' ); ?></span>
			</div>
		</header>

		<div class="listing-layout section-block">
			<div>
				<?php if ( $archive_posts ) : ?>
					<div id="blog-posts-grid" class="listing-grid js-load-more-grid" data-load-more-initial="4" data-load-more-step="4">
						<?php foreach ( $archive_posts as $archive_post ) : ?>
							<?php echo carlashub_v2_render_entry_card( $archive_post, 'listing' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endforeach; ?>
					</div>
					<?php if ( count( $archive_posts ) > 4 ) : ?>
						<div class="hero-actions wp-block-query-load-more">
							<button class="button js-load-more-button" type="button" data-load-more-target="blog-posts-grid">
								<?php esc_html_e( 'Load more posts', 'carlashub-v2' ); ?>
							</button>
							<span class="screen-reader-text js-load-more-status" aria-live="polite"></span>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<div class="empty-state">
						<h2><?php esc_html_e( 'No posts yet.', 'carlashub-v2' ); ?></h2>
						<p><?php esc_html_e( 'There is nothing in the archive yet.', 'carlashub-v2' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();
