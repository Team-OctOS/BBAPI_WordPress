<?php
/**
 * Plugin Name: BasketBuild
 * Plugin URI: TODO
 * Description: This plugin will show files from a developer's basketbuild account
 * Version: 0.1
 * Author: Simon Sickle
 * Author URI: http://simonsickle.com
 * License: GPLv2
 */
 
include_once('basketbuild-html.php');

 /* Shortcode functions */
function basketbuild_directorys($atts) {
	/* Make sure that dev is set in shortcode */
	if (isset($atts['dev'])) {
		if (isset($atts['directory'])) {
			return generateSingleDir($atts['dev'], $atts['directory']);
		} else {
			return generateAllDirs($atts['dev']);
		}
	} else {
		return "Username Is Not Set";
	}
}
add_shortcode('basketbuild', 'basketbuild_directorys');

function basketbuild_file($atts) {
	/* Make sure that dev is set in shortcode */
	if (isset($atts['dev']) && isset($atts['file'])) {
		return generateFileButton($atts['dev'], $atts['file']);
	} else {
		return "Filename or Username is not provided";
	}
}
add_shortcode('basketbuild-file', 'basketbuild_file');
?>