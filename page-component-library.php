<?php
/**
 * Template Name: Component Library
 */
get_header();
$snippets_dir = get_template_directory() . '/docs/snippets';
function carlashub_snippet( $file, $snippets_dir ) {
	$path = trailingslashit( $snippets_dir ) . $file;
	if ( file_exists( $path ) ) {
		echo file_get_contents( $path );
	}
}
?>
<main class="site-main">
	<section class="c-card c-card--a">
		<div class="c-card__body">
			<h1>Component Library</h1>
			<p>Keyboard notes: use Tab to move, Enter or Space to activate controls, Escape closes overlays. Tabs support arrow keys.</p>
		</div>
	</section>

	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-button.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-icon-button.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-link.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-input.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-textarea.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-select.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-checkbox.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-radio.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-toggle.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-tooltip.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-dropdown.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-modal.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-drawer.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-tabs.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-accordion.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-alert.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-toast.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-card.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-badge.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-breadcrumb.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-pagination.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-table.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-table-row-actions.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-loader.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-progress.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-empty-state.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-avatar.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-file-upload.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-search-input.html', $snippets_dir ); ?></div></section>
	<section class="c-card c-card--a"><div class="c-card__body"><?php carlashub_snippet( 'c-filter-group.html', $snippets_dir ); ?></div></section>
</main>
<?php
get_footer();
