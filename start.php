<?php

/**
 * Provides functions for adding external javascript and css files
 *
 * @author Cash Costello
 * @license http://opensource.org/licenses/gpl-2.0.php GPL 2
 */

if (!function_exists('elgg_register_external_js')) {

	/**
	 * Register a javascript file for inclusion
	 *
	 * This function handles adding javascript to a web page. If multiple
	 * calls are made to register the same javascript file based on the $name
	 * variable, only the last file is included. This allows a plugin to add
	 * javascript from a view that may be called more than once. It also handles
	 * more than one plugin adding the same javascript.
	 *
	 * Plugin authors are encouraged to use the $name variable. jQuery plugins
	 * often have filenames such as jquery.rating.js. In that case, the name
	 * would be "jquery.rating". It is recommended to not use version numbers
	 * in the name.
	 *
	 * The javascript files can be local to the server or remote (such as
	 * Google's CDN).
	 *
	 * The javascript is included at the bottom of the page so inline scripts
	 * that depend on a registered file should use jQuery's document ready
	 * function.
	 *
	 * @param string $url URL of the javascript
	 * @param string $name An identifier of the javascript library
	 * @return bool
	 */
	function elgg_register_external_js($url, $name) {
		return elgg_register_external_file('javascript', $url, $name);
	}

	function elgg_register_external_css($url, $name) {
		return elgg_register_external_file('css', $url, $name);
	}

	/**
	 * Core register external file function for convenience functions
	 *
	 * @param string $type Type of external resource
	 * @param string $url URL
	 * @param mixed $name Identifier used as key
	 * @return bool
	 */
	function elgg_register_external_file($type, $url, $name) {
		global $CONFIG;

		if (empty($url)) {
			return FALSE;
		}

		if (!isset($CONFIG->externals)) {
			$CONFIG->externals = array();
		}

		if (!isset($CONFIG->externals[$type])) {
			$CONFIG->externals[$type]  = array();
		}

		if (!isset($name)) {
			$name = count($CONFIG->externals[$type]);
		} else {
			$name = trim(strtolower($name));
		}

		$CONFIG->externals[$type][$name] = $url;

		return TRUE;
	}

	/**
	 * Get external javascript URLs
	 *
	 * @return array
	 */
	function elgg_get_external_js() {
		return elgg_get_external_file('javascript');
	}

	/**
	 * Get external CSS file URLs
	 *
	 * @return array
	 */
	function elgg_get_external_css() {
		return elgg_get_external_file('css');
	}

	/**
	 * Core function for getting external resource URLs
	 *
	 * @param string $type Type of resource
	 * @return array
	 */
	function elgg_get_external_file($type) {
		global $CONFIG;
		
		if (isset($CONFIG->externals) && isset($CONFIG->externals[$type])) {
			return $CONFIG->externals[$type];
		}
		return array();
	}
}

register_elgg_event_handler('init', 'system', 'manage_externals_init');

function manage_externals_init() {
	elgg_extend_view('footer/analytics', 'manage_externals/footer');
	elgg_extend_view('metatags', 'manage_externals/head');
}
