<?php

//require_once(TEMPLATEPATH . '/functions/admin-menu.php');

/***********************************************************************************************/
/* Define Constants */
/***********************************************************************************************/
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT.'/images');

/***********************************************************************************************/
/* Add Menus */
/***********************************************************************************************/
function register_my_menus() {
	register_nav_menus(array(
		'main-menu' => 'Main Menu',
		'category-menu' => 'Category Menu'
	));
}

add_action('init', 'register_my_menus');


/***********************************************************************************************/
/* Add Theme Support for Post Thumbnails */
/***********************************************************************************************/
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(362, 209);
}



/***********************************************************************************************/
/* Load JS Files */
/***********************************************************************************************/
add_action('wp_enqueue_scripts', 'load_custom_scripts');

function load_custom_scripts() {
	wp_enqueue_script('custom_script', THEMEROOT.'/js/custom.js', array('jquery'), true);
}



/**** Interview Related ****/


/***** Consider the following code snippet. Briefly explain what changes it will achieve, 
who can and cannot view its effects, and at what URL WordPress will make it available. *****/

add_action('admin_menu', 'custom_menu');

function custom_menu(){
    add_menu_page('Custom Menu', 'Custom Menu', 'manage_options', 'custom-menu-slug', 'custom_menu_page_display');
}

function custom_menu_page_display(){
    echo '<h1>Hello World</h1>';
    echo '<p>This is a custom page</p>';
} 

/***** How would you change all the occurrences of “Hello” into “Good Morning” in post/page contents, when viewed before 11AM? *****/

/***** What is the $wpdb variable in WordPress, and how can you use it to improve the following code? *****/

/***** Consider the following code snippet and explain the purpose of wp_enqueue_script. Can you figure out if something is wrong in the snippet? *****/

/***** Assuming we have a file named “wp-content/plugins/hello-world.php” with the following content. What is this missing to be called a plugin and run properly? *****/

/***** What is a potential problem in the following snippet of code from a WordPress theme file named “footer.php”? *****/

/***** What is this code for? How can the end user use it? *****/

function new_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => "warning"
    ), $atts));
    return '<div class="alert alert-'.$type.'">'.$content.'</div>';
}
add_shortcode("warning_box", "new_shortcode");

/***** Is WordPress safe from brute force login attempts? If not, how can you prevent such an attack vector? *****/

/***** The following line is in a function inside a theme’s “function.php” file. What is wrong with this line of code? *****/

/***** Suppose you have a non-WordPress PHP website with a WordPress instance in the “/blog/” folder. How can you show a list of the last 3 posts in your non-WordPress pages? *****/



/***********************************************************************************************/
/* Add Meta Box to the Posts */
/***********************************************************************************************/
add_action('add_meta_boxes', 'custom_add_meta_box');

function custom_add_meta_box() {
	add_meta_box(
		'portfolio_details',				// ID
		'Portfolio Entry Details (Post)',	// Title
		'custom_display_meta_box',			// Callback
		'post',								// Targeted post type "page or post"
		'normal'							// Position
	);
}

/***********************************************************************************************/
/* Add Meta Box to the Pages */
/***********************************************************************************************/
add_action('add_meta_boxes', 'custom_add_meta_box_page');

function custom_add_meta_box_page() {
	add_meta_box(
		'portfolio_details',				// ID
		'Portfolio Entry Details (Page)',	// Title
		'custom_display_meta_box',			// Callback
		'page',								// Targeted post type "page or post"
		'normal'							// Position
	);
}


/***********************************************************************************************/
/* Add Meta Box to the Particular Page */
/***********************************************************************************************/
add_action( 'add_meta_boxes_page', 'topic_landing_add_meta_boxes_page' );

function topic_landing_add_meta_boxes_page() {
    global $post;
    if ( 'page-movie.php' == get_post_meta( $post->ID, '_wp_page_template', true ) ) {
       add_meta_box( 'topics_meta', 
	   				 'Topic Landing Pages Settings', 
					 'display_meta_box',  
					 'page', 
					 'normal', 
					 'high');
    }
}


