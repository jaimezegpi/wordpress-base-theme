<?php

/*HEADER*/
add_theme_support( 'title-tag' );
/*CSS INI*/
wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css',false,'1.1','all');
wp_enqueue_style( 'fucknimation', get_template_directory_uri() . '/css/fucknimation.css',false,'1.1','all');
/*MINICSS ini*/
wp_enqueue_style( 'minicss', get_template_directory_uri() . '/css/mini-dark.min.css',false,'1.1','all');
//wp_enqueue_style( 'main', get_template_directory_uri() . '/css/mini-default.min.css',false,'1.1','all');
//wp_enqueue_style( 'main', get_template_directory_uri() . '/css/mini-nord.min.min.css',false,'1.1','all');
/*MINICSS end*/
wp_enqueue_style( 'general', get_template_directory_uri() . '/css/general.css',false,'1.1','all');
wp_enqueue_style( 'desktop', get_template_directory_uri() . '/css/desktop.css',false,'1.1','all');
wp_enqueue_style( 'tablet', get_template_directory_uri() . '/css/tablet.css',false,'1.1','all');
wp_enqueue_style( 'mobile', get_template_directory_uri() . '/css/mobile.css',false,'1.1','all');
/*CSS END*/

/*FOOTER*/
/*JAVASCRIPT INI*/
wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', array ( 'jquery' ), 1.1, true);
wp_enqueue_script( 'fucknimation', get_template_directory_uri() . '/js/fucknimation.js', array ( 'jquery' ), 1.1, true);
wp_enqueue_script( 'functions', get_template_directory_uri() . '/js/functions.js', array ( 'jquery' ), 1.1, true);
/*JAVASCRIPT END*/

/*-------------------------------------------*/

/**
 * @return Menu array by name
 */
function base_wpGetMenuArray($current_menu) {
    $array_menu = wp_get_nav_menu_items($current_menu);
    $menu = array();
    foreach ($array_menu as $m) {
        //var_dump($m);
        if (empty($m->menu_item_parent)) {
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID'] = $m->ID;
            $menu[$m->ID]['object_id'] = $m->object_id;
            $menu[$m->ID]['title'] = $m->title;
            $menu[$m->ID]['url'] = $m->url;
            $menu[$m->ID]['children'] = array();
        }
    }
    $submenu = array();
    foreach ($array_menu as $m) {
        if ($m->menu_item_parent) {
            $submenu[$m->ID] = array();
            $submenu[$m->ID]['ID'] = $m->ID;
            $submenu[$m->ID]['object_id'] = $m->object_id;
            $submenu[$m->ID]['title'] = $m->title;
            $submenu[$m->ID]['url'] = $m->url;
            $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
        }
    }
    return $menu;
}

/**
 * Register Menu in WP
 */
function base_registerMenus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
        )
    );
}
add_action( 'init', 'base_registerMenus' );

/**
 * @param  [string psot type name]
 * @param  [Limit , default is -1 for all]
 * @return [object]
 */
function base_getCustomPosts($post_name, $limit){
	if (!$post_name){ return false; }
	if (!$limit){ $limit = -1; }
	$query = array(
		'post_type' => $post_name,
		'post_status' => 'publish',
		'posts_per_page' => $limit,
		'order_by' => 'date',
		'order' => 'DESC'
	);
	return get_posts($query);
}

/**
 * @param  [the_content]
 * @return [render the content - using <p>'s]
 */
function base_theContent($content){
	if( !$content ){ return false; }
	echo apply_filters( 'the_content', $content );
}

function base_custom_post_type( $name, $singular_name, $menu_name, $parent_item_colon, $all_items, $view_item, $add_new_item, $add_new, $edit_item, $update_item, $search_items, $not_found, $not_found_in_trash,$description) {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( $name, 'Post Type General Name', 'base' ),
        'singular_name'       => _x( $singular_name, 'Post Type Singular Name', 'base' ),
        'menu_name'           => __( $menu_name, 'base' ),
        'parent_item_colon'   => __( $parent_item_colon, 'base' ),
        'all_items'           => __( $all_items, 'base' ),
        'view_item'           => __( $view_item, 'base' ),
        'add_new_item'        => __( $add_new_item, 'base' ),
        'add_new'             => __( $add_new, 'base' ),
        'edit_item'           => __( $edit_item, 'base' ),
        'update_item'         => __( $update_item, 'base' ),
        'search_items'        => __( $search_items, 'base' ),
        'not_found'           => __( $not_found, 'base' ),
        'not_found_in_trash'  => __( $not_found_in_trash, 'base' )
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( strtolower( $singular_name ) , 'base' ),
        'description'         => __( $description, 'base' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields','page-attributes' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page'
    );
     
    // Registering your Custom Post Type
    register_post_type( strtolower($menu_name), $args );
 
}

