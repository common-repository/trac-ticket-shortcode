<?php
/*
Plugin Name: Trac Ticket Shortcode
Description: Links directly to a ticket ("bug") on a Trac site.
Version: 0.1
Author: Frederick Ding
Author URI: http://www.frederickding.com/
License: GPLv2 or later
*/

// define('TRAC_TICKET_URL', 'http://gsoc.trac.wordpress.org/');
// define('TRAC_TICKET_SHORTCODE', 'ticket');

function fjd_trac_ticket_shortcode ($atts, $content = null)
{
	global $post;
	if (! is_numeric($atts[0])) {
		return;
	}
	
	// allow users to override which Trac is linked
	if (defined('TRAC_TICKET_URL') &&
			 filter_var(TRAC_TICKET_URL, FILTER_VALIDATE_URL, 
					FILTER_FLAG_PATH_REQUIRED)) {
		// e.g. http://gsoc.trac.wordpress.org/
		$trac_link_format = TRAC_TICKET_URL . 'ticket/%d';
	} else {
		$trac_link_format = 'http://core.trac.wordpress.org/ticket/%d';
	}
	$anchor_format = '<a href="%s" title="%s">%s</a>';
	
	$trac_link = sprintf($trac_link_format, $atts[0]);
	$trac_rss = $trac_link . '?format=rss';
	$text = sprintf('#%d', $atts[0]);
	$post_meta_key = sprintf('fjd_trac_ticket_title_%d', $atts[0]);
	
	$title_post_meta = get_post_meta($post->ID, $post_meta_key, true);
	if (! empty($title_post_meta)) {
		$title = $title_post_meta;
	} elseif (function_exists('fetch_feed')) {
		$feed = fetch_feed($trac_rss);
		if (! is_wp_error($feed)) {
			$title = addslashes($feed->get_title());
			update_post_meta($post->ID, $post_meta_key, $title);
		}
	}
	
	if (empty($title))
		$title = $text;
	
	$anchor = sprintf($anchor_format, $trac_link, $title, $text);
	return $anchor;
}

function fjd_trac_ticket_register ()
{
	if (! defined('TRAC_TICKET_SHORTCODE')) {
		add_shortcode('bug', 'fjd_trac_ticket_shortcode');
	} else {
		// let user change what the shortcode is hooked to
		$filtered_tag_name = preg_replace('/[^a-z0-9_]/', '', 
				strtolower(TRAC_TICKET_SHORTCODE));
		add_shortcode($filtered_tag_name, 'fjd_trac_ticket_shortcode');
	}
}
add_action('init', 'fjd_trac_ticket_register');
