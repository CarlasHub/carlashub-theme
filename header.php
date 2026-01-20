<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CarlasHub
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
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'carlashub' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-header__inner">
			<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$carlashub_description = get_bloginfo( 'description', 'display' );
			if ( $carlashub_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $carlashub_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'carlashub' ); ?>">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'carlashub' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
			</nav><!-- #site-navigation -->

			<div class="site-header__actions">
				<a class="btn btn--ghost" href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Log in', 'carlashub' ); ?></a>
				<?php if ( get_option( 'users_can_register' ) ) : ?>
					<a class="btn btn--primary" href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Sign up', 'carlashub' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</header><!-- #masthead -->
