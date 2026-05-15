<?php
/**
 * Shared site footer.
 *
 * @package CarlasHub_V2
 */

$footer_posts      = get_posts(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
$footer_categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 4,
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);
$footer_social_links = carlashub_v2_get_footer_social_links();
?>
	<footer class="site-footer">
		<div class="shell shell--wide">
			<div class="site-footer__grid">
				<section class="site-footer__section">
					<p class="eyebrow"><?php esc_html_e( 'ABOUT', 'carlashub-v2' ); ?></p>
					<h2><?php esc_html_e( 'Carla Goncalves', 'carlashub-v2' ); ?></h2>
					<p class="site-footer__support"><?php esc_html_e( 'Web developer. Thinker. Tinkerer.', 'carlashub-v2' ); ?></p>
					<?php if ( ! empty( $footer_social_links ) ) : ?>
						<ul class="footer-social-links">
							<?php foreach ( $footer_social_links as $social_link ) : ?>
								<?php $icon_markup = carlashub_v2_get_share_icon_svg( $social_link['icon'] ); ?>
								<?php if ( ! $icon_markup ) : ?>
									<?php continue; ?>
								<?php endif; ?>
								<li>
									<a class="footer-social-link" href="<?php echo esc_url( $social_link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
										<?php echo $icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										<span><?php echo esc_html( $social_link['label'] ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</section>

				<nav class="site-footer__section" aria-label="<?php esc_attr_e( 'Footer menu', 'carlashub-v2' ); ?>">
					<h2 class="widget-title"><?php esc_html_e( 'Site', 'carlashub-v2' ); ?></h2>
					<ul class="footer-menu">
						<li class="menu-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'carlashub-v2' ); ?></a></li>
						<li class="menu-item"><a href="<?php echo esc_url( carlashub_v2_get_blog_url() ); ?>"><?php esc_html_e( 'Writing', 'carlashub-v2' ); ?></a></li>
						<li class="menu-item"><a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>"><?php esc_html_e( 'Search', 'carlashub-v2' ); ?></a></li>
					</ul>
				</nav>

				<section class="site-footer__section">
					<h2 class="widget-title"><?php esc_html_e( 'TOPICS', 'carlashub-v2' ); ?></h2>
					<ul class="archive-list">
						<?php foreach ( $footer_categories as $category ) : ?>
							<li>
								<a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>

				<section class="site-footer__section">
					<h2 class="widget-title"><?php esc_html_e( 'Recent posts', 'carlashub-v2' ); ?></h2>
					<ul class="archive-list">
						<?php foreach ( $footer_posts as $footer_post ) : ?>
							<li>
								<a href="<?php echo esc_url( get_permalink( $footer_post ) ); ?>"><?php echo esc_html( get_the_title( $footer_post ) ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			</div>

			<div class="site-footer__meta">
				<p><?php echo esc_html( gmdate( 'Y' ) . ' CarlasHub.' ); ?></p>
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
