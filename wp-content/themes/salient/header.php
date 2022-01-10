<!doctype html>

<html <?php language_attributes(); ?> class="no-js">
<head>

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php $options = get_nectar_theme_options(); ?>

<?php if(!empty($options['responsive']) && $options['responsive'] == 1) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />

<?php } else { ?>
	<meta name="viewport" content="width=1200" />
<?php } ?>

<!--Shortcut icon-->
<?php if(!empty($options['favicon']) && !empty($options['favicon']['url'])) { ?>
	<link rel="shortcut icon" href="<?php echo nectar_options_img($options['favicon']); ?>" />
<?php } ?>

<?php wp_head(); ?>

<?php if(!empty($options['google-analytics'])) echo $options['google-analytics']; ?>

</head>

<?php
 global $post;
 global $woocommerce;


//check if parallax nectar slider is being used
$parallax_nectar_slider = using_nectar_slider();
$force_effect = get_post_meta($post->ID, '_force_transparent_header', true);

$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';

// header transparent option
$transparency_markup = null;
$activate_transparency = null;

$using_page_header = using_page_header($post->ID);
$using_fw_slider = $parallax_nectar_slider;
$using_fw_slider = (!empty($options['transparent-header']) && $options['transparent-header'] == '1') ? $using_fw_slider : 0;
if($force_effect == 'on') $using_fw_slider = '1';
$disable_effect = get_post_meta($post->ID, '_disable_transparent_header', true);

$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';

if(!empty($options['transparent-header']) && $options['transparent-header'] == '1' && $headerFormat != 'left-header') {

	$starting_color = (empty($options['header-starting-color'])) ? '#ffffff' : $options['header-starting-color'];
	$activate_transparency = $using_page_header;
	$remove_border = (!empty($options['header-remove-border']) && $options['header-remove-border'] == '1' || $theme_skin == 'material') ? 'true' : 'false';
	$transparency_markup = ($activate_transparency == 'true') ? 'data-transparent-header="true" data-remove-border="'.$remove_border.'" class="transparent"' : null ;
}

