<?php
/*
Plugin Name: Lite Syntax Highlighting
Plugin URI: http://blweb.ru/plugin-lite-syntax-highlighting
Description: Lite Syntax Highlighting for PHP, JS, CSS ans HTML code
Version: 0.5
Author: Maksim Iliukovich
Author URI: http://blweb.ru
*/

// todo: check work short codes in comments
// todo: check work all langs with replace < > in PHP and not
// todo: edit readme
// todo: test options with upload, activate and other actions
require_once dirname( __FILE__ ) . '/LiteSyntaxHighlighting.php';
require_once dirname( __FILE__ ) . '/LiteSyntaxSupporter.php';

add_action( 'admin_init', 'LiteSyntaxHighlighting::languagesSetup');
add_action( 'wp_enqueue_scripts', 'LiteSyntaxHighlighting::liteSyntaxHighlightingResources' );
add_action( 'admin_print_footer_scripts', 'LiteSyntaxHighlighting::liteSyntaxHighlightingAddButtons' );
add_action('admin_menu', 'LiteSyntaxHighlighting::liteSyntaxHighlightingAddConfigPag');

add_filter("plugin_action_links_".plugin_basename(  __FILE__ ), 'LiteSyntaxHighlighting::addSettingsLink' );

register_activation_hook( __FILE__, 'LiteSyntaxHighlighting::activation' );
register_uninstall_hook( __FILE__, 'LiteSyntaxHighlighting::uninstall' );

add_shortcode(LiteSyntaxSupporter::$SHORT_CODE, 'LiteSyntaxSupporter::shortCodeFunction');