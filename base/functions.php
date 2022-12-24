<?php
define("HANDSHAKE","TAbUTLecuraMUNCeldIMplectfis");
define("TIMEZONE","America/Santiago");
define("BASE_DEBUG",true);
/* install theme exceute only one time */
if ( !file_exists(__DIR__.'/base_setup.php') ){
	base_showDebugLine("Theme not instaled. Proceed to do..");
	base_showDebugLine("1.- Creating CRUD ( Create, Read, Update, Delete ) Pages..");
	base_create_page("crud","page for actions of theme" );
	base_showDebugLine("2.- Include ".__DIR__."/install.php");
	if ( file_exists(__DIR__.'/install.php') ){
		include( "install.php" );
	}else{
		base_showDebugLine("File not exist install.php");
	}
}

/*Set time*/
date_default_timezone_set(TIMEZONE);
add_action('wp_enqueue_scripts', 'base_implementScripts'); 
function base_implementScripts(){
	if ( !is_admin() ){

		/* General User Site */

		global $post;
		$post_id = $post->ID."";
		$version = "1.1";
		/*HEADER*/
		add_theme_support( 'title-tag' );
		/*CSS INI*/
		wp_enqueue_style( 'main-css', get_template_directory_uri() . '/css/main.css',false,$version,'all');
		wp_enqueue_style( 'bxc_animation-css', get_template_directory_uri() . '/css/bxc_animation.css',false,$version,'all');
		wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/css/swiper-bundle.min.css',false,$version,'all');
		wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/css/jquery.fancybox.min.css',false,$version,'all');
		wp_enqueue_style( 'desktop-css', get_template_directory_uri() . '/css/desktop.css',false,$version,'all');
		wp_enqueue_style( 'tablet-css', get_template_directory_uri() . '/css/tablet.css',false,$version,'all');
		wp_enqueue_style( 'mobile-css', get_template_directory_uri() . '/css/mobile.css',false,$version,'all');
		/*CSS END*/
		/* HERE Insert Your custom CSS File */
		/*wp_enqueue_style( 'your_libname-css', get_template_directory_uri() . '/css/your_libname.js', false, $version, 'all');*/
		

		/*FOOTER*/
		/*JAVASCRIPT INI*/
		wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/js/swiper-bundle.min.js', array ( 'jquery' ), $version, true);
		wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array ( 'jquery' ), $version, true);
		wp_enqueue_script( 'bxc_animation-js', get_template_directory_uri() . '/js/bxc_animation.js', array ( 'jquery' ), $version, true);
		wp_enqueue_script( 'functions-js', get_template_directory_uri() . '/js/functions.js', array ( 'jquery' ), $version, true);
		wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array ( 'jquery' ), $version, true);

		wp_localize_script( 'functions-js', 'post_id', $post_id);
		wp_localize_script( 'functions-js', 'post', json_encode($post) );
		wp_localize_script( 'functions-js', 'site_url', get_site_url());
		wp_localize_script( 'functions-js', 'template_url', get_template_directory_uri());

		/*-------------*/
		/* HERE Insert Your custom JS File */
		/*wp_enqueue_script( 'your_libname-js', get_template_directory_uri() . '/js/your_libname.js', array ( 'jquery' ), $version, true);*/
		/*JAVASCRIPT END*/

	}else{

		/* Admin User Dashboard */
		/*HEADER*/
		/*CSS INI*/
		wp_enqueue_style( 'wordpress-dashboard-css', get_template_directory_uri() . '/css/wordpress-dashboard.css',false,$version,'all');
		/*CSS END*/

		/*FOOTER*/
		/*JAVASCRIPT INI*/
		wp_enqueue_script( 'wordpress-dashboard-js', get_template_directory_uri() . '/js/wordpress-dashboard.js', array ( 'jquery' ), 1.1, true);
		/*JAVASCRIPT END*/
	}

}

/*-------------------------------------------*/

/**
 * @return Menu array by name
 */
