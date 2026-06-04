<?php
/**
 * Single post template.
 *
 * @package CarlasHub_V2
 */

get_header();
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$read_time        = carlashub_v2_get_read_time( get_the_ID() );
			$rendered_content = apply_filters( 'the_content', get_the_content() );
			$post_thumbnail   = get_the_post_thumbnail(
				get_the_ID(),
				'large',
				array(
					'class'         => 'document__intro-thumbnail-image',
					'loading'       => 'eager',
					'fetchpriority' => 'high',
					'decoding'      => 'async',
				)
			);
			if ( ! $post_thumbnail ) {
				$intro_media      = carlashub_v2_extract_intro_media_from_content( $rendered_content );
				$post_thumbnail   = $intro_media['media_markup'];
				$rendered_content = $intro_media['content'];
			}
			if ( $post_thumbnail ) {
				$rendered_content = carlashub_v2_inject_intro_media_after_first_paragraph(
					$rendered_content,
					'<figure class="document__intro-thumbnail">' . $post_thumbnail . '</figure>'
				);
			}
			?>
			<article <?php post_class(); ?>>
				<header class="panel document__header">
					<p class="eyebrow"><?php esc_html_e( 'Article', 'carlashub-v2' ); ?></p>
					<p class="entry-card__path"><?php echo esc_html( carlashub_v2_get_entry_path_label( get_post() ) ); ?></p>
					<h1 class="document__title"><?php the_title(); ?></h1>
					<?php echo carlashub_v2_get_taxonomy_chips( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</header>

				<div class="document__layout">
					<div class="panel document__content entry-content entry-content--prose">
						<div class="meta-row">
							<span class="meta-pill"><strong><?php echo esc_html( get_the_author() ? get_the_author() : __( 'Carla G.', 'carlashub-v2' ) ); ?></strong></span>
							<span class="meta-pill"><?php echo esc_html( get_the_date() ); ?></span>
							<span class="meta-pill"><?php echo esc_html( sprintf( __( 'Updated %s', 'carlashub-v2' ), get_the_modified_date() ) ); ?></span>
							<span class="meta-pill">
								<?php
								printf(
									/* translators: %d: minutes. */
									esc_html( _n( '%d min read', '%d mins read', $read_time, 'carlashub-v2' ) ),
									(int) $read_time
								);
								?>
							</span>
						</div>
						<?php echo $rendered_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php wp_link_pages(); ?>
						<?php echo carlashub_v2_render_article_share_panel( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>

					<div class="document__aside">
						<section class="document__aside-card">
							<p class="document-meta__label"><?php esc_html_e( 'Article metadata', 'carlashub-v2' ); ?></p>
							<div class="document-meta">
								<p><strong><?php esc_html_e( 'Published', 'carlashub-v2' ); ?></strong><br><?php echo esc_html( get_the_date() ); ?></p>
								<p><strong><?php esc_html_e( 'Updated', 'carlashub-v2' ); ?></strong><br><?php echo esc_html( get_the_modified_date() ); ?></p>
								<p><strong><?php esc_html_e( 'Permalink', 'carlashub-v2' ); ?></strong><br><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Stable article URL', 'carlashub-v2' ); ?></a></p>
							</div>
						</section>

						<?php echo carlashub_v2_get_author_box_markup( (int) get_the_author_meta( 'ID' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php get_sidebar(); ?>
					</div>
				</div>
			</article>

			<?php the_post_navigation(); ?>

			<?php
			// Comments are intentionally disabled for this site.
			?>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
