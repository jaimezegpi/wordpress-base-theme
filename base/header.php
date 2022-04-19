<?php
$menu_name = "Menu";/*<-- Name MEnu*/
$menu_arr = array();

if ( $menu_name ){
	$menu_arr = base_wpGetMenuArray($menu_name);
}

?>
<!DOCTYPE html lang="es">
<html>
<head>

	<meta name="description" content="<?php echo bloginfo('description'); ?>" />
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<?php wp_head(); ?>


</head>
<body id="body_<?php echo $post->ID; ?>" >

<header id="header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/hero-background.jpg">

	<div id="navbar" class="navbar">
		<div class="content">
			<div class="row">
				<div class="col-sm-6 col-md-3 logo" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/base-logo.png')"></div>
				<div class="col-sm-6 col-md-9 menu flex flex-end">
					<div class="only-desktop">
						<div class="menu-items flex flex-end">
							<?php
							if ( is_array($menu_arr) ){
								foreach ($menu_arr as $menu_key => $menu_item) {
									?>
									<div class="menu-item"><a href=""><?php echo $menu_item["title"] ?></a></div>
									<?php
								}
							}
							?>
						</div>
					</div>
					<div class="only-mobile">
						MENU
					</div>
				</div>

			</div>

		</div>
	</div>

	<div class="hero flex flex-column flex-center">
		<h1><?php echo $post->post_title; ?></h1>
	</div>

</header>