<?php
/*
* Plugin Name: Lite Syntax Highlighting
* Plugin URI: http://blweb.ru/plugin-lite-syntax-highlighting
* Description: Lite Syntax Highlighting for PHP, JS, CSS ans HTML code
* Version: 0.5
* Author: Maksim Iliukovich
* Text Domain: lite-syntax-highlighting
* Author URI: http://blweb.ru
*/

require_once dirname( __FILE__ ) . '/LiteSyntaxHighlighting.php';
require_once dirname( __FILE__ ) . '/LiteSyntaxSupporter.php';
require_once dirname( __FILE__ ) . '/LiteSyntaxOptionsPage.php';

add_action( 'admin_init', 'LiteSyntaxHighlighting::languagesSetup');
add_action( 'wp_enqueue_scripts', 'LiteSyntaxHighlighting::liteSyntaxHighlightingResources' );
add_action( 'admin_print_footer_scripts', 'LiteSyntaxHighlighting::liteSyntaxHighlightingAddButtons' );
add_action('admin_menu', 'LiteSyntaxOptionsPage::addConfigPage');

add_filter("plugin_action_links_".plugin_basename(  __FILE__ ), 'LiteSyntaxOptionsPage::addSettingsLink' );

register_activation_hook( __FILE__, 'LiteSyntaxHighlighting::activation' );
register_uninstall_hook( __FILE__, 'LiteSyntaxHighlighting::uninstall' );

add_shortcode(LiteSyntaxSupporter::$SHORT_CODE, 'LiteSyntaxSupporter::shortCodeFunction');

// we need do_shortcode before using function wpautop
remove_filter('the_content', 'wpautop');
add_filter('the_content', 'LiteSyntaxSupporter::wpAutoP');

add_filter('comment_text', 'do_shortcode');