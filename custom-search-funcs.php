<?php 

function expert_cpt() {
	$labels = array(
	  'name'               => _x( 'Experts', 'expert' ),
	  'singular_name'      => _x( 'Expert', 'expert' ),
	  'add_new'            => _x( 'Add New', 'Expert' ),
	  'add_new_item'       => __( 'Add New Expert' ),
	  'edit_item'          => __( 'Edit Expert' ),
	  'new_item'           => __( 'New Expert' ),
	  'all_items'          => __( 'All Expert' ),
	  'view_item'          => __( 'View Experts' ),
	  'search_items'       => __( 'Search Experts' ),
	  'not_found'          => __( 'No Experts found' ),
	  'not_found_in_trash' => __( 'No Experts found in the Trash' ),
	  'menu_name'          => 'Experts',
	);
	$args = array(
	  'labels'              => $labels,
	  'description'         => 'Expert Witnesses',
	  'public'              => true,
	  'publicly_queryable'  => true,
	  'menu_position'       => 5,
	  'menu_icon'           => 'dashicons-businessman',
	  'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
	  'rewrite'             => array( 'slug' => 'experts' ),
	  'has_archive'         => true,
	  'show_in_rest' 		=> true,
	  'taxonomies'  => array( 'types' )
	);
	register_post_type( 'experts', $args ); 
  }
  add_action( 'init', 'expert_cpt' );

  function experts_taxonomy() {
	$industries_labels = array(
		'name'               => _x( 'Expert Industries', 'expert_industries' ),
		'singular_name'      => _x( 'Expert Industry', 'expert_industry' ),
		'add_new'            => _x( 'Add New', 'Expert Industry' ),
		'add_new_item'       => __( 'Add New Expert Industry' ),
		'edit_item'          => __( 'Edit Expert Industry' ),
		'new_item'           => __( 'New Expert Industry' ),
		'all_items'          => __( 'All Expert Industries' ),
		'view_item'          => __( 'View Expert Industries' ),
		'search_items'       => __( 'Search Expert Industries' ),
		'not_found'          => __( 'No Expert Industries found' ),
		'not_found_in_trash' => __( 'No Expert Industries found in the Trash' ),
		'menu_name'          => 'Expert Industries',
	  );
	register_taxonomy(
		'experts_industries',  // name of the taxonomy. 
		'experts',             // post type name
		array(
			'hierarchical' => true,
			'labels' => $industries_labels, // custom labels
			'query_var' => true,
			'show_in_rest'  => true,
			'rewrite' => array(
				'slug' => 'expert_industry',    // This controls the base slug that will display before each term
				'with_front' => false  // Don't display the category base before
			)
		)
	);
    $specialities_labels = array(
		'name'               => _x( 'Expert Specialities', 'expert_speciality' ),
		'singular_name'      => _x( 'Expert Speciality', 'expert_speciality' ),
		'add_new'            => _x( 'Add New', 'Expert Speciality' ),
		'add_new_item'       => __( 'Add New Expert Speciality' ),
		'edit_item'          => __( 'Edit Expert Speciality' ),
		'new_item'           => __( 'New Expert Speciality' ),
		'all_items'          => __( 'All Expert Specialities' ),
		'view_item'          => __( 'View Expert Specialities' ),
		'search_items'       => __( 'Search Expert Specialities' ),
		'not_found'          => __( 'No Expert Specialities found' ),
		'not_found_in_trash' => __( 'No Expert Specialities found in the Trash' ),
		'menu_name'          => 'Expert Specialities',
	  );
	register_taxonomy(
		'experts_specialities',  // name of the taxonomy. 
		'experts',             // post type name
		array(
			'hierarchical' => true,
			'labels' => $specialities_labels, // custom labels
			'query_var' => true,
			'show_in_rest'  => true,
			'rewrite' => array(
				'slug' => 'expert_speciality',    // This controls the base slug that will display before each term
				'with_front' => false  // Don't display the category base before
			)
		)
	);
    $location_labels = array(
		'name'               => _x( 'Expert Locations', 'expert_locations' ),
		'singular_name'      => _x( 'Expert Location', 'expert_location' ),
		'add_new'            => _x( 'Add New', 'Expert Location' ),
		'add_new_item'       => __( 'Add New Expert Location' ),
		'edit_item'          => __( 'Edit Expert Location' ),
		'new_item'           => __( 'New Expert Location' ),
		'all_items'          => __( 'All Expert Locations' ),
		'view_item'          => __( 'View Expert Locations' ),
		'search_items'       => __( 'Search Expert Locations' ),
		'not_found'          => __( 'No Expert Locations found' ),
		'not_found_in_trash' => __( 'No Expert Locations found in the Trash' ),
		'menu_name'          => 'Expert Locations',
	  );
	register_taxonomy(
		'experts_locations',  // name of the taxonomy. 
		'experts',             // post type name
		array(
			'hierarchical' => true,
			'labels' => $location_labels, // custom labels
			'query_var' => true,
			'show_in_rest'  => true,
			'rewrite' => array(
				'slug' => 'expert_locations',    // This controls the base slug that will display before each term
				'with_front' => false  // Don't display the category base before
			)
		)
	);
 }
 add_action( 'init', 'experts_taxonomy');

 // Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

/*=================================================
CUSTOM QUERY
=================================================== */
function custom_search_query_vars_filter( $vars ) {

    $vars[] .= 'keyword';
    $vars[] .= 'industry_select';
    $vars[] .= 'speciality';
    $vars[] .= 'location_select';
    return $vars;
}
add_filter( 'query_vars', 'custom_search_query_vars_filter' );

