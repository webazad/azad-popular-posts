<?php

/**
 * Parse args ( merge arrays )
 *
 * Similar to wp_parse_args() but extended to also merge multidimensional arrays
 *
 * @param array   $a - set of values to merge
 * @param array   $b - set of default values
 * @return array Merged set of elements
 * @since  1.0.0
 */

if ( !function_exists( 'meks_ess_parse_args' ) ):
	function meks_ess_parse_args( &$a, $b ) {

		$a = (array)$a;
		$b = (array)$b;
		$r = $b;
		foreach ( $a as $k => &$v ) {
			if ( is_array( $v ) && !isset( $v[0] ) && isset( $r[ $k ] ) ) {
				$r[ $k ] = meks_ess_parse_args( $v, $r[ $k ] );
			} else {
				$r[ $k ] = $v;
			}
		}

		return $r;
	}
endif;