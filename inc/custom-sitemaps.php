<?php
/**
 * Custom sitemap routes and renderers for CarlasHub V2.
 *
 * @package CarlasHub_V2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register query vars for custom sitemap routes.
 *
 * @param array<int,string> $query_vars Existing public query vars.
 * @return array<int,string>
 */
function carlashub_v2_register_sitemap_query_vars( $query_vars ) {
	$query_vars[] = 'carlashub_sitemap';

	return $query_vars;
}
add_filter( 'query_vars', 'carlashub_v2_register_sitemap_query_vars' );

/**
 * Register rewrite rules for custom sitemap routes.
 */
function carlashub_v2_add_sitemap_rewrite_rules() {
	add_rewrite_rule( '^sitemap\.xml$', 'index.php?carlashub_sitemap=index', 'top' );
	add_rewrite_rule( '^sitemap-posts\.xml$', 'index.php?carlashub_sitemap=posts', 'top' );
	add_rewrite_rule( '^sitemap-categories\.xml$', 'index.php?carlashub_sitemap=categories', 'top' );
}
add_action( 'init', 'carlashub_v2_add_sitemap_rewrite_rules' );

/**
 * Return the sitemap route URLs used by the custom renderer.
 *
 * @return array<string,string>
 */
function carlashub_v2_get_custom_sitemap_urls() {
	return array(
		'index'      => home_url( '/sitemap.xml' ),
		'posts'      => home_url( '/sitemap-posts.xml' ),
		'categories' => home_url( '/sitemap-categories.xml' ),
	);
}

/**
 * Return the current custom sitemap route slug when present.
 *
 * @return string
 */
function carlashub_v2_get_current_sitemap_route() {
	$route = get_query_var( 'carlashub_sitemap' );

	return is_string( $route ) ? $route : '';
}

/**
 * Build XML-safe text.
 *
 * @param string $value Raw text.
 * @return string
 */
function carlashub_v2_escape_xml_text( $value ) {
	return htmlspecialchars( $value, ENT_XML1 | ENT_COMPAT, 'UTF-8' );
}

/**
 * Return sitemap entries for published posts.
 *
 * @return array<int,array<string,string>>
 */
function carlashub_v2_get_post_sitemap_entries() {
	$posts = get_posts(
		array(
			'post_type'              => 'post',
			'post_status'            => 'publish',
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'posts_per_page'         => -1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'suppress_filters'       => false,
		)
	);

	$entries = array();

	foreach ( $posts as $post ) {
		$permalink = get_permalink( $post );

		if ( ! is_string( $permalink ) || '' === $permalink ) {
			continue;
		}

		$entries[] = array(
			'loc'     => $permalink,
			'lastmod' => get_post_modified_time( DATE_W3C, true, $post ),
		);
	}

	return $entries;
}

/**
 * Return sitemap entries for non-empty categories.
 *
 * @return array<int,array<string,string>>
 */
function carlashub_v2_get_category_sitemap_entries() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
		)
	);

	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$entries = array();

	foreach ( $terms as $term ) {
		$url = get_term_link( $term );

		if ( is_wp_error( $url ) || ! is_string( $url ) || '' === $url ) {
			continue;
		}

		$entries[] = array(
			'loc' => $url,
		);
	}

	return $entries;
}

/**
 * Build sitemap index XML.
 *
 * @return string
 */
function carlashub_v2_render_sitemap_index_xml() {
	$urls = carlashub_v2_get_custom_sitemap_urls();

	return '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
		'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n" .
		"\t" . '<sitemap><loc>' . carlashub_v2_escape_xml_text( $urls['posts'] ) . '</loc></sitemap>' . "\n" .
		"\t" . '<sitemap><loc>' . carlashub_v2_escape_xml_text( $urls['categories'] ) . '</loc></sitemap>' . "\n" .
		'</sitemapindex>';
}

/**
 * Build a sitemap urlset XML document.
 *
 * @param array<int,array<string,string>> $entries Sitemap entries.
 * @return string
 */
function carlashub_v2_render_sitemap_urlset_xml( $entries ) {
	$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	foreach ( $entries as $entry ) {
		if ( empty( $entry['loc'] ) || ! is_string( $entry['loc'] ) ) {
			continue;
		}

		$xml .= "\t" . '<url>' . "\n";
		$xml .= "\t\t" . '<loc>' . carlashub_v2_escape_xml_text( $entry['loc'] ) . '</loc>' . "\n";

		if ( ! empty( $entry['lastmod'] ) && is_string( $entry['lastmod'] ) ) {
			$xml .= "\t\t" . '<lastmod>' . carlashub_v2_escape_xml_text( $entry['lastmod'] ) . '</lastmod>' . "\n";
		}

		$xml .= "\t" . '</url>' . "\n";
	}

	$xml .= '</urlset>';

	return $xml;
}

/**
 * Send a custom sitemap response when one of the route query vars is present.
 */
function carlashub_v2_serve_custom_sitemaps() {
	$route = carlashub_v2_get_current_sitemap_route();

	if ( '' === $route ) {
		return;
	}

	if ( function_exists( 'carlashub_v2_is_demo_host' ) && carlashub_v2_is_demo_host() ) {
		status_header( 410 );
		header( 'Content-Type: text/plain; charset=UTF-8', true );
		echo 'Demo sitemaps are disabled.';
		exit;
	}

	switch ( $route ) {
		case 'index':
			$xml = carlashub_v2_render_sitemap_index_xml();
			break;
		case 'posts':
			$xml = carlashub_v2_render_sitemap_urlset_xml( carlashub_v2_get_post_sitemap_entries() );
			break;
		case 'categories':
			$xml = carlashub_v2_render_sitemap_urlset_xml( carlashub_v2_get_category_sitemap_entries() );
			break;
		default:
			status_header( 404 );
			return;
	}

	status_header( 200 );
	header( 'Content-Type: application/xml; charset=UTF-8', true );
	echo $xml;
	exit;
}
add_action( 'template_redirect', 'carlashub_v2_serve_custom_sitemaps', 0 );
