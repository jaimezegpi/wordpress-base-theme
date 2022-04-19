<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 flex flex-top footer-column">
				izquierda
			</div>
			<div class="col-sm-12 col-md-4 flex flex-center footer-column">
				centro
			</div>
			<div class="col-sm-12 col-md-4 flex flex-end footer-column">
				derecha
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
<script type="text/javascript">
		/*JAVASCRIPT TEMPLATES*/
	var container_post = document.querySelector("#var_post");
	if ( container_post ){
		var obj_post = JSON.parse(post);
		container_post.innerHTML = "Post Title:"+obj_post.post_title;
	}

	var container_post_id = document.querySelector("#var_post_id");
	if ( container_post_id ){ container_post_id.innerHTML = post_id;}

	var container_site_url = document.querySelector("#var_site_url");
	if ( container_site_url ){ container_site_url.innerHTML = site_url;}

	var container_template_url = document.querySelector("#var_template_url");
	if ( container_template_url ){ container_template_url.innerHTML = template_url;}

</script>
</body>
</html>