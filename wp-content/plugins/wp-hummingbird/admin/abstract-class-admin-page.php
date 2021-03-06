<?php

abstract class WP_Hummingbird_Admin_Page {

	protected $slug = '';

	public $page_id = null;

	protected $meta_boxes = array();

	/**
	 * In order to avoid duplicated notices,
	 * we save notices IDs here
	 *
	 * @var array
	 */
	protected static $displayed_notices = array();

	public function __construct( $slug, $page_title, $menu_title, $parent = false, $render = true  ) {
		$this->slug = $slug;

		if ( ! $parent ) {
			$this->page_id = add_menu_page(
				$page_title,
				$menu_title,
				wphb_get_admin_capability(),
				$slug,
				$render ? array( $this, 'render' ) : null,
				'none'
			);
		}
		else {
			$this->page_id = add_submenu_page(
				$parent,
				$page_title,
				$menu_title,
				wphb_get_admin_capability(),
				$slug,
				$render ? array( $this, 'render' ) : null
			);
		}


		add_action( 'load-' . $this->page_id, array( $this, 'register_meta_boxes' ) );
		add_action( 'load-' . $this->page_id, array( $this, 'on_load' ) );
		add_filter( 'load-' . $this->page_id, array( $this, 'add_screen_hooks' ) );

	}

	/**
	 * Load an admin view
	 */
	protected function view( $name, $args = array(), $echo = true ) {
		$file = wphb_plugin_dir() . "admin/views/$name.php";
		$content = '';

		if ( is_file ( $file ) ) {

			ob_start();

			if ( class_exists( 'WDEV_Plugin_Ui' ) ) {
				WDEV_Plugin_Ui::output();
			}

			if ( isset( $args['id'] ) ) {
				$args['orig_id'] = $args['id'];
				$args['id'] = str_replace( '/', '-', $args['id'] );
			}
			extract( $args );

			include( $file );

			$content = ob_get_clean();
		}

		if ( ! $echo )
			return $content;

		echo $content;

	}

	protected function view_exists( $name ) {
		$file = wphb_plugin_dir() . "admin/views/$name.php";
		return is_file ( $file );
	}