/***********************************************************************************************/
/* Add Meta Box to the Custom Post Type */
/***********************************************************************************************/
/*add_action('add_meta_boxes', 'custom_add_meta_box_movie');

function custom_add_meta_box_movie() {
	add_meta_box(
		'portfolio_details',				// ID
		'Portfolio Entry Details (Movie)',	// Title
		'custom_display_meta_box',			// Callback
		'movies',							// Targeted post type "custom post type"
		'normal'							// Position
	);
}*/


/***********************************************************************************************/
/* Add Meta Box to the Multiple Custom Post Type */
/***********************************************************************************************/
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
/*function nw_add_custom_meta_box() {

    $screens = array( 'site' ); // add items to add to multiple post types

    foreach ( $screens as $screen ) {
        add_meta_box(
        'website', // $id
        'Website', // $title 
        'show_custom_meta_box', // $callback
        $screen, // $page
        'normal', // $context
        'high' // $priority
        );
    }
}
add_action( 'add_meta_boxes', 'nw_add_custom_meta_box' );*/


function custom_display_meta_box($post) {
	$portfolio_description = get_post_meta($post->ID, 'portfolio_description', true);
	$portfolio_link = get_post_meta($post->ID, 'portfolio_link', true);
	$portfolio_quote = get_post_meta($post->ID, 'portfolio_quote', true);
	$portfolio_quote_author = get_post_meta($post->ID, 'portfolio_quote_author', true);

	// Security check
	wp_nonce_field('portfolio_meta_nonce', 'portfolio_nonce');
	
	// Display fields
	?>
	
	<p>
		<label for="portfolio_description">Project Description:</label>
		<textarea class="widefat" name="portfolio_description" id="portfolio_description" cols="30" rows="10"><?php echo $portfolio_description; ?></textarea>
	</p>
	<p>
		<label for="portfolio_link">Link:</label><br />
		<input type="text" name="portfolio_link" id="portfolio_link" value="<?php echo $portfolio_link; ?>" />
	</p>
	<p>
		<label for="portfolio_quote">Quote:</label>
		<textarea class="widefat" name="portfolio_quote" id="portfolio_quote" cols="30" rows="10"><?php echo $portfolio_quote; ?></textarea>
	</p>
	<p>
		<label for="portfolio_quote_author">Quote Author:</label><br />
		<input type="text" name="portfolio_quote_author" id="portfolio_quote_author" value="<?php echo $portfolio_quote_author; ?>" />
	</p>
	
	<?php
}

function custom_save_portfolio_details($post_id) {
	// If we're doing an autosave, return
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	
	// If nonce if not present or invalid, return
	if (!isset($_POST['portfolio_nonce']) || !wp_verify_nonce($_POST['portfolio_nonce'], 'portfolio_meta_nonce')) return;
	
	// Save/Update Data
	if (isset($_POST['portfolio_description']) && $_POST['portfolio_description'] != '') {
		update_post_meta($post_id, 'portfolio_description', esc_html($_POST['portfolio_description']));
	}
	if (isset($_POST['portfolio_link']) && $_POST['portfolio_link'] != '') {
		update_post_meta($post_id, 'portfolio_link', esc_url($_POST['portfolio_link']));
	}
	if (isset($_POST['portfolio_quote']) && $_POST['portfolio_quote'] != '') {
		update_post_meta($post_id, 'portfolio_quote', esc_html($_POST['portfolio_quote']));
	}
	if (isset($_POST['portfolio_quote_author']) && $_POST['portfolio_quote_author'] != '') {
		update_post_meta($post_id, 'portfolio_quote_author', esc_html($_POST['portfolio_quote_author']));
	}
}

add_action('save_post', 'custom_save_portfolio_details');



/***********************************************************************************************/
/* Add Meta Box to the Custom Post Type */
/***********************************************************************************************/
add_action('add_meta_boxes', 'custom_add_meta_box_movie_det');

function custom_add_meta_box_movie_det() {
	add_meta_box(
		'movie_details',				 // ID
		'Movie Entry Details (Movie)',	 // Title
		'custom_display_movie_meta_box', // Callback
		'movies',						 // Targeted post type "custom post type"
		'normal'						 // Position
	);
}

