<?php
/*
Plugin Name: Lite Syntax Highlighting
Plugin URI: http://blweb.ru
Description: Lite Syntax Highlighting for PHP, JS, CSS ans HTML code
Version: 0.1
Author: Maksim Iliukovich
Author URI: http://blweb.ru
*/
require_once dirname( __FILE__ ) . '/functions.php';

add_action( 'wp_enqueue_scripts', 'liteSyntaxHighlightingResources' );
add_action( 'admin_print_footer_scripts', 'liteSyntaxHighlightingAddButtons' );