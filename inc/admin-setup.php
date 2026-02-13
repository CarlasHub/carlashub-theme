<?php
/**
 * Admin setup helper for CarlasHub.
 */

function carlashub_register_setup_page() {
	add_theme_page(
		__( 'CarlasHub Setup', 'carlashub' ),
		__( 'CarlasHub Setup', 'carlashub' ),
		'manage_options',
		'carlashub-setup',
		'carlashub_render_setup_page'
	);
}
add_action( 'admin_menu', 'carlashub_register_setup_page' );

function carlashub_handle_demo_seed_action() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( empty( $_POST['carlashub_seed_demo'] ) ) {
		return;
	}
	check_admin_referer( 'carlashub_seed_demo' );

	if ( function_exists( 'carlashub_seed_demo_content' ) ) {
		carlashub_seed_demo_content( true );
	}

	$redirect = add_query_arg( 'seeded', '1', menu_page_url( 'carlashub-setup', false ) );
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_init', 'carlashub_handle_demo_seed_action' );

function carlashub_render_setup_page() {
	$seeded = (bool) get_option( 'carlashub_demo_seeded' );
	$just_seeded = ! empty( $_GET['seeded'] );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'CarlasHub Setup', 'carlashub' ); ?></h1>
		<?php if ( $just_seeded ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Demo content generated.', 'carlashub' ); ?></p></div>
		<?php endif; ?>
		<p><?php esc_html_e( 'Generate the demo pages, posts, and menus so you can view the full theme system.', 'carlashub' ); ?></p>
		<?php if ( $seeded ) : ?>
			<div class="notice notice-info"><p><?php esc_html_e( 'Demo content already exists. You can re-run this to ensure all pages and menus are created.', 'carlashub' ); ?></p></div>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'carlashub_seed_demo' ); ?>
			<?php submit_button( __( 'Generate Demo Content', 'carlashub' ), 'primary', 'carlashub_seed_demo', false ); ?>
		</form>
	</div>
	<?php
}