	/**
	 * Common hooks for all screens
	 */
	public function add_screen_hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_notices', array(  $this, 'notices' ) );
		add_action( 'network_admin_notices', array(  $this, 'notices' ) );
	}

	public function notices() {}


	/**
	 * Function triggered when the page is loaded
	 * before render any content
	 */
	public function on_load() {}

	public function enqueue_scripts( $hook ) {

		/* Enqueue Dashboard UI Shared Lib */
		WDEV_Plugin_Ui::load( wphb_plugin_url() . 'externals/shared-ui' );

		// Styles
		wp_enqueue_style( 'wphb-admin', wphb_plugin_url() . 'admin/assets/css/admin.css' );

		// Scripts
		wphb_enqueue_admin_scripts();

	}

	/**
	 * Trigger before on_load, allows to register meta boxes for the page
	 */
	public function register_meta_boxes() {}

	/**
	 * @param $id
	 * @param $title
	 * @param callable|string|null $callback
	 * @param callable|string|null $callback_header
	 * @param callable|string|null $callback_footer
	 * @param string $context
	 * @param array $args
	 */
	protected function add_meta_box( $id, $title, $callback = '', $callback_header = '', $callback_footer = '', $context = 'main', $args = array() ) {
		$default_args = array(
			'box_class'			=> 'dev-box',
			'box_header_class'	=> 'box-title',
			'box_content_class'	=> 'box-content',
			'box_footer_class'	=> 'box-footer'
		);

		$args = wp_parse_args( $args, $default_args );

		if ( ! isset( $this->meta_boxes[ $this->slug ] ) )
			$this->meta_boxes[ $this->slug ] = array();

		if ( ! isset( $this->meta_boxes[ $this->slug ][ $context ] ) )
			$this->meta_boxes[ $this->slug ][ $context ] = array();

		if ( !isset($this->meta_boxes[ $this->slug ][ $context ] ) )
			$this->meta_boxes[ $this->slug ][ $context ] = array();

		$meta_box = array('id' => $id, 'title' => $title, 'callback' => $callback, 'callback_header' => $callback_header, 'callback_footer' => $callback_footer, 'args' => $args );
		/**
		 * Allow to filter a WP Hummingbird Metabox
		 *
		 * @param array $meta_box Meta box attributes
		 * @param string $slug Admin page slug
		 * @param string $page_id Admin page ID
		 */
		$meta_box = apply_filters( 'wphb_add_meta_box', $meta_box, $this->slug, $this->page_id );
		$meta_box = apply_filters( 'wphb_add_meta_box_' . $meta_box['id'], $meta_box, $this->slug, $this->page_id );

		if ( $meta_box ) {
			$this->meta_boxes[ $this->slug ][ $context ][ $id ] = $meta_box;
		}

	}

	/**
	 * Render
	 * @param string $context
	 */
	protected function do_meta_boxes( $context = 'main' ) {
		if ( empty( $this->meta_boxes[ $this->slug ][ $context ] ) )
			return;

		foreach ( $this->meta_boxes[ $this->slug ][ $context ] as $id => $box ) {
			$args = array( 'title' => $box['title'], 'id' => $id, 'callback' => $box['callback'], 'callback_header' => $box['callback_header'], 'callback_footer' => $box['callback_footer'], 'args' => $box['args'] );
			$this->view( 'meta-box', $args );
		}

	}

	/**
	 * Check if there is any meta box for a given context
	 */
	protected function has_meta_boxes( $context ) {
		return ! empty( $this->meta_boxes[ $this->slug ][ $context ] );
	}

	/**
	 * Renders the template header that is repeated on every page.
	 * From WPMU DEV Dashboard
	 *
	 */
	protected function render_header() {

		?>
		<section id="header">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		</section><!-- end header -->

		<?php
	}

	/**
	 * Render the page
	 */
	public function render() {
		?>

		<div id="container" class="wrap wrap-wp-hummingbird wrap-wp-hummingbird-page <?php echo 'wrap-' . $this->slug; ?>">

		<?php
			if ( isset( $_GET['updated'] ) ) :
				$this->show_notice( 'updated', __( 'Settings Updated', 'wphb' ), 'success' );
			endif;

			$this->render_header();

			$this->render_inner_content();
		?>

		</div><!-- end container -->

		<script>
			jQuery(document).ready( function() {
				WPHB_Admin.getModule( 'notices' );
			});

			// Avoid moving dashboard notice under h2
			var wpmuDash = document.getElementById( 'wpmu-install-dashboard' );
			if ( wpmuDash )
				wpmuDash.className = wpmuDash.className + " inline";

			jQuery( 'div.updated, div.error' ).addClass( 'inline' );
		</script>
		<?php
	}

	protected function render_inner_content() {
		$this->view( $this->slug . '-page' );
	}

	/**
	 * Show an admin notice
	 *
	 * @param string $id Unique identificator for the notice
	 * @param string $message The notice text
	 * @param string $class Class for the notice wrapper
	 * @param bool|false $dismissable if is dissmisable or not
	 */
	public function show_notice( $id, $message, $class = 'error', $dismissable = false ) {
		// Is already dismissed ?
		if ( $dismissable && get_user_meta( get_current_user_id(), 'wphb-notice-' . $id ) )
			return;

		if ( ! current_user_can( wphb_get_admin_capability() ) )
			return;

		if ( in_array( $id, self::$displayed_notices ) )
			return;

		$nonce = '';
		if ( $dismissable ) {
			$nonce = wp_create_nonce( 'wphb-dismiss' );
		}

		$args = compact( 'message', 'id', 'class', 'dismissable', 'nonce' );
		$this->view( 'notice', $args );

		self::$displayed_notices[] = $id;
	}

	/**
	 * Return this menu page URL
	 *
	 * @return string
	 */
	public function get_page_url() {
		if ( is_multisite() && is_network_admin() ) {
			global $_parent_pages;

			if ( isset( $_parent_pages[$this->slug] ) ) {
				$parent_slug = $_parent_pages[$this->slug];
				if ( $parent_slug && ! isset( $_parent_pages[$parent_slug] ) ) {
					$url = network_admin_url( add_query_arg( 'page', $this->slug, $parent_slug ) );
				} else {
					$url = network_admin_url( 'admin.php?page=' . $this->slug );
				}
			} else {
				$url = '';
			}

			$url = esc_url($url);

			return $url;
		}
		else {
			return menu_page_url( $this->slug, false );
		}

	}
}