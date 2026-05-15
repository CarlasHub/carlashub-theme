<?php
/**
 * Theme setup and shared helpers for CarlasHub V2.
 *
 * @package CarlasHub_V2
 */

if ( ! defined( 'CARLASHUB_V2_VERSION' ) ) {
	define( 'CARLASHUB_V2_VERSION', '1.1.0' );
}

require_once get_template_directory() . '/inc/custom-sitemaps.php';

/**
 * Register theme support and menus.
 */
function carlashub_v2_setup() {
	load_theme_textdomain( 'carlashub-v2', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'custom-background' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'carlashub-v2' ),
			'footer'  => __( 'Footer Menu', 'carlashub-v2' ),
		)
	);
}
add_action( 'after_setup_theme', 'carlashub_v2_setup' );

/**
 * Register the sidebar.
 */
function carlashub_v2_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'carlashub-v2' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Repository-style metadata panels and widgets.', 'carlashub-v2' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Front Page Hero', 'carlashub-v2' ),
			'id'            => 'front-page-hero',
			'description'   => __( 'Add one CarlasHub Hero widget here to control the front-page hero section.', 'carlashub-v2' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	register_widget( 'CarlasHub_V2_Hero_Widget' );
}
add_action( 'widgets_init', 'carlashub_v2_widgets_init' );

/**
 * Prevent search widgets from rendering in the primary sidebar.
 *
 * @param array<string,mixed>|false $instance Widget instance settings.
 * @param WP_Widget                 $widget   Widget object.
 * @param array<string,mixed>       $args     Sidebar display arguments.
 * @return array<string,mixed>|false
 */
function carlashub_v2_filter_sidebar_search_widgets( $instance, $widget, $args ) {
	if ( empty( $args['id'] ) || 'sidebar-1' !== $args['id'] ) {
		return $instance;
	}

	if ( $widget instanceof WP_Widget_Search ) {
		return false;
	}

	if (
		$widget instanceof WP_Widget_Block &&
		is_array( $instance ) &&
		! empty( $instance['content'] ) &&
		(
			false !== strpos( $instance['content'], '<!-- wp:search' ) ||
			has_block( 'core/search', $instance['content'] )
		)
	) {
		return false;
	}

	return $instance;
}
add_filter( 'widget_display_callback', 'carlashub_v2_filter_sidebar_search_widgets', 10, 3 );

/**
 * Enqueue widget admin assets for hero image uploads.
 *
 * @param string $hook_suffix Current admin page.
 */
function carlashub_v2_admin_enqueue_assets( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'widgets.php', 'customize.php' ), true ) ) {
		return;
	}

	$admin_style_path = get_template_directory() . '/assets/css/admin.css';
	$admin_style_ver  = file_exists( $admin_style_path ) ? (string) filemtime( $admin_style_path ) : CARLASHUB_V2_VERSION;

	wp_enqueue_style(
		'carlashub-v2-admin',
		get_template_directory_uri() . '/assets/css/admin.css',
		array(),
		$admin_style_ver
	);
	wp_enqueue_media();
	wp_enqueue_script(
		'carlashub-v2-widget-media',
		get_template_directory_uri() . '/assets/js/widget-media.js',
		array( 'jquery' ),
		CARLASHUB_V2_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'carlashub_v2_admin_enqueue_assets' );

/**
 * Enqueue theme assets.
 */
function carlashub_v2_enqueue_assets() {
	$stylesheet_path = get_stylesheet_directory() . '/style.css';
	$script_path     = get_template_directory() . '/assets/js/theme.js';
	$style_version   = file_exists( $stylesheet_path ) ? (string) filemtime( $stylesheet_path ) : CARLASHUB_V2_VERSION;
	$script_version  = file_exists( $script_path ) ? (string) filemtime( $script_path ) : CARLASHUB_V2_VERSION;

	wp_enqueue_style( 'carlashub-v2-style', get_stylesheet_uri(), array(), $style_version );
	wp_enqueue_script(
		'carlashub-v2-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		$script_version,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'carlashub_v2_enqueue_assets' );

/**
 * Limit core XML sitemaps to canonical article content only.
 *
 * @param array<string,string> $post_types Public post types for sitemap output.
 * @return array<string,string>
 */
function carlashub_v2_exclude_legacy_items_from_core_sitemaps( $post_types ) {
	foreach ( array_keys( $post_types ) as $post_type ) {
		if ( 'post' !== $post_type ) {
			unset( $post_types[ $post_type ] );
		}
	}

	return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'carlashub_v2_exclude_legacy_items_from_core_sitemaps' );

/**
 * Exclude low-value archive taxonomies from core XML sitemaps while keeping
 * category archives available as canonical discovery paths.
 *
 * @param array<string,string> $taxonomies Public taxonomies for sitemap output.
 * @return array<string,string>
 */
function carlashub_v2_exclude_archive_taxonomies_from_core_sitemaps( $taxonomies ) {
	unset( $taxonomies['post_tag'], $taxonomies['post_format'] );
	return $taxonomies;
}
add_filter( 'wp_sitemaps_taxonomies', 'carlashub_v2_exclude_archive_taxonomies_from_core_sitemaps' );

/**
 * Exclude user archives from core XML sitemaps.
 *
 * @param bool   $is_enabled Whether the provider is enabled.
 * @param string $provider_name Current sitemap provider name.
 * @return bool
 */
function carlashub_v2_exclude_users_from_core_sitemaps( $is_enabled, $provider_name ) {
	if ( 'users' === $provider_name ) {
		return false;
	}

	return $is_enabled;
}
add_filter( 'wp_sitemaps_add_provider', 'carlashub_v2_exclude_users_from_core_sitemaps', 10, 2 );

/**
 * Return the current request host name without any port suffix.
 *
 * @return string
 */
function carlashub_v2_get_current_request_host() {
	$host = '';

	if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
		$host = (string) wp_unslash( $_SERVER['HTTP_HOST'] );
	}

	if ( '' === $host ) {
		$parsed_host = wp_parse_url( home_url(), PHP_URL_HOST );
		$host        = is_string( $parsed_host ) ? $parsed_host : '';
	}

	$host = strtolower( preg_replace( '/:\d+$/', '', trim( $host ) ) );

	return $host;
}

/**
 * Check whether the current request is for one of the demo subdomains that
 * must never be indexed.
 *
 * @param string|null $host Optional host override.
 * @return bool
 */
function carlashub_v2_is_demo_host( $host = null ) {
	$host = is_string( $host ) && '' !== $host ? strtolower( $host ) : carlashub_v2_get_current_request_host();

	return in_array(
		$host,
		array(
			'demo-1.carlashub.com',
			'demo-3.carlashub.com',
			'demo-4.carlashub.com',
		),
		true
	);
}

/**
 * Check whether the current request targets a sitemap endpoint.
 *
 * @return bool
 */
function carlashub_v2_is_sitemap_request() {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return false;
	}

	if ( '' !== carlashub_v2_get_current_sitemap_route() ) {
		return true;
	}

	$request_path = wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );

	if ( ! is_string( $request_path ) ) {
		return false;
	}

	return (bool) preg_match( '#^/(?:sitemap(?:-posts|-categories)?\.xml|wp-sitemap.*|sitemap(?:_index)?\.xml|sitemap[0-9]+\.xml)$#i', $request_path );
}

/**
 * Determine whether the current request should be noindexed.
 *
 * Main site:
 * - keep singular posts/pages and the front page indexable
 * - noindex archives, the posts page, search, 404s, and paginated archive views
 *
 * Demo subdomains:
 * - noindex everything
 *
 * @return bool
 */
function carlashub_v2_should_noindex_current_request() {
	if ( is_admin() ) {
		return false;
	}

	if ( carlashub_v2_is_sitemap_request() ) {
		return false;
	}

	if ( carlashub_v2_is_demo_host() ) {
		return true;
	}

	if ( is_search() || is_404() || is_feed() ) {
		return true;
	}

	if ( is_home() && ! is_front_page() ) {
		return true;
	}

	if ( is_archive() && ! is_singular() ) {
		return true;
	}

	if ( is_paged() && ! is_singular() ) {
		return true;
	}

	return false;
}

/**
 * Build the current robots directives in array form.
 *
 * @return array<int,string>
 */
function carlashub_v2_get_current_robots_directives() {
	if ( ! carlashub_v2_should_noindex_current_request() ) {
		return array();
	}

	if ( carlashub_v2_is_demo_host() ) {
		return array( 'noindex', 'nofollow', 'noarchive', 'nosnippet' );
	}

	return array( 'noindex', 'follow' );
}

/**
 * Apply robots directives through WordPress core.
 *
 * @param array<string,mixed> $robots Existing robots directives.
 * @return array<string,mixed>
 */
function carlashub_v2_filter_wp_robots( $robots ) {
	$directives = carlashub_v2_get_current_robots_directives();

	if ( empty( $directives ) ) {
		return $robots;
	}

	unset( $robots['index'], $robots['follow'] );

	foreach ( $directives as $directive ) {
		$robots[ $directive ] = true;
	}

	return $robots;
}
add_filter( 'wp_robots', 'carlashub_v2_filter_wp_robots' );

/**
 * Apply the same robots policy when Yoast SEO controls the front-end meta tag.
 *
 * @param string|array<int,string> $robots Existing Yoast robots directives.
 * @return string|array<int,string>
 */
function carlashub_v2_filter_wpseo_robots( $robots ) {
	$directives = carlashub_v2_get_current_robots_directives();

	if ( empty( $directives ) ) {
		return $robots;
	}

	if ( is_array( $robots ) ) {
		return $directives;
	}

	return implode( ', ', $directives );
}
add_filter( 'wpseo_robots', 'carlashub_v2_filter_wpseo_robots' );

/**
 * Apply the same robots policy when Yoast exposes an array-based robots filter.
 *
 * @param array<int,string> $robots Existing Yoast array directives.
 * @return array<int,string>
 */
function carlashub_v2_filter_wpseo_robots_array( $robots ) {
	$directives = carlashub_v2_get_current_robots_directives();

	if ( empty( $directives ) ) {
		return $robots;
	}

	return $directives;
}
add_filter( 'wpseo_robots_array', 'carlashub_v2_filter_wpseo_robots_array' );

/**
 * Apply the same robots policy when Rank Math controls the front-end meta tag.
 *
 * @param array<int,string> $robots Existing Rank Math directives.
 * @return array<int,string>
 */
function carlashub_v2_filter_rank_math_robots( $robots ) {
	$directives = carlashub_v2_get_current_robots_directives();

	if ( empty( $directives ) ) {
		return $robots;
	}

	return $directives;
}
add_filter( 'rank_math/frontend/robots', 'carlashub_v2_filter_rank_math_robots' );

/**
 * Send X-Robots-Tag headers for feeds and demo hosts where there is no HTML
 * head output to carry the noindex directive.
 */
function carlashub_v2_send_x_robots_tag_header() {
	if ( is_admin() || headers_sent() ) {
		return;
	}

	$directives = carlashub_v2_get_current_robots_directives();

	if ( empty( $directives ) ) {
		return;
	}

	header( 'X-Robots-Tag: ' . implode( ', ', $directives ), true );
}
add_action( 'send_headers', 'carlashub_v2_send_x_robots_tag_header' );

/**
 * Filter the virtual robots.txt output.
 *
 * Main site:
 * - keep the sitemap
 * - keep the default wp-admin restrictions
 *
 * Demo hosts:
 * - remove sitemap discovery
 * - disallow all crawling as a defence-in-depth measure once noindex is live
 *
 * @param string $output Existing robots.txt output.
 * @param bool   $public Whether the site is considered public.
 * @return string
 */
