<?php

$options = get_nectar_theme_options();
global $post;
$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';
$cta_link = ( !empty($options['cta-btn-link']) ) ? $options['cta-btn-link'] : '#';
$using_footer_widget_area = (!empty($options['enable-main-footer-area']) && $options['enable-main-footer-area'] == 1) ? 'true' : 'false';
$disable_footer_copyright = (!empty($options['disable-copyright-footer-area']) && $options['disable-copyright-footer-area'] == 1) ? 'true' : 'false';
$footer_reveal = (!empty($options['footer-reveal'])) ? $options['footer-reveal'] : 'false';
$footer_full_width = (!empty($options['footer-full-width'])) ? $options['footer-full-width'] : 'false';
$midnight_non_reveal = ($footer_reveal != 'false') ? null : 'data-midnight="light"';

$footer_bg_image_overlay = (!empty($options['footer-background-image-overlay'])) ? $options['footer-background-image-overlay'] : '0.8';
$footer_bg_image = (!empty($options['footer-background-image']) && !empty($options['footer-background-image']['url'])) ? nectar_options_img($options['footer-background-image']) : false;
$usingFooterBgImg = 'false';
$footer_bg_image_markup = '';

if($footer_bg_image && !empty($footer_bg_image)) {
	$usingFooterBgImg = 'true';
	$footer_bg_image_markup = 'style="background-image:url('.$footer_bg_image.');"';
}

$exclude_pages = (!empty($options['exclude_cta_pages'])) ? $options['exclude_cta_pages'] : array();
$footerColumns = (!empty($options['footer_columns'])) ? $options['footer_columns'] : '4';

?>