function base_add_custom_post_type(){
	/* 
	Example
	base_custom_post_type("Cliente", "Cliente", "Cliente", "Paren Cliente", "Todas los registros", "Ver Registro", "Agregar Cliente", "Agregar Cliente", "Editar Cliente", "Actualizar Cliente", "Buscar Cliente", "Cliente no encontrada", "Cliente no está en el basurero", "Bases de Ejemplo");
	*/
}
add_action( 'init', 'base_add_custom_post_type', 0 );

/* II.- PLUGINS */
/* Contact Form 7 CF7 */
// 1. - Control de envio de formulario , agregar nuevos correos
add_action('wpcf7_before_send_mail','base_dynamic_addcc');
/**
 * @param  [ctform]
 * @return [boolean]
 */
function base_dynamic_addcc($WPCF7_ContactForm){
		$form_id='00000'; /* ID de formulario */
	    if ($form_id == $WPCF7_ContactForm->id()) {
        $currentformInstance  = WPCF7_ContactForm::get_current();
        $contactformsubmition = WPCF7_Submission::get_instance();
        if ($contactformsubmition) {
            $cc_email = array();
            $data = $contactformsubmition->get_posted_data();
            /* -------------- */
            /*
            $post_id = $data['ID']; <-- name of input field
            */
			$email1='ejemplo@ejemplo.com';
			$email2='ejemplo2@ejemplo2.com';
			if ($email1){array_push($cc_email, $email1);}
			if ($email2){array_push($cc_email, $email2);}

			$cclist = implode(', ',$cc_email);
            if (empty($data)){ return; }

            $mail = $currentformInstance->prop('mail');

            if(!empty($cclist)){
                $mail['additional_headers'] = "Cc: $cclist";
            }

            $currentformInstance->set_properties(array(
                "mail" => $mail
            ));

            // return current cf7 instance
            return $currentformInstance;
        }
	}
	return true;
}

// 2. - Control de envio de formulario , Guardo en la BD
add_action('wpcf7_before_send_mail','base_catch_beforme_send');
/**
 * @param  [cftform]
 * @return [boolean]
 */
function base_catch_beforme_send($WPCF7_ContactForm){
		 $log_file='loginsert';
		$form_id='00000'; /* ID de formulario */
	    if ($form_id == $WPCF7_ContactForm->id()) {
        $currentformInstance  = WPCF7_ContactForm::get_current();
        $contactformsubmition = WPCF7_Submission::get_instance();
        if ($contactformsubmition) {
            $cc_email = array();
            $data = $contactformsubmition->get_posted_data();
            /* -------------- */
            /*
            $post_id = $data['ID']; <-- name of input field
            */
			try {

				global $wpdb;

				$wpdb->insert( 
					'vista_cotizaciones', 
					array( 
						'rut' => $data['rut'],
						'fecha' => DATE('Y-m-d H:i:s')
					), 
					array( 
						'%s','%s'
					) 
				);
				
			} catch (Exception $e) {

				$out = fopen(get_template_directory()."/".$log_file.".log", "w");
				$file_data = '$e' ;
				fwrite($out, $file_data);
				fclose($out);
				
			}
            return $currentformInstance;
        }
	}
	return true;
}

/*ESPECIAL*/
/*
Obtiene la UF , 
primero la guarda en un archivo con la fecha dentro de una carpeta llamada UF
Retorna el valor de la UF
*/
/**
 * @return [write UF in File]
 */
function base_getUF(){
  if (!file_exists('uf')) {
      mkdir("uf/", 0777);
  }
  if ( file_exists('uf/uf.txt') ){
    $fichero = file_get_contents('uf/uf.txt', true);
    $fichero_a = explode("|", $fichero);
    if ($fichero_a[0]==DATE("Y-m-d")."txt"){
		return $fichero_a[1];
    }else{
    	return base_contactUFSource();
    }    
  }else{
    return base_contactUFSource();
  }
}

/**
 * @return [string UF]
 */
function base_contactUFSource(){
    $apiUrl = 'https://mindicador.cl/api';
    //Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
    if ( ini_get('allow_url_fopen') ) {
        $json = file_get_contents($apiUrl);
    } else {
        //De otra forma utilizamos cURL
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        curl_close($curl);
    }
    $dailyIndicators = json_decode($json);
    $uf = $dailyIndicators->uf->valor;
    $str = 'uf/uf.txt';
    $out = fopen($str, "w");
    fwrite($out, $uf);
    fclose($out);
    return $uf;
}