//header vars
$logo_class = (!empty($options['use-logo']) && $options['use-logo'] == '1') ? null : 'class="no-image"';
$sideWidgetArea = (!empty($options['header-slide-out-widget-area']) && $headerFormat != 'left-header' ) ? $options['header-slide-out-widget-area'] : 'off';
$sideWidgetClass = (!empty($options['header-slide-out-widget-area-style'])) ? $options['header-slide-out-widget-area-style'] : 'slide-out-from-right';
$sideWidgetIconAnimation = 'simple-transform';
if($sideWidgetClass == 'slide-out-from-right-hover') $sideWidgetIconAnimation = 'simple-transform';
$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? 'true' : 'false';
$headerSearch = (!empty($options['header-disable-search']) && $options['header-disable-search'] == '1') ? 'false' : 'true';
$mobile_fixed = (!empty($options['header-mobile-fixed'])) ? $options['header-mobile-fixed'] : 'false';
$mobile_breakpoint = (!empty($options['header-menu-mobile-breakpoint'])) ? $options['header-menu-mobile-breakpoint'] : 1000;
$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? 'true' : 'false';
$headerColorScheme = (!empty($options['header-color'])) ? $options['header-color'] : 'light';
$userSetBG = (!empty($options['header-background-color']) && $headerColorScheme == 'custom') ? $options['header-background-color'] : '#ffffff';
$trans_header = (!empty($options['transparent-header']) && $options['transparent-header'] == '1') ? $options['transparent-header'] : 'false';
if($headerFormat == 'left-header') $trans_header = 'false';
$bg_header = (!empty($post->ID) && $post->ID != 0) ? $using_page_header : 0;
$bg_header = ($bg_header == 1) ? 'true' : 'false'; //convert to string for references in css
$header_box_shadow = (!empty($options['header-box-shadow'])) ? $options['header-box-shadow'] : 'small';
$perm_trans = (!empty($options['header-permanent-transparent']) && $trans_header != 'false' && $bg_header == 'true') ? $options['header-permanent-transparent'] : 'false';
$headerLinkHoverEffect = (!empty($options['header-hover-effect'])) ? $options['header-hover-effect'] : 'default';
$headerRemoveStickiness = (!empty($options['header-remove-fixed'])) ? $options['header-remove-fixed'] : '0';
$hideHeaderUntilNeeded = (!empty($options['header-hide-until-needed'])) ? $options['header-hide-until-needed'] : '0';
if($headerFormat == 'left-header') { $hideHeaderUntilNeeded = '0'; $headerRemoveStickiness = '0'; }
if($headerRemoveStickiness == '1') $hideHeaderUntilNeeded = '1';
$headerResize = (!empty($options['header-resize-on-scroll']) && $perm_trans != '1') ? $options['header-resize-on-scroll'] : '0';
$dropdownStyle = (!empty($options['header-dropdown-style']) && $perm_trans != '1' && $headerFormat != 'left-header' ) ? $options['header-dropdown-style'] : 'classic';
$page_transition_effect = (!empty($options['transition-effect'])) ? $options['transition-effect'] : 'standard';
$megamenuwidth = (!empty($options['header-megamenu-width']) && $headerFormat != 'left-header') ? $options['header-megamenu-width'] : 'contained';
$megamenuRemoveTransparent = (!empty($options['header-megamenu-remove-transparent']) && $headerFormat != 'left-header') ? $options['header-megamenu-remove-transparent'] : '0';
$body_border = (!empty($options['body-border'])) ? $options['body-border'] : 'off';
if($hideHeaderUntilNeeded == '1' || $body_border == '1' || $headerFormat == 'left-header' || $headerRemoveStickiness == '1') $headerResize = '0';
$lightbox_script = (!empty($options['lightbox_script'])) ? $options['lightbox_script'] : 'pretty_photo';
if($lightbox_script == 'pretty_photo') { $lightbox_script = 'magnific'; }
$button_styling = (!empty($options['button-styling'])) ? $options['button-styling'] : 'default';
$form_style = (!empty($options['form-style'])) ? $options['form-style'] : 'default';
$fancy_rcs = (!empty($options['form-fancy-select'])) ? $options['form-fancy-select'] : 'default';
$footer_reveal = (!empty($options['footer-reveal'])) ? $options['footer-reveal'] : 'false';
$footer_reveal_shadow = (!empty($options['footer-reveal-shadow']) && $footer_reveal == '1') ? $options['footer-reveal-shadow'] : 'none';
$icon_style = (!empty($options['theme-icon-style'])) ? $options['theme-icon-style'] : 'inherit';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';
$animate_in_effect = (!empty($options['header-animate-in-effect'])) ? $options['header-animate-in-effect'] : 'none';
if($headerColorScheme == 'dark') { $userSetBG = '#1f1f1f'; }
$userSetSideWidgetArea = $sideWidgetArea;
if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';
if($headerFormat == 'centered-menu-under-logo') {
	if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') {
		$sideWidgetClass = 'slide-out-from-right';
	}
	$fullWidthHeader = 'false';
}
if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') $fullWidthHeader = 'true';
$column_animation_easing = (!empty($options['column_animation_easing'])) ? $options['column_animation_easing'] : 'linear';
$column_animation_duration = (!empty($options['column_animation_timing'])) ? $options['column_animation_timing'] : '650';
$prependTopNavMobile = (!empty($options['header-slide-out-widget-area-top-nav-in-mobile']) && $userSetSideWidgetArea == '1') ? $options['header-slide-out-widget-area-top-nav-in-mobile'] : 'false';
$smooth_scrolling = (!empty($options['smooth-scrolling'])) ? $options['smooth-scrolling'] : '0';
if($body_border == '1') $smooth_scrolling = '0';
$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
if($page_full_screen_rows == 'on') $smooth_scrolling = '0';
$form_submit_style = (!empty($options['form-submit-btn-style'])) ? $options['form-submit-btn-style'] : 'default';
$n_boxed_style = (!empty($options['boxed_layout']) && $options['boxed_layout'] == '1' && $headerFormat != 'left-header') ? true : false;

/*material skin defaults*/
if($theme_skin == 'material') {
	$icon_style = 'minimal';
}
if($theme_skin == 'material' && $headerFormat != 'left-header') {
	$dropdownStyle = 'minimal';
}

?>

