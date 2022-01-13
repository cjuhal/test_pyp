<?php 
global $options; 
global $post;

$masonry_size_pm = get_post_meta($post->ID, '_post_item_masonry_sizing', true); 
$masonry_item_sizing = (!empty($masonry_size_pm)) ? $masonry_size_pm : 'regular'; 
$using_masonry = null;
 
global $layout;

if(isset($GLOBALS['nectar_blog_std_style']) && $GLOBALS['nectar_blog_std_style'] != 'inherit') {
	$blog_standard_type = $GLOBALS['nectar_blog_std_style'];
} else {
	$blog_standard_type = (!empty($options['blog_standard_type'])) ? $options['blog_standard_type'] : 'classic';
}

$blog_type = $options['blog_type']; 

if(isset($GLOBALS['nectar_blog_masonry_style']) && $GLOBALS['nectar_blog_masonry_style'] != 'inherit') {
	$masonry_type = $GLOBALS['nectar_blog_masonry_style'];
} else {
	$masonry_type = (!empty($options['blog_masonry_type'])) ? $options['blog_masonry_type'] : 'classic';
}

if(
$blog_type == 'masonry-blog-sidebar' && substr( $layout, 0, 3 ) != 'std' || 
$blog_type == 'masonry-blog-fullwidth' && substr( $layout, 0, 3 ) != 'std' || 
$blog_type == 'masonry-blog-full-screen-width' && substr( $layout, 0, 3 ) != 'std' || 
$layout == 'masonry-blog-sidebar' || $layout == 'masonry-blog-fullwidth' || $layout == 'masonry-blog-full-screen-width') {
  $using_masonry = true;
}

$use_excerpt = (!empty($options['blog_auto_excerpt']) && $options['blog_auto_excerpt'] == '1') ? 'true' : 'false'; 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($masonry_item_sizing.' quote'); ?>>
	
	<div class="inner-wrap animated">

		<div class="post-content">
			
			<?php if( !is_single() ) { ?>
				
			<!--VALAKAX EDITION -->
			
			
				<?php 
				$quote = get_post_meta($post->ID, '_nectar_quote', true);
				$quote_author = get_post_meta($post->ID, '_nectar_quote_author', true); 
				?>

					 <div class="article-content-wrap reflexiones-article-content-wrap">
							<div class="mb-0 post-header">

						 <!--conteiner-->
						 <div style="width: 100%;display: flex;flex-direction: row;border-radius: 25px">
						
						<div class="post-content-wrap pr-4 pl-4 pt-0 pb-4 white" <?php if($quote === "") echo 'style="width:100%"'; ?> > 
								<div class="title escenas-title">
									<?php if( !is_single() && !($using_masonry == true && $masonry_type == 'classic_enhanced') ) { ?> 
										<a href="<?php the_permalink(); ?>"><?php } ?>
											<?php the_title(); ?>
										<?php if( !is_single() && !($using_masonry == true && $masonry_type == 'classic_enhanced') ) {?> </a> 
									<?php } ?>
								</div>
							
							<?php 
							//if no excerpt is set
							global $post;
							if($post->post_excerpt !== ""){?>
							<a href="<?php the_permalink(); ?>">
							<?php 
							echo '<div class="div-reflexiones">';
							echo $post->post_excerpt;
							/*$excerpt_length = (!empty($options['blog_excerpt_length'])) ? intval($options['blog_excerpt_length']) : 15; 
							echo nectar_excerpt($excerpt_length);*/
							echo '</div>';
							echo '</a>';
							}


						?>
						</div> <!--/post-content-wrap-->
					<?php 
							echo '<div style="width:35%">';
							if($quote !== ""){?>
							<a href="<?php the_permalink(); ?>">
							<?php 	
							echo '<div class="autor-reflexiones">';
							echo '<h3>Autores:</h3>';	
							echo $quote;
							/*$excerpt_length = (!empty($options['blog_excerpt_length'])) ? intval($options['blog_excerpt_length']) : 15; 
							echo nectar_excerpt($excerpt_length);*/
							echo '</div>';
							echo '</a>';
							echo '</div>';
							}
							?>
								
								
						</div> <!--/Container-->
							 
							</div><!--/post-header-->
					</div><!--article-content-wrap-->
								<div class="container sharedButtonsRight mt-2"><?php echo do_shortcode('[Sassy_Social_Share]') ?></div>

				<?php } ?>
						 <!--/VALAKAX EDITION -->
			
		</div><!--/post-content-->
		
	</div><!--/inner-wrap-->
		
</article><!--/article-->