function custom_display_movie_meta_box($post) {
	$color = get_post_meta($post->ID, 'color', true);
	$price = get_post_meta($post->ID, 'price', true);
	
	// Security check
	wp_nonce_field('movie_meta_nonce', 'movie_nonce');
	
	// Display fields
	?>
	
	<p>
		<label for="color">Movie Color:</label><br />
		<input type="text" name="color" id="color" value="<?php echo $color; ?>" />
	</p>
	
    <p>
		<label for="price">Movie Price:</label><br />
		<input type="text" name="price" id="price" value="<?php echo $price; ?>" />
	</p>
	
	<?php
}

function custom_save_movie_details($post_id) {
	// If we're doing an autosave, return
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	
	// If nonce if not present or invalid, return
	if (!isset($_POST['movie_nonce']) || !wp_verify_nonce($_POST['movie_nonce'], 'movie_meta_nonce')) return;
	
	// Save/Update Data
	if (isset($_POST['color']) && $_POST['color'] != '') {
		update_post_meta($post_id, 'color', esc_html($_POST['color']));
	}
	
	if (isset($_POST['price']) && $_POST['price'] != '') {
		update_post_meta($post_id, 'price', esc_html($_POST['price']));
	}
		
}

add_action('save_post', 'custom_save_movie_details');

/******************************* End Metabox *************************************/



/**** Here's a basic example of adding a custom post type: ****/

/*add_action( 'init', 'create_post_type' );

function create_post_type() {
	  register_post_type( 'acme_product',
		array(
		  'labels' => array(
			'name' => __( 'Products' ),
			'singular_name' => __( 'Product' )
		  ),
		  'public' => true,
		  'has_archive' => true,
		)
	  );
}*/	


/**** URLs of Namespaced Custom Post Types Identifiers
When you namespace a custom post type identifier and still want to use a clean URL structure, you need to set the rewrite argument of the register_post_type() function. For example, assuming the ACME Widgets example from above: ****/

/*add_action( 'init', 'create_posttype' );

function create_posttype() {
	  register_post_type( 'acme_product',
		array(
		  'labels' => array(
			'name' => __( 'Products' ),
			'singular_name' => __( 'Product' )
		  ),
		  'public' => true,
		  'has_archive' => true,
		  'rewrite' => array('slug' => 'products'),
		)
	  );
}*/


/*
* Creating a function to create our CPT
*/

function custom_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Movies', 'Post Type General Name', 'twentythirteen' ),
		'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'twentythirteen' ),
		'menu_name'           => __( 'Movies', 'twentythirteen' ),
		'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
		'all_items'           => __( 'All Movies', 'twentythirteen' ),
		'view_item'           => __( 'View Movie', 'twentythirteen' ),
		'add_new_item'        => __( 'Add New Movie', 'twentythirteen' ),
		'add_new'             => __( 'Add New', 'twentythirteen' ),
		'edit_item'           => __( 'Edit Movie', 'twentythirteen' ),
		'update_item'         => __( 'Update Movie', 'twentythirteen' ),
		'search_items'        => __( 'Search Movie', 'twentythirteen' ),
		'not_found'           => __( 'Not Found', 'twentythirteen' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
	);
	