<body class="admin-bar ascend bg-teal container customize-support home logged-in nectar-auto-lightbox page" data-footer-reveal="<?php echo $footer_reveal; ?>" data-header-format="<?php echo $headerFormat; ?>" data-boxed-style="<?php echo $n_boxed_style; ?>" data-header-breakpoint="<?php echo $mobile_breakpoint; ?>" data-footer-reveal-shadow="<?php echo $footer_reveal_shadow; ?>" data-dropdown-style="<?php echo $dropdownStyle;?>" data-cae="<?php echo $column_animation_easing; ?>" data-megamenu-width="<?php echo $megamenuwidth; ?>" data-cad="<?php echo $column_animation_duration; ?>" data-aie="<?php echo $animate_in_effect; ?>" data-ls="<?php echo $lightbox_script;?>" data-apte="<?php echo $page_transition_effect;?>" data-hhun="<?php echo $hideHeaderUntilNeeded; ?>" data-fancy-form-rcs="<?php echo $fancy_rcs; ?>" data-form-style="<?php echo $form_style; ?>" data-form-submit="<?php echo $form_submit_style; ?>" data-is="<?php echo $icon_style; ?>" data-button-style="<?php echo $button_styling; ?>" data-header-inherit-rc="<?php echo (!empty($options['header-inherit-row-color']) && $options['header-inherit-row-color'] == '1' && $perm_trans != 1) ? "true" : "false"; ?>" data-header-search="<?php echo $headerSearch; ?>" data-animated-anchors="<?php echo (!empty($options['one-page-scrolling']) && $options['one-page-scrolling'] == '1') ? 'true' : 'false'; ?>" data-ajax-transitions="<?php echo (!empty($options['ajax-page-loading']) && $options['ajax-page-loading'] == '1') ? 'true' : 'false'; ?>" data-full-width-header="<?php echo $fullWidthHeader; ?>" data-slide-out-widget-area="<?php echo ($sideWidgetArea == '1') ? 'true' : 'false';  ?>" data-slide-out-widget-area-style="<?php echo $sideWidgetClass; ?>" data-user-set-ocm="<?php echo $userSetSideWidgetArea; ?>" data-loading-animation="<?php echo (!empty($options['loading-image-animation'])) ? $options['loading-image-animation'] : 'none'; ?>" data-bg-header="<?php echo $bg_header; ?>" data-ext-responsive="<?php echo (!empty($options['responsive']) && $options['responsive'] == 1 && !empty($options['ext_responsive']) && $options['ext_responsive'] == '1') ? 'true' : 'false'; ?>" data-header-resize="<?php echo $headerResize; ?>" data-header-color="<?php echo (!empty($options['header-color'])) ? $options['header-color'] : 'light' ; ?>" <?php echo (!empty($options['transparent-header']) && $options['transparent-header'] == '1') ? null : 'data-transparent-header="false"'; ?> data-cart="<?php echo ($woocommerce && !empty($options['enable-cart']) && $options['enable-cart'] == '1') ? 'true': 'false';?>" data-smooth-scrolling="<?php echo $smooth_scrolling; ?>" data-permanent-transparent="<?php echo $perm_trans; ?>" data-responsive="<?php echo (!empty($options['responsive']) && $options['responsive'] == 1) ? '1'  : '0' ?>" >
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '692583047835855');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=692583047835855&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<div class="main">
<?php if($theme_skin == 'material') { echo '<div class="ocm-effect-wrap"><div class="ocm-effect-wrap-inner">'; } ?>

<?php if($n_boxed_style) { echo '<div id="boxed">'; } ?>

<?php $using_secondary = (!empty($options['header_layout']) && $headerFormat != 'left-header') ? $options['header_layout'] : ' ';

if($using_secondary == 'header_with_secondary') { ?>

	<div id="header-secondary-outer" data-lhe="<?php echo $headerLinkHoverEffect; ?>" data-full-width="<?php echo (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? 'true' : 'false' ; ?>" data-permanent-transparent="<?php echo $perm_trans; ?>" >
		<div class="container">
			<nav>
				<?php if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1') nectar_header_social_icons('secondary-nav'); ?>

				<?php if(has_nav_menu('secondary_nav')) { ?>
					<ul class="sf-menu">
				   	   <?php wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'secondary_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); ?>
				    </ul>
				<?php }

				?>

			</nav>
		</div>
	</div>

<?php }

$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
if($perm_trans != 1 || $perm_trans == 1 && $bg_header == 'false' || $page_full_screen_rows == 'on') { ?>
<!--    <div id="header-space" data-header-mobile-fixed='--><?php //echo $mobile_fixed; ?><!--'></div> -->
<?php } ?>

