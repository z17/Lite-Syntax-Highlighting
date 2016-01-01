<?php
/*
Plugin Name: Lite Syntax Highlighting
Plugin URI: http://blweb.ru
Description: Lite Syntax Highlighting for PHP, JS, CSS ans HTML code
Version: 0.1
Author: Maksim Iliukovich
Author URI: http://blweb.ru
*/
require_once dirname( __FILE__ ) . '/LiteSyntaxHighlighting.php';

add_action( 'wp_enqueue_scripts', array('LiteSyntaxHighlighting', 'liteSyntaxHighlightingResources') );
add_action( 'admin_print_footer_scripts', array('LiteSyntaxHighlighting', 'liteSyntaxHighlightingAddButtons') );
add_action('admin_menu', array('LiteSyntaxHighlighting', 'liteSyntaxHighlightingAddConfigPag'));

function activatePlugin() {
    LiteSyntaxHighlighting::activation();
}
register_activation_hook( __FILE__, 'activatePlugin' );


function uninstallPlugin() {
    LiteSyntaxHighlighting::uninstall();
}
register_uninstall_hook( __FILE__, 'uninstallPlugin' );