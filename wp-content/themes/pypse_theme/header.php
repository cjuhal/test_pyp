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

<style>
html {
    margin-top: 0px !important;
}
</style>

</head>

<?php
 global $post;
$using_page_header = using_page_header($post->ID);
$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';
$sideWidgetClass = (!empty($options['header-slide-out-widget-area-style'])) ? $options['header-slide-out-widget-area-style'] : 'slide-out-from-right';
$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
$sideWidgetArea = (!empty($options['header-slide-out-widget-area']) && $headerFormat != 'left-header' ) ? $options['header-slide-out-widget-area'] : 'off';
$dropdownStyle = (!empty($options['header-dropdown-style']) && $perm_trans != '1' && $headerFormat != 'left-header' ) ? $options['header-dropdown-style'] : 'classic';
$page_transition_effect = (!empty($options['transition-effect'])) ? $options['transition-effect'] : 'standard';
$icon_style = (!empty($options['theme-icon-style'])) ? $options['theme-icon-style'] : 'inherit';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';
if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';
$userSetSideWidgetArea = $sideWidgetArea;
if($headerFormat == 'centered-menu-under-logo') {
	if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') {
		$sideWidgetClass = 'slide-out-from-right';
	}
	$fullWidthHeader = 'false';
}
if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') $fullWidthHeader = 'true';

/*material skin defaults*/
if($theme_skin == 'material') {
	$icon_style = 'minimal';
}
if($theme_skin == 'material' && $headerFormat != 'left-header') {
	$dropdownStyle = 'minimal';
}

?>

<body class="admin-bar ascend bg-teal container customize-support home logged-in nectar-auto-lightbox page">
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
<!-- MAIN (termina en footer.php) -->
<div class="main">


<!-- HEADER -->
<div id="header-outer" >
	<header class="header_">
		<div class="container">



            <div class="row" style="width: 100%;">
                
				<div class="pl-logo1" style="text-align: center">
                    <img src="<?php echo get_template_directory_uri();?>/img/logo-1.png">
                </div>

                <div class="pt-logo2 ">
					<div class="flex_vlkx">
				<img class="logo2" src="<?php echo get_template_directory_uri();?>/img/logo-2.png" >

				<!-- 2 MENU -->
				<nav class="navbar navbar-expand navbar-light mt-submenu">
				<button class="bg-white hidden_desktop toggle_vlkx" type="button" data-toggle="collapse" data-target="#menu_mobile" aria-controls="menu_mobile" aria-expanded="false">
    					<span class="navbar-toggler-icon"></span>
  					</button>
					<div class="collapse navbar-collapse" style="justify-content: flex-end">
						<div class="navbar-nav lr-auto">
							<a class="border nav-link button_contact" href="/contactanos">
							<i class="fa fa-envelope" style="vertical-align: middle;position: static;"></i><span class="hidden_mobile">CONTACTANOS</span></a>
						</div>
							<ul id="menu-top-flacso"class="navbar-nav mr-auto">
								<li class="nav-item"><a class="nav-link" href="http://flacso.org.ar/institucional/" target="_blank"><span> FLACSO</span></a></li>
								<li class="nav-item"><a class="nav-link" href="http://flacso.org.ar/biblioteca/" target="_blank"><span>Biblioteca</span></a></li>
								<li class="nav-item"><a class="nav-link" href="http://flacso.org.ar/flacso-virtual/" target="_blank"><span>FLACSO Virtual</span></a></li>
							</ul>
					</div>
				</nav>
				<!-- FIN 2 MENU -->

				<!-- MENU MOBILE -->
				<nav class="navbar navbar-expand-lg navbar-light hidden_desktop">
						<div class='collapse navbar-collapse justify-content-md-center' id='menu_mobile'>
							<?php do_shortcode('[HTML_CUSTOM_MENU]');?>
						</div>
  					</nav>
				<!-- FIN MENU MOBILE -->
			</div>
					
					<!-- MENU DESKTOP -->
					<nav class="navbar navbar-expand-lg navbar-light hidden_mobile">
						<div class='collapse navbar-collapse justify-content-md-center' id='menu_mobile'>
							<?php do_shortcode('[HTML_CUSTOM_MENU]');?>
						</div>
  					</nav>
					<!-- FIN MENU DESKTOP -->
                </div>
            </div>
            <!--/row-->
		</div><!--/container-->
	</header>
</div><!--/header-outer-->
<!-- FIN HEADER -->




<!-- SPINNER -->

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
<!-- FIN SPINNER -->

<div id="ajax-content-wrap" class="bg-content">

<?php
	if($sideWidgetArea == '1' && $sideWidgetClass == 'fullscreen') echo '<div class="blurred-wrap">';

?>

