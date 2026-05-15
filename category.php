<?php
/**
 * Category archive template.
 *
 * @package CarlasHub_V2
 */

get_header();
$category_count = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<header class="panel archive-header">
			<p class="eyebrow"><?php esc_html_e( 'Category', 'carlashub-v2' ); ?></p>
			<h1><?php single_cat_title(); ?></h1>
			<div class="section-intro">
				<?php
				$description = category_description();
				if ( $description ) {
					echo wp_kses_post( wpautop( $description ) );
				} else {
					echo '<p>' . esc_html( carlashub_v2_get_archive_support_text() ) . '</p>';
				}
				?>
			</div>
			<div class="meta-row">
				<span class="meta-pill"><strong><?php echo esc_html( number_format_i18n( $category_count ) ); ?></strong>&nbsp;<?php esc_html_e( 'Posts', 'carlashub-v2' ); ?></span>
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
						<h2><?php esc_html_e( 'No posts in this category yet.', 'carlashub-v2' ); ?></h2>
						<p><?php esc_html_e( 'There is nothing in this category yet.', 'carlashub-v2' ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();
