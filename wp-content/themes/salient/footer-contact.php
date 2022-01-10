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
?>


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

</body>
</html>
