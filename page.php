<?php
/**
 * Page template.
 *
 * @package CarlasHub_V2
 */

get_header();
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php $page_excerpt = carlashub_v2_get_card_excerpt( get_post(), 34 ); ?>
			<article <?php post_class(); ?>>
				<header class="panel document__header">
					<p class="eyebrow"><?php esc_html_e( 'Page', 'carlashub-v2' ); ?></p>
					<p class="entry-card__path"><?php echo esc_html( carlashub_v2_get_entry_path_label( get_post() ) ); ?></p>
					<h1 class="document__title"><?php the_title(); ?></h1>
					<?php if ( $page_excerpt ) : ?>
						<p class="section-intro"><?php echo esc_html( $page_excerpt ); ?></p>
					<?php endif; ?>
				</header>

				<div class="document__layout">
					<div class="panel document__content entry-content entry-content--prose">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div>

					<div class="document__aside">
						<section class="document__aside-card">
							<p class="document-meta__label"><?php esc_html_e( 'Page metadata', 'carlashub-v2' ); ?></p>
							<div class="document-meta">
								<p><strong><?php esc_html_e( 'Published', 'carlashub-v2' ); ?></strong><br><?php echo esc_html( get_the_date() ); ?></p>
								<p><strong><?php esc_html_e( 'Route', 'carlashub-v2' ); ?></strong><br><?php echo esc_html( wp_parse_url( get_permalink(), PHP_URL_PATH ) ? wp_parse_url( get_permalink(), PHP_URL_PATH ) : '/' ); ?></p>
							</div>
						</section>

						<?php get_sidebar(); ?>
					</div>
				</div>
			</article>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
