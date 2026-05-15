<?php
/**
 * Archive template.
 *
 * @package CarlasHub_V2
 */

get_header();

$description = get_the_archive_description();
if ( ! $description ) {
	$description = carlashub_v2_get_archive_support_text();
}
$archive_count = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<header class="panel archive-header">
			<p class="eyebrow"><?php esc_html_e( 'Archive', 'carlashub-v2' ); ?></p>
			<h1><?php the_archive_title(); ?></h1>
			<div class="section-intro"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
			<div class="meta-row">
				<span class="meta-pill"><strong><?php echo esc_html( number_format_i18n( $archive_count ) ); ?></strong>&nbsp;<?php esc_html_e( 'Results', 'carlashub-v2' ); ?></span>
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
						<h2><?php esc_html_e( 'No matching entries', 'carlashub-v2' ); ?></h2>
						<p><?php esc_html_e( 'There is nothing here yet.', 'carlashub-v2' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();
