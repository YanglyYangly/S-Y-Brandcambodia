<?php
/**
 * Customize and add more fields for mega menu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Walker_Nav_Menu_Edit' ) ) {
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
}

/**
 * Class TT_Mega_Menu_Walker_Edit
 *
 * Class for adding more controllers into a menu item
 */
class TT_Mega_Menu_Walker_Edit extends Walker_Nav_Menu_Edit {
	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int   $_wp_nav_menu_max_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$mega = get_post_meta( $item->ID, '_menu_item_mega', true );
		$mega = TT_parse_args( $mega, TT_get_mega_menu_setting_default() );

		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args );

		$dom = new DOMDocument();

		$dom->validateOnParse = true;
		$dom->loadHTML( mb_convert_encoding( $item_output, 'HTML-ENTITIES', 'UTF-8' ) );
		$xpath = new DOMXPath( $dom );

		// Adds mega menu data holder
		$settings = $xpath->query( "//*[@id='menu-item-settings-" . $item->ID . "']" )->item( 0 );

		if ( $settings ) {
			$node            = $dom->createElement( 'span' );
			$node->nodeValue = $mega['content'];
			//unset( $mega['content'] );
			$node->setAttribute( 'data-mega', json_encode( $mega ) );
			$node->setAttribute( 'class', 'hidden mega-data' );
			$settings->appendChild( $node );
		}

		// Add settings link
		$cancel = $xpath->query( "//*[@id='cancel-" . $item->ID . "']" )->item( 0 );

		if ( $cancel ) {
			$link            = $dom->createElement( 'a' );
			$link->nodeValue = esc_html__( 'Settings', 'megashop' );
			$link->setAttribute( 'class', 'item-config-mega openmenusettings submitcancel hide-if-no-js' );
			$link->setAttribute( 'href', '#' );
			$sep            = $dom->createElement( 'span' );
			$sep->nodeValue = ' | ';
			$sep->setAttribute( 'class', 'meta-sep hide-if-no-js' );
			$cancel->parentNode->insertBefore( $link, $cancel );
			$cancel->parentNode->insertBefore( $sep, $cancel );
		}

		$output .= $dom->saveHTML();
	}
}

/**
 * Class TT_Mega_Menu_Edit
 *
 * Main class for adding mega setting modal
 */
class TT_Mega_Menu_Edit {
	/**
	 * Modal screen of mega menu settings
	 *
	 * @var array
	 */
	public $modals = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->modals = apply_filters( 'TT_mega_menu_modals', array(
			'menus',
			'title',
			'mega',
			'background',
			'icon',
			'content',
			'design',
			'settings',
		) );

		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'modal' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'templates' ) );
		add_action( 'wp_ajax_megashop_save_menu_item_data', array( $this, 'save_menu_item_data' ) );
	}

	/**
	 * Change walker class for editing nav menu
	 *
	 * @return string
	 */
	public function edit_walker() {
		return 'TT_Mega_Menu_Walker_Edit';
	}

	/**
	 * Load scripts on Menus page only
	 *
	 * @param string $hook
	 */
	public function scripts( $hook ) {
		if ( 'nav-menus.php' !== $hook ) {
			return;
		}

		wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );
		wp_register_style( 'megashop-mega-menu-admin', get_template_directory_uri() . '/admin/css/mega-menu.css', array(
			'media-views',
			'wp-color-picker',
			'font-awesome',
		) );
		wp_enqueue_style( 'megashop-mega-menu-admin' );

		wp_register_script( 'megashop-mega-menu-admin', get_template_directory_uri() . '/admin/js/mega-menu.js', array(
			'jquery',
			'jquery-ui-resizable',
			'wp-util',
			'wp-color-picker',
		), null, true );
		wp_enqueue_media();
		wp_enqueue_script( 'megashop-mega-menu-admin' );

		wp_localize_script( 'megashop-mega-menu-admin', 'ttmModals', $this->modals );
	}

	/**
	 * Prints HTML of modal on footer
	 */
	public function modal() {
		?>
		<div id="ttm-settings" tabindex="0" class="ttm-settings">
			<div class="ttm-modal media-modal wp-core-ui">
				<button type="button" class="button-link media-modal-close ttm-modal-close">
					<span class="media-modal-icon"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'megashop' ) ?></span></span>
				</button>
				<div class="media-modal-content">
					<div class="ttm-frame-menu media-frame-menu">
						<div class="ttm-menu media-menu"></div>
					</div>
					<div class="ttm-frame-title media-frame-title"></div>
					<div class="ttm-frame-content media-frame-content">
						<div class="ttm-content"></div>
					</div>
					<div class="ttm-frame-toolbar media-frame-toolbar">
						<div class="ttm-toolbar media-toolbar">
							<div class="ttm-toolbar-primary media-toolbar-primary search-form">
								<button type="button" class="button ttm-button ttm-button-save media-button button-primary button-large"><?php esc_html_e( 'Save Changes', 'megashop' ) ?></button>
								<button type="button" class="button ttm-button ttm-button-cancel media-button button-secondary button-large"><?php esc_html_e( 'Cancel', 'megashop' ) ?></button>
								<span class="spinner"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="media-modal-backdrop ttm-modal-backdrop"></div>
		</div>
		<?php
	}

	/**
	 * Prints underscore template on footer
	 */
	public function templates() {
		foreach ( $this->modals as $template ) {
			$file = get_theme_file_path( 'inc/mega-menu/menu-templates/' . $template . '.php' );
			$file = apply_filters( 'TT_mega_menu_modal_template_file', $file, $template );

			if ( ! file_exists( $file ) ) {
				continue;
			}
			?>
			<script type="text/html" id="tmpl-megashop-<?php echo esc_attr( $template ) ?>">
				<?php include $file; ?>
			</script>
			<?php
		}
	}

	/**
	 * Ajax function to save menu item data
	 */
	public function save_menu_item_data($data) {
		$_POST['data'] = stripslashes_deep( $_POST['data'] );
		parse_str( $_POST['data'], $data );
		$updated = $data;

		// Save menu item data
		foreach ( $data['menu-item-mega'] as $id => $meta ) {
			$meta = TT_parse_args( $meta, TT_get_mega_menu_setting_default() );
			$updated['menu-item-mega'][ $id ] = $meta;

			update_post_meta( $id, '_menu_item_mega', $meta );
		}

		wp_send_json_success( $updated );
	}
}

add_action('media_buttons', 'add_my_media_button', 15);
function add_my_media_button() { ?>
    <a href="#" id="insert-my-media" class="button menu_icon"><?php esc_html_e( 'Add my media', 'megashop' ); ?></a>
    <?php
}
add_action('media_buttons', 'add_icon_media_button', 16);
function add_icon_media_button() { ?>
    <a href="#" id="insert-icon-media" class="button menu_icon">><?php esc_html_e( 'uplaod icon', 'megashop' ); ?></a>
    <?php
}