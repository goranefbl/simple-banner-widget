<?php
/**
 *
 * Plugin Name:       Super Simple Banner Widget
 * Plugin URI:        http://www.itsgoran.com
 * Description:       Widgets for Advertising Banners.
 * Version:           1.0.0
 * Author:            Goran Jakovljevic
 * Text Domain:       lt-ads-widgets
 * Domain Path:       /lang
 */
 
 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// TODO: change 'Widget_Name' to the name of your plugin
class Lt_Ads_Widgets extends WP_Widget {

    protected $widget_slug = 'lt-ads-widgets';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		// TODO: update description
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Simple Banner Widget', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Place Advertising on your site.', $this->get_widget_slug() )
			)
		);

		// Register admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	} // end constructor


    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		
		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		// go on with your widget logic, put everything into a string and …


		extract( $args, EXTR_SKIP );
		$title = apply_filters( 'widget_title', $instance['title'] );

		$widget_string = $before_widget;
		// TODO: Here is where you manipulate your widget's values based on their input fields
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget
	
	
	public function flush_widget_cache() 
	{
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		// TODO: Here is where you update your widget's old values with the new, incoming values
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['size'] = strip_tags( $new_instance['size'] );
		$instance['ad_width'] = strip_tags( $new_instance['ad_width'] );
		$instance['ad_height'] = strip_tags( $new_instance['ad_height'] );
		$instance['ads'] = array();

		if(!empty($new_instance['ad_img']) && !empty($new_instance['ad_link'])){
			for($i=0; $i < (count($new_instance['ad_img']) ); $i++){
				if(!empty($new_instance['ad_img'][$i]) && !empty($new_instance['ad_link'][$i])){
					$ad = array();
					$ad['img'] = esc_url($new_instance['ad_img'][$i]);
					$ad['link'] = esc_url($new_instance['ad_link'][$i]);
					$instance['ads'][] = $ad;
				}
			}	
		}

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$default_settings = array(
	      'title' 	 => '',
	      'size' => '',
	      'ad_width'=>'',
	      'ad_height' 	 => '',
	      'ads'	=> array()
	    );

		// TODO: Define default values for your variables
		$instance = wp_parse_args(
			(array) $instance,
			$default_settings
		);

		// TODO: Store the values of the widget in their own variable
		$title = $instance['title'];
		$size = $instance['size'];
		$ad_width = $instance['ad_width'];
		$ad_height = $instance['ad_height'];
		$ads = $instance['ads'];
		// Display the admin form
		include( plugin_dir_path(__FILE__) . 'views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	public function widget_textdomain() {

		load_plugin_textdomain( $this->get_widget_slug(), false, plugin_dir_path( __FILE__ ) . 'lang/' );

	} // end widget_textdomain
	
	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'css/widget.css', __FILE__ ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'js/widget.js', __FILE__ ), array('jquery') );

	} // end register_widget_scripts

} // end class

add_action( 'widgets_init', create_function( '', 'register_widget("Lt_Ads_Widgets");' ) );