// Set other options for Custom Post Type
	
	$args = array(
		'label'               => __( 'movies', 'twentythirteen' ),
		'description'         => __( 'Movie news and reviews', 'twentythirteen' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),	// 'custom-fields', 
		// You can associate this CPT with a taxonomy or custom taxonomy. 
		'taxonomies'          => array( 'genre' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/	
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		//'menu_icon'         => plugins_url( 'images/image2.png' ),
		'has_archive'         => true,
		'rewrite'             => array('slug' => 'movies'),
	);
	
	// Registering your Custom Post Type
	register_post_type( 'movies', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'custom_post_type', 0 );



/*function people_init() {
	// create a new taxonomy
	register_taxonomy(
		'people',
		'post',
		array(
			'label' => __( 'People' ),
			'rewrite' => array( 'slug' => 'person' ),
			'capabilities' => array(
				'assign_terms' => 'edit_guides',
				'edit_terms' => 'publish_guides'
			)
		)
	);
}
add_action( 'init', 'people_init' );*/


/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 http://www.smashingmagazine.com/2012/01/04/create-custom-taxonomies-wordpress/
 */
function add_custom_taxonomies() {
  // Add new "Locations" taxonomy to Posts
  register_taxonomy('location', 'post', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Locations', 'taxonomy general name' ),
      'singular_name' => _x( 'Location', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Locations' ),
      'all_items' => __( 'All Locations' ),
      'parent_item' => __( 'Parent Location' ),
      'parent_item_colon' => __( 'Parent Location:' ),
      'edit_item' => __( 'Edit Location' ),
      'update_item' => __( 'Update Location' ),
      'add_new_item' => __( 'Add New Location' ),
      'new_item_name' => __( 'New Location Name' ),
      'menu_name' => __( 'Locations' ),
    ),
    // Control the slugs used for this taxonomy
   'rewrite' => array(
   'slug' => 'locations', // This controls the base slug that will display before each term
   'with_front' => false, // Don't display the category base before "/locations/"
   'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );


/**** Get terms for all custom taxonomies ****/

// get taxonomies terms links
function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    if ( !empty( $terms ) ) {
      $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
      foreach ( $terms as $term ) {
        $out[] =
          '  <li><a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
        .    $term->name
        . "</a></li>\n";
      }
      $out[] = "</ul>\n";
    }
  }

  return implode('', $out );
}


/**** Create Custom Taxonomies ****/
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_movie_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "movies"
function create_movie_taxonomies() {
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Genres' ),
		'all_items'         => __( 'All Genres' ),
		'parent_item'       => __( 'Parent Genre' ),
		'parent_item_colon' => __( 'Parent Genre:' ),
		'edit_item'         => __( 'Edit Genre' ),
		'update_item'       => __( 'Update Genre' ),
		'add_new_item'      => __( 'Add New Genre' ),
		'new_item_name'     => __( 'New Genre Name' ),
		'menu_name'         => __( 'Genres' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);

	register_taxonomy( 'genre', array( 'movies' ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Writers' ),
		'popular_items'              => __( 'Popular Writers' ),
		'all_items'                  => __( 'All Writers' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer' ),
		'update_item'                => __( 'Update Writer' ),
		'add_new_item'               => __( 'Add New Writer' ),
		'new_item_name'              => __( 'New Writer Name' ),
		'separate_items_with_commas' => __( 'Separate writers with commas' ),
		'add_or_remove_items'        => __( 'Add or remove writers' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers' ),
		'not_found'                  => __( 'No writers found.' ),
		'menu_name'                  => __( 'Writers' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);

	register_taxonomy( 'writer', 'movies', $args );
}


/**** Add Custom Fields in Admin Panel Sidebar Settings Menu ****/

function register_fields()
{
    register_setting('general', 'my_first_field', 'esc_attr');
    add_settings_field('my_first_field', '<label for="my_first_field">'.__('My Field' , 'my_first_field' ).'</label>' , 'print_first_field', 'general');

    register_setting('general', 'my_second_field', 'esc_attr');
    add_settings_field('my_second_field', '<label for="my_second_field">'.__('My Field' , 'my_second_field' ).'</label>' , 'print_second_field', 'general');
}

function print_first_field()
{
    $value = get_option( 'my_first_field', '' );
    echo '<input type="text" id="my_first_field" name="my_first_field" value="' . $value . '" />';
}

function print_second_field()
{
    $value = get_option( 'my_second_field', '' );
    echo '<input type="text" id="my_second_field" name="my_second_field" value="' . $value . '" />';
}

add_filter('admin_init', 'register_fields');


/**** Add Custom Option and Create custom fields of that option in Admin Panel Sidebar Settings Menu ( Using Class Method ) ****/

class options_page {
	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	function admin_menu () {
		add_options_page( 'Custom Fields','Custom Fields','manage_options','options_page_slug', array( $this, 'settings_page' ) );
	}
	function  settings_page () {
		//echo 'This is the page content';
		?>
        <div class='wrap'>
        <h2>Custom Fields</h2>
        <form method="post" action="options.php">
        <?php wp_nonce_field('update-options') ?>
    
        <p><strong>My Name:</strong><br />
        <input type="text" name="myname_cl" size="45" value="<?php echo get_option('myname_cl'); ?>" /></p>
        
        <p><strong>Amazon ID:</strong><br />
        <input type="text" name="amazonid_cl" size="45" value="<?php echo get_option('amazonid_cl'); ?>" /></p>
    
        <p><strong>Today's Featured Website:</strong><br />
        <input type="text" name="todaysite_cl" size="45" value="<?php echo get_option('todaysite_cl'); ?>" /></p>
    
        <p><strong>Welcome Text:</strong><br />
        <textarea name="welcomemessage_cl" cols="100%" rows="7"><?php echo get_option('welcomemessage_cl'); ?></textarea></p>
    
        <p>
        <!--<input type="submit" name="Submit" value="Update Options" />-->
        <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
        </p>
    
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="myname_cl,amazonid_cl,todaysite_cl,welcomemessage_cl" />
    
        </form>
        </div>
        <?php
	}
}
new options_page;


/**** Add Custom Option and Create custom fields of that option in Admin Panel Sidebar Settings Menu ( Without using Class Method ) ****/

//Custom Theme Settings
add_action('admin_menu', 'add_gcf_interface');

function add_gcf_interface() {
	add_options_page('Global Custom Fields', 'Global Custom Fields', '8', 'functions', 'editglobalcustomfields');
}

function editglobalcustomfields() {
	?>
	<div class='wrap'>
	<h2>Global Custom Fields</h2>
	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options') ?>

	<p><strong>My Name:</strong><br />
	<input type="text" name="myname" size="45" value="<?php echo get_option('myname'); ?>" /></p>
	
	<p><strong>Amazon ID:</strong><br />
	<input type="text" name="amazonid" size="45" value="<?php echo get_option('amazonid'); ?>" /></p>

	<p><strong>Today's Featured Website:</strong><br />
	<input type="text" name="todaysite" size="45" value="<?php echo get_option('todaysite'); ?>" /></p>

	<p><strong>Welcome Text:</strong><br />
	<textarea name="welcomemessage" cols="100%" rows="7"><?php echo get_option('welcomemessage'); ?></textarea></p>

	<p>
    <!--<input type="submit" name="Submit" value="Update Options" />-->
    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </p>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="myname,amazonid,todaysite,welcomemessage" />

	</form>
	</div>
	<?php
}




// Login redirects
 
function custom_login() {
    echo header("Location: " . get_bloginfo( 'url' ) . "/login");
}
 
add_action('login_head', 'custom_login');
 
/*function login_link_url( $url ) {
   $url = get_bloginfo( 'url' ) . "/login";
   return $url;
   }
add_filter( 'login_url', 'login_link_url', 10, 2 );*/


function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('cat','8,11');
    }
    return $query;
}

add_filter('pre_get_posts','SearchFilter');


/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * Hooks into the after_setup_theme action.
 *
 */
function shape_register_custom_background() {
    $args = array(
        'default-color' => 'e9e0d1',
    );
 
    $args = apply_filters( 'shape_custom_background_args', $args );
 
    if ( function_exists( 'wp_get_theme' ) ) {
        add_theme_support( 'custom-background', $args );
    } else {
        define( 'BACKGROUND_COLOR', $args['default-color'] );
        define( 'BACKGROUND_IMAGE', $args['default-image'] );
        add_custom_background();
    }
}
add_action( 'after_setup_theme', 'shape_register_custom_background' );
 

/**** Disable Admin Bar in Site Pages for All Users Except for Administrators ****/
/*add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}*/


/**
 * Disable admin bar on the frontend of your website
 * for subscribers.
 */
function themeblvd_disable_admin_bar() { 
	if( !current_user_can('edit_posts') )
		add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'themeblvd_disable_admin_bar');


// function remove_admin_bar() {
//     if (!current_user_can('administrator') && !is_admin()) {
//       show_admin_bar(false);
//     }
// }
// add_action('after_setup_theme', 'remove_admin_bar');


/**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function themeblvd_redirect_admin(){
	if ( ! current_user_can( 'edit_posts' ) ){
		wp_redirect( site_url() );
		exit;		
	}
}
add_action( 'admin_init', 'themeblvd_redirect_admin' );


function login_link_url( $url ) {
   $url = get_bloginfo( 'url' ) . "/login-page";
   return $url;
   }
add_filter( 'login_url', 'login_link_url', 10, 2 );


///** Step 2 (from text above). */
//add_action( 'admin_menu', 'my_plugin_menu' );
//
///** Step 1. */
//function my_plugin_menu() {
//	add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
//}
//
///** Step 3. */
//function my_plugin_options() {
//	if ( !current_user_can( 'manage_options' ) )  {
//		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
//	}
//	echo '<div class="wrap">';
//	echo '<p>Here is where the form would go if I actually had options.</p>';
//	echo '</div>';
//}

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );



/**** Customize Comments markup ****/

function my_custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <?php if ($comment->comment_approved == '0') : ?>
      <em><?php _e('Your comment is awaiting moderation.') ?></em>
   <?php endif; 
   // Comments markup code here, e.g. functions like comment_text(); 
}


/**** Change the Login Logo ****/

function custom_login_logo() {
	echo '<style type="text/css">h1 a { background: url('.IMAGES.'/logo.png) 50% 50% no-repeat !important; }</style>';
}
add_action('login_head', 'custom_login_logo');

/****Turn On More Buttons in the WordPress Visual Editor ****/
function add_more_buttons($buttons) {
 $buttons[] = 'hr';
 $buttons[] = 'del';
 $buttons[] = 'sub';
 $buttons[] = 'sup';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 $buttons[] = 'styleselect';
 return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");


/**** Move WordPress Admin Bar to the Bottom ****/
//function fb_move_admin_bar() {
//    echo '
//    <style type="text/css">
//    body {
//    margin-top: -28px;
//    padding-bottom: 28px;
//    }
//    body.admin-bar #wphead {
//       padding-top: 0;
//    }
//    body.admin-bar #footer {
//       padding-bottom: 28px;
//    }
//    #wpadminbar {
//        top: auto !important;
//        bottom: 0;
//    }
//    #wpadminbar .quicklinks .menupop ul {
//        bottom: 28px;
//    }
//    </style>';
//}
//// on backend area
//add_action( 'admin_head', 'fb_move_admin_bar' );
//
//// on frontend area
//add_action( 'wp_head', 'fb_move_admin_bar' );


/**** Change the URL ****/

/*function change_wp_login_url() {
	return bloginfo('url');
}
add_filter('login_headerurl', 'change_wp_login_url');*/


/**** Change the Title ****/

/*function change_wp_login_title() {
	return get_option('blogname');
}
add_filter('login_headertitle', 'change_wp_login_title');*/




/**** Shortcode ****/
//[foobar]
function foobar_func( $atts ){
	return "foo and bar";
}
add_shortcode( 'foobar', 'foobar_func' );


// [bartag foo="foo-value"]
/*function bartag_func( $atts ) {
    $a = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts );

    return "foo = {$a['foo']}";
}
add_shortcode( 'bartag', 'bartag_func' );*/

// [bartag foo="some1" bar="someelse1"]
function bartag_func( $atts ) {
    extract( shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts, 'multilink' ) );

    return sprintf('foo = %1$s, bar = %2$s ', esc_html( $foo ), esc_html( $bar ));
}
add_shortcode( 'bartag', 'bartag_func' );


// Extended subscription function with subscription type variable
function subscribe_multilink_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'subtype' => 'RSS',
        'subtypeurl' => 'http://feeds.feedburner.com/ElegantThemes',
    ), $atts, 'multilink' ) );
  
    return sprintf('Be sure to subscribe to future Elegant Themes updates <a href="%1$s">by %2$s</a>.', esc_url( $subtypeurl ), esc_html( $subtype ));
}
add_shortcode( 'subscribe', 'subscribe_multilink_shortcode' );


