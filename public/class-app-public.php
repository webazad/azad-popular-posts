<?php

class AppPublic {

    /**
     * The ID of this plugin.
     */
    public $plugin_name;

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
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles() {

        // $options = get_option('woo_amc_options');
        // $enabled = isset( $options['enabled']) ? $options['enabled'] : 1;
        // if( ( is_cart() || is_checkout() ) && $enabled != 1 ){return;}
        // wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-amc-public.css', array(), $this->version, 'all' );

        // $inline_css = $this->get_inline_css();
        // wp_add_inline_style( $this->plugin_name, $inline_css );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts() {

        //self::custom_ids();		
		//self::fixed_wigets();		
		//wp_enqueue_script('jquery');		
		wp_enqueue_script( 'azad-fixed-widget', plugin_dir_url( __FILE__ ) . 'js/azad-fixed-widget.js', array('jquery'), $this->version, true);		
		self::wp_localize_script( 'azad-fixed-widget' );

        // $options = get_option( 'app_settings' );
        // $enabled = isset( $options['enabled']) ? $options['enabled'] : 1;
        // wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-amc-public.js', array( 'jquery' ), $this->version, false );

        // wp_localize_script( $this->plugin_name, 'wooAmcVars', array(
        //         'ajaxurl' => admin_url( 'admin-ajax.php' ),
        //         'nonce' => wp_create_nonce( 'woo-amc-security' ),
        //         'cart_type' => $options['cart_type'],
        //     )
        // );

    }

    protected static function wp_localize_script( $id ) {

        $options = self::load_options();
        
		// if ( is_array(self::$fixed_widgets) && !empty(self::$fixed_widgets) ) {		
		// 	if ( isset($options['window-load-enabled']) && $options['window-load-enabled'] == 'yes' ) $window_load_hook = true; else $window_load_hook = false;	
		// 	if ( isset($options['width-inherit']) && $options['width-inherit'] ) $width_inherit = true; else $width_inherit = false;				
		// 	if ( isset($options['disable-mo-api']) && $options['disable-mo-api'] ) $disable_mo_api = true; else $disable_mo_api = false;				
		// 	if ( $options['refresh-interval'] > 0 ) $refresh_interval = $options['refresh-interval']; else $refresh_interval = 0;				
		// 	$i = 0;
		// 	$sidebar_options = array();				
		// 	self::$fixed_widgets = apply_filters( 'q2w3-fixed-widgets', self::$fixed_widgets ); // this filter was requested by users			
		// 	foreach ( self::$fixed_widgets as $sidebar => $widgets ) {		
		// 		$sidebar_options[ $i ] = array(
		// 				'sidebar' => $sidebar,
		// 				'margin_top' => $options['margin-top'],
		// 				'margin_bottom' => $options['margin-bottom'],
		// 				'stop_id' => $options['stop-id'],
		// 				'screen_max_width' => $options['screen-max-width'],
		// 				'screen_max_height' => $options['screen-max-height'],
		// 				'width_inherit' => $width_inherit,
		// 				'refresh_interval' => $refresh_interval,
		// 				'window_load_hook' => $window_load_hook,
		// 				'disable_mo_api' => $disable_mo_api,
		// 				'widgets' => array_values( $widgets )
		// 		);		
		// 		$i++;		
		// 	}				
			// wp_localize_script( $this->plugin_name, 'q2w3_sidebar_options', $sidebar_options );				
			wp_localize_script( $id, 'q2w3_sidebar_options', $options );				
        // }
        				
    }
    
    protected static function defaults() {

		$defaults['margin_top'] = 10;			
        $defaults['margin_bottom'] = 0;		
		$defaults['stop_id'] = '';		
		$defaults['refresh_interval'] = 1500;		
		$defaults['screen-max-width'] = 0;		
		$defaults['screen-max-height'] = 0;		
		$defaults['fix-widget-id'] = 'yes';		
		$defaults['window-load-enabled'] = false;	
		$defaults['logged_in_req'] = false;	
		$defaults['width-inherit'] = false;		
		$defaults['disable-mo-api'] = false;

        return $defaults;

    }
    
	protected static function load_options() {

        $options = get_option( 'app_settings' );
        return $options = azad_parse_args( $options, self::defaults() );
        
	}

    private function get_inline_css(){

        // $css = get_option('woo_amc_options');
        // $button_icon_color  = isset( $css['button_icon_color'] ) ? $css['button_icon_color'] : 'red';
        // $css = "
        //     .woo_amc_open{
        //         background: {$button_bg_color};
        //         border-radius: {$button_border_radius}px;
        //     }
        //     .woo_amc_open path{
        //         fill: {$button_icon_color};
        //     }
        // ";

        // return $css;

    }

}
