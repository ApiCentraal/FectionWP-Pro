<?php
/**
 * Utility menu walker (icon menu)
 *
 * Renders Bootstrap Icons based on menu item CSS classes.
 * Add a class like `bi-instagram` to a menu item to render the icon.
 *
 * @package FectionWP_Pro
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FWP_Utility_Menu_Walker' ) ) {
	class FWP_Utility_Menu_Walker extends Walker_Nav_Menu {
		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$show_labels = function_exists( 'fwp_utilitybar_show_icon_labels' ) ? (bool) fwp_utilitybar_show_icon_labels() : false;

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes = array_filter( array_map( 'sanitize_html_class', $classes ) );

			$li_classes = array( 'nav-item' );
			$li_classes = array_merge( $li_classes, $classes );

			$class_names = implode( ' ', array_filter( $li_classes ) );
			$output .= $indent . '<li class="' . esc_attr( $class_names ) . '">';

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';

			$atts['class'] = 'nav-link fwp-utilitybar__link';

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );

			$icon_class = '';
			foreach ( $classes as $class ) {
				if ( is_string( $class ) && str_starts_with( $class, 'bi-' ) ) {
					$icon_class = $class;
					break;
				}
			}

			$item_output  = '';
			$item_output .= '<a' . $attributes . '>';

			if ( $icon_class ) {
				$item_output .= '<i class="bi ' . esc_attr( $icon_class ) . '" aria-hidden="true"></i>';
				if ( $show_labels ) {
					$item_output .= '<span class="fwp-utilitybar__label">' . esc_html( $title ) . '</span>';
				} else {
					$item_output .= '<span class="visually-hidden">' . esc_html( $title ) . '</span>';
				}
			} else {
				$item_output .= esc_html( $title );
			}

			$item_output .= '</a>';

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			$output .= "</li>\n";
		}
	}
}