<?php
	//using pr
	$using_pr_menu = 'false';
	if($headerFormat == 'menu-left-aligned' || $headerFormat == 'centered-menu') {
		if(has_nav_menu('top_nav_pull_right')) {
			$using_pr_menu = 'true';
		}
	}
?>
<div id="header-outer" data-has-menu="<?php echo $has_main_menu; ?>" <?php echo $transparency_markup; ?> data-using-pr-menu="<?php echo $using_pr_menu; ?>" data-mobile-fixed="<?php echo $mobile_fixed; ?>" data-ptnm="<?php echo $prependTopNavMobile;?>" data-lhe="<?php echo $headerLinkHoverEffect; ?>" data-user-set-bg="<?php echo $userSetBG; ?>" data-format="<?php echo $headerFormat; ?>" data-permanent-transparent="<?php echo $perm_trans; ?>" data-megamenu-rt="<?php echo $megamenuRemoveTransparent; ?>" data-remove-fixed="<?php echo $headerRemoveStickiness; ?>" data-cart="<?php echo ($woocommerce && !empty($options['enable-cart']) && $options['enable-cart'] == '1') ? 'true': 'false';?>" data-transparency-option="<?php if($disable_effect == 'on') { echo '0'; } else { echo $using_fw_slider; } ?>" data-box-shadow="<?php echo $header_box_shadow; ?>" data-shrink-num="<?php echo (!empty($options['header-resize-on-scroll-shrink-num'])) ? $options['header-resize-on-scroll-shrink-num'] : 6; ?>" data-full-width="<?php echo $fullWidthHeader; ?>" data-using-secondary="<?php echo ($using_secondary == 'header_with_secondary') ? '1' : '0'; ?>" data-using-logo="<?php if(!empty($options['use-logo'])) echo $options['use-logo']; ?>" data-logo-height="<?php if(!empty($options['logo-height'])) echo $options['logo-height']; ?>" data-m-logo-height="<?php if(!empty($options['mobile-logo-height'])) { echo $options['mobile-logo-height']; } else { echo '24'; } ?>" data-padding="<?php echo (!empty($options['header-padding'])) ? $options['header-padding'] : "28"; ?>" data-header-resize="<?php echo $headerResize; ?>">

	<?php if(empty($options['theme-skin'])) {
		get_template_part('includes/header-search');
	}
	elseif(!empty($options['theme-skin']) && $options['theme-skin'] != 'ascend' && $headerFormat != 'left-header')  {
		 get_template_part('includes/header-search');
	} ?>

	<header class="header_">

		<div class="container">
            <nav class="navbar navbar-expand navbar-light mt-submenu">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#flacsomenu" aria-controls="flacsomenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" id="flacsomenu"></span>
                </button>
                <div class="collapse navbar-collapse">
                    <ul id="menu-top-flacso"class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="http://flacso.org.ar/institucional/" target="_blank"><span> FLACSO</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="http://flacso.org.ar/biblioteca/" target="_blank"><span>Biblioteca</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="http://flacso.org.ar/flacso-virtual/" target="_blank"><span>FLACSO Virtual</span></a></li>
                    </ul>
                </div>
            </nav>


            <div class="row" style="width: 100%;">
                <div class="pl-logo1" style="text-align: center">
                    <img src="<?php echo get_template_directory_uri();?>/img/logo-1.png">
                </div>
                <div class="pt-logo2">
                    <img style="padding-left:15px;" src="<?php echo get_template_directory_uri();?>/img/logo-2.png" >
                </div>
				<div class="pt-logo3">
    				<a class="border nav-link button_contact" href="/contactanos">
					<i class="fa fa-envelope" style="vertical-align: middle;position: static;"></i><span>CONTACTANOS</span></a>
                </div>
            </div>


            <!--/row-->

		</div><!--/container-->

	</header>


	<?php if (!empty($options['enable-cart']) && $options['enable-cart'] == '1' && $theme_skin != 'material') { ?>
		<?php
		if ($woocommerce) {
			echo nectar_header_cart_output();
	 	}
   }


   echo '<div class="ns-loading-cover"></div>';

   ?>


</div><!--/header-outer-->

<?php //slide in cart style
	if (!empty($options['enable-cart']) && $options['enable-cart'] == '1') {

		$nav_cart_style = (!empty($options['ajax-cart-style'])) ? $options['ajax-cart-style'] : 'default';

		if ($woocommerce && $nav_cart_style == 'slide_in') {
			echo '<div class="nectar-slide-in-cart">';
				// Check for WooCommerce 2.0 and display the cart widget
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					the_widget( 'WC_Widget_Cart', 'title= ' );
				} else {
					the_widget( 'WooCommerce_Widget_Cart', 'title= ' );
				}
			echo '</div>';
		}
	}