function base_wpGetMenuArray($current_menu) {
	$menu = wp_nav_menu( array(
		'menu'   => $current_menu,
		'walker' => new base_WPDocs_Walker_Nav_Menu()
	) );
	return $menu;
}


class base_WPDocs_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * Adds classes to the unordered list sub-menus.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// Depth-dependent classes.
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'sub-menu',
			( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
			( $display_depth >=2 ? 'sub-sub-menu' : '' ),
			'menu-depth-' . $display_depth
		);
		$class_names = implode( ' ', $classes );

		// Build HTML for output.
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	/**
	 * Start the element output.
	 *
	 * Adds main/sub-classes to the list items and links.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// Depth-dependent classes.
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// Passed classes.
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// Build HTML.
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// Link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		// Build HTML output and pass through the proper filter.
		if ( isset($args->before) ){
			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after
			);
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
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

function base_custom_post_type( $name, $singular_name, $menu_name, $parent_item_colon, $all_items, $view_item, $add_new_item, $add_new, $edit_item, $update_item, $search_items, $not_found, $not_found_in_trash, $description, $menu_position, $menu_icon) {
	if ( !$menu_position ){		$menu_position = 1;	}
	if ( !is_numeric($menu_position) ){		$menu_position = 1;	}
 if ( !$menu_icon ){ $menu_icon = 'dashicons-chart-pie';	}

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
		'menu_position'       => $menu_position,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'menu_icon'						=> $menu_icon,
		'capability_type'     => 'page'
	);
	 
	// Registering your Custom Post Type
	register_post_type( strtolower($menu_name), $args );
 
}

function base_add_custom_post_type(){
	/* 
	Example
base_custom_post_type(
	$name,
	$singular_name,
	$menu_name,
	$parent_item_colon,
	$all_items,
	$view_item,
	$add_new_item,
	$add_new,
	$edit_item,
	$update_item,
	$search_items,
	$not_found,
	$not_found_in_trash,
	$description,
	$menu_position,
	$menu_icon
);
	*/
}
add_action( 'init', 'base_add_custom_post_type', 0 );


/* META BOXES O CUSTOM FIELDS */

function base_register_meta_boxes() {
	/*Exmaple*/
	/*add_meta_box( 'mi-meta-box-id', __( 'Fields', 'tutorialeswp' ), 'base_display_callback', 'post' );*/
}
add_action( 'add_meta_boxes', 'base_register_meta_boxes' );

function base_display_callback( $post ) {
	$web1 = get_post_meta( $post->ID, 'web1', true );
	$web2 = get_post_meta( $post->ID, 'web2', true );
	wp_nonce_field( 'mi_meta_box_nonce', 'meta_box_nonce' );
	echo '<p><label for="web1_label">Web de referencia 1</label> <input type="text" name="web1" id="web1" value="'. $web1 .'" /></p>';
	echo '<p><label for="web2_label">Web de referencia 2</label> <input type="text" name="web2" id="web2" value="'. $web2 .'" /></p>';
}

function base_save_meta_box( $post_id ) {
	// Comprobamos si es auto guardado
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	// Comprobamos el valor nonce creado en twp_mi_display_callback()
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'mi_meta_box_nonce' ) ) return;
	// Comprobamos si el usuario actual no puede editar el post
	if( !current_user_can( 'edit_post' ) ) return;
	
	
	// Guardamos...
	if( isset( $_POST['web1'] ) )
	update_post_meta( $post_id, 'web1', $_POST['web1'] );
	if( isset( $_POST['web2'] ) )
	update_post_meta( $post_id, 'web2', $_POST['web2'] );
}
add_action( 'save_post', 'base_save_meta_box' );

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

/**
*  Add to the admin_init hook of your theme functions.php file 
*/
function base_category_tag_settings() {  
	// Add tag metabox to page
	register_taxonomy_for_object_type('post_tag', 'page'); 
	// Add category metabox to page
	register_taxonomy_for_object_type('category', 'page');  
}
// Add to the admin_init hook of your theme functions.php file 
add_action( 'init', 'base_category_tag_settings' );

