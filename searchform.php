<?php
/**
 * Search form template.
 *
 * @package CarlasHub_V2
 */

$search_label   = isset( $args['aria_label'] ) ? (string) $args['aria_label'] : __( 'Search the site', 'carlashub-v2' );
$show_label     = isset( $args['show_label'] ) ? (bool) $args['show_label'] : true;
$search_id      = wp_unique_id( 'search-field-' );
$label_classes  = $show_label ? '' : 'screen-reader-text';
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="<?php echo esc_attr( $label_classes ); ?>" for="<?php echo esc_attr( $search_id ); ?>"><?php echo esc_html( $search_label ); ?></label>
	<div class="search-form__controls">
		<input type="search" id="<?php echo esc_attr( $search_id ); ?>" class="search-field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search posts, pages', 'carlashub-v2' ); ?>">
		<button type="submit" class="search-submit"><?php esc_html_e( 'Search', 'carlashub-v2' ); ?></button>
	</div>
</form>