function carlashub_v2_filter_robots_txt( $output, $public ) {
	if ( carlashub_v2_is_demo_host() ) {
		return implode(
			"\n",
			array(
				'User-agent: *',
				'Disallow: /',
				'',
			)
		);
	}

	$lines = array(
		'User-agent: *',
		'Disallow: /wp-admin/',
		'Allow: /wp-admin/admin-ajax.php',
		'',
	);

	if ( $public ) {
		$sitemap_urls = carlashub_v2_get_custom_sitemap_urls();
		$sitemap_url  = $sitemap_urls['index'];

		if ( is_string( $sitemap_url ) && '' !== $sitemap_url ) {
			$lines[] = 'Sitemap: ' . esc_url_raw( $sitemap_url );
		}
	}

	$lines[] = '';

	return implode( "\n", $lines );
}
add_filter( 'robots_txt', 'carlashub_v2_filter_robots_txt', 10, 2 );

/**
 * Redirect legacy or plugin-owned sitemap entrypoints to the canonical core
 * sitemap so stale physical files or alternate generators do not drift away
 * from the current site content model.
 */
function carlashub_v2_redirect_legacy_sitemap_requests() {
	if ( is_admin() || empty( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$request_path = wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );

	if ( ! is_string( $request_path ) ) {
		return;
	}

	if ( preg_match( '#^/(?:wp-sitemap(?:.*)?|sitemap_index\.xml|sitemap[0-9]+\.xml)$#i', $request_path ) ) {
		$sitemap_urls = carlashub_v2_get_custom_sitemap_urls();
		wp_safe_redirect( $sitemap_urls['index'], 301 );
		exit;
	}
}
add_action( 'template_redirect', 'carlashub_v2_redirect_legacy_sitemap_requests', 0 );

/**
 * Disable core XML sitemaps entirely on demo hosts.
 *
 * @param bool $enabled Whether core XML sitemaps are enabled.
 * @return bool
 */
function carlashub_v2_disable_core_sitemaps_on_demo_hosts( $enabled ) {
	return false;
}
add_filter( 'wp_sitemaps_enabled', 'carlashub_v2_disable_core_sitemaps_on_demo_hosts' );

/**
 * Limit Yoast XML sitemaps to canonical article content only.
 *
 * @param bool   $excluded  Whether the post type is excluded.
 * @param string $post_type Current post type.
 * @return bool
 */
function carlashub_v2_exclude_legacy_items_from_yoast_sitemaps( $excluded, $post_type ) {
	if ( 'post' !== $post_type ) {
		return true;
	}

	return $excluded;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'carlashub_v2_exclude_legacy_items_from_yoast_sitemaps', 10, 2 );

/**
 * Exclude low-value archive taxonomies from Yoast XML sitemaps while keeping
 * categories available.
 *
 * @param bool   $excluded Whether the taxonomy is excluded.
 * @param string $taxonomy Current taxonomy.
 * @return bool
 */
function carlashub_v2_exclude_archive_taxonomies_from_yoast_sitemaps( $excluded, $taxonomy ) {
	if ( carlashub_v2_is_demo_host() ) {
		return true;
	}

	if ( in_array( $taxonomy, array( 'post_tag', 'post_format' ), true ) ) {
		return true;
	}

	return $excluded;
}
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'carlashub_v2_exclude_archive_taxonomies_from_yoast_sitemaps', 10, 2 );

/**
 * Mark legacy /items/* URLs as permanently gone (410) so they cannot linger in
 * search indexes or surface in sitemap generators.
 */
