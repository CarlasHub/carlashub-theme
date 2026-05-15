<?php
/**
 * Search results template.
 *
 * @package CarlasHub_V2
 */

get_header();
$result_count = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<header class="panel archive-header">
			<p class="eyebrow"><?php esc_html_e( 'Search', 'carlashub-v2' ); ?></p>
			<h1><?php printf( esc_html__( 'Results for “%s”', 'carlashub-v2' ), get_search_query() ); ?></h1>
			<p class="section-intro"><?php esc_html_e( 'Posts and pages that match your search.', 'carlashub-v2' ); ?></p>
			<div class="meta-row">
				<span class="meta-pill"><strong><?php echo esc_html( number_format_i18n( $result_count ) ); ?></strong>&nbsp;<?php esc_html_e( 'Matches', 'carlashub-v2' ); ?></span>
			</div>
		</header>

		<div class="listing-layout">
			<div>
				<?php if ( have_posts() ) : ?>
					<div class="listing-grid">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php echo carlashub_v2_render_entry_card( get_post(), 'listing' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endwhile; ?>
					</div>
					<?php the_posts_pagination(); ?>
				<?php else : ?>
					<div class="empty-state">
						<h2><?php esc_html_e( 'No results found', 'carlashub-v2' ); ?></h2>
						<p><?php esc_html_e( 'Try a different search or browse the writing archive instead.', 'carlashub-v2' ); ?></p>
						<?php get_search_form( array( 'aria_label' => __( 'Search again', 'carlashub-v2' ), 'show_label' => true ) ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();
