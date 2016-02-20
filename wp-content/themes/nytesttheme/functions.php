<?php

	// prevent hack
	defined('ABSPATH') or die("No Hackers Sorry !");
	
	// add support thumbnail
	add_theme_support( 'post-thumbnails' ); 
	
	
	if( is_user_logged_in() )
	{
		// excute the profile part
		// just want to write profile functions in other file
		get_template_part( 'functions', 'profile' );
		
		// add editor style
		wp_register_style( 'project-member-editor',
							get_template_directory_uri().'/css/project-member-editor.css');
		wp_enqueue_style( 'project-member-editor' );
		
		// editor part : display custome project member field and tags like facebook
		get_template_part( 'functions', 'editor' );
		
		// allow iframe
		add_filter( 'wp_kses_allowed_html', 'esw_author_cap_filter',1,1 );
	}
		
	// register part
	get_template_part( 'functions', 'register' );
	
	
	register_nav_menus
	(
		array('primary-menu' => __('主選單') )
	);
	
	
	//test custome post types
	//register_post_type( 'one-column' );
	//register_post_type( 'half-picture' );
	//add_post_type_support( 'one-column', 'page-attributes' );
	//add_post_type_support( 'half-picture' );
	
	
	function return_404() {
		status_header(404);
		nocache_headers();
		include( get_404_template() );
		exit();
	}
	
	// make iframe available
	function esw_author_cap_filter( $allowedposttags ) {

		//Here put your conditions, depending your context
		
		if ( !current_user_can( 'publish_posts' ) )
		return $allowedposttags;
		
		// Here add tags and attributes you want to allow
		
		$allowedposttags['iframe'] = array (
		'align' => true,
		'width' => true,
		'height' => true,
		'frameborder' => true,
		'name' => true,
		'src' => true,
		'id' => true,
		'class' => true,
		'style' => true,
		'scrolling' => true,
		'marginwidth' => true,
		'marginheight' => true,
		
		);
		return $allowedposttags;
	}
	
	// add custome post type
	//add_action( 'init', 'codex_book_init' );
	function codex_book_init() {
		
		$labels = array(
		'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Book', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Books', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'book', $args );
}
?>