/**** Shortcode for Posts ( Start ) ****/

/**** Simple Shortcode ****/

// Shortcode is [recent-posts] , That is specified in "ACF" page's Editor field
//CREATE THE CALLBACK FUNCTION
function recent_posts_function($atts,$content=null) {
   query_posts(array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => 2));
   if (have_posts()) :
      while (have_posts()) : the_post();
         $return_string.= '<a href="'.get_permalink().'">'.get_the_title().'</a>,';
      endwhile;
   endif;
   wp_reset_query();
   return $return_string;
}

//REGISTER THE SHORTCODE
function register_shortcodes(){
   add_shortcode('recent-posts', 'recent_posts_function');
}

//HOOK INTO WORDPRESS
add_action( 'init', 'register_shortcodes');


/**** Advanced Shortcode ****/

// Shortcode is [advanced-recent-posts posts="4"] , That is specified in "ACF" page's Editor field
//CREATE THE CALLBACK FUNCTION
function advanced_recent_posts_function($atts,$content=null) {
   extract(shortcode_atts(array(
      'posts' => '',
   ), $atts));

   $return_string = '<h3>'.$content.'</h3>';
   $return_string .= '<ul>';
   
   //$return_string  = '<ul>';
   
   query_posts(array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => $posts));
   if (have_posts()) :
      while (have_posts()) : the_post();
         $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
      endwhile;
   endif;
   $return_string .= '</ul>';

   wp_reset_query();
   return $return_string;
}

