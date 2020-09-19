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

    protected static $fixed_widgets;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->fixed_widget();

    }

    public function fixed_widget() {

        $sidebars = wp_get_sidebars_widgets();
        if ( $sidebars && is_array( $sidebars ) ) {
            foreach ( $sidebars as $sidebar_id => $sidebar_widgets){
                if ( ! ( stristr($sidebar_id, 'orphaned_widgets') !== false || $sidebar_id == 'wp_inactive_widgets' ) ) {
                    if ( $sidebar_widgets && is_array( $sidebar_widgets ) ) {
                        foreach ( $sidebar_widgets as $widget ) {
                            
                            $widget_id = substr( strrchr( $widget, '-' ), 1 );
                            $widget_type = stristr($widget, '-'.$widget_id, true);
                            $widget_options = get_option('widget_' . $widget_type);

                            if ( isset( $widget_options[$widget_id]['fixed'] ) && $widget_options[$widget_id]['fixed'] ) {
                                self::$fixed_widgets[] = $widget;
                            }

                        }
                    }
                }
            }            
        }

    }
	
	public function enqueue_styles() {
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/azad-popular-posts.min.css', array(), $this->version, 'all' );
		
	}

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/azad-fixed-widget.js', array( 'jquery' ), $this->version, true );		
		self::wp_localize_script( $this->plugin_name );

    }

    protected static function wp_localize_script( $id ) {        

        $settings = get_option( 'app_settings' );
        $options[] = array(
            'margin_top' => (int)$settings['margin_top'],
            'margin_bottom' => (int)$settings['margin-bottom'],
			'stop_id' => $settings['stop_id'],
			// 'screen_max_width' => $settings['screen-max-width'],
			'widgets' => self::$fixed_widgets,
			
			// 'screen_max_height' => $options['screen-max-height'],
			// 'width_inherit' => $width_inherit,
			// 'refresh_interval' => $refresh_interval,
			// 'window_load_hook' => $window_load_hook,
			// 'disable_mo_api' => $disable_mo_api,
        );
        wp_localize_script( $id, 'q2w3_sidebar_options', $options );				
        				
    }

}
