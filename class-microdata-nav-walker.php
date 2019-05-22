<?php
/**
 * Microdata Walker
 *
 * This is a custom microdata nav menu walker for WordPress.
 * Based on @drewapicture code in WordPress developer website,
 * and internet sources other sources, like schema.org.
 *
 * @package FAPNET
 * @subpackage YourProjectName
 * @author Fernando Arbulu Perrella <feperrella@gmail.com>
 * @link https://fapnet.com.br
 * @license MIT
 * @version 1.0.0
 */

/**
 * Custom Walker Nav Menu
 */
class Microdata_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * Adds classes to the unordered list sub-menus.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		// Depth-dependent classes.
		$indent        = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent.
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0.
		$classes       = array(
			'menu vertical', // css classes to use with Zurb Foundation 6.
			( $display_depth >= 2 ? 'menu' : 'nested' ),
		);
		$class_names   = implode( ' ', $classes );

		// Build HTML for output with MicroData.
		$output .= "\n" . $indent . '<ul class="' . $class_names . '" itemscope itemtype="http://www.schema.org/SiteNavigationElement">' . "\n";
	}


	/**
	 * Start the element output.
	 *
	 * Adds main/sub-classes to the list items and links.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent.

		// Depth-dependent classes.
		$depth_classes     = array(
			( 0 === $depth ? 'main-menu-item' : 'sub-menu-item' ),
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// Passed classes.
		$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// Build HTML items with MicroData.
		$output .= $indent . '<li id="menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '" itemprop="name">';

		// Link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
		$attributes .= ! empty( $item->url ) ? ' itemprop="url"' : '';

		// Build HTML output and pass through the proper filter.
		$item_output = sprintf(
			'%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			( ! empty( $args->before ) ? $args->before : '' ),
			$attributes,
			( ! empty( $args->link_before ) ? $args->link_before : '' ),
			apply_filters( 'the_title', $item->title, $item->ID ),
			( ! empty( $args->link_after ) ? $args->link_after : '' ),
			( ! empty( $args->after ) ? $args->after : '' )
		);

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