<div <?php echo $midnight_non_reveal; ?> data-cols="<?php echo $footerColumns; ?>" data-disable-copyright="<?php echo $disable_footer_copyright; ?>" data-using-bg-img="<?php echo $usingFooterBgImg; ?>" data-bg-img-overlay="<?php echo $footer_bg_image_overlay; ?>" data-full-width="<?php echo $footer_full_width; ?>" data-using-widget-area="<?php echo $using_footer_widget_area; ?>" <?php echo $footer_bg_image_markup;?>>

	<?php if(!empty($options['cta-text']) && current_page_url() != $cta_link && !in_array($post->ID, $exclude_pages)) {
		$cta_btn_color = (!empty($options['cta-btn-color'])) ? $options['cta-btn-color'] : 'accent-color'; ?>

		<div id="call-to-action">
			<div class="container">
				<div class="triangle"></div>
				<span> <?php echo $options['cta-text']; ?> </span>
				<a class="nectar-button <?php if($cta_btn_color != 'see-through') echo 'regular-button '; ?> <?php echo $cta_btn_color;?>" data-color-override="false" href="<?php echo $cta_link ?>"><?php if(!empty($options['cta-btn'])) echo $options['cta-btn']; ?> </a>
			</div>
		</div>

	<?php } ?>

	<?php if( $using_footer_widget_area == 'true') {


	?>

	<div id="footer-widgets" data-cols="<?php echo $footerColumns; ?>">

		<div class="text-center text-md-left footer-border-top">

			<div class="row">


				<?php

				if($footerColumns == '1'){
					$footerColumnClass = 'col span_12';
				} else if($footerColumns == '2'){
					$footerColumnClass = 'col span_6';
				} else if($footerColumns == '3'){
					$footerColumnClass = 'col span_4';
				} else {
					$footerColumnClass = 'col-md-3';
				}
				?>

				<?php if($footerColumns == '4') echo '<div class="col-md-8 row">' ?>

				<div class="<?php echo $footerColumnClass;?>">
				<?php 		$post   = get_post( 370 );
							$output =  apply_filters( 'the_content', $post->post_content );
							echo $output;
				?>
				</div><!--/span_3-->

				<?php if($footerColumns == '2' || $footerColumns == '3' || $footerColumns == '4' || $footerColumns == '5') { ?>

					<div class="<?php echo $footerColumnClass;?>">
						 <!-- Footer widget area 2 -->
			             <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 2') ) : else : ?>
			                  <div class="widget">
							 	 <h4 class="widgettitle">Widget Area 2</h4>
							 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
					     	  </div>
					     <?php endif; ?>

					</div><!--/span_3-->

				<?php } ?>


				<?php if($footerColumns == '3' || $footerColumns == '4' || $footerColumns == '5') { ?>
					<div class="<?php echo $footerColumnClass;?>">
						 <!-- Footer widget area 3 -->
			              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 3') ) : else : ?>
			              	  <div class="widget">
							  	<h4 class="widgettitle">Widget Area 3</h4>
							  	<p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
							  </div>
					     <?php endif; ?>

					</div><!--/span_3-->
				<?php } ?>

				<?php if($footerColumns == '4') { ?>
					<div class="<?php echo $footerColumnClass;?>">
						 <!-- Footer widget area 3 -->
										<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 4') ) : else : ?>
												<div class="widget">
									<h4 class="widgettitle">Widget Area 3</h4>
									<p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
								</div>
							 <?php endif; ?>

					</div><!--/span_3-->
				<?php } ?>
				<?php if($footerColumns == '4') echo '</div>' ?>

				<?php if($footerColumns == '4') { ?>
					<div class="col-md-4 row" style="color: #777777!important;">
						 <!-- Footer widget area 5 -->
										<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 5') ) : else : ?>
											<div class="widget">
									<h4>Widget Area 4</h4>
									<p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
							 </div><!--/widget-->
							 <?php endif; ?>

					</div><!--/span_3-->
				<?php } ?>

				<?php if($footerColumns == '5') { ?>
					<div class="col <?php echo $footerColumnClass;?>" >
						 <!-- Footer widget area 4 -->
			              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 4') ) : else : ?>
			              	<div class="widget">
							    <h4>Widget Area 4</h4>
							    <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
							 </div><!--/widget-->
					     <?php endif; ?>

					</div><!--/span_3-->
				<?php } ?>

			</div><!--/row-->

		</div><!--/container-->

	</div><!--/footer-widgets-->

	<?php } //endif for enable main footer area


	   if( $disable_footer_copyright == 'false') { ?>




			<div class="mt-3 text-center text-md-left" style="height:35px;">

				<div class="row" id="copyright">
					<div class="col-lg-4 col-sm-4" style="padding-left: 15px;">

						</div><!--/span_7-->

				<?php if($footerColumns != '0'){ ?>
					<div class="col-lg-4 col-sm-4 text-center">

						<?php if(!empty($options['disable-auto-copyright']) && $options['disable-auto-copyright'] == 1) { ?>
							<p><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>
						<?php } else { ?>
							<p>Copyright &copy; <?php echo date('Y') ?> <a href="https://www.instagram.com/valakax/" target="_blank"><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> VALAKAX</a></p>
						<?php } ?>

					</div>
					<div class="col-lg-4 col-sm-4"></div><!--/span_5-->
				<?php } ?>


				<?php if($footerColumns == '122'){ ?>
					<div class="col-lg-4">

						<?php if(!empty($options['disable-auto-copyright']) && $options['disable-auto-copyright'] == 1) { ?>
							<p><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>
						<?php } else { ?>
							<p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>. <?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>
						<?php } ?>

					</div><!--/span_5-->
				<?php } ?>

			</div><!--/container-->

		</div><!--/row-->

		<?php } //endif for enable main footer copyright ?>

</div><!--/footer-outer-->

<?php

$mobile_fixed = (!empty($options['header-mobile-fixed'])) ? $options['header-mobile-fixed'] : 'false';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';

$sideWidgetArea = (!empty($options['header-slide-out-widget-area'])) ? $options['header-slide-out-widget-area'] : 'off';
$userSetSideWidgetArea = $sideWidgetArea;
if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';

$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? true : false;
$sideWidgetClass = (!empty($options['header-slide-out-widget-area-style'])) ? $options['header-slide-out-widget-area-style'] : 'slide-out-from-right';

