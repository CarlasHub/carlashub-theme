<?php
/**
 * Shared sidebar.
 *
 * @package CarlasHub_V2
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<aside class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'carlashub-v2' ); ?>">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside>
<?php else : ?>
	<?php
	$sidebar_posts = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => true,
		)
	);
	$sidebar_categories = get_categories(
		array(
			'hide_empty' => true,
			'number'     => 6,
			'orderby'    => 'count',
			'order'      => 'DESC',
		)
	);
	?>
	<aside class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'carlashub-v2' ); ?>">
		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Recent posts', 'carlashub-v2' ); ?></h2>
			<ul class="archive-list">
				<?php foreach ( $sidebar_posts as $sidebar_post ) : ?>
					<li>
						<a href="<?php echo esc_url( get_permalink( $sidebar_post ) ); ?>"><?php echo esc_html( get_the_title( $sidebar_post ) ); ?></a>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $sidebar_post ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y', $sidebar_post ) ); ?></time>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Topics', 'carlashub-v2' ); ?></h2>
			<ul class="archive-list">
				<?php foreach ( $sidebar_categories as $category ) : ?>
					<li>
						<a href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
						<span class="archive-count"><?php echo esc_html( sprintf( _n( '%d post', '%d posts', (int) $category->count, 'carlashub-v2' ), (int) $category->count ) ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section class="widget">
			<h2 class="widget-title"><?php esc_html_e( 'Archives', 'carlashub-v2' ); ?></h2>
			<ul class="archive-list">
				<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
			</ul>
		</section>
	</aside>
<?php endif; ?>
