<?php
/*
Plugin Name: Team Area for Organization
Plugin URI: http://oployeelabs.com
Description: Declares a plugin that will create a custom post type displaying all Team list.
Version: 1.0
Author: Rasel
Author URI: http://raselsec.com
*/
add_action('init','ta_create_team');

function ta_create_team(){
	 register_post_type( 'ta_team',
        array(
            'labels' => array(
                'name' => 'Teams Area',
                'singular_name' => 'Team ',
                'add_new' => 'Add New Team',
                'add_new_item' => 'Add New Team ',
                'edit' => 'Edit',
                'edit_item' => 'Edit Team ',
                'new_item' => 'New Team ',
                'view' => 'View',
                'view_item' => 'View Team Area',
                'search_items' => 'Search Team Area',
                'not_found' => 'No Team Area found',
                'not_found_in_trash' => 'No Team Area found in Trash',
                'parent' => 'Parent Team Area'
            ),
 
            'public' => true,
            'menu_position' => 15,
			'publicly_queryable' => true,
			'query_var' => true,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail','post-thumbnails'),
            'taxonomies' => array( '' ),
            'menu_icon' => 'dashicons-admin-users',
            'has_archive' => true,
			'rewrite' => array('slug' => 'teamlist', 'with_front' => true ),
			
        )
    );
	
	
}	
	

	add_action( 'init', 'ta_create_team_taxonomies', 0 );

	// create two taxonomies, Doctors and writers for the post type "book"
	function ta_create_team_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Designation', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Designation', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Designation', 'textdomain' ),
			'all_items'         => __( 'All Designation', 'textdomain' ),
			'parent_item'       => __( 'Parent Designation', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Designation:', 'textdomain' ),
			'edit_item'         => __( 'Edit Designation', 'textdomain' ),
			'update_item'       => __( 'Update Designation', 'textdomain' ),
			'add_new_item'      => __( 'Add New Designation', 'textdomain' ),
			'new_item_name'     => __( 'New Designation Name', 'textdomain' ),
			'menu_name'         => __( 'Designation', 'textdomain' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'Designation' ),
		);

		register_taxonomy( 'Designation', array( 'ta_team' ), $args );

		
	}
	
function team_area_css_and_js() {
	wp_register_style('animate', plugins_url('css/animate.css',__FILE__ ));
	wp_enqueue_style('animate');
	
	wp_register_style('style(2)', plugins_url('css/style(2).css',__FILE__ ));
	wp_enqueue_style('style(2)');
	
	wp_register_style('ta_bootstrap', plugins_url('css/bootstrap.css',__FILE__ ));
	 wp_enqueue_style('ta_bootstrap');
     
    wp_register_script( 'schedule_js', plugins_url( 'js/schedule_type.js', __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('schedule_js');
	

	wp_register_script( 'opl_ad_js', plugins_url( 'js/counter_advertisement.js', __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('opl_ad_js');
	
	


}


add_action( 'init','team_area_css_and_js');


add_shortcode('ta_team', 'ta_team_area_shortcode');

function ta_team_area_shortcode($atts, $content = null) {
    
			extract(shortcode_atts(array(
				"class" =>'class-name',
			), $atts));
      $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	  $args = array(
		'post_type' => 'ta_team',
		'posts_per_page' => 4,
		'paged' => $paged
	  );
	$loop = new WP_Query( $args );
	
	if( $loop->have_posts() ):
		$full_team ='<div id="team-area"><div class="col-md-12">';		
		while( $loop->have_posts() ): $loop->the_post(); global $post;
		
			$full_team.=' 
					<div class="wpb_wrapper col-md-3">
						<div class="box-scene">
							<div class="box">
								<div class="front face">
									<img class="alignnone size-full wp-image-988" src="'. plugin_dir_url( __FILE__ ) . 'images/Andy.png'.'" alt="Andy" width="270" height="270">
								</div>
								<div class="side face"><img class="alignnone size-full wp-image-989" src="'. plugin_dir_url( __FILE__ ) . 'images/Andy-fliped.png'.'" alt="Andy-fliped" width="270" height="270"></div>
							</div>
						</div>
						<div class="teamMemberdesc">
							<p class="name">Team Name</p>
							<p class="memberPosition">Product Manager</p>
							<p class="membeQoute">Don’t dream of winning, work for it!</p>
						</div>
					</div>';
		endwhile;
		$full_team.='</div></div>';
         endif;
		return $full_team;
}

               
                
