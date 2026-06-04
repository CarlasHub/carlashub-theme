<?php
/**
 * Front page template.
 *
 * @package CarlasHub_V2
 */

get_header();

$featured_posts  = carlashub_v2_get_pinned_posts( 4 );
$recent_posts    = get_posts(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 21,
		'ignore_sticky_posts' => true,
	)
);
$topic_categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 4,
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);
$contact_email      = carlashub_v2_get_contact_email();
$contact_mailto_url = carlashub_v2_get_contact_mailto_url();
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide hub-home">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$front_page_content_raw = (string) get_the_content();
			$has_front_page_content = '' !== trim( $front_page_content_raw );
			?>
			<?php if ( is_active_sidebar( 'front-page-hero' ) ) : ?>
				<?php dynamic_sidebar( 'front-page-hero' ); ?>
			<?php else : ?>
				<?php
				echo carlashub_v2_render_hub_hero(
					array(
						'eyebrow'         => __( 'Carla Goncalves', 'carlashub-v2' ),
						'lede'            => __( 'Mostly things I work on, test, fix, or think about.', 'carlashub-v2' ),
						'support'         => __( 'Web Developement x A11Y x Design x AI x Tools', 'carlashub-v2' ),
						'primary_label'   => __( 'Recent posts', 'carlashub-v2' ),
						'secondary_label' => __( 'Topics', 'carlashub-v2' ),
						'secondary_url'   => '#topics',
						'status_eyebrow'  => __( 'ON THIS SITE', 'carlashub-v2' ),
						'status_1_label'  => __( 'LATEST POSTS', 'carlashub-v2' ),
						'status_1_value'  => __( 'New posts, project notes, and the longer write-ups when they are worth doing.', 'carlashub-v2' ),
						'status_2_label'  => __( 'WHAT I WRITE ABOUT', 'carlashub-v2' ),
						'status_2_value'  => __( 'Mostly accessibility, front-end work, WordPress, and the decisions that shape the finished result.', 'carlashub-v2' ),
						'status_3_label'  => __( 'START HERE', 'carlashub-v2' ),
						'status_3_value'  => __( 'Start with the recent posts, then follow a topic if you want more.', 'carlashub-v2' ),
					)
				); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			<?php endif; ?>

			<nav class="section-tabs" aria-label="<?php esc_attr_e( 'Front page sections', 'carlashub-v2' ); ?>">
				<ul class="section-tabs__list">
					<?php if ( $has_front_page_content ) : ?>
						<li><a href="#entry-content"><?php esc_html_e( 'About', 'carlashub-v2' ); ?></a></li>
					<?php endif; ?>
					<?php if ( $featured_posts ) : ?>
						<li><a href="#featured"><?php esc_html_e( 'Featured posts', 'carlashub-v2' ); ?></a></li>
					<?php endif; ?>
					<li><a href="#topics"><?php esc_html_e( 'Topics', 'carlashub-v2' ); ?></a></li>
					<li><a href="#updates"><?php esc_html_e( 'Recent posts', 'carlashub-v2' ); ?></a></li>
					<li><a href="#contact"><?php esc_html_e( 'Contact', 'carlashub-v2' ); ?></a></li>
				</ul>
			</nav>

			<?php if ( $has_front_page_content ) : ?>
				<section id="entry-content" class="section-block">
					<div class="section-head">
						<div>
							<p class="eyebrow"><?php esc_html_e( 'ABOUT', 'carlashub-v2' ); ?></p>
							<h2><?php esc_html_e( 'What this site is for', 'carlashub-v2' ); ?></h2>
							<p class="section-intro"><?php esc_html_e( 'Mostly notes from real work, plus the projects I keep coming back to.', 'carlashub-v2' ); ?></p>
						</div>
					</div>
					<div class="card-grid">
						<article class="entry-card entry-card--featured entry-content entry-content--landing">
							<?php if ( false !== strpos( $front_page_content_raw, 'post-cards' ) ) : ?>
								<div class="wp-block-query is-layout-flow wp-block-query-is-layout-flow">
									<ul class="post-cards is-style-cards wp-block-post-template is-layout-flow wp-block-post-template-is-layout-flow">
										<?php foreach ( $recent_posts as $landing_post ) : ?>
											<li class="wp-block-post post-<?php echo esc_attr( (string) $landing_post->ID ); ?>">
												<?php echo carlashub_v2_render_entry_card( $landing_post, 'featured' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</li>
										<?php endforeach; ?>
									</ul>
									<?php if ( count( $recent_posts ) > 4 ) : ?>
										<div class="hero-actions">
											<a class="button" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'View all posts', 'carlashub-v2' ); ?></a>
										</div>
									<?php endif; ?>
								</div>
							<?php else : ?>
								<?php echo do_shortcode( wp_kses_post( $front_page_content_raw ) ); ?>
							<?php endif; ?>
							<?php
							wp_link_pages(
								array(
									'before'      => '<nav class="page-links" aria-label="' . esc_attr__( 'Landing page navigation', 'carlashub-v2' ) . '"><span class="page-links-title">' . esc_html__( 'Pages:', 'carlashub-v2' ) . '</span>',
									'after'       => '</nav>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								)
							);
							?>
						</article>
					</div>
				</section>
			<?php endif; ?>

			<?php if ( $featured_posts ) : ?>
				<section id="featured" class="section-block">
					<div class="section-head">
						<div>
							<p class="eyebrow"><?php esc_html_e( 'FEATURED', 'carlashub-v2' ); ?></p>
							<h2><?php esc_html_e( 'Featured posts', 'carlashub-v2' ); ?></h2>
							<p class="section-intro"><?php esc_html_e( 'A few posts that say the most about how I work.', 'carlashub-v2' ); ?></p>
						</div>
					</div>
					<div class="card-grid">
						<?php foreach ( $featured_posts as $featured_post ) : ?>
							<?php echo carlashub_v2_render_entry_card( $featured_post, 'featured' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<section id="topics" class="section-block">
					<div class="section-head">
						<div>
							<p class="eyebrow"><?php esc_html_e( 'TOPICS', 'carlashub-v2' ); ?></p>
							<h2><?php esc_html_e( 'Browse by topic', 'carlashub-v2' ); ?></h2>
							<p class="section-intro"><?php esc_html_e( 'If you want one subject at a time, start here.', 'carlashub-v2' ); ?></p>
						</div>
					</div>
				<div class="topic-grid">
					<?php foreach ( $topic_categories as $category ) : ?>
						<?php
						$topic_keys    = array_filter(
							array_unique(
								array(
									sanitize_title( (string) $category->slug ),
									sanitize_title( (string) $category->name ),
								)
							)
						);
						$topic_summary = $category->description ? wp_trim_words( wp_strip_all_tags( $category->description ), 20 ) : __( 'Posts gathered under this topic.', 'carlashub-v2' );

						if ( array_intersect( $topic_keys, array( 'web-apps', 'web-app', 'webapps' ) ) ) {
							$topic_summary = __( 'Build notes, experiments, and web projects that turned into something worth keeping.', 'carlashub-v2' );
						} elseif ( array_intersect( $topic_keys, array( 'a11y', 'accessibility', 'web-accessibility' ) ) ) {
							$topic_summary = __( 'Accessibility posts from audits, fixes, and the parts that are harder to get right.', 'carlashub-v2' );
						} elseif ( array_intersect( $topic_keys, array( 'wp', 'wordpress' ) ) ) {
							$topic_summary = __( 'WordPress work, theme notes, and the odd lesson learned the hard way.', 'carlashub-v2' );
						} elseif ( in_array( 'portfolio', $topic_keys, true ) ) {
							$topic_summary = __( 'Projects and older work I still wanted to keep around.', 'carlashub-v2' );
						}
						?>
						<article class="panel topic-card">
							<div class="topic-card__header">
								<div>
									<p class="entry-card__path"><?php echo esc_html( 'topic / ' . $category->slug ); ?></p>
									<h3 class="entry-card__title"><a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></h3>
								</div>
								<span class="entry-card__badge screen-reader-text"><?php echo esc_html( sprintf( _n( '%d post', '%d posts', (int) $category->count, 'carlashub-v2' ), (int) $category->count ) ); ?></span>
							</div>
							<p class="entry-summary"><?php echo esc_html( $topic_summary ); ?></p>
							<div class="entry-card__footer">
								<div class="entry-card__stats">
									<span><?php esc_html_e( 'Topic page', 'carlashub-v2' ); ?></span>
									<span><?php echo esc_html( sprintf( _n( '%d post', '%d posts', (int) $category->count, 'carlashub-v2' ), (int) $category->count ) ); ?></span>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</section>

			<section id="updates" class="section-block">
					<div class="section-head">
						<div>
							<p class="eyebrow"><?php esc_html_e( 'RECENT POSTS', 'carlashub-v2' ); ?></p>
							<h2><?php esc_html_e( 'Recent posts', 'carlashub-v2' ); ?></h2>
							<p class="section-intro"><?php esc_html_e( 'The newest posts on the site.', 'carlashub-v2' ); ?></p>
						</div>
					</div>
				<div id="recent-posts-grid" class="card-grid js-load-more-grid" data-load-more-initial="4" data-load-more-step="4">
					<?php foreach ( $recent_posts as $recent_post ) : ?>
						<?php echo carlashub_v2_render_entry_card( $recent_post, 'featured' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endforeach; ?>
				</div>
				<?php if ( count( $recent_posts ) > 4 ) : ?>
					<div class="hero-actions wp-block-query-load-more">
						<button class="button js-load-more-button" type="button" data-load-more-target="recent-posts-grid">
							<?php esc_html_e( 'Load more posts', 'carlashub-v2' ); ?>
						</button>
						<span class="screen-reader-text js-load-more-status" aria-live="polite"></span>
					</div>
				<?php endif; ?>
			</section>

			<section id="contact" class="hub-cta">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'CONTACT', 'carlashub-v2' ); ?></p>
					<h2><?php esc_html_e( 'Get in touch', 'carlashub-v2' ); ?></h2>
					<p class="section-intro"><?php esc_html_e( 'If you want to talk about a project or ask something, email me.', 'carlashub-v2' ); ?></p>
				</div>
				<?php if ( $contact_mailto_url ) : ?>
					<div class="hero-actions">
						<a class="button" href="<?php echo esc_url( $contact_mailto_url ); ?>"><?php esc_html_e( 'Email me', 'carlashub-v2' ); ?></a>
					</div>
				<?php else : ?>
					<p class="section-intro">
						<?php
						esc_html_e(
							'Set a contact email in WordPress Settings > General to enable the email link.',
							'carlashub-v2'
						);
						?>
					</p>
				<?php endif; ?>
				<?php if ( $contact_email ) : ?>
					<p class="screen-reader-text">
						<?php
						printf(
							/* translators: %s: configured contact email address. */
							esc_html__( 'Contact email: %s', 'carlashub-v2' ),
							esc_html( $contact_email )
						);
						?>
					</p>
				<?php endif; ?>
			</section>
		<?php endwhile; ?>
	</div>
</main>
<?php
get_footer();
