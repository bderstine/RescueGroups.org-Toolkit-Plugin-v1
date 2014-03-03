<?php
/*
Plugin Name: RescueGroups.org Toolkit Plugin v1
Plugin URI: https://github.com/bderstine/RescueGroups.org-Toolkit-Plugin-v1
Description: A basic plugin to include the javascript toolkit files from RescueGroups.org
Version: 1.0
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
 
	if ($shortcode_found) {
		wp_enqueue_style('rg-style-1', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/container/assets/skins/sam/container.css');
		wp_enqueue_style('rg-style-2', 'http://toolkit.rescuegroups.org/javascript/v2.0/styles_list?key='.get_option('rg_avail_key'));
		wp_enqueue_style('rg-style-3', 'http://toolkit.rescuegroups.org/javascript/v2.0/styles_random?key='.get_option('rg_avail_key'));

		wp_enqueue_script('rg-script-1', 'http://toolkit.rescuegroups.org/javascript/v2.0/?key='.get_option('rg_avail_key'));
		wp_enqueue_script('rg-script-2', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/yahoo-dom-event/yahoo-dom-event.js');
		wp_enqueue_script('rg-script-3', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/animation/animation-min.js');
		wp_enqueue_script('rg-script-4', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/container/container-min.js');
	}
 
	return $posts;
}

function rg_available() {
	$output = "<!-- Begin Pet Adoption Toolkit -->
		<div class=\"rgPetDetails\" id=\"rgPetDetails\"></div>
		<div id=\"rgPetsContainer\"></div>
		<script type=\"text/javascript\" language=\"JavaScript\">
		try{
		  new cPets('rgPets');
		  rgPets.fields = 'name,breed,pictmn1';
		  rgPets.detailPage = 'popup';
		  rgPets.sortbyField = 'name';
		  rgPets.sortbyOrder = 'asc';
		  rgPets.petFields['pictmn1']['name'] = '';
		  rgPets.picSize = 'thumbnail';
		  rgPets.enableSearch = false;
		  rgPets.paging = false;
		  rgPets.perRow = 4;
		  rgPets.rows = 999999;
		  rgPets.grid('rgPetsContainer');
		}catch(e){
		  if (e) {
		    document.getElementById('rgPetsContainer').innerHTML = \"Oops! \" +
		    \"There was a problem getting our pet list. \" +
		    \"Please try again later. Thank you!\";
		  }
		}
		</script>
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
 
	if ($shortcode_found) {
		wp_enqueue_style('rg-style-1', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/container/assets/skins/sam/container.css');
		wp_enqueue_style('rg-style-2', 'http://toolkit.rescuegroups.org/javascript/v2.0/styles_list?key='.get_option('rg_adopt_key'));
		wp_enqueue_style('rg-style-3', 'http://toolkit.rescuegroups.org/javascript/v2.0/styles_random?key='.get_option('rg_adopt_key'));

		wp_enqueue_script('rg-script-1', 'http://toolkit.rescuegroups.org/javascript/v2.0/?key='.get_option('rg_adopt_key'));
		wp_enqueue_script('rg-script-2', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/yahoo-dom-event/yahoo-dom-event.js');
		wp_enqueue_script('rg-script-3', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/animation/animation-min.js');
		wp_enqueue_script('rg-script-4', 'http://toolkit.rescuegroups.org/javascript/v2.0/yui/build/container/container-min.js');
	}
 
	return $posts;
}

function rg_adopted() {
	$output = "<!-- Begin Pet Adoption Toolkit -->
		<div class=\"rgPetDetails\" id=\"rgPetDetails\"></div>
		<div id=\"rgPetsContainer\"></div>
		<script type=\"text/javascript\" language=\"JavaScript\">// <![CDATA[
		try{
		  new cPets('rgPets');
		  rgPets.fields = 'name,breed';
		  rgPets.detailPage = 'popup';
		  rgPets.sortbyField = 'name';
		  rgPets.sortbyOrder = 'asc';
		  rgPets.petFields['pictmn1']['name'] = '';
		  rgPets.picSize = 'thumbnail';
		  rgPets.enableSearch = false;
		  rgPets.paging = false;
		  rgPets.perRow = 4;
		  rgPets.rows = 999999;
		  rgPets.grid('rgPetsContainer');
		}catch(e){
		  if (e) {
		    document.getElementById('rgPetsContainer').innerHTML = \"Oops! \" +
		    \"There was a problem getting our pet list. \" +
		    \"Please try again later. Thank you!\";
		  }
		}
		// ]]></script>
		<!-- End Pet Adoption Toolkit -->";
	return $output;
}

add_shortcode('rg-adopted', 'rg_adopted');

// Adding the functions for the admin menu options
function rg_plugin_menu() {
	add_options_page('RescueGroups Settings', 'RescueGroups.org', 'manage_options', 'rg-unique-identifier', 'rg_options_page');
}

function rg_options_page() {
	include(WP_PLUGIN_DIR.'/wp-rescuegroups-master/options.php');  
}

function register_rg_avail_key_settings() {
	register_setting('rg_options_group', 'rg_avail_key'); 
	register_setting('rg_options_group', 'rg_adopt_key'); 
} 

add_action('admin_menu', 'rg_plugin_menu');
add_action('admin_init', 'register_rg_avail_key_settings');

?>
