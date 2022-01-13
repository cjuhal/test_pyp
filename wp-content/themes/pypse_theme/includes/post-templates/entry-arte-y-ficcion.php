<?php 
global $options; 
global $post;
global $indexCategory;

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


	
	<div class="inner-wrap animated span5_9" id="post-<?php the_ID(); ?>">

		<div class="post-content pl-0">
		
			
			
				<?php if( !is_single() ) { ?> 
			
										<?php 
							echo '<span class="meta-category">';
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								$output = null;
							    foreach( $categories as $category ) {
									$link = get_link_category_valakax($category);
							        $output .= '<a class="'.$category->slug.'" href="' . esc_url( $link ) . '">' . esc_html( $category->name ) . '</a>';
							    }
							    echo trim( $output);
							}
						echo '</span>';  ?>
			

					 <div class="article-content-wrap" style="flex-direction: column;">

						<div class="post-featured-img-wrap" style="width: 100%; min-height: 150px;"> 
							
							<?php if ( has_post_thumbnail() ) {?>
								<a href="<?php the_permalink(); ?>">
								<?php	echo'<span class="post-featured-img" style="background-image: url('.get_the_post_thumbnail_url($post->ID, 'wide_photography', array('title' => '')).');"></span>'; ?>
								</a> 
							<?php } ?>
							
										

							
						</div>
						 
						 						<div class="post-content-wrap" style="width: 100%"> 
						
							<div class="post-header ">

								<h3 class="title" style="text-align: center;">
									<?php if( !is_single() && !($using_masonry == true && $masonry_type == 'classic_enhanced') ) { ?> 
										<a href="<?php the_permalink(); ?>"><?php } ?>
											<?php the_title(); ?>
										<?php if( !is_single() && !($using_masonry == true && $masonry_type == 'classic_enhanced') ) {?> </a> 
									<?php } ?>
								</h3>
								
								<div class="container mt-2" style="    display: flex; justify-content: center;"><?php echo do_shortcode('[Sassy_Social_Share]') ?></div>

								
							</div><!--/post-header-->
							

					</div><!--post-content-wrap-->
		
					</div><!--article-content-wrap-->

				<?php } ?>
			
		</div><!--/post-content-->
		
	</div><!--/inner-wrap-->
		