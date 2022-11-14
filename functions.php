<?php
/**
 * CDIL Blocks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cdilbocks
 * @since CDIL Blocks 1.0
 */

if ( ! function_exists( 'cdilblocks_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since CDIL Blocks 1.0
	 *
	 * @return void
	 */
	function cdilblocks_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );
		

		// Remove core block patterns.
		remove_theme_support( 'core-block-patterns' );
	}

endif;

add_action( 'after_setup_theme', 'cdilblocks_support' );

if ( ! function_exists( 'cdilblocks_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since CDIL Blocks 1.0
	 *
	 * @return void
	 */
	function cdilblocks_styles() {

		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'cdilblocks-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'cdilblocks-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'cdilblocks_styles' );


/**
 * Registers block categories, and type.
 *
 * @since 1.0
 */
function cdilblocks_register_block_pattern_categories() {

	/* Functionality specific to the Block Pattern Explorer plugin. */
	if ( function_exists( 'register_block_pattern_category_type' ) ) {
		register_block_pattern_category_type( 'cdilblocks', array( 'label' => __( 'cdilblocks', 'cdilblocks' ) ) );
	}

	$block_pattern_categories = array(
		'cdilblocks-footer'  => array(
			'label'         => __( 'Footer', 'cdilblocks' ),
			'categoryTypes' => array( 'cdilblocks' ),
		),
		'cdilblocks-general' => array(
			'label'         => __( 'General', 'cdilblocks' ),
			'categoryTypes' => array( 'cdilblocks' ),
		),
		'cdilblocks-header'  => array(
			'label'         => __( 'Header', 'cdilblocks' ),
			'categoryTypes' => array( 'cdilblocks' ),
		),
		'cdilblocks-casestudy'    => array(
			'label'         => __( 'Case Studies', 'cdilblocks' ),
			'categoryTypes' => array( 'cdilblocks' ),
		),
		'cdilblocks-query'   => array(
			'label'         => __( 'Query', 'cdilblocks' ),
			'categoryTypes' => array( 'cdilblocks' ),
		),
	);

	foreach ( $block_pattern_categories as $name => $properties ) {
		register_block_pattern_category( $name, $properties );
	}
}
add_action( 'init', 'cdilblocks_register_block_pattern_categories', 9 );


/**
 * Register block styles.
 */
function cdilblocks_register_block_styles() {

	$block_styles = array(
		'core/image'            => array(
			'shadow-lg' => __( 'Shadow-Large', 'cdilblocks' ),
		),
		'core/group'            => array(
			'shadow' => __( 'Shadow', 'cdilblocks' ),
			'shadow-lg' => __( 'Shadow-Large', 'cdilblocks' ),
			'highlight-box' => __( 'Highlight Box', 'cdilblocks' ),
			'callout-info' => __( 'Info', 'cdilblocks' ),
			'callout-success' => __( 'Success', 'cdilblocks' ),
			'callout-warning' => __( 'Warning', 'cdilblocks' ),
			'callout-danger' => __( 'Danger', 'cdilblocks' ),
		),

		'core/embed'            => array(
			'shadow-lg' => __( 'Shadow-Large', 'cdilblocks' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'cdilblocks_register_block_styles' );

/**
 * Register block variations.
 */

function block_variations_enqueue() {
    wp_enqueue_script(
        'block-variations',
		get_template_directory_uri() . '/assets/js/block-variations.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
    );
}
add_action( 'enqueue_block_editor_assets', 'block_variations_enqueue' );


// Enqueue Scripts and Styles
function add_theme_scripts() {
	
	wp_enqueue_style( 'tocbot', get_template_directory_uri() . '/assets/scripts/toc/toc.css', array(), '1.1', 'all');
	wp_enqueue_script('tocbot', get_stylesheet_directory_uri().'/assets/scripts/toc/tocbot.min.js', 
    array(), false, true);
	wp_enqueue_script('tocbot-init', get_stylesheet_directory_uri().'/assets/scripts/toc/tocbot-init.js', 
    array(), false, true);
	wp_enqueue_style( 'scroll-to-top', get_template_directory_uri() . '/assets/scripts/scroll-to-top/scroll-to-top.css', array(), '1.1', 'all');
	wp_enqueue_script('scroll-to-top', get_stylesheet_directory_uri().'/assets/scripts/scroll-to-top/scroll-to-top.js', 
    array(), false, true);
	wp_enqueue_script('sticky-header', get_stylesheet_directory_uri().'/assets/scripts/sticky/sticky-header.js', 
    array(), false, true);

	wp_enqueue_style( 'clipboard', get_template_directory_uri() . '/assets/scripts/clipboard/clipboard.css', array(), '1.1', 'all');
	wp_enqueue_script('clipboard', get_stylesheet_directory_uri().'/assets/scripts/clipboard/clipboard.min.js', 
    array(), false, true);
	wp_enqueue_script('clipboard-init', get_stylesheet_directory_uri().'/assets/scripts/clipboard/clipboard-init.js', 
    array(), false, true);

	//   if ( is_singular() ) {
	// 	wp_enqueue_script( 'comment-reply' );
	//   }
  }
  add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// Add ID to headings for TOC
// Credits https://jeroensormani.com/automatically-add-ids-to-your-headings/
	function auto_id_headings( $content ) {

		$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
			if ( ! stripos( $matches[0], 'id=' ) ) :
				$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $matches[3] . $matches[4];
			endif;
			return $matches[0];
		}, $content );
	
		return $content;
	
	}
	add_filter( 'the_content', 'auto_id_headings' );


// remove "Private: " from titles
function remove_private_prefix($title) {
	$title = str_replace('Private: ', '', $title);
	return $title;
}
add_filter('the_title', 'remove_private_prefix');

// Add "private" class to body for styling purposes
add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
    if ( get_post_status() == 'private' ) {
        $classes[] = 'private';
    }
    return $classes;
}

// Add Exerpts on Pages
add_post_type_support( 'page', 'excerpt' );


// Add Tags and Categories to Pages
function page_tagcat_settings() {
// Add tag metabox to page
// register_taxonomy_for_object_type('post_tag', 'page');
// Add category metabox to page
register_taxonomy_for_object_type('category', 'page');
}
// Add to the admin_init hook of your theme functions.php file
add_action( 'init', 'page_tagcat_settings' );




/*
 * Blacklist specific Gutenberg blocks
 *
 * @author Misha Rudrastyh
 * @link https://rudrastyh.com/gutenberg/remove-default-blocks.html#blacklist-blocks
 */
// add_filter( 'allowed_block_types_all', 'blacklist_blocks' );
 
// function blacklist_blocks( $allowed_blocks ) {
// 	// get all the registered blocks
// 	$blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

// 	// then disable some of them
// 	unset( $blocks[ 'kadence/countdown' ] );
// 	unset( $blocks[ 'kadence/countup' ] );
// 	unset( $blocks[ 'kadence/icon' ] );

// 	// return the new list of allowed blocks
// 	return array_keys( $blocks );
	
// }

/* Add customizer  */
add_action( 'customize_register', '__return_true' );

/* Allow dashicons to view for all users */
function ww_load_dashicons(){
	wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'ww_load_dashicons');


// Theme Admin Page
require get_template_directory() . '/inc/admin/theme-admin.php';

/* Add required plugins notices
[Wordpress Themes Required Plugins - Dhali.com](https://dhali.com/wordpress/wordpress-required-plugins/)
May need to make these dismissable: [WPTT/admin-notices: Package for standardizing how themes output admin notices.](https://github.com/WPTT/admin-notices)
*/

add_action('admin_notices', 'showAdminMessages');

function showAdminMessages() {
	$plugin_messages = array();

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// Lazyblocks Plugin
	if(!is_plugin_active( 'lazyblocks.php' ))	{
		$plugin_messages[] = 'This theme requires you to install the Lazyblocks plugin, <a href="https://wordpress.org/plugins/lazy-blocks/">download it from here</a>.';
	}

	if(count($plugin_messages) > 0)	{
		echo '<div class="notice notice-warning" >';

			foreach($plugin_messages as $message) {
				echo '<p><strong>'.$message.'</strong></p>';
			}

		echo '</div>';
	}
}

// Set Default Logo
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
if ( has_custom_logo() ) {
        echo '<img src="'. esc_url( $logo[0] ) .'">';
} else {
        echo '<img src="'. get_stylesheet_directory_uri() . '/assets/images/BC-Wordmark-Single-Line-Gold.png' .'">';
}