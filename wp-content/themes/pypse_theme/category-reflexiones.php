

<?php get_header(); ?>
<?php do_action('get_breadcrumbs_vlkx'); ?>
<?php nectar_page_header(get_option('page_for_posts')); ?>

<div class="main-content">
<div class="container-wrap pt-0">
		
	<div class="main-content">
		
		<div class="row">
			
		<div class="span_9">
		    <?php 
				get_search_form_valakax();
				$the_query = get_search_categoires_post();
			?>
			<div class="col featured_img_left post-area" data-ams="8px">
			<?php
				apply_desing_categories_post('includes/post-templates/entry-reflexiones', $the_query); 
			?>
			</div><!--/ post-area-->
			<?php valakax_pagination($the_query); ?>
			</div><!--/span_9-->
			<div id="sidebar" data-nectar-ss="false" class="col span_3 col_last mt-5 hidden_mobile">
				<?php get_sidebar(); ?>
			</div><!--/span_3-->
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
</div><!--/main-content-->
<?php get_footer(); ?>
