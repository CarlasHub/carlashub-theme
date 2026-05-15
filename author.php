<?php
/**
 * Author archive template.
 *
 * @package CarlasHub_V2
 */

get_header();

$author = get_queried_object();
$author_count = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<header class="panel archive-header">
			<p class="eyebrow"><?php esc_html_e( 'Author', 'carlashub-v2' ); ?></p>
			<h1><?php echo esc_html( $author ? $author->display_name : get_the_author() ); ?></h1>
			<p class="section-intro"><?php echo esc_html( carlashub_v2_get_archive_support_text() ); ?></p>
			<div class="meta-row">
				<span class="meta-pill"><strong><?php echo esc_html( number_format_i18n( $author_count ) ); ?></strong>&nbsp;<?php esc_html_e( 'Posts', 'carlashub-v2' ); ?></span>
			</div>
		</header>

		<?php if ( $author ) : ?>
			<?php echo carlashub_v2_get_author_box_markup( $author->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>

		<div class="listing-layout section-block">
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
						<h2><?php esc_html_e( 'No posts from this author yet.', 'carlashub-v2' ); ?></h2>
						<p><?php esc_html_e( 'Nothing from this author has been published yet.', 'carlashub-v2' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();
