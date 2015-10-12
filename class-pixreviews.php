<?php
/**
 * PixReviews.
 * @package   PixReviewsPlugin
 * @author    Pixelgrade <contact@pixelgrade.com>
 * @license   GPL-2.0+
 * @link      http://pixelgrade.com
 * @copyright 2014 Pixelgrade
 */
class PixReviewsPlugin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 * @since   1.0.0
	 * @const   string
	 */
	protected $version = '1.0.0';
	/**
	 * Unique identifier for your plugin.
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'comments-ratings';

	/**
	 * Instance of this class.
	 * @since    1.0.0
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Path to the plugin.
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_basepath = null;
	protected $plugin_baseurl = null;

	public $display_admin_menu = false;

	protected static $config;

	public static $plugin_settings;

	protected static $localized = array();

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 * @since     1.0.0
	 */
	protected function __construct() {
		$this->plugin_basepath = plugin_dir_path( __FILE__ );
		$this->plugin_baseurl = plugin_dir_url( __FILE__ );
		self::$config          = self::get_config();
		self::$plugin_settings = get_option( 'pixreviews_settings' );

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) . 'pixreviews.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'comment_form_logged_in_after', array( $this, 'output_rating_field' ) ); // Logged in
		add_action( 'comment_form_after_fields', array( $this, 'output_rating_field' ) ); // Guest

		add_action( 'comment_post', array( $this, 'save_comment' ) );
		add_action( 'comment_text', array( $this, 'display_rating' ) );
	}

	/**
	 * Return an instance of this class.
	 * @since     1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

	}

	/**
	 * Fired when the plugin is deactivated.
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 * @since    1.0.0
	 */
	function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, basename( dirname( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Settings page scripts
	 */
	function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
			wp_localize_script( $this->plugin_slug . '-admin-script', 'locals', array(
				'ajax_url' => admin_url( 'admin-ajax.php' )
			) );
		}
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		// add assets here
		wp_enqueue_script( 'jquery-raty', $this->plugin_baseurl . 'js/jquery.raty.js' , array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'jquery-raty-style', $this->plugin_baseurl . 'css/jquery.raty.css' , array(), $this->version, false );
		wp_enqueue_script( 'reviews-scripts', $this->plugin_baseurl . 'js/reviews.js' , array( 'jquery-raty' ), $this->version, true );

		wp_localize_script( 'reviews-scripts', 'pixreviews', array(
				'hints' => array (
					__( 'Terrible', 'pixreviews_txtd'),
					__( 'Poor', 'pixreviews_txtd'),
					__( 'Average', 'pixreviews_txtd'),
					__( 'Very Good', 'pixreviews_txtd'),
					__( 'Exceptional', 'pixreviews_txtd'),
				)
			)
		);
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_options_page( __( 'Comments Ratings', 'pixreviews_txtd' ), __( 'Comments Ratings', 'pixreviews_txtd' ), 'edit_plugins', $this->plugin_slug, array(
			$this,
			'display_plugin_admin_page'
		) );
	}

	/**
	 * Render the settings page for this plugin.
	 */
	function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 */
	function add_action_links( $links ) {
		return array_merge( array( 'settings' => '<a href="' . admin_url( 'options-general.php?page=pixreviews' ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>' ), $links );
	}

	function save_comment( $commentID ) {
		// Save rating against comment
		if ( isset( $_POST['score'] ) && is_numeric( $_POST['score'] ) ) {
			update_comment_meta( $commentID, 'pixrating', $_POST['score'], true );
		}

		if ( isset( $_POST['pixrating_title'] ) && is_numeric( $_POST['pixrating_title'] ) ) {
			update_comment_meta( $commentID, 'pixrating_title', $_POST['pixrating_title'], true );
		}
	}

	function display_rating( $comment ) {
		global $post;

		$commentID = get_comment_ID();
		$rating    = get_comment_meta( $commentID, 'pixrating', true );
		$pixrating_title    = get_comment_meta( $commentID, 'pixrating_title', true );

		if ( ! empty( $rating ) ) {
			$output = '<div class="comment_rate" data-score="' . $rating . '"></div>';

			$comment .= $output . $comment;
		}

		if ( ! empty( $pixrating_title ) ) {
			$output = '<span class="review_title">'. $pixrating_title .' </span>';

			$comment .= $output . $comment;
		}

		return $comment;
	}

	function output_rating_field() {
		global $post;
		$commentID = get_comment_ID();
		$rating    = get_comment_meta( $commentID, 'pixrating', true );

		// if there is a value, display it
		$data = '';
		if ( ! empty( $rating ) ) {
			$data .= 'data-score="' . $rating . '"';
		} ?>

		<fieldset id="add_comment_rating_wrap">
			<div id="add_post_rating" <?php echo $data; ?> data-assets_path="<?php echo $this->plugin_baseurl .'/images'; ?>" > </div>
		</fieldset>
		<?php
	}

	protected static function get_config() {
		// @TODO maybe check this
		return include 'plugin-config.php';
	}

	/**
	 * Get an option's value from the config file
	 *
	 * @param $option
	 * @param null $default
	 *
	 * @return bool|null
	 */
	public static function get_config_option( $option, $default = null ) {

		if ( isset( self::$config[ $option ] ) ) {
			return self::$config[ $option ];
		} elseif ( $default !== null ) {
			return $default;
		}

		return false;
	}

	static function get_plugin_option( $option, $default = null ) {

		if ( isset( self::$plugin_settings[ $option ] ) ) {
			return self::$plugin_settings[ $option ];
		} elseif ( $default !== null ) {
			return $default;
		}

		return false;
	}

	static function get_base_path() {
		return plugin_dir_path( __FILE__ );
	}
}
