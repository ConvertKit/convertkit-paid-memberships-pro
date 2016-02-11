<?php

/**
 * The admin-specific functionality for ConvertKit Paid Memberships Pro
 *
 * @link       http://www.convertkit.com
 * @since      1.0.0
 *
 * @package    ConvertKit_PMP
 * @subpackage ConvertKit_PMP/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ConvertKit_PMP
 * @subpackage ConvertKit_PMP/admin
 * @author     Daniel Espinoza <daniel@growdevelopment.com>
 */
class ConvertKit_PMP_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * API functionality class
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var     ConvertKit_PMP_API $api
	 */
	private $api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-convertkit-pmp-api.php';

		$api_key = $this->get_option( 'api_key' );

		$this->api = new ConvertKit_PMP_API( $api_key );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/convertkit-pmp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/convertkit-pmp-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 *  Register settings for the plugin.
	 *
	 * @since       1.0.0
	 * @return      void
	 */
	public function register_settings() {

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->plugin_name . '-display-options',
			apply_filters( $this->plugin_name . '-display-section-title', __( 'General', 'convertkit-pmp' ) ),
			array( $this, 'display_options_section' ),
			$this->plugin_name
		);

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'api-key',
			apply_filters( $this->plugin_name . '-display-api-key', __( 'API Key', 'convertkit-pmp' ) ),
			array( $this, 'display_options_api_key' ),
			$this->plugin_name,
			$this->plugin_name . '-display-options'
		);

		add_settings_field(
			'form',
			apply_filters( $this->plugin_name . '-display-form', __( 'Default form', 'convertkit-pmp' ) ),
			array( $this, 'display_options_form' ),
			$this->plugin_name,
			$this->plugin_name . '-display-options'
		);


	}


	/**
	 * Adds a settings page link to a menu
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {
		// add_options_page( $page_title, $menu_title, $capability, $menu_slug, $callback );
		add_options_page(
			apply_filters( $this->plugin_name . '-settings-page-title', __( 'ConvertKit PMP Settings', 'convertkit-pmp' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', __( 'ConvertKit PMP', 'convertkit-pmp' ) ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'options_page' )
		);
	}


	/**
	 * Creates the options page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function options_page() {
		?><div class="wrap"><h1><?php echo esc_html( get_admin_page_title() ); ?></h1></div>
		<form action="options.php" method="post"><?php
		settings_fields( 'convertkit-pmp-options' );
		do_settings_sections( $this->plugin_name );
		submit_button( 'Save Settings' );
		?></form><?php
	}


	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {
		$valid = array();

		// TODO Finish validation


		return $input;
	}

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function display_options_section( $params ) {
		echo '<p>' . __( 'Add your API key below and then choose a default form to add subscribers to.','convertkit-pmp') .'</p>';
	}

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of links
	 * @return 		array 					The modified array of links
	 */
	public function settings_link( $links ) {

		$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=' . $this->plugin_name ), __( 'Settings', 'convertkit-pmp' ) );
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Creates a settings checkbox
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The checkbox field
	 */
	public function display_options_checkbox( $field_name) {
		$options 	= get_option( $this->plugin_name . '-options' );
		$option 	= 0;
		if ( ! empty( $options['display-salary'] ) ) {
			$option = $options['display-salary'];
		}
		?><input type="checkbox" id="<?php echo $this->plugin_name; ?>-options'[<?php echo $field_name ?>]" name="<?php echo $this->plugin_name; ?>-options'[<?php echo $field_name ?>]" value="1" <?php checked( 1, $option, false ); ?> /><?php
	}

	/**
	 * Creates a settings input for the API key.
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function display_options_api_key() {
		$api_key = $this->get_option( 'api-key' );

		?><input type="text" id="<?php echo $this->plugin_name; ?>-options[api-key]" name="<?php echo $this->plugin_name; ?>-options[api-key]" value="<?php echo esc_attr( $api_key ); ?>" /><br/>
		<p class="description"><a href="https://app.convertkit.com/account/edit" target="_blank"><?php echo __( 'Get your ConvertKit API Key', 'convertkit-pmp' ); ?></a></p><?php
	}


	/**
	 * Creates a settings input for the API key.
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function display_options_form() {
		$form = $this->get_option( 'form' );

		$forms = $this->api->get_forms();

		if ( 0 === count( $forms ) ){
			$options = array( '' => __( 'Add API key to retrieve forms', 'convertkit-pmp' ) );
		} else {
			$options = $forms;
		}

		error_log( print_r( $options, true ) );

		?><select id="<?php echo $this->plugin_name; ?>-options[form]" name="<?php echo $this->plugin_name; ?>-options[form]"><?php
		foreach ( $options as $value => $text ) {
			?><option value="<?php echo $value; ?>" <?php selected( $form, $value); ?>><?php echo $text; ?></option><?
		}
		?></select><?php

	}


	/**
	 * Get the setting option requested.
	 *
	 * @since   1.0.0
	 * @param   $option_name
	 * @return  string $option
	 */
	public function get_option( $option_name ){

		$options = get_option( $this->plugin_name . '-options' );
		$option = '';

		if ( ! empty( $options[ $option_name ] ) ) {
			$option = $options[ $option_name ];
		}

		return $option;
	}

}