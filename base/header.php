<!DOCTYPE html lang="es">
<html>
<head>
	<title><?php echo $post->post_title; ?></title>
	<meta name="description" content="<?php echo bloginfo('description'); ?>" />
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- Lang INI -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<!-- Lang END -->
	<?php wp_head(); ?>
</head>
<body id="body_<?php echo $post->ID; ?>" onLoad="base_onload();">
<header>

  <h2>Cities ( header.php )</h2>

</header>