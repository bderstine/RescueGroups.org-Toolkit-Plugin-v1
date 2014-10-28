<?php
/*
Plugin Name: RescueGroups.org Toolkit Plugin v1
Plugin URI: https://github.com/bderstine/RescueGroups.org-Toolkit-Plugin-v1
Description: A basic plugin to include the javascript toolkit files from RescueGroups.org
Version: 1.1
Author: Brad Derstine
Author URI: http://bizzartech.com
License: GPL2
*/

add_filter('the_posts', 'check_for_rg_available'); // the_posts gets triggered before wp_head
function check_for_rg_available($posts){
	if (empty($posts)) return $posts;
 
	$shortcode_found = false; // use this flag to see if styles and scripts need to be enqueued
	foreach ($posts as $post) {
		if (stripos($post->post_content, '[rg-available]') !== false) {
			$shortcode_found = true; // bingo!
			break;
		}
	}
 
	return $posts;
}

function rg_available() {
	$output = "<!--
		Pet Adoption Toolkit (JavaScript)
		Provided by RescueGroups.org completely free of cost,
		commitment, external links or advertisements
		http://www.rescuegroups.org
		-->
		<script src=\"https://toolkit.rescuegroups.org/j/3/".get_option('rg_avail_key')."/toolkit.js\"></script>
		<!-- End Pet Adoption Toolkit -->";

	return $output;
}

add_shortcode('rg-available', 'rg_available');

add_filter('the_posts', 'check_for_rg_adopted'); // the_posts gets triggered before wp_head
function check_for_rg_adopted($posts){
	if (empty($posts)) return $posts;
 
	$shortcode_found = false; // use this flag to see if styles and scripts need to be enqueued
	foreach ($posts as $post) {
		if (stripos($post->post_content, '[rg-adopted]') !== false) {
			$shortcode_found = true; // bingo!
			break;
		}
	}
 
	return $posts;
}

function rg_adopted() {
	$output = "<!--
		Pet Adoption Toolkit (JavaScript)
		Provided by RescueGroups.org completely free of cost,
		commitment, external links or advertisements
		http://www.rescuegroups.org
		-->
		<script src=\"https://toolkit.rescuegroups.org/j/3/".get_option('rg_adopt_key')."/toolkit.js\"></script>
		<!-- End Pet Adoption Toolkit -->";

	return $output;
}

add_shortcode('rg-adopted', 'rg_adopted');

// Adding the functions for the admin menu options
function rg_plugin_menu() {
	add_options_page('RescueGroups Settings', 'RescueGroups.org', 'manage_options', 'rg-unique-identifier', 'rg_options_page');
}

function rg_options_page() {
	include(WP_PLUGIN_DIR.'/RescueGroups.org-Toolkit-Plugin-v1-master/options.php');  
}

function register_rg_avail_key_settings() {
	register_setting('rg_options_group', 'rg_avail_key'); 
	register_setting('rg_options_group', 'rg_adopt_key'); 
} 

add_action('admin_menu', 'rg_plugin_menu');
add_action('admin_init', 'register_rg_avail_key_settings');

?>
