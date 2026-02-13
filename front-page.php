<?php
/**
 * Template for the front page.
 *
 * @package CarlasHub
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="hero" aria-label="<?php esc_attr_e( 'Hero', 'carlashub' ); ?>">
		<div class="hero__inner">
			<div class="hero__orb" aria-hidden="true"></div>

			<h1 class="hero__title"><?php bloginfo( 'name' ); ?></h1>

			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( ! $description ) {
				$description = __( 'A modern WordPress site with a high contrast glass interface.', 'carlashub' );
			}
			?>
			<p class="hero__subtitle"><?php echo esc_html( $description ); ?></p>

			<div class="hero__actions">
				<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'Learn more', 'carlashub' ); ?></a>
				<a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( (int) get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Read the blog', 'carlashub' ); ?></a>
			</div>
		</div>
	</section>

	<?php
	$front_page_id = (int) get_queried_object_id();

	if ( $front_page_id && 'page' === get_post_type( $front_page_id ) ) {
		$front_page = get_post( $front_page_id );

		if ( $front_page && trim( (string) $front_page->post_content ) ) {
			?>
			<section class="panel panel--content" aria-label="<?php esc_attr_e( 'Intro', 'carlashub' ); ?>">
				<div class="panel__inner">
					<?php echo wp_kses_post( apply_filters( 'the_content', $front_page->post_content ) ); ?>
				</div>
			</section>
			<?php
		}
	}
	?>

	<?php
	$posts_per_page = 6;

	$front_posts = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => $posts_per_page,
			'no_found_rows'       => true,
		)
	);

	if ( $front_posts->have_posts() ) :
		?>
		<section class="panel panel--posts" aria-labelledby="front-posts-title">
			<div class="panel__inner">
				<header class="panel__header">
					<h2 id="front-posts-title" class="panel__title"><?php esc_html_e( 'Latest posts', 'carlashub' ); ?></h2>
					<?php
					$posts_page_id  = (int) get_option( 'page_for_posts' );
					$posts_page_url = $posts_page_id ? get_permalink( $posts_page_id ) : get_post_type_archive_link( 'post' );

					if ( $posts_page_url ) :
						?>
						<a class="btn btn--ghost" href="<?php echo esc_url( $posts_page_url ); ?>">
							<?php esc_html_e( 'View all posts', 'carlashub' ); ?>
						</a>
						<?php
					endif;
					?>
				</header>

				<ul class="tiles" role="list">
					<?php
					while ( $front_posts->have_posts() ) :
						$front_posts->the_post();

						$post_id    = get_the_ID();
						$post_title = get_the_title();
						$post_url   = get_permalink();
						?>
						<li class="tiles__item">
							<article class="tile" aria-labelledby="tile-title-<?php echo esc_attr( (string) $post_id ); ?>">
								<a class="tile__media" href="<?php echo esc_url( $post_url ); ?>">
									<?php if ( has_post_thumbnail( $post_id ) ) : ?>
										<?php
										the_post_thumbnail(
											'medium_large',
											array(
												'class'   => 'tile__thumb',
												'loading' => 'lazy',
											)
										);
										?>
									<?php else : ?>
										<div class="tile__thumb tile__thumb--placeholder" aria-hidden="true"></div>
										<span class="screen-reader-text"><?php esc_html_e( 'No featured image available', 'carlashub' ); ?></span>
									<?php endif; ?>
								</a>

								<div class="tile__body">
									<h3 id="tile-title-<?php echo esc_attr( (string) $post_id ); ?>" class="tile__title">
										<a class="tile__title-link" href="<?php echo esc_url( $post_url ); ?>">
											<?php echo esc_html( $post_title ); ?>
										</a>
									</h3>

									<p class="tile__meta">
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
											<?php echo esc_html( get_the_date() ); ?>
										</time>
									</p>

									<div class="tile__excerpt">
										<?php echo wp_kses_post( wpautop( wp_trim_words( get_the_excerpt( $post_id ), 22 ) ) ); ?>
									</div>

									<div class="tile__actions">
										<a class="btn btn--primary tile__button" href="<?php echo esc_url( $post_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read: %s', 'carlashub' ), $post_title ) ); ?>">
											<?php esc_html_e( 'Read post', 'carlashub' ); ?>
										</a>
									</div>
								</div>
							</article>
						</li>
						<?php
					endwhile;
					?>
				</ul>
			</div>
		</section>
		<?php
	endif;

	wp_reset_postdata();
	?>
</main>

<?php
get_footer();
