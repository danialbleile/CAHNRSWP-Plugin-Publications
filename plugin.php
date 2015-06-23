<?php
/**
* Plugin Name: CAHNRSWP Publications
* Plugin URI:  http://cahnrs.wsu.edu/communications/
* Description: Adds Publication Content Type
* Version:     0.2.1
* Author:      CAHNRS Communications, Danial Bleile
* Author URI:  http://cahnrs.wsu.edu/communications/
* License:     Copyright Washington State University
* License URI: http://copyright.wsu.edu
*/

/** Temp Documentation *

**/

class CAHNRSWP_Plugin_Publications {
	
	
	public function __construct(){
		
		define( 'CWPPURL' , plugin_dir_url( __FILE__ ) ); // Plugin Base url
		
		define( 'CWPPDIR' , plugin_dir_path( __FILE__ ) ); // Plugin Directory Path
		
		// Actions
		
		add_action( 'edit_form_after_title', array( $this ,'cwp_edit_form_after_title' ), 1 );
		
		add_action( 'save_post_publication' , array( $this , 'cwp_save_post' ) );
		
		add_action( 'init' , array( $this , 'cwp_init' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this , 'cwp_admin_scripts' ) );
		
		add_action( 'wp_enqueue_scripts', array( $this , 'cwp_scripts' ) );
		
		// Filters
		
		add_filter( 'template_include', array( $this , 'cwp_template_include' ), 99 );
		
	} // end __construct
	
	public function cwp_edit_form_after_title( $post ){
		
		if ( $post->post_type == 'publication' ){
		
			require_once 'model/model-publication-post-cwpp.php';
			
			$publication = new Model_Publication_CWPP();
			
			$publication->build( $post );
			
			//require_once 'control/control-publication-cwpp.php';
			
			require_once 'view/view-publication-editor-cwpp.php';
			
			//$Publication = new Model_Publication_Post_CWPP();
			
			$publication_View = new View_Publication_Editor_CWPP( $publication );
			
			$publication_View->the_editor();
		
		}// end if
		
		//$publication_control = new Control_Publication_CWPP( $Publication , $publication_View );
		
		//$publication_control->the_editor( $post );
		
	}
	
	public function cwp_save_post( $post_id ){
		
		require_once 'model/model-publication-save-cwpp.php';
		
		//require_once 'control/control-publication-cwpp.php';
		
		$publication = new Model_Publication_Save_CWPP();
		
		$publication->build( $post_id );
		
		//var_dump( $publication );
		
		//$publication_control = new Control_Publication_CWPP( $Publication );
		
		remove_action( 'save_post_publication' , array( $this , 'cwp_save_post' ) );
		
		$publication->save( $post_id );
		
	}
	
	public function cwp_template_include( $template ){
		
		if ( isset ( $_GET[ 'pub-pdf' ] ) ){
			
			$template = CWPPDIR . 'templates/pdf.php';
			
		} else if ( isset ( $_GET[ 'publication' ] ) ){
			
			$template = CWPPDIR . 'templates/syndicate.php';
			
		}// end if
		
		return $template;
		
	}
	
	public function cwp_init(){
		
		$this->regisert_post();
		
	}
	
	public function cwp_admin_scripts(){
		
		wp_enqueue_script( 'publications-admin-js', CWPPURL . 'js/admin.js', array(), '0.0.1' );
		
		wp_enqueue_style( 'publications-admin-cs', CWPPURL . 'css/admin.css', array(), '0.0.1' );
		
	}
	
	public function cwp_scripts(){
		
		wp_enqueue_script( 'publications-public-js', CWPPURL . 'js/public.js', array(), '0.0.1', 99 );
		wp_enqueue_script( 'cycle2', CWPPURL . 'js/cycle2.js', array(), '0.0.1', 99 );
		
		wp_enqueue_style( 'publications-public-cs', CWPPURL . 'css/public.css', array(), '0.0.1' );
		
	}
	
	
	private function regisert_post(){
		
		$args = array(
		  'public' => true,
		  'label'  => 'Publications',
		  'hierarchical'       => true,
		  'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
		  'rewrite'            => array( 'slug' => 'pubs' ),
		);
		
		register_post_type( 'publication', $args );
		
	}
	
}

$cahnrswp_plugin_publications = new CAHNRSWP_Plugin_Publications();