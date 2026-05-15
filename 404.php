<?php
/**
 * 404 template.
 *
 * @package CarlasHub_V2
 */

get_header();
?>
<main id="primary" class="site-main">
	<div class="shell shell--wide">
		<div class="empty-state">
			<p class="eyebrow"><?php esc_html_e( '404', 'carlashub-v2' ); ?></p>
			<h1><?php esc_html_e( 'That page does not exist.', 'carlashub-v2' ); ?></h1>
			<p><?php esc_html_e( 'Try a search or head back to the homepage.', 'carlashub-v2' ); ?></p>
			<div class="hero-actions">
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return home', 'carlashub-v2' ); ?></a>
				<a class="button button--ghost" href="<?php echo esc_url( carlashub_v2_get_blog_url() ); ?>"><?php esc_html_e( 'Open writing', 'carlashub-v2' ); ?></a>
			</div>
			<?php get_search_form( array( 'aria_label' => __( 'Search the site', 'carlashub-v2' ), 'show_label' => true ) ); ?>
		</div>
	</div>
</main>
<?php
get_footer();