/**
 * $role
 */
function base_role_exists( $role ) {

	if( ! empty( $role ) ) {
		return $GLOBALS['wp_roles']->is_role( $role );
	}

	return false;
}

/**
 *  @$origien_role
 *  @$clone_name
 *  @$clone_show_name
 * @return 
 */
function base_clone_role( $origin_role, $clone_name, $clone_show_name ) {
	if (!$origin_role || !$clone_name || !$clone_show_name){ return false; }
	if ( !base_role_exists( $role ) ){ return false; }
	strtolower($clone_name);
	$clone_name = base_clean_string_onlyLetters( $clone_name );
	add_role( $clone_name, $clone_show_name, get_role( $origin_role )->capabilities );
}


/**
 * @s
 * @return [string]
 */
function base_clean_string_onlyLetters( $s ){
	if ( !$s ){
		return false;
	}elseif ( !is_string($s) ) {
		return false;
	}
	str_replace(" ", "_", $s);
	$result = preg_replace("/[^a-zA-Z0-9]+/", "", $s);
	return $result;
}


/* SECURITY ---------------------------------------------------------*/
function base_removeWordpressVersion() {
return '';
}
add_filter('the_generator', 'base_removeWordpressVersion');


/* THEME ---------------------------------------------------------*/

/**
 * Change login form
 */
function base_theme_loginForm() { ?>
	<style type="text/css">

	body.login.login-action-login{
		background-image: url(<?php echo get_template_directory_uri(); ?>/img/login-background.jpg);
		background-size: cover;
		background-position: center;
	}

	#login h1 a, .login h1 a {
		background-image: url(<?php echo get_template_directory_uri(); ?>/img/padlock.png);
		height:100px;
		width:100px;
		background-size: 100px 100px;
		background-repeat: no-repeat;
		padding-bottom: 30px;
	}
	</style>
<?php
}
add_action( 'login_enqueue_scripts', 'base_theme_loginForm' );



/**
 * Hide Admin bar.
 */
function base_theme_hideAdminBar(){ return false; }
add_filter( 'show_admin_bar', 'base_theme_hideAdminBar' );

/*

Email sender

// Función para cambiar el remitente. Cambiamos "admin@example.com" por nuestro email
function wpb_sender_email( $original_email_address ) {
	return 'admin@example.com';
} 

// Función para cambiar el nombre del remitente. Cambiamos "Admin Admin" por el nombre que deseemos
function wpb_sender_name( $original_email_from ) {
	return 'Admin Admin';
}

// Hookeamos las funciones 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );
*/
/*---------------------------------------------------------*/


function base_create_page($title_of_the_page,$content,$parent_id = NULL ) {
    $objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
    if( ! empty( $objPage ) )
    {
        /*echo "Page already exists:" . $title_of_the_page . "<br/>";*/
        return $objPage->ID;
    }
    
    $page_id = wp_insert_post(
            array(
            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => ucwords($title_of_the_page),
            'post_name'      => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
            'post_status'    => 'publish',
            'post_content'   => $content,
            'post_type'      => 'page',
            'post_parent'    =>  $parent_id //'id_of_the_parent_page_if_it_available'
            )
        );
    /*echo "Created page_id=". $page_id." for page '".$title_of_the_page. "'<br/>";*/
    return $page_id;
}

//base_create_page("action","page for actions of theme" );
//base_create_page("create","child of actions for create posts" );


/* Error Display on DEBUG */
function base_showDebugLine($line,$type=""){
	if ( !BASE_DEBUG ){ return false;	}
	$line = sanitize_text_field($line);
	if ($type=="pre"){
		echo '<div class="base-debug-line"><pre>';
		var_dump($line);
		echo '</pre></div>';
	}else{
		echo '<div class="base-debug-line">'.$line.'</div>';
	}
}