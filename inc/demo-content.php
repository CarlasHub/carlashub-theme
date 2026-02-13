<?php
/**
 * Demo content setup for CarlasHub.
 */

function carlashub_create_attachment_from_theme_asset( $relative_path ) {
	$path = get_theme_file_path( $relative_path );
	if ( ! file_exists( $path ) ) {
		return 0;
	}

	$upload = wp_upload_bits( basename( $path ), null, file_get_contents( $path ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$filetype = wp_check_filetype( $upload['file'], null );
	$attachment = array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => sanitize_file_name( $upload['file'] ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	$attach_id = wp_insert_attachment( $attachment, $upload['file'] );
	if ( ! $attach_id ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;
}

function carlashub_seed_demo_content( $force = false ) {
	if ( get_option( 'carlashub_demo_seeded' ) && ! $force ) {
		return;
	}

	$pages = array(
		'Home' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/hero-editorial-centered\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/value-prop-asym\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/services-circular\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/blog-listing-dominant\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/testimonials\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		),
		'About' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/about-narrative\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/about-portrait\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/content-split-right\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/dense-content-grid\"} /-->",
		),
		'Services' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/services-circular\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/content-split-right\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/pricing\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		),
		'Portfolio' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/portfolio-intro\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/featured-project\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/portfolio-grid-offset\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/portfolio-grid\"} /-->",
		),
		'Blog' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/blog-intro\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/blog-listing-dominant\"} /-->",
		),
		'Contact' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/contact\"} /-->",
		),
		'Privacy Policy' => array(
			'content' => "<!-- wp:heading {\"level\":2} --><h2>Privacy Policy</h2><!-- /wp:heading --><!-- wp:paragraph --><p>We respect your privacy. Replace this text with your official policy.</p><!-- /wp:paragraph -->",
		),
		'Style Guide' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/style-guide\"} /-->",
		),
		'Pattern Library' => array(
			'content' => "<!-- wp:pattern {\"slug\":\"carlashub/pattern-library\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		),
	);

	$page_slugs = array(
		'Home'            => 'home',
		'About'           => 'about',
		'Services'        => 'services',
		'Portfolio'       => 'portfolio',
		'Blog'            => 'blog',
		'Contact'         => 'contact',
		'Privacy Policy'  => 'privacy-policy',
		'Style Guide'     => 'style-guide',
		'Pattern Library' => 'pattern-library',
	);

	$page_ids = array();
	foreach ( $pages as $title => $data ) {
		$existing = get_page_by_title( $title );
		if ( $existing ) {
			$page_ids[ $title ] = $existing->ID;
			wp_update_post(
				array(
					'ID'           => $existing->ID,
					'post_content' => $data['content'],
					'post_status'  => 'publish',
					'post_name'    => isset( $page_slugs[ $title ] ) ? $page_slugs[ $title ] : $existing->post_name,
				)
			);
			continue;
		}

		$page_ids[ $title ] = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_content' => $data['content'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_name'    => isset( $page_slugs[ $title ] ) ? $page_slugs[ $title ] : '',
			)
		);
	}

	$child_pages = array(
		'Services'  => array( 'Brand Strategy', 'Website Development', 'Editorial Design' ),
		'Portfolio' => array( 'Ritual House', 'Velvet Archive', 'Obsidian Studio' ),
		'About'     => array( 'Studio Process', 'Values' ),
	);

	$child_slugs = array(
		'Brand Strategy'      => 'brand-strategy',
		'Website Development' => 'website-development',
		'Editorial Design'    => 'editorial-design',
		'Ritual House'        => 'ritual-house',
		'Velvet Archive'      => 'velvet-archive',
		'Obsidian Studio'     => 'obsidian-studio',
		'Studio Process'      => 'studio-process',
		'Values'              => 'values',
	);

	$child_page_content = array(
		'Ritual House'    => "<!-- wp:pattern {\"slug\":\"carlashub/case-study-intro-ritual\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/case-study-hero\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/content-split-left\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/case-study-outcome-ritual\"} /-->",
		'Velvet Archive'  => "<!-- wp:pattern {\"slug\":\"carlashub/case-study-intro-velvet\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/case-study-hero\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/content-split-right\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/case-study-outcome-generic\"} /-->",
		'Obsidian Studio' => "<!-- wp:pattern {\"slug\":\"carlashub/content-split-left\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		'Brand Strategy'      => "<!-- wp:pattern {\"slug\":\"carlashub/content-split-left\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		'Website Development' => "<!-- wp:pattern {\"slug\":\"carlashub/content-split-right\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		'Editorial Design'    => "<!-- wp:pattern {\"slug\":\"carlashub/content-split-left\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		'Studio Process'      => "<!-- wp:pattern {\"slug\":\"carlashub/content-split-right\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
		'Values'              => "<!-- wp:pattern {\"slug\":\"carlashub/content-split-left\"} /-->\n<!-- wp:pattern {\"slug\":\"carlashub/cta-banner\"} /-->",
	);

	foreach ( $child_pages as $parent_title => $children ) {
		if ( empty( $page_ids[ $parent_title ] ) ) {
			continue;
		}

		foreach ( $children as $child_title ) {
			$child_content = isset( $child_page_content[ $child_title ] ) ? $child_page_content[ $child_title ] : '<!-- wp:pattern {"slug":"carlashub/content-split-left"} /--><!-- wp:pattern {"slug":"carlashub/cta-banner"} /-->';
			$existing = get_page_by_title( $child_title );
			if ( $existing ) {
				wp_update_post(
					array(
						'ID'          => $existing->ID,
						'post_parent' => $page_ids[ $parent_title ],
						'post_status' => 'publish',
						'post_content' => $child_content,
						'post_name'   => isset( $child_slugs[ $child_title ] ) ? $child_slugs[ $child_title ] : $existing->post_name,
					)
				);
				continue;
			}

			wp_insert_post(
				array(
					'post_title'   => $child_title,
					'post_content' => $child_content,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_parent'  => $page_ids[ $parent_title ],
					'post_name'    => isset( $child_slugs[ $child_title ] ) ? $child_slugs[ $child_title ] : '',
				)
			);
		}
	}

	if ( ! empty( $page_ids['Home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['Home'] );
	}
	update_option( 'page_for_posts', 0 );

	$categories = array( 'Ritual', 'Design Systems', 'Brand Strategy' );
	$category_ids = array();
	foreach ( $categories as $category ) {
		$term = term_exists( $category, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $category, 'category' );
		}
		if ( ! is_wp_error( $term ) ) {
			$category_ids[] = (int) $term['term_id'];
		}
	}

	$tags = array( 'Editorial', 'Accessibility', 'Themes', 'Patterns' );
	$tag_ids = array();
	foreach ( $tags as $tag ) {
		$term = term_exists( $tag, 'post_tag' );
		if ( ! $term ) {
			$term = wp_insert_term( $tag, 'post_tag' );
		}
		if ( ! is_wp_error( $term ) ) {
			$tag_ids[] = (int) $term['term_id'];
		}
	}

	$featured_id = carlashub_create_attachment_from_theme_asset( 'screenshot.png' );

	for ( $i = 1; $i <= 8; $i++ ) {
		$title = 'Journal Entry ' . $i;
		$existing = get_page_by_title( $title, OBJECT, 'post' );
		if ( $existing ) {
			if ( ! $force ) {
				continue;
			}

			$post_id = $existing->ID;
			wp_update_post(
				array(
					'ID'           => $post_id,
					'post_content' => '<!-- wp:paragraph --><p>Quick update from Carla&rsquo;s Hub. This entry will be expanded with the final content soon&mdash;thanks for reading and check back shortly.</p><!-- /wp:paragraph -->',
					'post_status'  => 'publish',
				)
			);
		} else {
			$post_id = wp_insert_post(
				array(
					'post_title'   => $title,
					'post_content' => '<!-- wp:paragraph --><p>Quick update from Carla&rsquo;s Hub. This entry will be expanded with the final content soon&mdash;thanks for reading and check back shortly.</p><!-- /wp:paragraph -->',
					'post_status'  => 'publish',
					'post_type'    => 'post',
					'post_category'=> $category_ids,
					'tags_input'   => $tag_ids,
				)
			);
		}

		if ( $featured_id ) {
			set_post_thumbnail( $post_id, $featured_id );
		}
	}

	$primary_menu = wp_get_nav_menu_object( 'Primary' );
	if ( ! $primary_menu ) {
		$primary_menu_id = wp_create_nav_menu( 'Primary' );
	} else {
		$primary_menu_id = $primary_menu->term_id;
	}

	$footer_menu = wp_get_nav_menu_object( 'Footer' );
	if ( ! $footer_menu ) {
		$footer_menu_id = wp_create_nav_menu( 'Footer' );
	} else {
		$footer_menu_id = $footer_menu->term_id;
	}

	$existing_items = wp_get_nav_menu_items( $primary_menu_id );
	$existing_by_object = array();
	if ( $existing_items ) {
		foreach ( $existing_items as $item ) {
			if ( 'page' === $item->object && 'post_type' === $item->type ) {
				$existing_by_object[ (int) $item->object_id ] = (int) $item->ID;
			}
		}
	}

	$menu_pages = array( 'Home', 'About', 'Services', 'Portfolio', 'Blog', 'Contact' );
	$menu_item_ids = array();
	foreach ( $menu_pages as $title ) {
		if ( empty( $page_ids[ $title ] ) ) {
			continue;
		}
		$object_id = (int) $page_ids[ $title ];
		$menu_item_id = isset( $existing_by_object[ $object_id ] ) ? $existing_by_object[ $object_id ] : 0;

		$menu_item_ids[ $title ] = wp_update_nav_menu_item(
			$primary_menu_id,
			$menu_item_id,
			array(
				'menu-item-title'     => $title,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $object_id,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	$submenu_map = array(
		'Services'  => array( 'Brand Strategy', 'Website Development', 'Editorial Design' ),
		'Portfolio' => array( 'Ritual House', 'Velvet Archive', 'Obsidian Studio' ),
		'About'     => array( 'Studio Process', 'Values' ),
	);

	foreach ( $submenu_map as $parent_title => $children ) {
		if ( empty( $menu_item_ids[ $parent_title ] ) ) {
			continue;
		}
		foreach ( $children as $child_title ) {
			$child_page = get_page_by_title( $child_title );
			if ( ! $child_page ) {
				continue;
			}
			$child_object_id = (int) $child_page->ID;
			$child_menu_item_id = isset( $existing_by_object[ $child_object_id ] ) ? $existing_by_object[ $child_object_id ] : 0;

			wp_update_nav_menu_item(
				$primary_menu_id,
				$child_menu_item_id,
				array(
					'menu-item-title'     => $child_title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $child_object_id,
					'menu-item-type'      => 'post_type',
					'menu-item-parent-id' => $menu_item_ids[ $parent_title ],
					'menu-item-status'    => 'publish',
				)
			);
		}
	}

	$footer_pages = array( 'Privacy Policy', 'Style Guide', 'Pattern Library', 'Contact' );
	foreach ( $footer_pages as $title ) {
		if ( empty( $page_ids[ $title ] ) ) {
			continue;
		}
		wp_update_nav_menu_item(
			$footer_menu_id,
			0,
			array(
				'menu-item-title'     => $title,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page_ids[ $title ],
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $primary_menu_id;
	$locations['footer']  = $footer_menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	$published_pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		)
	);
	foreach ( $published_pages as $page ) {
		if ( '' === trim( $page->post_title ) ) {
			wp_update_post(
				array(
					'ID'          => $page->ID,
					'post_status' => 'draft',
				)
			);
		}
	}

	update_option( 'carlashub_demo_seeded', 1 );
}
add_action(
	'after_switch_theme',
	function () {
		carlashub_seed_demo_content( true );
	}
);
