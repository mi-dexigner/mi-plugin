<?php
/**
 * @wordpress-plugin
 * Plugin Name:      MI Plugin
 * Plugin URI:        http://miplugin.com
 * Description:       create a basic plugin
 * Version:           1.0.0
 * Author:            MI Dexigner Team
 * Author URI:         http://www.midexigner.com
 * Text Domain:       mi-plugin
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/mi-dexigner/mi-plugin
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
use Inc\Activate;
use Inc\Deactivate;

if ( !class_exists( 'MIPlugin' ) ) {
	class MIPlugin
	{
		public $plugin;
		function __construct() {
			$this->plugin = plugin_basename( __FILE__ );
		}
		function register() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
		}
		public function settings_link( $links ) {
			$settings_link = '<a href="http://www.midexigner.com" target="_blank">Visit Website</a>  |  ';
			$settings_link .= '<a href="http://www.midexigner.com/donate/" target="_blank">Donate Now</a>';
			array_push( $links, $settings_link );
			return $links;
		}
		protected function create_post_type() {
			add_action( 'init', array( $this, 'custom_post_type' ) );
		}
		function custom_post_type() {
			register_post_type( 'book', ['public' => true, 'label' => 'Books'] );
		}
		function enqueue() {
			// enqueue all our scripts
			wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/css/admin.css', __FILE__ ) );
			wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/js/admin.js', __FILE__ ) );
		}
		function activate() {
			Activate::activate();
		}
	}
}
	$MIPlugin = new MIPlugin();
	$MIPlugin->register();
	// activation
	register_activation_hook( __FILE__, array( $MIPlugin, 'activate' ) );
	// deactivation
	register_deactivation_hook( __FILE__, array( 'Deactivate', 'deactivate' ) );