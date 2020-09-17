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
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Slug of the page, also used as identifier for hooks
     *
     * @var string
     */
    private $slug = 'app';

    /**
     * Settings key in database, used in get_option() as first parameter
     *
     * @var string
     */
    private $settings_key = 'app_settings';
    
    /**
     * Options group id, will be used as identifier for adding fields to options page
     *
     * @var string
     */
    private $options_group_id = 'app-settings';

    /**
     * Array of all fields that will be printed on the settings page
     *
     * @var array
     */

    private $fields;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version ) {

        $this->fields = $this->get_fields();
        $this->options = $this->get_options();

		$this->plugin_name = $plugin_name;
        $this->version = $version;

    }
    
    /* Get fields data */
    public function get_fields() {

        $fields = array(

            'margin_top' => array(
                'id' => 'margin_top',
                'section_id' => 'app_general_section',
                'title' =>  esc_html__( 'Margin Top', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 120
            ),

            'margin_bottom' => array(
                'id' => 'margin_bottom',
                'section_id' => 'app_general_section',
                'title' =>  esc_html__( 'Margin Bottom', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 120
            ),

            'stop_id' => array(
                'id' => 'stop_id',
                'section_id' => 'app_general_section',
                'title' =>  esc_html__( 'Stop ID', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 'Fotter Bottom ID'
            ),

            'refresh_interval' => array(
                'id' => 'refresh_interval',
                'section_id' => 'app_general_section',
                'title' =>  esc_html__( 'Reresh Interval', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 1500
            ),

            'disable_width' => array(
                'id' => 'disable_width',
                'section_id' => 'app_general_section',
                'title' =>  esc_html__( 'Disable Width', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 1500
            ),

            'disable_height' => array(
                'id' => 'disable_height',
                'section_id' => 'app_general_section',
                'title' =>  esc_html__( 'Disable Height', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 1500
            ),

            'auto_fix_widget_id' => array(
                'id' => 'auto_fix_widget_id',
                'section_id' => 'app_compatible_section',
                'title' =>  esc_html__( 'Auto Fix Widget ID', 'azad-popular-posts' ),
                'sanitize' => 'text',
                'default' => 1500
            ),

        );

        $fields = apply_filters( 'app_modify_options_fields', $fields );

        return $fields;

    }

    /**
     * Get options from database
     */
    private function get_options() {

        $defaults = array();

        foreach ( $this->fields as $field => $args ) {
            $defaults[$field] = $args['default'];
        }

        $defaults = apply_filters( 'app_modify_defaults', $defaults );

        $options = get_option( $this->settings_key );

        $options = azad_parse_args( $options, $defaults );

        $options = apply_filters( 'app_modify_options', $options );

        //print_r( $options );

        return $options;

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
            esc_html__( 'Azad Popular Posts', 'azad-popular-posts' ),
            esc_html__( 'Azad PP', 'azad-popular-posts' ),
            'manage_options',
            $this->slug,
            array( $this, 'print_settings_page' )
        );
    }

    /**
     * Options page callback
     */
    public function print_settings_page() { ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( $this->options_group_id );
                do_settings_sections( $this->slug );
                submit_button();
                ?>
            </form>
        </div> <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {

        register_setting(
            $this->options_group_id, // Option group
            $this->settings_key, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        if ( empty( $this->fields ) ) {
            return false;
        }

        // General Section
        // $section_id = 'app_general_section';

        // add_settings_section( 
        //     $section_id,
        //     esc_html__( 'General Settings', 'azad-popular-posts' ),
        //     '',
        //     $this->slug
        // );

        foreach ( $this->fields as $field ) {

            if ( empty( $field['id'] ) ) {
                continue;
            }

            $section_id = $field['section_id'];

            add_settings_section( 
                $section_id,
                esc_html__( 'General Settings', 'azad-popular-posts' ),
                '',
                $this->slug
            );

            $action = 'print_' . $field['id'] . '_field';
            $callback = method_exists( $this, $action ) ? array( $this, $action ) : $field['action'];

            add_settings_field(
                'app_' . $field['id'] . '_id',
                $field['title'],
                $callback,
                $this->slug,
                $section_id,
                $this->options[$field['id']]
            );
        }

    }

    /**
     * Sanitize each setting field as needed
     */
    public function sanitize( $input ) {

        if ( empty( $this->fields ) || empty( $input ) ) {
            return false;
        }

        $new_input = array();
        foreach ( $this->fields as $field ) {
            if ( isset( $input[$field['id']] ) ) {
                $new_input[$field['id']] = $this->sanitize_field( $input[$field['id']], $field['sanitize'] );
            }
        }

        return $new_input;
    }

    /**
     * Dynamically sanitize field values
     *
     * @param unknown $value
     * @param unknown $sensitization_type
     * @return int|string
     */
    private function sanitize_field( $value, $sensitization_type ) {
        switch ( $sensitization_type ) {

        case "checkbox":
            $new_input = array();
            foreach ( $value as $key => $val ) {
                $new_input[$key] = ( isset( $value[$key] ) ) ?
                    sanitize_text_field( $val ) :
                    '';
            }
            return $new_input;
            break;

        case "radio":
            return sanitize_text_field( $value );
            break;

        case "text":
            return sanitize_text_field( $value );
            break;

        default:
            break;
        }
    }

    /**
     * Print margin top field
     */
    public function print_margin_top_field( $args ) {

        printf(
            '<label><input type="number" id="meks_ess_label" name="%s[margin_top]" value="%s"/></label> px<br>',
            $this->settings_key,
            esc_html( $args )
        );

    }

    /**
     * Print margin bottom field
     */
    public function print_margin_bottom_field( $args ) {

        printf(
            '<label><input type="number" id="meks_ess_label" name="%s[margin_bottom]" value="%s"/></label> px<br>',
            $this->settings_key,
            esc_html( $args )
        );

    }

    /**
     * Print stop id field
     */
    public function print_stop_id_field( $args ) {

        printf(
            '<label><input type="text" id="meks_ess_label" name="%s[stop_id]" value="%s"/></label> px<br/>
            <span><i>You need to provide the HTML tag ID here. The position of that HTML element will determine the margin-bottom value.</i></span>',
            $this->settings_key,
            esc_html( $args )
        );

    }

    /**
     * Print refresh inerval field
     */
    public function print_refresh_interval_field( $args ) {

        printf(
            '<label><input type="text" id="%1$s_label" name="%1$s[refresh_interval]" value="%2$s"/></label> px<br><span><i>milliseconds / Used only for compatibility with browsers without MutationObserver API support. Set 0 to disable it completely.</i></span>',
            $this->settings_key,
            esc_html( $args )
        );

    }

    /**
     * Print disable width field
     */
    public function print_disable_width_field( $args ) {

        printf(
            '<label><input type="text" id="%1$s_label" name="%1$s[disable_width]" value="%2$s"/></label> px<br><span><i>Use this option to disable the plugin on portable devices. When the browser screen width is less than the specified value, the plugin will be disabled.</i></span>',
            $this->settings_key,
            esc_html( $args )
        );

    }

    /**
     * Print disable height field
     */
    public function print_disable_height_field( $args ) {

        printf(
            '<label><input type="text" id="%1$s_auto_fix_widget_id" name="%1$s[disable_height]" value="%2$s"/></label> px<br><span><i>Works like the Disable Width option.</i></span>',
            $this->settings_key,
            esc_html( $args )
        );        

    }

    /**
     * Print auto fix widget ID field
     */
    public function print_auto_fix_widget_id_field( $args ) {

        printf(
            '<label><input type="text" id="%1$s_auto_fix_widget_id" name="%1$s[auto_fix_widget_id]" value="%2$s"/></label> px<br><span><i>Works like the Disable Width option.</i></span>',
            $this->settings_key,
            esc_html( $args )
        );        

    }

}