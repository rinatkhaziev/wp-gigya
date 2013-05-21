<?php
/**
 * Frontend Uploader Settings
 */
class WP_Gigya_Settings {

	private $settings_api, $public_post_types = array();

	function __construct() {
		$this->settings_api = new WeDevs_Settings_API;

		add_action( 'current_screen', array( $this, 'action_current_screen' ) );
		add_action( 'admin_menu', array( $this, 'action_admin_menu' ) );
	}

	/**
	 * Only run if current screen is plugin settings or options.php
	 * @return [type] [description]
	 */
	function action_current_screen() {
		$screen = get_current_screen();
		if ( in_array( $screen->base, array( 'settings_page_fu_settings', 'options' ) ) ) {
			$this->settings_api->set_sections( $this->get_settings_sections() );
			$this->settings_api->set_fields( $this->get_settings_fields() );
			// Initialize settings
			$this->settings_api->admin_init();
		}
	}

	/**
	 * Get post types for checkbox option
	 * @return array of slug => label for registered post types
	 */
	function get_post_types() {
		$wpg_public_post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach( $wpg_public_post_types as $slug => $post_object ) {
			if ( $slug == 'attachment' ) {
				unset( $wpg_public_post_types[$slug] );
				continue;
			}
			$wpg_public_post_types[$slug] = $post_object->labels->name;
		}
		return $wpg_public_post_types;
	}

	function action_admin_menu() {
		add_options_page( __( 'Frontend Uploader Settings', 'wp-gigya' ) , __( 'Frontend Uploader Settings', 'wp-gigya' ), 'manage_options', 'fu_settings', array( $this, 'plugin_page' ) );
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'frontend_uploader_settings',
				'title' => __( 'Basic Settings', 'wp-gigya' ),
			),
		);
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {;
		$settings_fields = array(
			'wp_gigya_settings' => array(
				array(
					'name' => 'api_key',
					'label' => __( 'API Key', 'wp-gigya' ),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'api_secret',
					'label' => __( 'API Secret', 'wp-gigya' ),
					'type' => 'text',
					'default' => '',
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'comments_id',
					'label' => __( 'Comments ID', 'wp-gigya' ),
					'desc' => __( '', 'wp-gigya' ),
					'type' => 'text',
					'default' => '' ,
					'sanitize_callback' => 'sanitize_text_field'
				),
				array(
					'name' => 'chat_id',
					'label' => __( 'Chat ID', 'wp-gigya' ),
					'desc' => __( '', 'wp-gigya' ),
					'type' => 'text',
					'default' => '' ,
					'sanitize_callback' => 'sanitize_text_field'
				),
			),
		);
		return $settings_fields;
	}

	/**
	 * Render the UI
	 */
	function plugin_page() {
		echo '<div class="wrap">';
		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();
		echo '</div>';
	}
}

// Instantiate
$frontend_uploader_settings = new Frontend_Uploader_Settings;