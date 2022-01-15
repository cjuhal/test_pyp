<?php
/*template name: Plantilla con slider */
get_header(); ?>

<?php $options = get_nectar_theme_options();  ?>

<?php
$nectar_disable_home_slider = (!empty($options['disable_home_slider_pt']) && $options['disable_home_slider_pt'] == '1') ? true : false;
if($nectar_disable_home_slider != true) { ?>

    <div id="featured" data-caption-animation="<?php echo (!empty($options['slider-caption-animation']) && $options['slider-caption-animation'] == 1) ? '1' : '0'; ?>" data-bg-color="<?php if(!empty($options['slider-bg-color'])) echo $options['slider-bg-color']; ?>" data-slider-height="<?php if(!empty($options['slider-height'])) echo $options['slider-height']; ?>" data-animation-speed="<?php if(!empty($options['slider-animation-speed'])) echo $options['slider-animation-speed']; ?>" data-advance-speed="<?php if(!empty($options['slider-advance-speed'])) echo $options['slider-advance-speed']; ?>" data-autoplay="<?php echo $options['slider-autoplay'];?>">

        <?php
        $slides = new WP_Query( array( 'post_type' => 'home_slider', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) );
        if( $slides->have_posts() ) : ?>

            <?php while( $slides->have_posts() ) : $slides->the_post();

                $alignment = get_post_meta($post->ID, '_nectar_slide_alignment', true);

                $video_embed = get_post_meta($post->ID, '_nectar_video_embed', true);
                $video_m4v = get_post_meta($post->ID, '_nectar_video_m4v', true);
                $video_ogv = get_post_meta($post->ID, '_nectar_video_ogv', true);
                $video_poster = get_post_meta($post->ID, '_nectar_video_poster', true);

                ?>

                <div class="slide orbit-slide <?php if( !empty($video_embed) || !empty($video_m4v)) { echo 'has-video'; } else { echo $alignment; } ?>">

                    <?php $image = get_post_meta($post->ID, '_nectar_slider_image', true); ?>
                    <article data-background-cover="<?php echo (!empty($options['slider-background-cover']) && $options['slider-background-cover'] == 1) ? '1' : '0'; ?>" style="background-image: url('<?php echo $image; ?>')">
                        <div class="container">
                            <div class="col span_12">
                                <div class="post-title">

                                    <?php
                                    $wp_version = floatval(get_bloginfo('version'));

                                    //video embed
                                    if( !empty( $video_embed ) ) {

                                        echo '<div class="video">' . do_shortcode($video_embed) . '</div>';

                                    }
                                    //self hosted video pre 3-6
                                    else if( !empty($video_m4v) && $wp_version < "3.6" || !empty($video_ogv) && $wp_version < "3.6") {

                                        echo '<div class="video">';
                                        //nectar_video($post->ID);
                                        echo '</div>';

                                    }
                                    //self hosted video post 3-6
                                    else if($wp_version >= "3.6"){

                                        if(!empty($video_m4v) || !empty($video_ogv)) {

                                            $video_output = '[video ';

                                            if(!empty($video_m4v)) { $video_output .= 'mp4="'. $video_m4v .'" '; }
                                            if(!empty($video_ogv)) { $video_output .= 'ogv="'. $video_ogv .'"'; }

                                            $video_output .= ' poster="'.$video_poster.'"]';

                                            echo '<div class="video">' . do_shortcode($video_output) . '</div>';
                                        }
                                    }

                                    ?>

                                    <?php
                                    //mobile more info button for video
                                    if( !empty($video_embed) || !empty($video_m4v)) { echo '<div><a href="#" class="more-info"><span class="mi">'.__("More Info",NECTAR_THEME_NAME).'</span><span class="btv">'.__("Back to Video",NECTAR_THEME_NAME).'</span></a></div>'; } ?>

                                    <?php $caption = get_post_meta($post->ID, '_nectar_slider_caption', true); ?>
                                    <h2 data-has-caption="<?php echo (!empty($caption)) ? '1' : '0'; ?>"><span>
				        			<?php echo $caption; ?>
								</span></h2>

                                    <?php
                                    $button = get_post_meta($post->ID, '_nectar_slider_button', true);
                                    $button_url = get_post_meta($post->ID, '_nectar_slider_button_url', true);

                                    if(!empty($button)) { ?>
                                        <a href="<?php echo $button_url; ?>" class="uppercase"><?php echo $button; ?></a>
                                    <?php } ?>


                                </div><!--/post-title-->
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        <?php else: ?>


        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

<?php } ?>
<?php
$options = get_nectar_theme_options();
$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
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
<?php if($headerFormat == 'left-header') echo '<div class="nav-outer">'; ?>
<?php
echo do_shortcode('[smartslider3 slider=2]');

?>


<?php if($headerFormat == 'left-header') echo '</div>'; ?>
<?php do_action('get_breadcrumbs_vlkx');?>
	<div class="container sharedButtonsRight"><?php echo do_shortcode('[Sassy_Social_Share]') ?></div>
<div class="main-content">

    <div class="row">

        <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

            <?php the_content(); ?>

        <?php endwhile; endif; ?>

    </div><!--/row-->

</div><!--/container-->

<?php get_footer(); ?>