?>
<!-- MENU -->
<?php 
	echo "<nav class='navbar navbar-expand-lg navbar-dark bg-teal config_menu'>
	<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarsExample08' aria-controls='navbarsExample08' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	</button>

	<div class='collapse navbar-collapse justify-content-md-center' id='navbarsExample08'>";
		if($theme_skin != 'material') {
			echo "<ul class='navbar-nav'>";
				if($has_main_menu == 'true') {
					wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s' ) );
				} else {
					echo '<li class="no-menu-assigned"><a href="#">No menu assigned</a></li>';
				}
				echo "</ul>";
			} //non material skin
	echo "</div></nav>";
?>
<!-- FIN MENU -->
<?php  get_template_part('includes/header-search');
 		if(!empty($options['theme-skin']) && $options['theme-skin'] == 'ascend' || $headerFormat == 'left-header' ) { if($headerSearch != 'false') get_template_part('includes/header-search'); }
?>

<?php if($mobile_fixed != '1') { ?>

	<div id="mobile-menu" data-mobile-fixed="<?php echo $mobile_fixed; ?>">

		<div class="container">
			<ul>
				<?php
					if($has_main_menu == 'true' && $mobile_fixed == 'false') {

					    wp_nav_menu( array('theme_location' => 'top_nav', 'menu' => 'Top Navigation Menu', 'container' => '', 'items_wrap' => '%3$s' ) );

					    if($headerFormat == 'centered-menu' && $using_pr_menu == 'true' || $headerFormat == 'menu-left-aligned' && $using_pr_menu == 'true') {
							wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) );
						}

						echo '<li id="mobile-search">
						<form action="'.home_url().'" method="GET">
				      		<input type="text" name="s" value="" placeholder="'.__('Search..', NECTAR_THEME_NAME) .'" />
						</form>
						</li>';
					}
					else {
						echo '<li><a href="">No menu assigned!</a></li>';
					}
				?>
			</ul>
		</div>

	</div>

<?php } ?>



<div id="ajax-loading-screen" data-disable-fade-on-click="<?php echo (!empty($options['disable-transition-fade-on-click'])) ? $options['disable-transition-fade-on-click'] : '0' ; ?>" data-effect="<?php echo $page_transition_effect; ?>" data-method="<?php echo (!empty($options['transition-method'])) ? $options['transition-method'] : 'ajax' ; ?>">

	<?php if($page_transition_effect == 'horizontal_swipe' || $page_transition_effect == 'horizontal_swipe_basic') { ?>
		<div class="reveal-1"></div>
		<div class="reveal-2"></div>
	<?php } else if($page_transition_effect == 'center_mask_reveal') { ?>
		<span class="mask-top"></span>
		<span class="mask-right"></span>
		<span class="mask-bottom"></span>
		<span class="mask-left"></span>
	<?php } else { ?>
		<div class="loading-icon <?php echo (!empty($options['loading-image-animation']) && !empty($options['loading-image'])) ? $options['loading-image-animation'] : null; ?>">
			<?php
			$loading_icon = (isset($options['loading-icon'])) ? $options['loading-icon'] : 'default';
			$loading_img = (isset($options['loading-image'])) ? nectar_options_img($options['loading-image']) : null;
			if(empty($loading_img)) {
				if($loading_icon == 'material') {
					echo '<div class="material-icon">
							<div class="spinner">
								<div class="right-side"><div class="bar"></div></div>
								<div class="left-side"><div class="bar"></div></div>
							</div>
							<div class="spinner color-2">
								<div class="right-side"><div class="bar"></div></div>
								<div class="left-side"><div class="bar"></div></div>
							</div>
						</div>';
				} else {
					if(!empty($options['theme-skin']) && $options['theme-skin'] == 'ascend') {
						echo '<span class="default-loading-icon spin"></span>';
					} else {
						echo '<span class="default-skin-loading-icon"></span>';
					}
				}
			}
			 ?>
		</div>
	<?php } ?>
</div>

<div id="ajax-content-wrap">

<?php
	if($sideWidgetArea == '1' && $sideWidgetClass == 'fullscreen') echo '<div class="blurred-wrap">';

?>