if($headerFormat == 'centered-menu-under-logo') {
	if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') {
		$sideWidgetClass = 'slide-out-from-right';
	}
}

$sideWidgetOverlayOpacity = (!empty($options['header-slide-out-widget-area-overlay-opacity'])) ? $options['header-slide-out-widget-area-overlay-opacity'] : 'dark';
$prependTopNavMobile = (!empty($options['header-slide-out-widget-area-top-nav-in-mobile'])) ? $options['header-slide-out-widget-area-top-nav-in-mobile'] : 'false';
if($theme_skin == 'material') $prependTopNavMobile = '1';

$dropdownFunc = (!empty($options['header-slide-out-widget-area-dropdown-behavior'])) ? $options['header-slide-out-widget-area-dropdown-behavior'] : 'default';
if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt') {
	$dropdownFunc = 'default';
}

if($sideWidgetArea == '1') {

	if($sideWidgetClass == 'fullscreen') echo '</div><!--blurred-wrap-->'; ?>

	<div id="slide-out-widget-area-bg" class="<?php echo $sideWidgetClass . ' '. $sideWidgetOverlayOpacity; ?>"><?php if($sideWidgetClass == 'fullscreen-alt') echo '<div class="bg-inner"></div>';?></div>
	<div id="slide-out-widget-area" class="<?php echo $sideWidgetClass; ?>" data-dropdown-func="<?php echo $dropdownFunc; ?>" data-back-txt="<?php echo __('Back', NECTAR_THEME_NAME); ?>">

		<?php if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt' || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right') || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right-hover') ) echo '<div class="inner-wrap">'; ?>

		<?php $prepend_mobile_menu = ($prependTopNavMobile == '1' && $has_main_menu == 'true' && $userSetSideWidgetArea != 'off') ? 'true' : 'false'; ?>
		<div class="inner" data-prepend-menu-mobile="<?php echo $prepend_mobile_menu; ?>">

		  <a class="slide_out_area_close" href="#">
		  	<?php
		  	if($theme_skin != 'material') {
			  	echo '<span class="icon-salient-x icon-default-style"></span>';
			  } else {
			  	echo '<span class="close-wrap"> <span class="close-line close-line1"></span> <span class="close-line close-line2"></span> </span>';
			  } ?>
		  </a>


		   <?php

		   if($userSetSideWidgetArea == 'off' || $prependTopNavMobile == '1' && $has_main_menu == 'true') { ?>
			   <div class="off-canvas-menu-container mobile-only">
			  		<ul class="menu">
					   <?php
					  		////use default top nav menu if ocm is not activated
					  	     ////but is needed for mobile when the mobile fixed nav is on
					   		wp_nav_menu( array('theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s'));

					   		if($headerFormat == 'centered-menu' || $headerFormat == 'menu-left-aligned') {
					   			if(has_nav_menu('top_nav_pull_right')) {
									wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) );
								}
							}

					   ?>

					</ul>

					<ul class="menu secondary-header-items"><?php
						//material secondary nav in menu
						$using_secondary = (!empty($options['header_layout']) && $headerFormat != 'left-header') ? $options['header_layout'] : ' ';
						if($theme_skin == 'material' && $using_secondary == 'header_with_secondary' && has_nav_menu('secondary_nav')) {
			   	  			 wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'secondary_nav', 'container' => '', 'items_wrap' => '%3$s' ) );
						} ?>
					</ul>
				</div>
			<?php }

		  if(has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') { ?>
		 	 <div class="off-canvas-menu-container">
		  		<ul class="menu">
					    <?php wp_nav_menu( array('theme_location' => 'off_canvas_nav', 'container' => '', 'items_wrap' => '%3$s'));

					  	?>
				</ul>
		    </div>

		  <?php }

		   //widget area
		   if($sideWidgetClass != 'slide-out-from-right-hover') {
			   if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Off Canvas Menu') ) : elseif(!has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') : ?>
			      <div class="widget">
				 	 <h4 class="widgettitle">Side Widget Area</h4>
				 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign widgets to this area.</a></p>
			 	  </div>
			 <?php endif;

			} ?>

		</div>

		<?php

			$usingSocialOrBottomText = (!empty($options['header-slide-out-widget-area-social']) && $options['header-slide-out-widget-area-social'] == '1' || !empty($options['header-slide-out-widget-area-bottom-text'])) ? true : false;

			echo '<div class="bottom-meta-wrap">';

			if($sideWidgetClass == 'slide-out-from-right-hover') {
			   if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Off Canvas Menu') ) : elseif(!has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') : ?>
			      <div class="widget">
				 	 <h4 class="widgettitle">Side Widget Area</h4>
				 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign widgets to this area.</a></p>
			 	  </div>
			 <?php endif;

			}

			global $using_secondary;
		 	/*social icons*/
			 if(!empty($options['header-slide-out-widget-area-social']) && $options['header-slide-out-widget-area-social'] == '1') {
			 	$social_link_arr = array('twitter-url','facebook-url','vimeo-url','pinterest-url','linkedin-url','youtube-url','tumblr-url','dribbble-url','rss-url','github-url','behance-url','google-plus-url','instagram-url','stackexchange-url','soundcloud-url','flickr-url','spotify-url','vk-url','vine-url','houzz-url', 'phone-url','email-url');
			 	$social_icon_arr = array('fa fa-twitter','fa fa-facebook','fa fa-vimeo','fa fa-pinterest','fa fa-linkedin','fa fa-youtube-play','fa fa-tumblr','fa fa-dribbble','fa fa-rss','fa fa-github-alt','fa fa-behance','fa fa-google-plus','fa fa-instagram','fa fa-stackexchange','fa fa-soundcloud','fa fa-flickr','icon-salient-spotify','fa fa-vk','fa-vine','fa-houzz','fa fa-phone', 'fa fa-envelope');

			 	echo '<ul class="off-canvas-social-links">';

			 	for($i=0; $i<sizeof($social_link_arr); $i++) {

			 		if(!empty($options[$social_link_arr[$i]]) && strlen($options[$social_link_arr[$i]]) > 1) echo '<li><a target="_blank" href="'.$options[$social_link_arr[$i]].'"><i class="'.$social_icon_arr[$i].'"></i></a></li>';
			 	}

			 	echo '</ul>';
			 } else if (!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary') {
			 	echo '<ul class="off-canvas-social-links mobile-only">';
				nectar_header_social_icons('off-canvas');
				echo '</ul>';
			 }

			 /*bottom text*/
			 if(!empty($options['header-slide-out-widget-area-bottom-text'])) {
			 	$desktop_social = (!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1') ? 'false' : 'true';
			 	echo '<p class="bottom-text" data-has-desktop-social="'. $desktop_social .'">'.$options['header-slide-out-widget-area-bottom-text'].'</p>';
			 }

			echo '</div><!--/bottom-meta-wrap-->';

			if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt' || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right') || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right-hover') ) echo '</div> <!--/inner-wrap-->'; ?>

	</div>
<?php } ?>


</div> <!--/ajax-content-wrap-->


<?php if(!empty($options['boxed_layout']) && $options['boxed_layout'] == '1' && $headerFormat != 'left-header') { echo '</div>'; } ?>

<?php if(!empty($options['back-to-top']) && $options['back-to-top'] == 1) { ?>
	<a id="to-top" class="<?php if(!empty($options['back-to-top-mobile']) && $options['back-to-top-mobile'] == 1) echo 'mobile-enabled'; ?>"><i class="fa fa-angle-up"></i></a>
<?php }

$body_border = (!empty($options['body-border'])) ? $options['body-border'] : 'off';
if($body_border == '1') {
	echo '<div class="body-border-top"></div>
		<div class="body-border-right"></div>
		<div class="body-border-bottom"></div>
		<div class="body-border-left"></div>';
}

wp_footer(); ?>

<?php if($theme_skin == 'material') { echo '</div></div><!--/ocm-effect-wrap-->'; } ?>
</div>
</body>
</html>
