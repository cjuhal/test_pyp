<?php

$options = get_nectar_theme_options();
global $post;
$using_footer_widget_area = (!empty($options['enable-main-footer-area']) && $options['enable-main-footer-area'] == 1) ? 'true' : 'false';
$footerColumns = (!empty($options['footer_columns'])) ? $options['footer_columns'] : '4';

?>

<div>


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
					<div class="col-lg-4 col-sm-4"></div>
				<?php } ?>

			</div><!--/container-->

		</div><!--/row-->

		<?php } //endif for enable main footer copyright ?>

</div><!--/footer-outer-->

</div> <!--/ajax-content-wrap-->

</div><!-- FIN MAIN -->
</body>
</html>
