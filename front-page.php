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
				<a class="btn btn--ghost" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Read the blog', 'carlashub' ); ?></a>
			</div>
		</div>
	</section>

	<?php
	while ( have_posts() ) :
		the_post();
		if ( trim( get_the_content() ) ) :
			?>
			<section class="panel panel--content" aria-label="<?php esc_attr_e( 'Intro', 'carlashub' ); ?>">
				<div class="panel__inner">
					<?php the_content(); ?>
				</div>
			</section>
			<?php
		endif;
	endwhile;
	?>
</main>

<?php
get_footer();
