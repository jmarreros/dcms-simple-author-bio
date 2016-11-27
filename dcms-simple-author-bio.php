<?php
 /*
 * Plugin Name:       DCMS Simple Author Bio
 * Plugin URI:        https://decodecms.com
 * Description:       This plugins shows the bio in articles
 * Version:           1.0.0
 * Author:            Jhon Marreros Guzmán
 * Author URI:        https://decodecms.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dcms-simple-author-bio
 * Domain Path:       /languages
 */

//if this file is called directly, abort
if ( ! defined('WPINC') ) die();

require_once plugin_dir_path( __FILE__ ).'includes/class-dcms-simple-author-bio.php';

register_activation_hook( __FILE__, ['Dcms_Simple_Author_Bio','dcms_sab_activate'] );

new Dcms_Simple_Author_Bio();



add_action('init', 'dcms_plugin_load_textdomain');

function dcms_plugin_load_textdomain() {
	
	$text_domain	= 'dcms-simple-author-bio';
	$path_languages = basename(dirname(__FILE__)).'/languages/';

 	load_plugin_textdomain($text_domain, false, $path_languages );
}

