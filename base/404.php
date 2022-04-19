<?php get_header(); ?>
<?php
	echo apply_filters("the_content",$post->post_content);
?>
<section id="random-seccion" class="target-top-margin">
	<h1>404</h1>
	<h2>UPS! No existe esta URL</h2>
	<h3>En unos segundos te enviaremos al Home</h3>
</section>
<script type="text/javascript">
	setTimeout(function(){
		window.location.href=site_url;
	},5000);
</script>
<?php get_footer(); ?>