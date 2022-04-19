<?php get_header(); ?>

<section id="random-seccion" class="target-top-margin">
	
	<div class="content">
		<h1>Template Base</h1>
		<p>Esta es una base sencilla para trabajar.</p>
		<section>
			<h2>I.- Funciones PHP Importantes</h2>
			<arcticle>
				<h3>1.- Valor UF Chile.</h3>
				<p>Obtiene el ultimo valor de la UF que se ha registrado en el sistema. Esta la obtiene del banco central y la guarda en un archivo plano en la raíz del sitio dentro de una carpeta llamada "UF". Primero verifica que se haya extraido el valor durante el día, si no ha sido así, se conecta con el Banco Central y la obtiene. Si no le es posible conectar regresa el úlltimo valor obtenido.</p>
				<p>Ej. de uso:</p>
				<code>
$uf = base_getUF();
echo $uf;
				</code>
			</arcticle>
			<arcticle>
				<h3>2.- Agregar un Tipo de Post Personalizado.</h3>
				<p>Agrega un nuevo tipo de post, que tiene las mismas capacidades de una página. Este se crea en el archivo functions.php del tema.</p>
				<p>Ej. de uso: Creo un nuevo tipo de Post llamado Cliente </p>
				<code>
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
				</code>
			</arcticle>
			<arcticle>
				<h3>3.- Obtener un menú determinado.</h3>
				<p>Obtiene el array completo de un Menú creado en el administrador. Se obtiene por el nombre exacto dado en el administrador.</p>
				<p>Ej. de uso:</p>
				<code>
$menu = base_wpGetMenuArray("Menu 1");
if ($menu){
    foreach($menu as $menu_key=>$menu_item){
	    echo $menu_item["title"];
    }
}
				</code>
			</arcticle>
			<arcticle>
				<h3>3.1- Obtener el Arbol Completo de un menú determinado.</h3>
				<p>Obtiene el array completo de un Menú creado en el administrador, lo serializa y regresa toda su estructura de hijos y submenus en un formato html más manejable.</p>
				<p>Ej. de uso:</p>
				<code>
$menu = base_wpGetMenuArray("Menu 1");
if ($menu){
	$menu_tree = base_getHtmlRecursiveMenu($menu, $menu_order=0)
	if ($menu_tree){
		echo $menu_tree;
	}
}
				</code>
			</arcticle>
			<arcticle>
				<h3>4.- Obtener Post de un tipo determinado.</h3>
				<p>Obtiene los post de un tipo determinado con o sin limite. Los obtiene por fecha en orden inverso, Los más nuevos primero, Con la posibilidad de limitarlo a un número determinado de posts. Ej los últimos cuatro productos cargados.</p>
				<p>Ej. de uso: Obtener los últimos 4 clientes ingresados. Si deseas obtener todos los clientes el valor ha de ser -1 </p>
				<code>
$posts_clientes = base_getCustomPosts("clientes",4); 
if ($posts){
    foreach($posts_clientes as $cliente_key=>$cliente_item){
	    echo $cliente_item->post_title;
    }
}
				</code>
			</arcticle>

			<arcticle>
				<h3>5.- Renderizar el contenido de un Post en forma correcta ( the_content ).</h3>
				<p>Renderiza el contenido de un post en forma correcta. Este proceso le agrega un <\p> al inicio y al final.</p>
				<p>Ej. de uso:</p>
				<code>
base_theContent($post->post_content);
				</code>
			</arcticle>

			<arcticle>
				<h3>6.- Crear un nuevo rol de usuario.</h3>
				<p>Crea un nuevo rol de usuario clonando otro ya existente.</p>
				<p>Ej. de uso:( "rol_original", "nombre_nuevo_rol", "Nombre a Mostrar" )</p>
				<code>
base_clone_role( "editor", "cliente_actualizador", "Miembro Actualizador de Contenidos" );
				</code>
			</arcticle>

			<arcticle>
				<h3>7.- Limpiar Variables y deja sólo letras .</h3>
				<p>Limpia una variable de caracteres ilegales y espacios en blanco, dejando sólo letras.</p>
				<p>Ej. de uso:</p>
				<code>
$variable_limpia = base_clean_string_onlyLetters($string);
				</code>
			</arcticle>

			<hr>

			<h2>Javascript</h2>

			<arcticle>
				<h3>1.- Obtener el Id del post de la actual página.</h3>
				<p>Variable: post_id</p>
				<p >Ej:</p>
				<div id="var_post_id" >XXX</div>
			</arcticle>

			<arcticle>
				<h3>2.- Obtener toda la info pública de la actual página ( es la info del post ).</h3>
				<p>Variable: post</p>
				<p >Ej:</p>
				<div id="var_post" >XXX</div>
			</arcticle>

			<arcticle>
				<h3>3.- Url del Sitio Web .</h3>
				<p>Variable: site_url</p>
				<p >Ej:</p>
				<div id="var_site_url" >XXX</div>
			</arcticle>

			<arcticle>
				<h3>4.- Url del Template .</h3>
				<p>Variable: template_url</p>
				<p >Ej:</p>
				<div id="var_template_url" >XXX</div>
			</arcticle>

			<hr>

			<h2>Librerias Js PreInstaladas</h2>
			<arcticle>
				<h3>1.- SwiperJS 6.7.0</h3>
				<p><a href="https://swiperjs.com/swiper-api" target="_blank">API</a></p>
			</arcticle>

			<arcticle>
				<h3>2.- fancybox 3</h3>
				<small>Deprecated - Pero hasta la fecha aun funciona mejor que la V.4 ( 30/09/2021 )</small>
				<p><a href="https://web.archive.org/web/20210325170940/https://fancyapps.com/fancybox/3/docs/" target="_blank">API</a></p>
			</arcticle>

			<arcticle>
				<h3>3.- Main ( mini bootstrap frame )</h3>
				<small>Librería propia</small>
			</arcticle>

			<arcticle>
				<h3>4.- BXC Animation ( ex-fuckanimation )</h3>
				<small>Librería propia</small>
			</arcticle>

			<arcticle>
				<h3>TIP 1.- Como Incluir un CSS o un JS nuevo</h3>
				<p>En el archivo function.php está el ejemplo.</p>
				<code>
wp_enqueue_style( 'tu_libreria-css', get_template_directory_uri() . '/css/tu_libreria.css',false,$version,'all');
wp_enqueue_script( 'tu_libreria-js', get_template_directory_uri() . '/js/tu_libreria.js', array ( 'jquery' ), $version, true);

$version <-- Es la version actual de los recursos..
Si tienes problemas con tus usuarios que no ven cambios que tu ya has realizado, 
cambiando este valor se fuerza la actualización en el browser del cliente.
				</code>
				
			</arcticle>
			 
		</section>

	</div>
	
 
</section>

<?php get_footer(); ?>
