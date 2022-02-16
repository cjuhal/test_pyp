<?php get_header(); ?>
<?php nectar_page_header($post->ID);

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

$options = get_nectar_theme_options();
$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
$theme_skin = (!empty($options['theme-skin'])) ? $options['theme-skin'] : 'original';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';
$animate_in_effect = (!empty($options['header-animate-in-effect'])) ? $options['header-animate-in-effect'] : 'none';
if ($headerColorScheme == 'dark') {
    $userSetBG = '#1f1f1f';
}
$userSetSideWidgetArea = $sideWidgetArea;
if ($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';

?>

<?php do_action('get_breadcrumbs_vlkx'); ?>

<div class="container-wrap">

    <div class="main-content">
        

        <div class="row">

            <div class="col span_12">

                <div id="error-404">
                    <h1>404</h1>
                    <h2>No encontrado</h2>
                </div>

            </div>
            <!--/span_12-->

        </div>
        <!--/row-->

    </div>
    <!--/container-->

</div>
<?php get_footer(); ?>