function carlashub_v2_mark_legacy_item_urls_gone() {
	if ( is_admin() || ! is_404() || empty( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$request_path = wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );

	if ( ! is_string( $request_path ) ) {
		return;
	}

	if ( preg_match( '#^/items/[^/]+/?$#', $request_path ) ) {
		status_header( 410 );
		nocache_headers();
	}
}
add_action( 'template_redirect', 'carlashub_v2_mark_legacy_item_urls_gone', 0 );

/**
 * Replace generic post excerpt "Read more" links with icon-only links that keep
 * a specific screen-reader label.
 *
 * @param string   $block_content Rendered block HTML.
 * @param array    $block         Parsed block data.
 * @param WP_Block $instance      Block instance.
 * @return string
 */
function carlashub_v2_render_post_excerpt_more_link_icon( $block_content, $block, $instance ) {
	if ( is_admin() || ! is_string( $block_content ) || false === strpos( $block_content, 'wp-block-post-excerpt__more-link' ) ) {
		return $block_content;
	}

	$post_id = 0;

	if ( $instance instanceof WP_Block && ! empty( $instance->context['postId'] ) ) {
		$post_id = (int) $instance->context['postId'];
	} elseif ( ! empty( $block['attrs']['postId'] ) ) {
		$post_id = (int) $block['attrs']['postId'];
	}

	$post_title       = $post_id ? wp_strip_all_tags( get_the_title( $post_id ) ) : '';
	$accessible_label = $post_title
		? sprintf(
			/* translators: %s: post title. */
			__( 'Read article: %s', 'carlashub-v2' ),
			$post_title
		)
		: __( 'Read article', 'carlashub-v2' );

	$pattern = '/<a\b([^>]*class="[^"]*\bwp-block-post-excerpt__more-link\b[^"]*"[^>]*)>.*?<\/a>/is';

	$updated_content = preg_replace_callback(
		$pattern,
		static function ( $matches ) use ( $accessible_label ) {
			$attributes = $matches[1];

			if ( preg_match( '/class="([^"]*)"/i', $attributes, $class_match ) ) {
				$class_names = trim( $class_match[1] . ' wp-block-post-excerpt__more-link--icon carlashub-read-link--icon' );
				$attributes  = preg_replace(
					'/class="[^"]*"/i',
					'class="' . esc_attr( $class_names ) . '"',
					$attributes,
					1
				);
			}

			return sprintf(
				'<a%1$s><span class="screen-reader-text">%2$s</span><span class="carlashub-link-icon" aria-hidden="true">↗</span></a>',
				$attributes,
				esc_html( $accessible_label )
			);
		},
		$block_content,
		1
	);

	return is_string( $updated_content ) ? $updated_content : $block_content;
}
add_filter( 'render_block_core/post-excerpt', 'carlashub_v2_render_post_excerpt_more_link_icon', 10, 3 );

/**
 * Render front-page query loop cards using the shared entry-card renderer so
 * metadata, tags, badges, and stats match the theme card-grid pattern.
 *
 * @param string   $block_content Rendered block HTML.
 * @param array    $block         Parsed block data.
 * @param WP_Block $instance      Block instance.
 * @return string
 */
function carlashub_v2_render_front_page_post_template_as_entry_cards( $block_content, $block, $instance ) {
	if (
		is_admin() ||
		! is_front_page() ||
		! is_string( $block_content ) ||
		'' === trim( $block_content ) ||
		false === strpos( $block_content, 'wp-block-post' ) ||
		! class_exists( 'DOMDocument' )
	) {
		return $block_content;
	}

	$class_name = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';

	if ( '' !== $class_name && false === strpos( $class_name, 'post-cards' ) ) {
		return $block_content;
	}

	$previous_errors = libxml_use_internal_errors( true );
	$dom             = new DOMDocument( '1.0', 'UTF-8' );
	$wrapper_id      = 'carlashub-post-template-root';
	$html            = '<?xml encoding="utf-8" ?><div id="' . esc_attr( $wrapper_id ) . '">' . $block_content . '</div>';
	$loaded          = $dom->loadHTML( $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );

	if ( ! $loaded ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $block_content;
	}

	$xpath = new DOMXPath( $dom );
	$items = $xpath->query( '//li[contains(concat(" ", normalize-space(@class), " "), " wp-block-post ")]' );

	if ( ! $items instanceof DOMNodeList || 0 === $items->length ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $block_content;
	}

	foreach ( $items as $item ) {
		$item_classes = (string) $item->getAttribute( 'class' );

		if ( ! preg_match( '/\bpost-(\d+)\b/', $item_classes, $matches ) ) {
			continue;
		}

		$post_id    = (int) $matches[1];
		$card_markup = carlashub_v2_render_entry_card( $post_id, 'featured' );

		if ( '' === $card_markup ) {
			continue;
		}

		$card_dom    = new DOMDocument( '1.0', 'UTF-8' );
		$card_loaded = $card_dom->loadHTML(
			'<?xml encoding="utf-8" ?><div id="carlashub-card-root">' . $card_markup . '</div>',
			LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
		);

		if ( ! $card_loaded ) {
			continue;
		}

		$card_root = $card_dom->getElementById( 'carlashub-card-root' );

		if ( ! $card_root || ! $card_root->firstChild ) {
			continue;
		}

		$replacement_nodes = array();

		foreach ( $card_root->childNodes as $card_child ) {
			$replacement_nodes[] = $dom->importNode( $card_child, true );
		}

		if ( empty( $replacement_nodes ) ) {
			continue;
		}

		while ( $item->firstChild ) {
			$item->removeChild( $item->firstChild );
		}

		foreach ( $replacement_nodes as $replacement_node ) {
			$item->appendChild( $replacement_node );
		}
	}

	$root = $dom->getElementById( $wrapper_id );

	if ( ! $root ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $block_content;
	}

	$output = '';

	foreach ( $root->childNodes as $child ) {
		$output .= $dom->saveHTML( $child );
	}

	libxml_clear_errors();
	libxml_use_internal_errors( $previous_errors );

	return '' !== $output ? $output : $block_content;
}
add_filter( 'render_block_core/post-template', 'carlashub_v2_render_front_page_post_template_as_entry_cards', 15, 3 );

/**
 * Replace generic front-end "Read more" and "Read me" text links with icon-only
 * links while keeping an explicit screen-reader label.
 *
 * @param string $content HTML content.
 * @return string
 */
function carlashub_v2_replace_read_text_links_with_icons( $content ) {
	if ( is_admin() || ! is_string( $content ) || '' === $content || false === stripos( $content, 'read' ) ) {
		return $content;
	}

	$post_id = get_the_ID() ? (int) get_the_ID() : 0;
	$title   = $post_id ? wp_strip_all_tags( get_the_title( $post_id ) ) : '';
	$label   = $title
		? sprintf(
			/* translators: %s: post title. */
			__( 'Read article: %s', 'carlashub-v2' ),
			$title
		)
		: __( 'Read article', 'carlashub-v2' );

	$updated_content = preg_replace_callback(
		'/<a\b([^>]*)>(.*?)<\/a>/is',
		static function ( $matches ) use ( $label ) {
			$attributes = $matches[1];
			$inner_html = $matches[2];

			if ( false !== strpos( $inner_html, 'carlashub-link-icon' ) ) {
				return $matches[0];
			}

			$text = strtolower( trim( wp_strip_all_tags( $inner_html ) ) );
			$text = preg_replace( '/[[:punct:]\s]+$/u', '', $text );

			if ( ! in_array( $text, array( 'read more', 'read me', 'continue reading' ), true ) ) {
				return $matches[0];
			}

			if ( preg_match( '/class="([^"]*)"/i', $attributes, $class_match ) ) {
				$class_names = trim( $class_match[1] . ' carlashub-read-link--icon' );
				$attributes  = preg_replace(
					'/class="[^"]*"/i',
					'class="' . esc_attr( $class_names ) . '"',
					$attributes,
					1
				);
			} else {
				$attributes = trim( $attributes ) . ' class="carlashub-read-link--icon"';
			}

			return sprintf(
				'<a%1$s><span class="screen-reader-text">%2$s</span><span class="carlashub-link-icon" aria-hidden="true">↗</span></a>',
				$attributes,
				esc_html( $label )
			);
		},
		$content
	);

	return is_string( $updated_content ) ? $updated_content : $content;
}
add_filter( 'the_content', 'carlashub_v2_replace_read_text_links_with_icons', 20 );
add_filter( 'the_content_more_link', 'carlashub_v2_replace_read_text_links_with_icons', 20 );

/**
 * Return normalized paragraph text for legacy-structure detection.
 *
 * @param string $text Raw paragraph text.
 * @return string
 */
function carlashub_v2_normalize_paragraph_text( $text ) {
	$text = html_entity_decode( (string) $text, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$text = str_replace( "\xc2\xa0", ' ', $text );
	$text = preg_replace( '/\s+/u', ' ', $text );

	return trim( (string) $text );
}

/**
 * Detect whether a paragraph text should be treated as an ordered list item.
 *
 * @param string $text Paragraph text.
 * @return bool
 */
function carlashub_v2_is_ordered_list_like_paragraph( $text ) {
	return 1 === preg_match( '/^\d{1,3}\s*[\.\)-]\s+\S/u', $text );
}

/**
 * Detect whether a paragraph text should be treated as an unordered list item.
 *
 * @param string $text Paragraph text.
 * @return bool
 */
function carlashub_v2_is_unordered_list_like_paragraph( $text ) {
	return 1 === preg_match( '/^(?:[-*•])\s+\S/u', $text );
}

/**
 * Get a paragraph inner HTML string.
 *
 * @param DOMElement $paragraph Paragraph element.
 * @param DOMDocument $dom      DOM document.
 * @return string
 */
function carlashub_v2_get_paragraph_inner_html( $paragraph, $dom ) {
	$inner_html = '';

	foreach ( $paragraph->childNodes as $child_node ) {
		$inner_html .= $dom->saveHTML( $child_node );
	}

	return $inner_html;
}

/**
 * Extract the first top-level content image from rendered post content.
 *
 * Returns the extracted image markup and the remaining content without that
 * first image block so the same image is not duplicated later in the article.
 *
 * @param string $content Rendered post content HTML.
 * @return array{media_markup:string,content:string}
 */
function carlashub_v2_extract_intro_media_from_content( $content ) {
	$default = array(
		'media_markup' => '',
		'content'      => $content,
	);

	if (
		! is_string( $content ) ||
		'' === trim( $content ) ||
		false === strpos( $content, '<img' ) ||
		! class_exists( 'DOMDocument' )
	) {
		return $default;
	}

	$previous_errors = libxml_use_internal_errors( true );
	$dom             = new DOMDocument( '1.0', 'UTF-8' );
	$wrapper_id      = 'carlashub-intro-media-root';
	$loaded          = $dom->loadHTML(
		'<?xml encoding="utf-8" ?><div id="' . esc_attr( $wrapper_id ) . '">' . $content . '</div>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $loaded ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $default;
	}

	$root = $dom->getElementById( $wrapper_id );

	if ( ! $root ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $default;
	}

	$media_markup = '';
	$xpath        = new DOMXPath( $dom );
	$candidates   = $xpath->query( './/figure[.//img] | .//img[not(ancestor::figure)]', $root );

	if ( $candidates instanceof DOMNodeList ) {
		foreach ( $candidates as $candidate ) {
			if ( ! $candidate instanceof DOMElement ) {
				continue;
			}

			$tag_name = strtolower( $candidate->tagName );

			if ( 'figure' === $tag_name ) {
				$media_markup = carlashub_v2_get_paragraph_inner_html( $candidate, $dom );

				if ( $candidate->parentNode ) {
					$candidate->parentNode->removeChild( $candidate );
				}

				break;
			}

			if ( 'img' === $tag_name ) {
				$media_markup = $dom->saveHTML( $candidate );

				if ( $candidate->parentNode ) {
					$candidate->parentNode->removeChild( $candidate );
				}

				break;
			}
		}
	}

	if ( '' === $media_markup ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $default;
	}

	$updated_content = '';

	foreach ( $root->childNodes as $remaining_child ) {
		$updated_content .= $dom->saveHTML( $remaining_child );
	}

	libxml_clear_errors();
	libxml_use_internal_errors( $previous_errors );

	return array(
		'media_markup' => $media_markup,
		'content'      => '' !== $updated_content ? $updated_content : $content,
	);
}

/**
 * Inject intro media markup after the first paragraph in rendered content.
 *
 * If no paragraph exists, the media is prepended to the content.
 *
 * @param string $content      Rendered post content HTML.
 * @param string $media_markup Intro media markup.
 * @return string
 */
function carlashub_v2_inject_intro_media_after_first_paragraph( $content, $media_markup ) {
	if (
		! is_string( $content ) ||
		'' === trim( $content ) ||
		! is_string( $media_markup ) ||
		'' === trim( $media_markup ) ||
		! class_exists( 'DOMDocument' )
	) {
		return $content;
	}

	$previous_errors = libxml_use_internal_errors( true );
	$dom             = new DOMDocument( '1.0', 'UTF-8' );
	$wrapper_id      = 'carlashub-injected-intro-root';
	$loaded          = $dom->loadHTML(
		'<?xml encoding="utf-8" ?><div id="' . esc_attr( $wrapper_id ) . '">' . $content . '</div>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $loaded ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $media_markup . $content;
	}

	$root = $dom->getElementById( $wrapper_id );

	if ( ! $root ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $media_markup . $content;
	}

	$media_fragment = new DOMDocument( '1.0', 'UTF-8' );
	$media_loaded   = $media_fragment->loadHTML(
		'<?xml encoding="utf-8" ?><div id="carlashub-media-fragment-root">' . $media_markup . '</div>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $media_loaded ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $media_markup . $content;
	}

	$media_root = $media_fragment->getElementById( 'carlashub-media-fragment-root' );

	if ( ! $media_root || ! $media_root->firstChild ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $content;
	}

	$media_node = $dom->importNode( $media_root->firstChild, true );
	$xpath      = new DOMXPath( $dom );
	$paragraph  = $xpath->query( './p[1]', $root );

	if ( $paragraph instanceof DOMNodeList && $paragraph->length > 0 ) {
		$first_paragraph = $paragraph->item( 0 );

		if ( $first_paragraph && $first_paragraph->parentNode ) {
			if ( $first_paragraph->nextSibling ) {
				$first_paragraph->parentNode->insertBefore( $media_node, $first_paragraph->nextSibling );
			} else {
				$first_paragraph->parentNode->appendChild( $media_node );
			}
		}
	} else {
		if ( $root->firstChild ) {
			$root->insertBefore( $media_node, $root->firstChild );
		} else {
			$root->appendChild( $media_node );
		}
	}

	$updated_content = '';

	foreach ( $root->childNodes as $child_node ) {
		$updated_content .= $dom->saveHTML( $child_node );
	}

	libxml_clear_errors();
	libxml_use_internal_errors( $previous_errors );

	return '' !== $updated_content ? $updated_content : $content;
}

/**
 * Build a DOM element containing HTML from an inner fragment.
 *
 * @param DOMDocument $dom        Destination DOM document.
 * @param string      $tag_name   Element tag.
 * @param string      $inner_html Inner HTML.
 * @return DOMElement
 */
function carlashub_v2_build_element_with_inner_html( $dom, $tag_name, $inner_html ) {
	$element = $dom->createElement( $tag_name );

	$tmp_dom = new DOMDocument( '1.0', 'UTF-8' );
	$loaded  = $tmp_dom->loadHTML(
		'<?xml encoding="utf-8" ?><div id="carlashub-inner-root">' . $inner_html . '</div>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $loaded ) {
		$element->appendChild( $dom->createTextNode( wp_strip_all_tags( $inner_html ) ) );
		return $element;
	}

	$tmp_root = $tmp_dom->getElementById( 'carlashub-inner-root' );

	if ( ! $tmp_root ) {
		$element->appendChild( $dom->createTextNode( wp_strip_all_tags( $inner_html ) ) );
		return $element;
	}

	foreach ( $tmp_root->childNodes as $tmp_child ) {
		$element->appendChild( $dom->importNode( $tmp_child, true ) );
	}

	return $element;
}

/**
 * Check whether a DOM node is ignorable whitespace text.
 *
 * @param DOMNode $node DOM node.
 * @return bool
 */
function carlashub_v2_is_ignorable_whitespace_node( $node ) {
	if ( ! $node instanceof DOMText ) {
		return false;
	}

	$text = str_replace( "\xc2\xa0", ' ', (string) $node->textContent );

	return '' === trim( $text );
}

/**
 * Get the next sibling node that is not ignorable whitespace.
 *
 * @param DOMNode $node Starting node.
 * @return DOMNode|null
 */
function carlashub_v2_get_next_significant_sibling( $node ) {
	$cursor = $node ? $node->nextSibling : null;

	while ( $cursor && carlashub_v2_is_ignorable_whitespace_node( $cursor ) ) {
		$cursor = $cursor->nextSibling;
	}

	return $cursor;
}

/**
 * Upgrade inline markdown code spans to semantic <code> nodes.
 *
 * @param DOMElement  $root Root DOM element.
 * @param DOMDocument $dom  DOM document.
 */
function carlashub_v2_upgrade_inline_markdown_code( $root, $dom ) {
	$xpath = new DOMXPath( $dom );
	$nodes = $xpath->query( './/text()', $root );

	if ( ! $nodes instanceof DOMNodeList || 0 === $nodes->length ) {
		return;
	}

	$text_nodes = array();

	foreach ( $nodes as $node ) {
		$text_nodes[] = $node;
	}

	foreach ( $text_nodes as $text_node ) {
		if ( ! $text_node instanceof DOMText || ! $text_node->parentNode ) {
			continue;
		}

		$ancestor        = $text_node->parentNode;
		$skip_conversion = false;

		while ( $ancestor instanceof DOMNode && XML_ELEMENT_NODE === $ancestor->nodeType ) {
			$ancestor_name = strtolower( (string) $ancestor->nodeName );

			if ( in_array( $ancestor_name, array( 'code', 'pre', 'script', 'style' ), true ) ) {
				$skip_conversion = true;
				break;
			}

			$ancestor = $ancestor->parentNode;
		}

		if ( $skip_conversion ) {
			continue;
		}

		$text_value = (string) $text_node->nodeValue;

		if ( false === strpos( $text_value, '`' ) || 1 !== preg_match( '/`[^`\n]+`/u', $text_value ) ) {
			continue;
		}

		$parts = preg_split( '/(`[^`\n]+`)/u', $text_value, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

		if ( ! is_array( $parts ) || empty( $parts ) ) {
			continue;
		}

		$parent            = $text_node->parentNode;
		$has_code_fragment = false;

		foreach ( $parts as $part ) {
			if ( 1 === preg_match( '/^`([^`\n]+)`$/u', $part, $inline_match ) ) {
				$code_node = $dom->createElement( 'code' );
				$code_node->appendChild( $dom->createTextNode( $inline_match[1] ) );
				$parent->insertBefore( $code_node, $text_node );
				$has_code_fragment = true;
			} else {
				$parent->insertBefore( $dom->createTextNode( $part ), $text_node );
			}
		}

		if ( $has_code_fragment ) {
			$parent->removeChild( $text_node );
		}
	}
}

/**
 * Convert markdown-like paragraph markers into semantic block elements.
 *
 * @param DOMElement  $root Root DOM element.
 * @param DOMDocument $dom  DOM document.
 */
function carlashub_v2_upgrade_legacy_block_semantics( $root, $dom ) {
	$blocked_ancestors = array( 'pre', 'code', 'li', 'blockquote', 'figcaption', 'td', 'th', 'script', 'style' );

	foreach ( iterator_to_array( $root->childNodes ) as $child ) {
		if ( ! $child instanceof DOMElement ) {
			continue;
		}

		if ( in_array( strtolower( $child->tagName ), $blocked_ancestors, true ) ) {
			continue;
		}

		carlashub_v2_upgrade_legacy_block_semantics( $child, $dom );
	}

	$child = $root->firstChild;

	while ( $child ) {
		$next_sibling = $child->nextSibling;

		if ( ! $child instanceof DOMElement || 'p' !== strtolower( $child->tagName ) ) {
			$child = $next_sibling;
			continue;
		}

		$normalized_text = carlashub_v2_normalize_paragraph_text( $child->textContent );
		$inner_html      = carlashub_v2_get_paragraph_inner_html( $child, $dom );
		$image_count     = $child->getElementsByTagName( 'img' )->length;
		$iframe_count    = $child->getElementsByTagName( 'iframe' )->length;

		if ( '' === $normalized_text && ! $image_count && ! $iframe_count ) {
			$root->removeChild( $child );
			$child = $next_sibling;
			continue;
		}

		$image_text_without_punctuation = preg_replace( '/[\p{P}\p{Z}\p{C}]+/u', '', $normalized_text );

		if ( $image_count > 0 && 0 === $iframe_count && '' === (string) $image_text_without_punctuation ) {
			$figure = $dom->createElement( 'figure' );
			$figure->setAttribute( 'class', 'wp-block-image' );

			foreach ( iterator_to_array( $child->childNodes ) as $image_child ) {
				if (
					$image_child instanceof DOMText &&
					'' === preg_replace( '/[\p{P}\p{Z}\p{C}]+/u', '', carlashub_v2_normalize_paragraph_text( $image_child->textContent ) )
				) {
					continue;
				}

				$figure->appendChild( $dom->importNode( $image_child, true ) );
			}

			$root->replaceChild( $figure, $child );
			$child = $next_sibling;
			continue;
		}

		if ( 1 === preg_match( '/^\*\*(.+?)\*\*$/u', $normalized_text, $strong_match ) ) {
			$paragraph = $dom->createElement( 'p' );
			$strong    = $dom->createElement( 'strong', $strong_match[1] );
			$paragraph->appendChild( $strong );
			$root->replaceChild( $paragraph, $child );
			$child = $next_sibling;
			continue;
		}

		if ( 1 === preg_match( '/^\*\*(\S.*)$/u', $normalized_text, $strong_open_match ) ) {
			$paragraph = $dom->createElement( 'p' );
			$strong    = $dom->createElement( 'strong', $strong_open_match[1] );
			$paragraph->appendChild( $strong );
			$root->replaceChild( $paragraph, $child );
			$child = $next_sibling;
			continue;
		}

		if ( 1 === preg_match( '/^(#{1,6})\s+(\S.*)$/u', $normalized_text, $heading_match ) ) {
			$level         = min( 6, max( 1, strlen( (string) $heading_match[1] ) ) );
			$cleaned_inner = preg_replace( '/^\s*#{1,6}\s+/u', '', $inner_html, 1 );
			$heading       = carlashub_v2_build_element_with_inner_html( $dom, 'h' . $level, (string) $cleaned_inner );
			$root->replaceChild( $heading, $child );
			$child = $next_sibling;
			continue;
		}

		if ( 1 === preg_match( '/^-{3,}$/u', $normalized_text ) ) {
			$rule = $dom->createElement( 'hr' );
			$root->replaceChild( $rule, $child );
			$child = $next_sibling;
			continue;
		}

		if ( 1 === preg_match( '/^>\s+(\S.*)$/u', $normalized_text ) ) {
			$cleaned_inner = preg_replace( '/^\s*>\s+/u', '', $inner_html, 1 );
			$quote         = $dom->createElement( 'blockquote' );
			$quote->appendChild( carlashub_v2_build_element_with_inner_html( $dom, 'p', (string) $cleaned_inner ) );
			$root->replaceChild( $quote, $child );
			$child = $next_sibling;
			continue;
		}

		if ( 1 === preg_match( '/^```(?:\s*([A-Za-z0-9_-]+))?\s*$/u', $normalized_text, $fence_start_match ) ) {
			$language    = isset( $fence_start_match[1] ) ? trim( (string) $fence_start_match[1] ) : '';
			$code_lines  = array();
			$fence_nodes = array( $child );
			$cursor      = carlashub_v2_get_next_significant_sibling( $child );
			$closed      = false;

			while ( $cursor instanceof DOMElement && 'p' === strtolower( $cursor->tagName ) ) {
				$cursor_text = carlashub_v2_normalize_paragraph_text( $cursor->textContent );
				$fence_nodes[] = $cursor;

				if ( 1 === preg_match( '/^```\s*$/u', $cursor_text ) ) {
					$closed = true;
					break;
				}

				$code_lines[] = trim( (string) $cursor->textContent, "\r\n" );
				$cursor       = carlashub_v2_get_next_significant_sibling( $cursor );
			}

			if ( $closed ) {
				$pre  = $dom->createElement( 'pre' );
				$code = $dom->createElement( 'code' );

				if ( '' !== $language ) {
					$code->setAttribute( 'class', 'language-' . strtolower( preg_replace( '/[^A-Za-z0-9_-]/', '', $language ) ) );
				}

				$code->appendChild( $dom->createTextNode( implode( "\n", $code_lines ) ) );
				$pre->appendChild( $code );
				$root->insertBefore( $pre, $child );

				foreach ( $fence_nodes as $fence_node ) {
					if ( $fence_node->parentNode === $root ) {
						$root->removeChild( $fence_node );
					}
				}

				$child = $pre->nextSibling;
				continue;
			}
		}

		$list_type = '';

		if ( carlashub_v2_is_ordered_list_like_paragraph( $normalized_text ) ) {
			$list_type = 'ol';
		} elseif ( carlashub_v2_is_unordered_list_like_paragraph( $normalized_text ) ) {
			$list_type = 'ul';
		}

		if ( '' === $list_type ) {
			$child = $next_sibling;
			continue;
		}

		$sequence = array();
		$cursor   = $child;

		while ( $cursor instanceof DOMElement && 'p' === strtolower( $cursor->tagName ) ) {
			$cursor_text = carlashub_v2_normalize_paragraph_text( $cursor->textContent );

			if (
				( 'ol' === $list_type && ! carlashub_v2_is_ordered_list_like_paragraph( $cursor_text ) ) ||
				( 'ul' === $list_type && ! carlashub_v2_is_unordered_list_like_paragraph( $cursor_text ) )
			) {
				break;
			}

			$sequence[] = $cursor;
			$cursor     = carlashub_v2_get_next_significant_sibling( $cursor );
		}

		$list = $dom->createElement( $list_type );

		if ( 'ol' === $list_type ) {
			$first_item_text = carlashub_v2_normalize_paragraph_text( $sequence[0]->textContent );
			$start_matches   = array();

			if ( 1 === preg_match( '/^(\d{1,3})\s*[\.\)-]\s+\S/u', $first_item_text, $start_matches ) ) {
				$start_value = (int) $start_matches[1];

				if ( $start_value > 1 ) {
					$list->setAttribute( 'start', (string) $start_value );
				}
			}
		}

		$root->insertBefore( $list, $child );

		foreach ( $sequence as $paragraph_node ) {
			$item_inner_html = carlashub_v2_get_paragraph_inner_html( $paragraph_node, $dom );

			if ( 'ol' === $list_type ) {
				$item_inner_html = preg_replace( '/^\s*\d{1,3}\s*[\.\)-]\s+/u', '', $item_inner_html, 1 );
			} else {
				$item_inner_html = preg_replace( '/^\s*(?:[-*•])\s+/u', '', $item_inner_html, 1 );
			}

			$list_item = carlashub_v2_build_element_with_inner_html( $dom, 'li', (string) $item_inner_html );
			$list->appendChild( $list_item );
			$root->removeChild( $paragraph_node );
		}

		$child = $list->nextSibling;
	}
}

/**
 * Convert legacy paragraph-only structures into semantic blocks at render time.
 *
 * This preserves post text while upgrading markdown-like lines and faux list
 * paragraphs into real heading/list/blockquote/hr markup.
 *
 * @param string $content Post content HTML.
 * @return string
 */
function carlashub_v2_upgrade_legacy_post_content_semantics( $content ) {
	if (
		is_admin() ||
		! is_string( $content ) ||
		'' === trim( $content ) ||
		false === strpos( $content, '<p' ) ||
		! class_exists( 'DOMDocument' )
	) {
		return $content;
	}

	$previous_errors = libxml_use_internal_errors( true );
	$dom             = new DOMDocument( '1.0', 'UTF-8' );
	$wrapper_id      = 'carlashub-content-root';
	$loaded          = $dom->loadHTML(
		'<?xml encoding="utf-8" ?><div id="' . esc_attr( $wrapper_id ) . '">' . $content . '</div>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);

	if ( ! $loaded ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $content;
	}

	$root = $dom->getElementById( $wrapper_id );

	if ( ! $root ) {
		libxml_clear_errors();
		libxml_use_internal_errors( $previous_errors );
		return $content;
	}

	carlashub_v2_upgrade_legacy_block_semantics( $root, $dom );
	carlashub_v2_upgrade_inline_markdown_code( $root, $dom );

	$output = '';

	foreach ( $root->childNodes as $child_node ) {
		$output .= $dom->saveHTML( $child_node );
	}

	libxml_clear_errors();
	libxml_use_internal_errors( $previous_errors );

	return '' !== $output ? $output : $content;
}
add_filter( 'the_content', 'carlashub_v2_upgrade_legacy_post_content_semantics', 12 );

/**
 * Normalize heading order in single-post content when legacy content starts at
 * h3 without any h2 sections.
 *
 * @param string $content Post content HTML.
 * @return string
 */
function carlashub_v2_normalize_single_post_heading_order( $content ) {
	if (
		is_admin() ||
		! is_singular( 'post' ) ||
		! is_string( $content ) ||
		'' === trim( $content )
	) {
		return $content;
	}

	$matches = array();
	preg_match_all( '/<h([2-6])\b/i', $content, $matches );

	if ( empty( $matches[1] ) || ! is_array( $matches[1] ) ) {
		return $content;
	}

	$levels = array_map( 'intval', $matches[1] );

	if ( in_array( 2, $levels, true ) || ! in_array( 3, $levels, true ) ) {
		return $content;
	}

	$updated_content = preg_replace_callback(
		'/<\s*(\/?)\s*h3\b([^>]*)>/i',
		static function ( $heading_match ) {
			$is_closing = ! empty( $heading_match[1] );

			if ( $is_closing ) {
				return '</h2>';
			}

			$attributes = isset( $heading_match[2] ) ? (string) $heading_match[2] : '';

			return '<h2' . $attributes . '>';
		},
		$content
	);

	return is_string( $updated_content ) ? $updated_content : $content;
}
add_filter( 'the_content', 'carlashub_v2_normalize_single_post_heading_order', 30 );

/**
 * Add useful body classes.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function carlashub_v2_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-hub-home';
	}

	if ( is_singular() ) {
		$classes[] = 'is-document-view';
	}

	if ( is_home() || is_archive() || is_search() ) {
		$classes[] = 'is-index-view';
	}

	return $classes;
}
add_filter( 'body_class', 'carlashub_v2_body_classes' );

/**
 * Return initials for the current site title.
 *
 * @return string
 */
function carlashub_v2_get_site_initials() {
	$name  = carlashub_v2_get_site_name();
	$parts = preg_split( '/\s+/', trim( $name ) );
	$parts = array_filter( $parts );

	if ( empty( $parts ) ) {
		return 'CH';
	}

	$initials = '';

	foreach ( array_slice( array_values( $parts ), 0, 2 ) as $part ) {
		$initials .= function_exists( 'mb_substr' ) ? mb_substr( $part, 0, 1 ) : substr( $part, 0, 1 );
	}

	return strtoupper( $initials );
}

/**
 * Get a safe site name fallback.
 *
 * @return string
 */
function carlashub_v2_get_site_name() {
	$name = trim( wp_strip_all_tags( get_bloginfo( 'name' ) ) );

	if ( $name ) {
		return $name;
	}

	return 'CarlasHub';
}

/**
 * Get a safe site description fallback.
 *
 * @return string
 */
function carlashub_v2_get_site_description() {
	$description = trim( get_bloginfo( 'description' ) );

	if ( $description ) {
		return $description;
	}

	return __( 'Mostly things I work on, test, fix, or think about.', 'carlashub-v2' );
}

/**
 * Get the contact email address used for visitor enquiries.
 *
 * @return string
 */
function carlashub_v2_get_contact_email() {
	$email = apply_filters( 'carlashub_v2_contact_email', get_option( 'admin_email' ) );
	$email = sanitize_email( trim( (string) $email ) );

	if ( ! $email || ! is_email( $email ) ) {
		return '';
	}

	return $email;
}

/**
 * Get the mailto URL for the configured contact email address.
 *
 * @return string
 */
function carlashub_v2_get_contact_mailto_url() {
	$email = carlashub_v2_get_contact_email();

	if ( ! $email ) {
		return '';
	}

	return 'mailto:' . rawurlencode( $email );
}

/**
 * Keep document titles usable when the site title option is blank.
 *
 * @param array<string,string> $parts Title parts.
 * @return array<string,string>
 */
function carlashub_v2_document_title_parts( $parts ) {
	$parts['site'] = carlashub_v2_get_site_name();

	return $parts;
}
add_filter( 'document_title_parts', 'carlashub_v2_document_title_parts' );

/**
 * Get overall site metrics for the hero and footer.
 *
 * @return array<string,int>
 */
function carlashub_v2_get_site_metrics() {
	$posts = wp_count_posts( 'post' );
	$pages = wp_count_posts( 'page' );

	return array(
		'posts'      => isset( $posts->publish ) ? (int) $posts->publish : 0,
		'pages'      => isset( $pages->publish ) ? (int) $pages->publish : 0,
		'categories' => (int) wp_count_terms(
			array(
				'taxonomy'   => 'category',
				'hide_empty' => true,
			)
		),
		'comments'   => (int) wp_count_comments()->approved,
	);
}

/**
 * Get the GitHub username used for the front-page WIP feed.
 *
 * @return string
 */
function carlashub_v2_get_github_wip_username() {
	$username = apply_filters( 'carlashub_v2_github_wip_username', 'CarlasHub' );
	$username = trim( (string) $username );
	$username = (string) preg_replace( '/[^A-Za-z0-9-]/', '', $username );

	return '' !== $username ? $username : 'CarlasHub';
}

/**
 * Map a GitHub event payload into a WIP feed entry.
 *
 * @param array<string,mixed> $event GitHub event payload.
 * @return array<string,mixed>|null
 */
function carlashub_v2_map_github_event_to_wip_item( $event ) {
	if (
		empty( $event['type'] ) ||
		empty( $event['repo'] ) ||
		! is_array( $event['repo'] ) ||
		empty( $event['repo']['name'] )
	) {
		return null;
	}

	$type        = (string) $event['type'];
	$repo_name   = (string) $event['repo']['name'];
	$repo_url    = 'https://github.com/' . $repo_name;
	$payload     = ( ! empty( $event['payload'] ) && is_array( $event['payload'] ) ) ? $event['payload'] : array();
	$created_raw = ! empty( $event['created_at'] ) ? (string) $event['created_at'] : '';
	$timestamp   = strtotime( $created_raw );

	if ( ! $timestamp ) {
		$timestamp = (int) current_time( 'timestamp', true );
	}

	$item = array(
		'repo_name'  => $repo_name,
		'repo_url'   => $repo_url,
		'url'        => $repo_url,
		'title'      => '',
		'summary'    => '',
		'created_at' => gmdate( DATE_W3C, $timestamp ),
		'timestamp'  => $timestamp,
	);

	switch ( $type ) {
		case 'PushEvent':
			$commit_count = isset( $payload['size'] ) ? (int) $payload['size'] : 0;
			$commit_count = $commit_count > 0 ? $commit_count : ( isset( $payload['commits'] ) && is_array( $payload['commits'] ) ? count( $payload['commits'] ) : 0 );
			$commit_count = max( 1, $commit_count );
			$branch       = isset( $payload['ref'] ) ? str_replace( 'refs/heads/', '', (string) $payload['ref'] ) : '';
			$first_commit = '';

			if ( ! empty( $payload['commits'][0]['message'] ) ) {
				$first_commit = wp_trim_words( wp_strip_all_tags( (string) $payload['commits'][0]['message'] ), 14 );
			}

			$item['title'] = sprintf(
				/* translators: 1: commit count, 2: repository name. */
				_n( 'Pushed %1$d commit to %2$s', 'Pushed %1$d commits to %2$s', $commit_count, 'carlashub-v2' ),
				$commit_count,
				$repo_name
			);

			if ( $branch && $first_commit ) {
				$item['summary'] = sprintf(
					/* translators: 1: branch name, 2: commit message. */
					__( 'Branch %1$s · %2$s', 'carlashub-v2' ),
					$branch,
					$first_commit
				);
			} elseif ( $branch ) {
				$item['summary'] = sprintf(
					/* translators: %s: branch name. */
					__( 'Branch %s', 'carlashub-v2' ),
					$branch
				);
			} elseif ( $first_commit ) {
				$item['summary'] = $first_commit;
			}
			break;

		case 'PullRequestEvent':
			$action = isset( $payload['action'] ) ? (string) $payload['action'] : '';

			if ( ! in_array( $action, array( 'opened', 'reopened', 'synchronize' ), true ) ) {
				return null;
			}

			$pr_title = ! empty( $payload['pull_request']['title'] ) ? (string) $payload['pull_request']['title'] : __( 'Pull request update', 'carlashub-v2' );

			if ( ! empty( $payload['pull_request']['html_url'] ) ) {
				$item['url'] = (string) $payload['pull_request']['html_url'];
			}

			$item['title'] = sprintf(
				/* translators: 1: pull request action, 2: pull request title. */
				__( 'Pull request %1$s: %2$s', 'carlashub-v2' ),
				$action,
				$pr_title
			);

			if ( ! empty( $payload['pull_request']['head']['ref'] ) ) {
				$item['summary'] = sprintf(
					/* translators: %s: branch name. */
					__( 'Head branch: %s', 'carlashub-v2' ),
					(string) $payload['pull_request']['head']['ref']
				);
			}
			break;

		case 'IssuesEvent':
			$action = isset( $payload['action'] ) ? (string) $payload['action'] : '';

			if ( ! in_array( $action, array( 'opened', 'reopened' ), true ) ) {
				return null;
			}

			$issue_title = ! empty( $payload['issue']['title'] ) ? (string) $payload['issue']['title'] : __( 'Issue update', 'carlashub-v2' );

			if ( ! empty( $payload['issue']['html_url'] ) ) {
				$item['url'] = (string) $payload['issue']['html_url'];
			}

			$item['title'] = sprintf(
				/* translators: 1: issue action, 2: issue title. */
				__( 'Issue %1$s: %2$s', 'carlashub-v2' ),
				$action,
				$issue_title
			);
			break;

		case 'IssueCommentEvent':
			$action = isset( $payload['action'] ) ? (string) $payload['action'] : '';

			if ( 'created' !== $action ) {
				return null;
			}

			$issue_title = ! empty( $payload['issue']['title'] ) ? (string) $payload['issue']['title'] : __( 'Issue discussion updated', 'carlashub-v2' );

			if ( ! empty( $payload['comment']['html_url'] ) ) {
				$item['url'] = (string) $payload['comment']['html_url'];
			}

			$item['title'] = sprintf(
				/* translators: %s: issue title. */
				__( 'Commented on: %s', 'carlashub-v2' ),
				$issue_title
			);
			break;

		case 'CreateEvent':
			$ref_type = isset( $payload['ref_type'] ) ? (string) $payload['ref_type'] : '';
			$ref_name = isset( $payload['ref'] ) ? (string) $payload['ref'] : '';

			if ( ! in_array( $ref_type, array( 'branch', 'repository' ), true ) ) {
				return null;
			}

			if ( 'branch' === $ref_type && '' !== $ref_name ) {
				$item['title'] = sprintf(
					/* translators: 1: branch name, 2: repository name. */
					__( 'Created branch %1$s in %2$s', 'carlashub-v2' ),
					$ref_name,
					$repo_name
				);
			} else {
				$item['title'] = sprintf(
					/* translators: %s: repository name. */
					__( 'Created repository %s', 'carlashub-v2' ),
					$repo_name
				);
			}
			break;

		default:
			return null;
	}

	return $item;
}

/**
 * Get GitHub work-in-progress feed items.
 *
 * @param int $limit Maximum items to return.
 * @return array<int,array<string,mixed>>
 */
function carlashub_v2_get_github_wip_feed_items( $limit = 6 ) {
	$limit         = max( 1, min( 12, (int) $limit ) );
	$username      = carlashub_v2_get_github_wip_username();
	$transient_key = 'carlashub_v2_github_wip_' . strtolower( $username );
	$cached_items  = get_transient( $transient_key );

	if ( is_array( $cached_items ) ) {
		return array_slice( $cached_items, 0, $limit );
	}

	$response = wp_remote_get(
		'https://api.github.com/users/' . rawurlencode( $username ) . '/events/public?per_page=30',
		array(
			'timeout' => 8,
			'headers' => array(
				'Accept'     => 'application/vnd.github+json',
				'User-Agent' => 'CarlasHub-V2/' . CARLASHUB_V2_VERSION,
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		set_transient( $transient_key, array(), 5 * MINUTE_IN_SECONDS );
		return array();
	}

	$status_code = (int) wp_remote_retrieve_response_code( $response );
	$body        = wp_remote_retrieve_body( $response );
	$events      = json_decode( $body, true );

	if ( 200 !== $status_code || ! is_array( $events ) ) {
		set_transient( $transient_key, array(), 5 * MINUTE_IN_SECONDS );
		return array();
	}

	$items = array();

	foreach ( $events as $event ) {
		if ( ! is_array( $event ) ) {
			continue;
		}

		$item = carlashub_v2_map_github_event_to_wip_item( $event );

		if ( ! $item ) {
			continue;
		}

		$items[] = $item;

		if ( count( $items ) >= 20 ) {
			break;
		}
	}

	set_transient( $transient_key, $items, 15 * MINUTE_IN_SECONDS );

	return array_slice( $items, 0, $limit );
}

/**
 * Get default hero configuration values.
 *
 * @return array<string,mixed>
 */
function carlashub_v2_get_default_hero_config() {
	$metrics = carlashub_v2_get_site_metrics();

	return array(
		'mark_image_id'     => 0,
		'mark_text'         => carlashub_v2_get_site_initials(),
		'eyebrow'           => __( 'Carla Goncalves', 'carlashub-v2' ),
		'title'             => carlashub_v2_get_site_name(),
		'lede'              => carlashub_v2_get_site_description(),
		'support'           => __( 'Web Developement x A11Y x Design x AI x Tools', 'carlashub-v2' ),
		'primary_label'     => __( 'Recent posts', 'carlashub-v2' ),
		'primary_url'       => carlashub_v2_get_blog_url(),
		'secondary_label'   => __( 'Pinned posts', 'carlashub-v2' ),
		'secondary_url'     => '#featured',
		'metric_1_value'    => number_format_i18n( $metrics['posts'] ),
		'metric_1_label'    => __( 'Articles', 'carlashub-v2' ),
		'metric_2_value'    => number_format_i18n( $metrics['categories'] ),
		'metric_2_label'    => __( 'Topics', 'carlashub-v2' ),
		'metric_3_value'    => number_format_i18n( $metrics['pages'] ),
		'metric_3_label'    => __( 'Pages', 'carlashub-v2' ),
		'status_eyebrow'    => __( 'ON THIS SITE', 'carlashub-v2' ),
		'status_1_label'    => __( 'LATEST POSTS', 'carlashub-v2' ),
		'status_1_value'    => __( 'New posts, project notes, and the longer write-ups when they are worth doing.', 'carlashub-v2' ),
		'status_2_label'    => __( 'WHAT I WRITE ABOUT', 'carlashub-v2' ),
		'status_2_value'    => __( 'Mostly accessibility, front-end work, WordPress, and the decisions that shape the finished result.', 'carlashub-v2' ),
		'status_3_label'    => __( 'START HERE', 'carlashub-v2' ),
		'status_3_value'    => __( 'Start with the recent posts, then follow a topic if you want more.', 'carlashub-v2' ),
	);
}

/**
 * Merge hero widget overrides with dynamic defaults.
 *
 * @param array<string,mixed> $overrides Hero overrides.
 * @return array<string,mixed>
 */
function carlashub_v2_get_hero_config( $overrides = array() ) {
	$defaults = carlashub_v2_get_default_hero_config();
	$config   = $defaults;

	foreach ( $defaults as $key => $default_value ) {
		if ( 'mark_image_id' === $key ) {
			if ( ! empty( $overrides[ $key ] ) ) {
				$config[ $key ] = (int) $overrides[ $key ];
			}

			continue;
		}

		if ( isset( $overrides[ $key ] ) && '' !== trim( (string) $overrides[ $key ] ) ) {
			$config[ $key ] = (string) $overrides[ $key ];
		}
	}

	return $config;
}

/**
 * Get the shared profile portrait image markup.
 *
 * @param string $class_name Image class name.
 * @param string $alt_text   Image alt text.
 * @return string
 */
function carlashub_v2_get_profile_portrait_markup( $class_name, $alt_text = '' ) {
	$relative_path = 'assets/images/carla-portofolio.png';
	$absolute_path = get_theme_file_path( $relative_path );

	if ( ! file_exists( $absolute_path ) ) {
		return '';
	}

	return sprintf(
		'<img class="%1$s" src="%2$s" alt="%3$s" loading="lazy" decoding="async">',
		esc_attr( $class_name ),
		esc_url( get_theme_file_uri( $relative_path ) ),
		esc_attr( $alt_text )
	);
}

/**
 * Render the front-page hero section.
 *
 * @param array<string,mixed> $overrides Hero overrides.
 * @return string
 */
function carlashub_v2_render_hub_hero( $overrides = array() ) {
	$config      = carlashub_v2_get_hero_config( $overrides );
	$mark_image  = '';
	$mark_class  = 'hero-identity__mark';
	$metrics     = array(
		array(
			'value' => $config['metric_1_value'],
			'label' => $config['metric_1_label'],
		),
		array(
			'value' => $config['metric_2_value'],
			'label' => $config['metric_2_label'],
		),
		array(
			'value' => $config['metric_3_value'],
			'label' => $config['metric_3_label'],
		),
	);
	$statuses    = array(
		array(
			'label' => $config['status_1_label'],
			'value' => $config['status_1_value'],
		),
		array(
			'label' => $config['status_2_label'],
			'value' => $config['status_2_value'],
		),
		array(
			'label' => $config['status_3_label'],
			'value' => $config['status_3_value'],
		),
	);

	$mark_image = carlashub_v2_get_profile_portrait_markup( 'hero-identity__mark-image', '' );

	if ( $mark_image ) {
		$mark_class .= ' hero-identity__mark--image';
	}

	ob_start();
	?>
	<section class="hub-hero">
		<div class="panel hub-hero__identity">
			<div class="hero-identity">
				<div class="<?php echo esc_attr( $mark_class ); ?>">
					<?php echo $mark_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div>
					<p class="eyebrow"><?php echo esc_html( $config['eyebrow'] ); ?></p>
					<h1 class="screen-reader-text"><?php echo esc_html( $config['title'] ); ?></h1>
					<p class="hero-identity__lede"><?php echo esc_html( $config['lede'] ); ?></p>
					<?php if ( ! empty( $config['support'] ) ) : ?>
						<p class="hero-identity__support"><?php echo esc_html( $config['support'] ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="hero-actions">
				<a class="button" href="<?php echo esc_url( $config['primary_url'] ); ?>"><?php echo esc_html( $config['primary_label'] ); ?></a>
				<a class="button button--ghost" href="<?php echo esc_url( $config['secondary_url'] ); ?>"><?php echo esc_html( $config['secondary_label'] ); ?></a>
			</div>

			<div class="meta-row">
				<?php foreach ( $metrics as $metric ) : ?>
					<span class="meta-pill"><strong><?php echo esc_html( $metric['value'] ); ?></strong>&nbsp;<?php echo esc_html( $metric['label'] ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="panel hub-hero__status">
			<p class="eyebrow"><?php echo esc_html( $config['status_eyebrow'] ); ?></p>
			<ul class="hub-status-list">
				<?php foreach ( $statuses as $status ) : ?>
					<li>
						<p class="status-label"><?php echo esc_html( $status['label'] ); ?></p>
						<p class="status-value"><?php echo esc_html( $status['value'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php

	return (string) ob_get_clean();
}

/**
 * Get the posts index URL.
 *
 * @return string
 */
function carlashub_v2_get_blog_url() {
	$posts_page_id = (int) get_option( 'page_for_posts' );

	if ( $posts_page_id ) {
		return get_permalink( $posts_page_id );
	}

	if ( 'posts' === get_option( 'show_on_front' ) ) {
		return home_url( '/' );
	}

	return get_post_type_archive_link( 'post' ) ? get_post_type_archive_link( 'post' ) : home_url( '/' );
}

/**
 * Get the newest published post.
 *
 * @return WP_Post|null
 */
function carlashub_v2_get_latest_post() {
	$posts = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 1,
			'ignore_sticky_posts' => true,
		)
	);

	return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Get pinned posts with sticky-first ordering.
 *
 * @param int $limit Maximum number of posts to return.
 * @return WP_Post[]
 */
function carlashub_v2_get_pinned_posts( $limit = 4 ) {
	$limit        = max( 1, (int) $limit );
	$sticky_ids   = array_map( 'intval', (array) get_option( 'sticky_posts' ) );
	$collected    = array();
	$collected_ids = array();

	if ( ! empty( $sticky_ids ) ) {
		$sticky_posts = get_posts(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'post__in'            => $sticky_ids,
				'orderby'             => 'post__in',
				'posts_per_page'      => $limit,
				'ignore_sticky_posts' => false,
			)
		);

		foreach ( $sticky_posts as $sticky_post ) {
			$collected[]     = $sticky_post;
			$collected_ids[] = (int) $sticky_post->ID;
		}
	}

	if ( count( $collected ) < $limit ) {
		$recent_posts = get_posts(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => $limit - count( $collected ),
				'post__not_in'        => $collected_ids,
				'ignore_sticky_posts' => true,
			)
		);

		foreach ( $recent_posts as $recent_post ) {
			$collected[] = $recent_post;
		}
	}

	return array_slice( $collected, 0, $limit );
}

/**
 * Estimate reading time in minutes.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function carlashub_v2_get_read_time( $post_id ) {
	$content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
	$words   = str_word_count( $content );

	return max( 1, (int) ceil( $words / 220 ) );
}

/**
 * Get an excerpt trimmed for cards.
 *
 * @param WP_Post|int $post Post object or ID.
 * @param int         $length Approximate word count.
 * @return string
 */
function carlashub_v2_get_card_excerpt( $post, $length = 28 ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$text = has_excerpt( $post ) ? $post->post_excerpt : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );

	return wp_trim_words( trim( $text ), $length );
}

/**
 * Get thumbnail markup for a card using featured media first, then first inline image.
 *
 * @param WP_Post|int $post Post object or ID.
 * @param string      $size Image size for featured media.
 * @return string
 */
function carlashub_v2_get_card_thumbnail_markup( $post, $size = 'large' ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	if ( has_post_thumbnail( $post->ID ) ) {
		return get_the_post_thumbnail(
			$post->ID,
			$size,
			array(
				'class'    => 'entry-card__thumbnail-image',
				'alt'      => '',
				'loading'  => 'lazy',
				'decoding' => 'async',
			)
		);
	}

	$content = (string) $post->post_content;

	if ( '' === trim( $content ) || false === stripos( $content, '<img' ) ) {
		return '';
	}

	if ( preg_match( '/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches ) ) {
		$image_src = esc_url( $matches[1] );

		if ( $image_src ) {
			return sprintf(
				'<img class="entry-card__thumbnail-image" src="%1$s" alt="" loading="lazy" decoding="async">',
				$image_src
			);
		}
	}

	return '';
}

/**
 * Get a path-like label for cards and headers.
 *
 * @param WP_Post|int $post Post object or ID.
 * @return string
 */
function carlashub_v2_get_entry_path_label( $post ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$prefix = 'post' === $post->post_type ? __( 'journal', 'carlashub-v2' ) : __( 'page', 'carlashub-v2' );
	$slug   = sanitize_title( $post->post_name ? $post->post_name : $post->post_title );

	return sprintf( '%1$s / %2$s', $prefix, $slug );
}

/**
 * Render taxonomy chips for a post.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function carlashub_v2_get_taxonomy_chips( $post_id ) {
	$terms = get_the_terms( $post_id, 'category' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return '';
	}

	$output = '<div class="entry-taxonomy">';

	foreach ( array_slice( $terms, 0, 3 ) as $term ) {
		$output .= sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( get_term_link( $term ) ),
			esc_html( $term->name )
		);
	}

	$output .= '</div>';

	return $output;
}

/**
 * Get a context-aware archive support line.
 *
 * @return string
 */
function carlashub_v2_get_archive_support_text() {
	if ( is_category() ) {
		return __( 'Posts in this topic.', 'carlashub-v2' );
	}

	if ( is_tag() ) {
		return __( 'Posts with this tag.', 'carlashub-v2' );
	}

	if ( is_author() ) {
		return __( 'Posts by this author.', 'carlashub-v2' );
	}

	if ( is_post_type_archive() ) {
		return __( 'Browse the full archive.', 'carlashub-v2' );
	}

	return __( 'Posts in this archive.', 'carlashub-v2' );
}

/**
 * Build article share links.
 *
 * @param int $post_id Post ID.
 * @return array<int,array<string,string>>
 */
function carlashub_v2_get_article_share_links( $post_id ) {
	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	if ( ! $post || 'post' !== $post->post_type ) {
		return array();
	}

	$permalink = get_permalink( $post );
	$title     = get_the_title( $post );

	if ( ! $permalink || ! $title ) {
		return array();
	}

	$encoded_permalink = rawurlencode( $permalink );
	$encoded_title     = rawurlencode( $title );

	return array(
		array(
			'label' => __( 'X', 'carlashub-v2' ),
			'icon'  => 'x',
			'url'   => 'https://twitter.com/intent/tweet?url=' . $encoded_permalink . '&text=' . $encoded_title,
		),
		array(
			'label' => __( 'LinkedIn', 'carlashub-v2' ),
			'icon'  => 'linkedin',
			'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_permalink,
		),
		array(
			'label' => __( 'Facebook', 'carlashub-v2' ),
			'icon'  => 'facebook',
			'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_permalink,
		),
		array(
			'label' => __( 'GitHub', 'carlashub-v2' ),
			'icon'  => 'github',
			'url'   => 'https://github.com/CarlasHub',
		),
	);
}

/**
 * Return inline SVG markup for share link icons.
 *
 * @param string $icon_key Icon key.
 * @return string
 */
function carlashub_v2_get_share_icon_svg( $icon_key ) {
	$icons = array(
		'x'        => '<svg class="share-links__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M18.2 3h2.95l-6.45 7.37L22.29 21h-5.95l-4.66-6.1L6.34 21H3.39l6.9-7.89L2 3h6.1l4.21 5.56L18.2 3Zm-1.03 16.24h1.63L7.22 4.67H5.48l11.69 14.57Z"/></svg>',
		'linkedin' => '<svg class="share-links__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M4.98 3.5C4.98 4.88 3.87 6 2.49 6S0 4.88 0 3.5 1.11 1 2.49 1s2.49 1.12 2.49 2.5ZM.46 8h4.07v13H.46V8ZM8 8h3.9v1.78h.06c.54-1.02 1.86-2.09 3.83-2.09 4.1 0 4.86 2.7 4.86 6.21V21h-4.07v-6.35c0-1.52-.03-3.47-2.11-3.47-2.11 0-2.44 1.65-2.44 3.36V21H8V8Z"/></svg>',
		'facebook' => '<svg class="share-links__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13.5 21v-8.2h2.75l.41-3.2H13.5V7.56c0-.93.26-1.56 1.59-1.56h1.7V3.14c-.29-.04-1.29-.13-2.45-.13-2.42 0-4.08 1.48-4.08 4.2v2.35H7.5v3.2h2.76V21h3.24Z"/></svg>',
		'github'   => '<svg class="share-links__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 .5A11.5 11.5 0 0 0 .5 12.25c0 5.13 3.29 9.48 7.86 11.01.58.11.79-.26.79-.58v-2.06c-3.2.72-3.88-1.4-3.88-1.4-.53-1.37-1.3-1.73-1.3-1.73-1.06-.74.08-.72.08-.72 1.17.09 1.79 1.23 1.79 1.23 1.05 1.83 2.75 1.3 3.42.99.11-.77.41-1.3.74-1.6-2.56-.3-5.25-1.3-5.25-5.77 0-1.28.45-2.33 1.19-3.15-.12-.3-.52-1.49.11-3.11 0 0 .97-.31 3.17 1.2A10.8 10.8 0 0 1 12 5.94a10.8 10.8 0 0 1 2.89.4c2.2-1.51 3.16-1.2 3.16-1.2.64 1.62.24 2.81.12 3.11.74.82 1.19 1.87 1.19 3.15 0 4.48-2.7 5.46-5.27 5.76.41.37.78 1.09.78 2.21v3.29c0 .32.21.7.8.58a11.5 11.5 0 0 0 7.83-11A11.5 11.5 0 0 0 12 .5Z"/></svg>',
	);

	if ( ! isset( $icons[ $icon_key ] ) ) {
		return '';
	}

	return $icons[ $icon_key ];
}

/**
 * Get footer social profile links.
 *
 * Update these URLs here if profile locations change.
 *
 * @return array<int,array<string,string>>
 */
function carlashub_v2_get_footer_social_links() {
	return array(
			array(
				'label' => __( 'GitHub', 'carlashub-v2' ),
				'icon'  => 'github',
				'url'   => 'https://github.com/CarlasHub',
			),
			array(
				'label' => __( 'LinkedIn', 'carlashub-v2' ),
				'icon'  => 'linkedin',
				'url'   => 'https://www.linkedin.com/in/carla-goncalves-9a01a5164/',
			),
		);
	}

/**
 * Render the article share panel.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function carlashub_v2_render_article_share_panel( $post_id ) {
	$share_links = carlashub_v2_get_article_share_links( $post_id );

	if ( empty( $share_links ) ) {
		return '';
	}

	ob_start();
	?>
	<section class="widget share-widget">
		<h2 class="widget-title"><?php esc_html_e( 'Share Article', 'carlashub-v2' ); ?></h2>
		<ul class="share-links">
			<?php foreach ( $share_links as $share_link ) : ?>
				<?php $icon_markup = carlashub_v2_get_share_icon_svg( $share_link['icon'] ); ?>
				<?php if ( ! $icon_markup ) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<li>
					<a href="<?php echo esc_url( $share_link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
						<span class="screen-reader-text">
							<?php
							printf(
								/* translators: %s: social platform name. */
								esc_html__( 'Share on %s', 'carlashub-v2' ),
								esc_html( $share_link['label'] )
							);
							?>
						</span>
						<?php echo $icon_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php

	return (string) ob_get_clean();
}

/**
 * Render a shared author box.
 *
 * @param int $author_id Author ID.
 * @return string
 */
function carlashub_v2_get_author_box_markup( $author_id ) {
	$author = get_user_by( 'id', $author_id );

	if ( ! $author ) {
		return '';
	}

	$name        = $author->display_name ? $author->display_name : $author->user_login;
	$description = get_the_author_meta( 'description', $author_id );
	$post_count  = count_user_posts( $author_id, 'post', true );
	$archive_url = get_author_posts_url( $author_id );
	$portrait    = carlashub_v2_get_profile_portrait_markup( 'author-box__avatar', $name );

	$output  = '<section class="panel author-box">';
	$output .= '<div class="author-box__identity">';
	$output .= $portrait ? $portrait : get_avatar( $author_id, 88, '', $name, array( 'class' => 'author-box__avatar' ) );
	$output .= '<div>';
	$output .= '<p class="eyebrow">' . esc_html__( 'Written by', 'carlashub-v2' ) . '</p>';
	$output .= '<h2 class="author-box__name">' . esc_html( $name ) . '</h2>';
	$output .= '<p class="author-box__meta">' . esc_html( sprintf( _n( '%d published article', '%d published articles', $post_count, 'carlashub-v2' ), $post_count ) ) . '</p>';
	$output .= '</div>';
	$output .= '</div>';

	if ( $description ) {
		$output .= '<p class="author-box__description">' . esc_html( $description ) . '</p>';
	}

	$output .= '<div class="hero-actions">';
	$output .= '<a class="button button--ghost" href="' . esc_url( $archive_url ) . '">' . esc_html__( 'More from this author', 'carlashub-v2' ) . '</a>';
	$output .= '</div>';
	$output .= '</section>';

	return $output;
}

/**
 * Style the password form so protected content matches the theme.
 *
 * @return string
 */
function carlashub_v2_password_form() {
	$post_id  = get_the_ID();
	$field_id = 'pwbox-' . ( $post_id ? $post_id : wp_rand() );

	ob_start();
	?>
	<form class="post-password-form panel section-panel" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
		<p class="eyebrow"><?php esc_html_e( 'Protected Content', 'carlashub-v2' ); ?></p>
		<p><?php esc_html_e( 'This page is protected. Enter the password to view it.', 'carlashub-v2' ); ?></p>
		<label for="<?php echo esc_attr( $field_id ); ?>"><?php esc_html_e( 'Password', 'carlashub-v2' ); ?></label>
		<div class="search-form__controls">
			<input name="post_password" id="<?php echo esc_attr( $field_id ); ?>" type="password" size="20">
			<input type="submit" name="Submit" value="<?php esc_attr_e( 'Unlock', 'carlashub-v2' ); ?>">
		</div>
	</form>
	<?php

	return (string) ob_get_clean();
}
add_filter( 'the_password_form', 'carlashub_v2_password_form' );

/**
 * Determine whether the assigned menu is too sparse to use as-is.
 *
 * @param string $location Theme location.
 * @return bool
 */
function carlashub_v2_should_use_menu_fallback( $location ) {
	$locations = get_nav_menu_locations();

	if ( empty( $locations[ $location ] ) ) {
		return true;
	}

	$menu_items = wp_get_nav_menu_items( $locations[ $location ] );

	if ( ! is_array( $menu_items ) ) {
		return true;
	}

	$visible_items = array_filter(
		$menu_items,
		static function ( $item ) {
			return empty( $item->menu_item_parent );
		}
	);

	return count( $visible_items ) < 2;
}

/**
 * Render a menu and fall back to pages if the assigned menu is empty.
 *
 * @param string $location Theme location.
 * @param string $class Menu class.
 * @param string $fallback Fallback callback name.
 * @return string
 */
function carlashub_v2_get_menu_markup( $location, $class, $fallback ) {
	if ( carlashub_v2_should_use_menu_fallback( $location ) ) {
		ob_start();
		call_user_func( $fallback );
		return (string) ob_get_clean();
	}

	$markup = wp_nav_menu(
		array(
			'theme_location' => $location,
			'container'      => false,
			'menu_class'     => $class,
			'menu_id'        => 'primary' === $location ? 'primary-menu' : '',
			'fallback_cb'    => false,
			'echo'           => false,
		)
	);

	if ( $markup && false !== strpos( $markup, '<li' ) ) {
		return $markup;
	}

	ob_start();
	call_user_func( $fallback );
	return (string) ob_get_clean();
}

/**
 * Build deterministic fallback navigation links.
 *
 * @return array<int,array<string,string>>
 */
function carlashub_v2_get_fallback_navigation_items() {
	$items         = array();
	$front_page_id = (int) get_option( 'page_on_front' );
	$posts_page_id = (int) get_option( 'page_for_posts' );

	$items[] = array(
		'label' => __( 'Home', 'carlashub-v2' ),
		'url'   => home_url( '/' ),
	);

	$items[] = array(
		'label' => __( 'Writing', 'carlashub-v2' ),
		'url'   => carlashub_v2_get_blog_url(),
	);

	$pages = get_pages(
		array(
			'parent'      => 0,
			'sort_column' => 'menu_order,post_title',
		)
	);

	foreach ( $pages as $page ) {
		if ( (int) $page->ID === $front_page_id || (int) $page->ID === $posts_page_id ) {
			continue;
		}

		$items[] = array(
			'label' => $page->post_title,
			'url'   => get_permalink( $page ),
		);
	}

	$items[] = array(
		'label' => __( 'Search', 'carlashub-v2' ),
		'url'   => home_url( '/?s=' ),
	);

	return $items;
}

/**
 * Render a shared card for posts and pages.
 *
 * @param WP_Post|int $post Post object or ID.
 * @param string      $variant Card variant.
 * @return string
 */
function carlashub_v2_render_entry_card( $post, $variant = 'listing' ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return '';
	}

	$is_post         = 'post' === $post->post_type;
	$is_listing      = 'listing' === $variant;
	$card_classes    = 'entry-card entry-card--' . sanitize_html_class( $variant );
	$type_label      = $is_post ? __( 'Article', 'carlashub-v2' ) : __( 'Page', 'carlashub-v2' );
	$excerpt         = carlashub_v2_get_card_excerpt( $post, 'featured' === $variant ? 34 : 26 );
	$thumbnail       = 'featured' === $variant ? carlashub_v2_get_card_thumbnail_markup( $post, 'large' ) : '';
	$path_label      = carlashub_v2_get_entry_path_label( $post );
	$is_sticky       = $is_post && is_sticky( $post->ID );
	$is_archive_view = $is_listing && is_archive();
	$show_footer     = ! $is_listing && ! $is_archive_view;
	$badge_classes   = 'entry-card__badge screen-reader-text';
	$stats         = array(
		sprintf(
			/* translators: %s: modified date. */
			__( 'Updated %s', 'carlashub-v2' ),
			get_the_modified_date( 'M j, Y', $post )
		),
	);
	$facts         = array(
		__( 'Published', 'carlashub-v2' ) => get_the_date( 'M j, Y', $post ),
		__( 'Updated', 'carlashub-v2' )   => get_the_modified_date( 'M j, Y', $post ),
	);
	$comment_count = (int) get_comments_number( $post );

	if ( $is_post ) {
		$read_time               = carlashub_v2_get_read_time( $post->ID );
		$facts[ __( 'Read time', 'carlashub-v2' ) ] = sprintf(
			/* translators: %d: minutes. */
			_n( '%d min', '%d mins', $read_time, 'carlashub-v2' ),
			$read_time
		);
		$stats[] = sprintf(
			/* translators: %d: minutes. */
			_n( '%d min read', '%d mins read', $read_time, 'carlashub-v2' ),
			$read_time
		);
	}

	if ( $comment_count > 0 ) {
		$stats[] = sprintf(
			/* translators: %d: comments count. */
			_n( '%d comment', '%d comments', $comment_count, 'carlashub-v2' ),
			$comment_count
		);
	}

	$output  = '<article class="' . esc_attr( $card_classes ) . '">';

	if ( $is_listing ) {
		$output .= '<div class="entry-card__shell">';
		$output .= '<div class="entry-card__main">';
			$output .= '<div class="entry-card__header">';
			$output .= '<div>';
			$output .= '<p class="entry-card__path">' . esc_html( $path_label ) . '</p>';
			$output .= '<h2 class="entry-card__title"><a href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( get_the_title( $post ) ) . '</a></h2>';
			$output .= '</div>';
			$output .= '<span class="' . esc_attr( $badge_classes ) . '">' . esc_html( $type_label ) . '</span>';
		$output .= '</div>';

		if ( $excerpt ) {
			$output .= '<p class="entry-summary">' . esc_html( $excerpt ) . '</p>';
		}

		if ( $is_post ) {
			$output .= carlashub_v2_get_taxonomy_chips( $post->ID );
		}

		$output .= '</div>';
		$output .= '<dl class="entry-card__facts">';

		foreach ( $facts as $label => $value ) {
			$output .= '<div><dt>' . esc_html( $label ) . '</dt><dd>' . esc_html( $value ) . '</dd></div>';
		}

		$output .= '</dl>';
		$output .= '</div>';
	} else {
		if ( $thumbnail ) {
			$output .= '<div class="entry-card__thumbnail">' . $thumbnail . '</div>';
		}

			$output .= '<div class="entry-card__header">';
			$output .= '<div>';
			$output .= '<p class="entry-card__path">' . esc_html( $path_label ) . '</p>';
			$output .= '<h3 class="entry-card__title"><a href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( get_the_title( $post ) ) . '</a></h3>';
			$output .= '</div>';
			$output .= '<span class="' . esc_attr( $badge_classes ) . '">' . esc_html( $type_label ) . '</span>';
		$output .= '</div>';

		if ( $excerpt ) {
			$output .= '<p class="entry-summary">' . esc_html( $excerpt ) . '</p>';
		}
	}

	if ( $show_footer ) {
		$output .= '<div class="entry-card__footer">';

		if ( $is_post ) {
			$output .= carlashub_v2_get_taxonomy_chips( $post->ID );
		}

		$output .= '<div class="entry-card__stats">';

		if ( $is_sticky ) {
			$output .= '<span class="is-sticky">' . esc_html__( 'Pinned', 'carlashub-v2' ) . '</span>';
		}

		foreach ( $stats as $stat ) {
			$output .= '<span>' . esc_html( $stat ) . '</span>';
		}

		$output .= '</div>';
		$output .= '</div>';
	}
	$output .= '</article>';

	return $output;
}

/**
 * Fallback menu output for the primary location.
 */
function carlashub_v2_primary_menu_fallback() {
	$items = carlashub_v2_get_fallback_navigation_items();

	echo '<ul id="primary-menu" class="menu">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%1$s">%2$s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}

	echo '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Fallback menu output for the footer location.
 */
function carlashub_v2_footer_menu_fallback() {
	$items = carlashub_v2_get_fallback_navigation_items();

	echo '<ul class="footer-menu">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%1$s">%2$s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}

	echo '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Hero widget for the front page.
 */
class CarlasHub_V2_Hero_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'carlashub_v2_hero_widget',
			__( 'CarlasHub Hero', 'carlashub-v2' ),
			array(
				'description' => __( 'Editable front-page hero with image upload, actions, metrics, and status items.', 'carlashub-v2' ),
			)
		);
	}

	/**
	 * Output the widget.
	 *
	 * @param array<string,mixed> $args Sidebar args.
	 * @param array<string,mixed> $instance Widget values.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo carlashub_v2_render_hub_hero( $instance ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Save widget values.
	 *
	 * @param array<string,mixed> $new_instance New values.
	 * @param array<string,mixed> $old_instance Old values.
	 * @return array<string,mixed>
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = array();
		$instance['mark_image_id'] = ! empty( $new_instance['mark_image_id'] ) ? (int) $new_instance['mark_image_id'] : 0;

		$text_fields = array(
			'mark_text',
			'eyebrow',
			'title',
			'lede',
			'support',
			'primary_label',
			'secondary_label',
			'metric_1_value',
			'metric_1_label',
			'metric_2_value',
			'metric_2_label',
			'metric_3_value',
			'metric_3_label',
			'status_eyebrow',
			'status_1_label',
			'status_1_value',
			'status_2_label',
			'status_2_value',
			'status_3_label',
			'status_3_value',
		);

		foreach ( $text_fields as $field ) {
			$instance[ $field ] = isset( $new_instance[ $field ] ) ? sanitize_text_field( $new_instance[ $field ] ) : '';
		}

		$instance['primary_url']   = isset( $new_instance['primary_url'] ) ? esc_url_raw( $new_instance['primary_url'] ) : '';
		$instance['secondary_url'] = isset( $new_instance['secondary_url'] ) ? esc_url_raw( $new_instance['secondary_url'] ) : '';

		return $instance;
	}

	/**
	 * Output widget form.
	 *
	 * @param array<string,mixed> $instance Current values.
	 */
	public function form( $instance ) {
		$defaults = carlashub_v2_get_default_hero_config();
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'mark_image_id'   => 0,
				'mark_text'       => '',
				'eyebrow'         => '',
				'title'           => '',
				'lede'            => '',
				'support'         => '',
				'primary_label'   => '',
				'primary_url'     => '',
				'secondary_label' => '',
				'secondary_url'   => '',
				'metric_1_value'  => '',
				'metric_1_label'  => '',
				'metric_2_value'  => '',
				'metric_2_label'  => '',
				'metric_3_value'  => '',
				'metric_3_label'  => '',
				'status_eyebrow'  => '',
				'status_1_label'  => '',
				'status_1_value'  => '',
				'status_2_label'  => '',
				'status_2_value'  => '',
				'status_3_label'  => '',
				'status_3_value'  => '',
			)
		);
		$image_id = (int) $instance['mark_image_id'];
		$image    = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : '';
		?>
		<p><strong><?php esc_html_e( 'Hero mark', 'carlashub-v2' ); ?></strong></p>
		<div class="carlashub-media-control">
			<input class="carlashub-media-id" id="<?php echo esc_attr( $this->get_field_id( 'mark_image_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'mark_image_id' ) ); ?>" type="hidden" value="<?php echo esc_attr( $image_id ); ?>">
			<div class="carlashub-media-preview"<?php echo $image ? '' : ' hidden'; ?>>
				<?php if ( $image ) : ?>
					<img class="carlashub-media-preview__image" src="<?php echo esc_url( $image ); ?>" alt="">
				<?php endif; ?>
			</div>
			<p>
				<button class="button carlashub-media-select" type="button"><?php esc_html_e( 'Select image', 'carlashub-v2' ); ?></button>
				<button class="button carlashub-media-remove" type="button"><?php esc_html_e( 'Remove image', 'carlashub-v2' ); ?></button>
			</p>
		</div>
		<?php
		$this->render_text_field( 'mark_text', __( 'Fallback mark text', 'carlashub-v2' ), $instance['mark_text'], $defaults['mark_text'] );
		$this->render_text_field( 'eyebrow', __( 'Hero eyebrow', 'carlashub-v2' ), $instance['eyebrow'], $defaults['eyebrow'] );
		$this->render_text_field( 'title', __( 'Hero title', 'carlashub-v2' ), $instance['title'], $defaults['title'] );
		$this->render_textarea_field( 'lede', __( 'Hero lede', 'carlashub-v2' ), $instance['lede'], $defaults['lede'] );
		$this->render_textarea_field( 'support', __( 'Hero supporting copy', 'carlashub-v2' ), $instance['support'], $defaults['support'], 3 );

		echo '<hr>';
		echo '<p><strong>' . esc_html__( 'Actions', 'carlashub-v2' ) . '</strong></p>';
		$this->render_text_field( 'primary_label', __( 'Primary button label', 'carlashub-v2' ), $instance['primary_label'], $defaults['primary_label'] );
		$this->render_url_field( 'primary_url', __( 'Primary button URL', 'carlashub-v2' ), $instance['primary_url'], $defaults['primary_url'] );
		$this->render_text_field( 'secondary_label', __( 'Secondary button label', 'carlashub-v2' ), $instance['secondary_label'], $defaults['secondary_label'] );
		$this->render_url_field( 'secondary_url', __( 'Secondary button URL', 'carlashub-v2' ), $instance['secondary_url'], $defaults['secondary_url'] );

		echo '<hr>';
		echo '<p><strong>' . esc_html__( 'Metrics', 'carlashub-v2' ) . '</strong></p>';
		$this->render_text_field( 'metric_1_value', __( 'Metric 1 value', 'carlashub-v2' ), $instance['metric_1_value'], (string) $defaults['metric_1_value'] );
		$this->render_text_field( 'metric_1_label', __( 'Metric 1 label', 'carlashub-v2' ), $instance['metric_1_label'], $defaults['metric_1_label'] );
		$this->render_text_field( 'metric_2_value', __( 'Metric 2 value', 'carlashub-v2' ), $instance['metric_2_value'], (string) $defaults['metric_2_value'] );
		$this->render_text_field( 'metric_2_label', __( 'Metric 2 label', 'carlashub-v2' ), $instance['metric_2_label'], $defaults['metric_2_label'] );
		$this->render_text_field( 'metric_3_value', __( 'Metric 3 value', 'carlashub-v2' ), $instance['metric_3_value'], (string) $defaults['metric_3_value'] );
		$this->render_text_field( 'metric_3_label', __( 'Metric 3 label', 'carlashub-v2' ), $instance['metric_3_label'], $defaults['metric_3_label'] );

		echo '<hr>';
		echo '<p><strong>' . esc_html__( 'Status panel', 'carlashub-v2' ) . '</strong></p>';
		$this->render_text_field( 'status_eyebrow', __( 'Status eyebrow', 'carlashub-v2' ), $instance['status_eyebrow'], $defaults['status_eyebrow'] );
		$this->render_text_field( 'status_1_label', __( 'Status 1 label', 'carlashub-v2' ), $instance['status_1_label'], $defaults['status_1_label'] );
		$this->render_textarea_field( 'status_1_value', __( 'Status 1 value', 'carlashub-v2' ), $instance['status_1_value'], $defaults['status_1_value'], 3 );
		$this->render_text_field( 'status_2_label', __( 'Status 2 label', 'carlashub-v2' ), $instance['status_2_label'], $defaults['status_2_label'] );
		$this->render_textarea_field( 'status_2_value', __( 'Status 2 value', 'carlashub-v2' ), $instance['status_2_value'], $defaults['status_2_value'], 3 );
		$this->render_text_field( 'status_3_label', __( 'Status 3 label', 'carlashub-v2' ), $instance['status_3_label'], $defaults['status_3_label'] );
		$this->render_textarea_field( 'status_3_value', __( 'Status 3 value', 'carlashub-v2' ), $instance['status_3_value'], $defaults['status_3_value'], 2 );
	}

	/**
	 * Render a text field.
	 *
	 * @param string $field Field key.
	 * @param string $label Field label.
	 * @param string $value Current value.
	 * @param string $placeholder Placeholder value.
	 */
	private function render_text_field( $field, $label, $value, $placeholder ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $field ) ); ?>"><?php echo esc_html( $label ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>">
		</p>
		<?php
	}

	/**
	 * Render a URL field.
	 *
	 * @param string $field Field key.
	 * @param string $label Field label.
	 * @param string $value Current value.
	 * @param string $placeholder Placeholder value.
	 */
	private function render_url_field( $field, $label, $value, $placeholder ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $field ) ); ?>"><?php echo esc_html( $label ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $field ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field ) ); ?>" type="url" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>">
		</p>
		<?php
	}

	/**
	 * Render a textarea field.
	 *
	 * @param string $field Field key.
	 * @param string $label Field label.
	 * @param string $value Current value.
	 * @param string $placeholder Placeholder value.
	 * @param int    $rows Rows.
	 */
	private function render_textarea_field( $field, $label, $value, $placeholder, $rows = 4 ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( $field ) ); ?>"><?php echo esc_html( $label ); ?></label>
			<textarea class="widefat" rows="<?php echo esc_attr( (string) $rows ); ?>" id="<?php echo esc_attr( $this->get_field_id( $field ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $field ) ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
		</p>
		<?php
	}
}

/**
 * Disable comments and comment surfaces site-wide.
 */
function carlashub_v2_disable_comments() {
	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
		}
		if ( post_type_supports( $post_type, 'trackbacks' ) ) {
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'init', 'carlashub_v2_disable_comments', 100 );

add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 20 );
add_filter( 'feed_links_show_comments_feed', '__return_false', 20 );

/**
 * Remove comment feed links from the document head.
 */
function carlashub_v2_remove_comment_feed_links() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'wp_head', 'carlashub_v2_remove_comment_feed_links', 1 );