//REGISTER THE SHORTCODE
function register_shortcodes_adv(){
   add_shortcode('advanced-recent-posts', 'advanced_recent_posts_function');
}

//HOOK INTO WORDPRESS
add_action( 'init', 'register_shortcodes_adv');

/**** Shortcode for Posts ( End ) ****/



/**** Shortcode for Google Map ( Start ) ****/

function googlemap_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '640',
      "height" => '480',
      "src" => ''
   ), $atts));
   return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'&output=embed" ></iframe>';
}
add_shortcode("googlemap", "googlemap_function");

/**** Shortcode for Google Map ( End ) ****/



/**** Shortcode for Google Chart ( Start ) ****/

function chart_function( $atts ) {
   extract(shortcode_atts(array(
       'data' => '',
       'chart_type' => 'pie',
       'title' => 'Chart',
       'labels' => '',
       'size' => '640x480',
       'background_color' => 'FFFFFF',
       'colors' => '',
   ), $atts));

   switch ($chart_type) {
      case 'line' :
         $chart_type = 'lc';
         break;
      case 'pie' :
         $chart_type = 'p3';
         break;
      default :
         break;
   }

   $attributes = '';
   $attributes .= '&chd=t:'.$data.'';
   $attributes .= '&chtt='.$title.'';
   $attributes .= '&chl='.$labels.'';
   $attributes .= '&chs='.$size.'';
   $attributes .= '&chf='.$background_color.'';
   $attributes .= '&chco='.$colors.'';

   return '<br><br><img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$chart_type.''.$attributes.'" alt="'.$title.'" /><br><br>';
}
add_shortcode('chart', 'chart_function');

