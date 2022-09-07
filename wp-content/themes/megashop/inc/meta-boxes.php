<?php
add_filter( 'rwmb_meta_boxes', 'tt_register_meta_boxes' );
function tt_register_meta_boxes( $meta_boxes ) {

	$prefix = 'tt_';
	global $tt_data;
	
	/* ----------------------------------------------------- */
	// PORTFOLIO FILTER ARRAY
	if ( ! function_exists('is_plugin_active')){ include_once ABSPATH . 'wp-admin/includes/plugin.php'; } // load is_plugin_active() function if no available

		
	/* ----------------------------------------------------- */
	// BLOG CATEGORIES FILTER ARRAY
	$blog_options = array(); // fixes a PHP warning when no blog posts at all.
	$blog_categories = get_categories();
	if($blog_categories) {
		foreach ($blog_categories as $category) {
			$blog_options[$category->slug] = $category->name;
		}
	}

	/* ----------------------------------------------------- */
	// SIDEBAR ARRAY
	function get_sidebars_array() {
	    global $wp_registered_sidebars;
	    $list_sidebars = array();
	    foreach ( $wp_registered_sidebars as $sidebar ) {
	        $list_sidebars[$sidebar['id']] = $sidebar['name'];
	    }
	    unset($list_sidebars['footer-widgets']); // Remove Footer Widgets from List
	    return $list_sidebars;
	}

	
	/* ----------------------------------------------------- */
	// Project Info Metabox
	/* ----------------------------------------------------- */
		$meta_boxes[] = array(
			'id' => 'portfolio_info',
			'title' => 'Project Information',
			'pages' => array( 'portfolio' ),
			'context' => 'normal',

			'tabs'      => array(
				'portfolio'  => array(
	                'label' => __( 'Portfolio Configuration', 'megashop' ),
	            ),
	            'slides'  => array(
	                'label' => __( 'Portfolio Slides', 'megashop' ),
	            ),
	            'video'  => array(
	                'label' => __( 'Portfolio Video', 'megashop' ),
	            ),
	        ),

	        // Tab style: 'default', 'box' or 'left'. Optional
	        'tab_style' => 'default',
			
			'fields' => array(
				
				array(
					'name'		=> 'Detail Layout',
					'id'		=> $prefix . 'portfolio-detaillayout',
					'desc'		=> 'Choose your Layout for the Portfolio Detail Page.<br />If you choose the "Custom Portfolio Page" Layout, the Project Slides & Video fields below will be ignored. You will start with a blank canvas & use shortcodes to style your Page like a normal Page.',
					'type'		=> 'select',
					'options'	=> array(
						'wide'			=> 'Full Width (Slider)',
						'wide-ns'		=> 'Full Width (No Slider)',
						'sidebyside'	=> 'Side By Side (Slider)',
						'sidebyside-ns'	=> 'Side By Side (No Slider)',
						'custom'		=> 'Custom Portfolio Page (100% Section)'
					),
					'multiple'	=> false,
					'std'		=> array( 'no' ),
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Subtitle',
					'id'		=> $prefix . 'subtitle',
					'desc'		=> 'The Subtitle is shown on the Portfolio Overview Pages, Shortcodes & Related Projects. You can leave this empty to hide it. ',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'  => 'portfolio',
				),	
				array(
					'name'		=> 'Client',
					'id'		=> $prefix . 'portfolio-client',
					'desc'		=> 'The Client is shown on the Portfolio Detail Page. You can leave this empty to hide it.',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Project link',
					'id'		=> $prefix . 'portfolio-link',
					'desc'		=> 'URL Link to your Project (Do not forget the http://). This will be shown on the Portfolio Detail Page. You can leave this empty to hide it.',
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Show Project Details?',
					'id'		=> $prefix . "portfolio-details",
					'type'		=> 'checkbox',
					'std'		=> true,
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Show Related Projects?',
					'id'		=> $prefix . "portfolio-relatedposts",
					'type'		=> 'checkbox',
					'desc'		=> '',
					'std'		=> false,
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Masonry Size',
					'id'		=> $prefix . 'portfolio-size',
					'desc'		=> 'Only relevant when the portfolio is displayed in masonry format.',
					'type'		=> 'select',
					'options'	=> array(
						'regular'	=> 'Regular',
						'wide'		=> 'Wide',
						'tall'		=> 'Tall',
						'widetall'	=> 'Wide & Tall',
					),
					'multiple'	=> false,
					'std'		=> array( 'regular' ),
					'tab'  => 'portfolio',
				),
				array(
					'name'		=> 'Link to Lightbox',
					'id'		=> $prefix . "portfolio-lightbox",
					'type'		=> 'checkbox',
					'desc'		=> 'Open the Preview Image in a Lightbox (on Portfolio Overview, Shortcodes & Related Posts)',
					'std'		=> false,
					'tab'  => 'portfolio',
				),
				array(
					'name'	=> 'Project Slider Images',
					'desc'	=> 'You can upload up to 50 project images for a slideshow, or only one image to display a single image. <br /><strong>Notice:</strong> The Preview Image (on Overview, Shortcodes & Related Projects) will be the Image set as Featured Image.',
					'id'	=> $prefix . 'screenshot',
					'type'	=> 'image_advanced',
					'max_file_uploads' => 50,
					'tab'  => 'slides',
				),
				array(
					'name'		=> 'Video Source',
					'id'		=> $prefix . 'source',
					'type'		=> 'select',
					'options'	=> array(
						'videourl'		=> 'Video URL',
						'embedcode'		=> 'Embed Code'
					),
					'multiple'	=> false,
					'std'		=> array( 'no' ),
					'tab'  => 'video',
				),
				array(
					'name'	=> 'Video URL or own Embed Code',
					'id'	=> $prefix . 'embed',
					'desc'	=> 'If you choose Video URL you can just insert the URL of the <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Supported Video Site</a>. You can also insert your own Embed Code. If you fill out this field, it will be shown <strong>instead</strong> of the Slider.<br /><br /><strong>Notice:</strong> The Preview Image will be the Image set as Featured Image.',
					'type' 	=> 'textarea',
					'std' 	=> "",
					'cols' 	=> "40",
					'rows' 	=> "8",
					'tab'  => 'video',
				)
			)
		);

	return $meta_boxes;
}
