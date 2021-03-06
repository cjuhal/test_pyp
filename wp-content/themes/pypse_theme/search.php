<?php get_header(); 

global $options;
$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';

?>
<div class="container-wrap">
	<?php do_action('get_breadcrumbs_vlkx');?>
	<div class="main-content">
		
		<div class="row">
			<div class="col span_12">
				<div class="col span_12 section-title">
					<h1><?php echo __('Resultados para', NECTAR_THEME_NAME); ?><span>"<?php echo esc_html( get_search_query( false ) ); ?>"</span></h1>
					<?php if($theme_skin == 'material' && $wp_query->found_posts) echo '<span class="result-num">' . $wp_query->found_posts . ' resultados encontrados </span>'; ?>
				</div>
			</div>
		</div>
		
		<div class="divider"></div>
		
		</div>

	<div class="main-content">
		
		<div class="row">
			
		<div class="span_9">
			<div class="col featured_img_left post-area" data-ams="8px">
			<?php
				apply_desing_categories_post('includes/post-templates/entry', $wp_query); 
			?>
			</div><!--/ post-area-->
			<?php valakax_pagination_for_search($wp_query); ?>
			</div><!--/span_9-->
			<div id="sidebar" data-nectar-ss="false" class="col span_3 col_last mt-5 hidden_mobile">
				<?php get_sidebar(); ?>
			</div><!--/span_3-->
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
</div><!--/main-content-->
<?php get_footer(); ?>