/**** Shortcode for Google Chart ( End ) ****/


/**** Shortcode for PDF EMBEDDING ( Start ) ****/

function pdf_function($attr, $url) {
   extract(shortcode_atts(array(
       'width' => '640',
       'height' => '480'
   ), $attr));
   return '<iframe src="http://docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' .$width. '; height:' .$height. ';">Your browser does not support iframes</iframe>';
}
add_shortcode('pdf', 'pdf_function');

/**** Shortcode for PDF EMBEDDING ( End ) ****/


/**** Shortcode for WORDPRESS MENU ( Start ) ****/

function menu_function($atts, $content = null) {
   extract(
      shortcode_atts(
         array( 'name' => null, ),
         $atts
      )
   );
   return wp_nav_menu(
      array(
          'menu' => $name,
          'echo' => false
          )
   );
}
add_shortcode('menu', 'menu_function');

/**** Shortcode for WORDPRESS MENU ( End ) ****/


/**** Shortcode for LINK BUTTON ( Start ) ****/

function linkbutton_function( $atts, $content = null ) {
   return '<button type="button">'.do_shortcode($content).'</button>';
}
add_shortcode('linkbutton', 'linkbutton_function');

/**** Shortcode for LINK BUTTON ( End ) ****/


/**** Creating A Custom Post Type ( Start ) ****/

add_action( 'init', 'bs_post_types' );
function bs_post_types() {

  $labels = array(
    'name'                => __( 'Events', THEMENAME ),
    'singular_name'       => __( 'Event', THEMENAME ),
    'add_new'             => __( 'Add New', THEMENAME ),
    'add_new_item'        => __( 'Add New Event', THEMENAME ),
    'edit_item'           => __( 'Edit Event', THEMENAME ),
    'new_item'            => __( 'New Event', THEMENAME ),
    'all_items'           => __( 'All Event', THEMENAME ),
    'view_item'           => __( 'View Event', THEMENAME ),
    'search_items'        => __( 'Search Events', THEMENAME ),
    'not_found'           => __( 'No events found', THEMENAME ),
    'not_found_in_trash'  => __( 'No events found in Trash', THEMENAME ),
    'menu_name'           => __( 'Events', THEMENAME ),
  );

  $supports = array( 'title', 'editor' );

  $slug = get_theme_mod( 'event_permalink' );
  $slug = ( empty( $slug ) ) ? 'event' : $slug;

  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'query_var'           => true,
    'rewrite'             => array( 'slug' => $slug ),
    'capability_type'     => 'post',
    'has_archive'         => true,
    'hierarchical'        => false,
    'menu_position'       => null,
    'supports'            => $supports,
  );

  register_post_type( 'event', $args );

}

