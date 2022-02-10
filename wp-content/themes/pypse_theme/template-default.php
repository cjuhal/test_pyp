<?php
/*No se encuentra en uso, directamente se usa la predeterminada*/
get_header();
nectar_page_header($post->ID);

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

    <div class="container-wrap" style="min-height: 300px;">

    <?php do_action('get_breadcrumbs_vlkx'); ?>
        
	<div class="sharedButtonsRight"><?php echo do_shortcode('[Sassy_Social_Share]') ?></div>
        <div class="main-content">

            <div class="row">

                <?php

                //breadcrumbs
                if ( function_exists( 'yoast_breadcrumb' ) && !is_home() && !is_front_page() ){ yoast_breadcrumb('<p id="breadcrumbs">','</p>'); }

                //buddypress
                global $bp;
                if($bp && !bp_is_blog_page()) echo '<h1>' . get_the_title() . '</h1>';

                //fullscreen rows
                if($page_full_screen_rows == 'on') echo '<div id="nectar_fullscreen_rows" data-animation="'.$page_full_screen_rows_animation.'" data-row-bg-animation="'.$page_full_screen_rows_bg_img_animation.'" data-animation-speed="'.$page_full_screen_rows_animation_speed.'" data-content-overflow="'.$page_full_screen_rows_content_overflow.'" data-mobile-disable="'.$page_full_screen_rows_mobile_disable.'" data-dot-navigation="'.$page_full_screen_rows_dot_navigation.'" data-footer="'.$page_full_screen_rows_footer.'" data-anchors="'.$page_full_screen_rows_anchors.'">';

                if(have_posts()) : while(have_posts()) : the_post();

                    the_content();

                endwhile; endif;

                if($page_full_screen_rows == 'on') echo '</div>'; ?>

            </div><!--/row-->

        </div><!--/container-->

    </div><!--/container-wrap-->

<?php get_footer(); ?>