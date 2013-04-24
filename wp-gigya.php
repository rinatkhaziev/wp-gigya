<?php
/*
Plugin Name: RK Gigya
Plugin URI: http://digitallyconscious.com
Description: Taking care of Gigya integration for WordPress/WordPress VIP in minimalistic way
Author: Rinat Khaziev, doejo
Version: 0.0
Author URI: http://doejo.com

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

/**
 * This is a slight rewrite of Localtv_Gigya.
 *
 * @todo  package it as a complete standalone plugin and open source it.
 */

// __FILE__ resolves to abspath of symlinked file
define( 'RK_GIGYA_VERSION', '0.0' );
define( 'RK_GIGYA_ROOT' , dirname( __FILE__ ) );
define( 'RK_GIGYA_FILE_PATH' , RK_GIGYA_ROOT . '/' . basename( __FILE__ ) );
define( 'RK_GIGYA_URL' , plugins_url( '', __FILE__ ) );

class RK_Gigya {
	private static $instance;
	protected $API_Key, $API_Secret, $comments_ID, $chat_ID, $params;

	/**
	 * set Gigya API params
	 */
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Set our properties
	 *
	 * @todo  get rid of dependencies in order to release as a standalone plugin (use settings api)
	 * @return [type] [description]
	 */
	public function init() {
		$this->API_Key = rt_get_setting( 'gigya_api_key', false );
		$this->API_Secret = rt_get_setting( 'gigya_secret_key', false );
		$this->comments_ID = rt_get_setting( 'gigya_comments_category_id', false );
		$this->chat_ID = rt_get_setting( 'gigya_chat_id', false );
	}

	/**
	 *
	 *
	 * @todo  needs refactoring before release
	 * @param string  $block  what block to render
	 * @param array   $params
	 */
	function render( $block = '', $params = array() ) {
		$this->params = $params; //assign view-specific params to instance property $params
		ob_start();
		require "partial-".$block.".php";
		echo ob_get_clean();
	}
	/**
	 * Convert html entities to characters, strip all scripts, and escape double quotes
	 */
	function validate_and_format_string_for_js( $string ) {
		return trim( esc_js( html_entity_decode( $string, ENT_COMPAT, 'UTF-8' ) ) );
	}

	function enqueue_scripts() {
		wp_enqueue_script( 'gigya-socialize', 'http://cdn.gigya.com/js/socialize.js?apiKey=' . $this->API_Key );
		wp_enqueue_script( 'gigya', RK_GIGYA_URL  . 'inc/js/gigya.js' );
		wp_localize_script( 'gigya', 'conf', array( 'APIKey' => $this->API_Key ) );
		wp_localize_script( 'gigya', 'gigya_params', array( 'comments_id' => $this->comments_ID ) );

	}
}

/**
 * Template tag
 * @param  [type] $block [description]
 * @return [type]        [description]
 */
function rk_gigya_render( $block, $args = array() ) {
	global $rk_gigya;
	$rk_gigya->render( $block, $args );
}


global $rk_gigya;
$rk_gigya = new RK_Gigya();