/**** Creating A Custom Post Type ( End ) ****/


/*add_filter('manage_event_posts_columns', 'bs_event_table_head');
function bs_event_table_head( $defaults ) {
    $defaults['event_date']  = 'Event Date';
    $defaults['ticket_status']    = 'Ticket Status';
    $defaults['venue']   = 'Venue';
    $defaults['author'] = 'Added By';
    return $defaults;
}*/


/**** Display the denoted Custom Fields in Admin panel Post lists page ( Start ) ****/
 
function test_modify_post_table( $column ) {
    $column['portfolio_link'] = 'Link';
    $column['portfolio_quote'] = 'Quote';

    return $column;
}
add_filter( 'manage_post_posts_columns', 'test_modify_post_table' );

function test_modify_post_table_row( $column_name, $post_id ) {

    //$custom_fields = get_post_custom( $post_id );

    switch ($column_name) {
        case 'portfolio_link' :
            echo get_post_meta( $post_id, 'portfolio_link', true );
            break;

        case 'portfolio_quote' :
        echo get_post_meta( $post_id, 'portfolio_quote', true );
            break;

        default:
    }
}

add_action( 'manage_post_posts_custom_column', 'test_modify_post_table_row', 10, 2 );

/**** Display the denoted Custom Fields in Admin panel Post lists page ( End ) ****/



/**** Display the denoted Custom Fields in Admin panel Custom Post Type ( Movies ) lists page ( Start ) ****/
 
function test_modify_movies_post_table( $column ) {
    $column['color'] = 'Color';
    $column['price'] = 'Price';

    return $column;
}
add_filter( 'manage_movies_posts_columns', 'test_modify_movies_post_table' );

function test_modify_movies_post_table_row( $column_name, $post_id ) {

    //$custom_fields = get_post_custom( $post_id );

    switch ($column_name) {
        case 'color' :
            echo get_post_meta( $post_id, 'color', true );
            break;

        case 'price' :
        echo get_post_meta( $post_id, 'price', true );
            break;

        default:
    }
}

add_action( 'manage_movies_posts_custom_column', 'test_modify_movies_post_table_row', 10, 2 );

/**** Display the denoted Custom Fields in Admin panel Post lists page ( End ) ****/

/***********************************************************************************************/
/* Registers our main widget area of front page,single page and footer widget areas. */
/***********************************************************************************************/
function slavictheme_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Home Right sidebar', 'slavictheme' ), //'Home right sidebar',
		'id' => 'home_right_sidebar',
		'before_title' => '',
        'after_title' => '',
	) );
	
	register_sidebar( array(
		'name' => __( 'Single Right sidebar', 'slavictheme' ), //'Single Page right sidebar',
		'id' => 'single_right_sidebar',
		'before_title' => '',
        'after_title' => '',
	) );
	
	register_sidebar( array(
		'name' => __( 'Home Footer', 'slavictheme' ), //'Footer Page Widget',
		'id' => 'home_footer',
		'before_title' => '',
        'after_title' => '',
	) );
	
}
add_action( 'widgets_init', 'slavictheme_widgets_init' );


/**** Display Widget using shortcode ( It works under with "amr shortcode any widget" plugin ) It refers to "ACF page" content field ****/



/*add_action('acf/input/admin_head', 'my_acf_admin_head');

function my_acf_admin_head() {
    
    ?>
    <script type="text/javascript">
    (function($) {
        
        $(document).ready(function(){
            
            $('.acf-field-54cf2c4fcfbfe .acf-input').append( $('#postdivrich') );
            
        });
        
    })(jQuery);    
    </script>
    <style type="text/css">
        .acf-field #wp-content-editor-tools {
            background: transparent;
            padding-top: 0;
        }
    </style>
    <?php    
    
}*/
