<?php
/**
 * Shared site header.
 *
 * @package CarlasHub_V2
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site-shell">
	<a class="skip-link" href="#primary"><?php esc_html_e( 'Skip to content', 'carlashub-v2' ); ?></a>

	<header class="site-header">
		<div class="shell shell--wide site-header__inner">
			<div class="site-branding">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="site-branding__mark" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( carlashub_v2_get_site_initials() ); ?></a>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'Primary menu', 'carlashub-v2' ); ?>" data-nav-state="closed">
				<button id="primary-menu-toggle" class="menu-toggle" type="button" aria-controls="primary-menu-container" aria-expanded="false" hidden>
					<span class="menu-toggle__bars" aria-hidden="true"><span></span><span></span><span></span></span>
					<span><?php esc_html_e( 'Menu', 'carlashub-v2' ); ?></span>
				</button>

				<div id="primary-menu-container" class="site-nav__panel" hidden>
					<button id="primary-menu-close" class="menu-close" type="button">
						<span aria-hidden="true">&times;</span>
						<span><?php esc_html_e( 'Close', 'carlashub-v2' ); ?></span>
					</button>
					<?php echo carlashub_v2_get_menu_markup( 'primary', 'menu', 'carlashub_v2_primary_menu_fallback' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="site-nav__search">
						<?php get_search_form( array( 'aria_label' => __( 'Search the site', 'carlashub-v2' ), 'show_label' => false ) ); ?>
					</div>
				</div>
			</nav>
		</div>
	</header>