/*=================================================
SEARCH QUERY
=================================================== */
function custom_search( $query ) {
    if ( is_post_type_archive( 'experts' ) && $query->is_main_query() && !is_admin() ) {

        $keyword = get_query_var( 'keyword', FALSE );
        $industry_select = strtolower(str_replace(' ', '-', get_query_var( 'industry_select', FALSE ) ));
        $speciality_select = strtolower(str_replace(' ', '-', get_query_var( 'speciality', FALSE ) ));
        $location_select = strtolower(str_replace(' ', '-', get_query_var( 'location_select', FALSE ) ));


        // create list of terms similar to what the user typed in
		// creates a "broad" match type instead of requiring a user type in the taxonomies exactly as they have been input through the dashboard

		// array push to add original serach term to list of terms generated by get_terms

        $broad_match_ind = get_terms( array(
            'taxonomy' => 'experts_industries',
            'fields' => 'slugs', 
            'name__like' => $industry_select,
            'hide_empty' => false 
        ) );
        array_push($broad_match_ind, $industry_select);

        $broad_match_spec = get_terms( array(
            'taxonomy' => 'experts_specialities',
            'fields' => 'slugs',
            'name__like' => $speciality_select,
            'hide_empty' => false 
        ) );
        array_push($broad_match_spec, $speciality_select);

        $broad_match_loc = get_terms( array(
            'taxonomy' => 'experts_locations',
            'fields' => 'slugs', 
            'name__like' => $location_select,
            'hide_empty' => false 
        ) );
        array_push($broad_match_loc, $location_select);        

        // Keywords query
        $keyword ? $keyword : $keyword = null;

        $query->set('s', $keyword);   


        // Custom fields query
        //$meta_query_array = array('relation' => 'AND');
        //$status_list ? array_push($meta_query_array, array('key' => 'status_job', 'value' => '"' . $status_list . '"', 'compare' => 'LIKE') ) : null ;
        //$query->set( 'meta_query', $meta_query_array );
        

        // Build taxonomy array based on what's been filled out 

        $tax_query_array = array('relation' => 'OR');
        $location_select ? array_push($tax_query_array, array('taxonomy' => 'experts_locations', 'field' => 'slug', 'terms' => $broad_match_loc) ) : null ;
        $speciality_select ? array_push($tax_query_array, array('taxonomy' => 'experts_specialities', 'field' => 'slug', 'terms' => $broad_match_spec) ) : null ;
        $industry_select ? array_push($tax_query_array, array('taxonomy' => 'experts_industries', 'field' => 'slug', 'terms' => $broad_match_ind) ) : null ;

        $query->set( 'tax_query', $tax_query_array);

    }
}
add_action( 'pre_get_posts', 'custom_search' );

/*=================================================
ADD TAXONOMY TO CONTENT AREA SO WP SEARCH MATCHES CUSTOM TAXONOMY 
=================================================== */
function change_content_on_save($post_id, $post, $update) {
    if( "experts" == get_post_type() ) {
        // create content to add 
        $postID = get_the_ID();
        $industry_tax_terms = strip_tags(get_the_term_list( $post->ID, 'experts_industries', '', ', ' ));
        $spec_tax_terms = strip_tags(get_the_term_list( $post->ID, 'experts_specialities', '', ', ' ));
        $loc_tax_term = strip_tags(get_the_term_list( $post->ID, 'experts_locations', '', ', ' ));
        $add_content = $industry_tax_terms . ' ' . $spec_tax_terms . ' ' . $loc_tax_term;
        //error_log(print_r($add_content, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST))
        return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
        if (!current_user_can('edit_post', $post_id))
            return;
        
        // create your terms list and insert to content here:
        $post->post_content = $add_content;
        
        // Delete hook to avoid endless loop
        remove_action('save_post', 'change_content_on_save', 10);
        wp_update_post($post);
    }
  }
add_action( 'save_post', 'change_content_on_save', 10, 3 );

/*=================================================
AJAX LOAD MORE
=================================================== */

function load_more_flash() {

	$ajaxposts = new WP_Query([
	  'post_type' => 'flash-tattoos',
	  'posts_per_page' => 4,
	  'orderby' => 'date',
	  'order' => 'DESC',
	  'paged' => $_POST['paged'],
	]);
  
	$response = [];
  
	if($ajaxposts->have_posts()) { while($ajaxposts->have_posts()) : $ajaxposts->the_post();
		// build array of fields we need to build the flash tattoo cards
		$current_post = [];
		$title = get_the_title();
		array_push($current_post, $title);
		$flash_img = get_field('image_of_tattoo'); 
		array_push($current_post, $flash_img['url']);
		$artist = get_the_terms(get_the_ID(), 'Artists');
		array_push($current_post, $artist[0]->name);
		$size = get_the_terms(get_the_ID(), 'tattoo_sizes');
		array_push($current_post, $size[0]->name);
		$permalink = get_permalink(get_the_ID());
		array_push($current_post, $permalink);
		// add array built above to the response array 
		array_push($response, $current_post);
	  endwhile;
	} 
	// send the response as json to parse in JS
	echo(json_encode($response));
	die();
  }
  add_action('wp_ajax_load_more_flash', 'load_more_flash');
  add_action('wp_ajax_nopriv_load_more_flash', 'load_more_flash');