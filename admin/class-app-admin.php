<?php
/**
 * The admin-specific functionality of the plugin.
 */
class AppAdmin {

	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Add styles for admin
	 */
	public function enqueue_styles() {

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-amc-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'wp-color-picker', '', array(), $this->version, 'all' );

	}

	/**
	 * Add js code for admin
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-amc-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );

	}

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_submenu_page(
            'themes.php',
            'Azad Popular Posts',
            'Azad PP',
            'manage_options',
            'woocommerce-ajax-mini-cart',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'app' );
        ?>
        <div class="wrap">
            <h1>Azad Popular Posts</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'woo_amc_group' );
                do_settings_sections( 'woocommerce-ajax-mini-cart' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'woo_amc_group', // Option group
            'woo_amc_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'woo_amc_section_general', // ID
            'General settings', // Title
            '', // Callback
            'woocommerce-ajax-mini-cart' // Page
        );

        add_settings_section(
            'woo_amc_section_button', // ID
            'Button settings', // Title
            '', // Callback
            'woocommerce-ajax-mini-cart' // Page
        );

        add_settings_section(
            'woo_amc_section_bg', // ID
            'Background settings', // Title
            '', // Callback
            'woocommerce-ajax-mini-cart' // Page
        );

        add_settings_field(
            'enabled', // ID
            'Enabled', // Title
            array( $this, 'enabled_callback' ), // Callback
            'woocommerce-ajax-mini-cart', // Page
            'woo_amc_section_general' // Section
        );

        add_settings_field(
            'cart_type', // ID
            'Type', // Title
            array( $this, 'cart_type_callback' ), // Callback
            'woocommerce-ajax-mini-cart', // Page
            'woo_amc_section_general' // Section
        );

        add_settings_field(
            'button_icon_color', // ID
            'Icon Color', // Title
            array( $this, 'button_icon_color_callback' ), // Callback
            'woocommerce-ajax-mini-cart', // Page
            'woo_amc_section_button' // Section
        );
        add_settings_field(
            'button_bg_color', // ID
            'Background Color', // Title
            array( $this, 'button_bg_color_callback' ), // Callback
            'woocommerce-ajax-mini-cart', // Page
            'woo_amc_section_button' // Section
        );

        add_settings_field(
            'button_border_radius', // ID
            'Border Radius', // Title
            array( $this, 'button_border_radius_callback' ), // Callback
            'woocommerce-ajax-mini-cart', // Page
            'woo_amc_section_button' // Section
        );

    }

    /**
     * Sanitize each setting field as needed
     */
    public function sanitize( $input ) {
        $new_input = array();

        if( isset( $input['enabled'] ) )
            $new_input['enabled'] = sanitize_text_field( $input['enabled'] );

        if( isset( $input['cart_type'] ) )
            $new_input['cart_type'] = sanitize_text_field( $input['cart_type'] );

        if( isset( $input['button_icon_color'] ) )
            $new_input['button_icon_color'] = sanitize_text_field( $input['button_icon_color'] );

        if( isset( $input['button_bg_color'] ) )
            $new_input['button_bg_color'] = sanitize_text_field( $input['button_bg_color'] );

        if( isset( $input['button_border_radius'] ) )
            $new_input['button_border_radius'] = absint( $input['button_border_radius'] );

        if( isset( $input['button_position'] ) )
            $new_input['button_position'] = sanitize_text_field( $input['button_position'] );

        if( isset( $input['button_count_bg'] ) )
            $new_input['button_count_bg'] = sanitize_text_field( $input['button_count_bg'] );

        if( isset( $input['button_count_color'] ) )
            $new_input['button_count_color'] = sanitize_text_field( $input['button_count_color'] );

        if( isset( $input['bg_color'] ) )
            $new_input['bg_color'] = sanitize_text_field( $input['bg_color'] );

        if( isset( $input['bg_opacity'] ) )
            $new_input['bg_opacity'] = absint( $input['bg_opacity'] );

        if( isset( $input['cart_bg'] ) )
            $new_input['cart_bg'] = sanitize_text_field( $input['cart_bg'] );

        if( isset( $input['cart_loader_color'] ) )
            $new_input['cart_loader_color'] = sanitize_text_field( $input['cart_loader_color'] );

        if( isset( $input['cart_header_bg'] ) )
            $new_input['cart_header_bg'] = sanitize_text_field( $input['cart_header_bg'] );

        if( isset( $input['cart_header_title'] ) )
            $new_input['cart_header_title'] = sanitize_text_field( $input['cart_header_title'] );

        if( isset( $input['cart_header_title_size'] ) )
            $new_input['cart_header_title_size'] = sanitize_text_field( $input['cart_header_title_size'] );

        if( isset( $input['cart_header_title_color'] ) )
            $new_input['cart_header_title_color'] = sanitize_text_field( $input['cart_header_title_color'] );

        if( isset( $input['cart_header_close_color'] ) )
            $new_input['cart_header_close_color'] = sanitize_text_field( $input['cart_header_close_color'] );

        if( isset( $input['cart_item_bg'] ) )
            $new_input['cart_item_bg'] = sanitize_text_field( $input['cart_item_bg'] );

        

        return $new_input;
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function enabled_callback() {
        ?>
        <select name="woo_amc_options[enabled]">
            <option value="yes" <?php selected($this->options['enabled'], "yes"); ?>>Yes</option>
            <option value="no" <?php selected($this->options['enabled'], "no"); ?>>No</option>
        </select>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function cart_type_callback() {
        ?>
        <select name="woo_amc_options[cart_type]">
            <option value="left" <?php selected($this->options['cart_type'], "left"); ?>>Left</option>
            <option value="center" <?php selected($this->options['cart_type'], "center"); ?>>Center</option>
            <option value="right" <?php selected($this->options['cart_type'], "right"); ?>>Right</option>
        </select>
        <?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function button_icon_color_callback() {
        printf(
            '<input type="text" id="button_icon_color" class="woo_amc_select_color" name="woo_amc_options[button_icon_color]" value="%s" />',
            isset( $this->options['button_icon_color'] ) ? esc_attr( $this->options['button_icon_color']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function button_bg_color_callback() {
        printf(
            '<input type="text" id="button_bg_color" class="woo_amc_select_color" name="woo_amc_options[button_bg_color]" value="%s" />',
            isset( $this->options['button_bg_color'] ) ? esc_attr( $this->options['button_bg_color']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function button_border_radius_callback() {
        printf(
            '<input type="text" id="button_border_radius" name="woo_amc_options[button_border_radius]" value="%s" size="4" /> px',
            isset( $this->options['button_border_radius'] ) ? esc_attr( $this->options['button_border_radius']) : ''
        );
    }

}