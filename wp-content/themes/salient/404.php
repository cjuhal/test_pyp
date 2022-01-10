<?php get_header(); ?>
<?php nectar_page_header($post->ID);

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

$options = get_nectar_theme_options();
$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';
$animate_in_effect = (!empty($options['header-animate-in-effect'])) ? $options['header-animate-in-effect'] : 'none';
if($headerColorScheme == 'dark') { $userSetBG = '#1f1f1f'; }
$userSetSideWidgetArea = $sideWidgetArea;
if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';

?>
 
<div class="container-wrap">
       <nav class="navbar navbar-expand-lg navbar-dark bg-teal config_menu">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">

                <?php if($theme_skin != 'material') { ?>
                    <ul class="navbar-nav">
                        <?php
                        if($has_main_menu == 'true') {
                            wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s' ) );
                        } else {
                            echo '<li class="no-menu-assigned"><a href="#">No menu assigned</a></li>';
                        }
                        ?>
                    </ul>
                <?php } //non material skin ?>
            </div>
        </nav>

	
	<div class="container main-content">
		
		<div class="row">
			
			<div class="col span_12">
				
				<div id="error-404">
					<h1>404</h1>
					<h2><?php echo __('Not Found', NECTAR_THEME_NAME); ?></h2>
				</div>
				
			</div><!--/span_12-->
			
		</div><!--/row-->
		
	</div><!--/container-->

</div>
<?php get_footer(); ?>

