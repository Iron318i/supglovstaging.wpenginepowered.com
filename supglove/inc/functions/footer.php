<?php

/**
 *  Display footer widgets
 */
function supro_footer_widgets() {
	if (
		is_active_sidebar( 'footer-sidebar-1' ) == false &&
		is_active_sidebar( 'footer-sidebar-2' ) == false &&
		is_active_sidebar( 'footer-sidebar-3' ) == false &&
		is_active_sidebar( 'footer-sidebar-4' ) == false &&
		is_active_sidebar( 'footer-sidebar-5' ) == false
	) {
		return;
	}


	if ( ! intval( supro_get_option( 'footer_widgets' ) ) ) {
		return;
	}

	$columns = max( 1, absint( supro_get_option( 'footer_widgets_columns' ) ) );
	$col     = 'offcol-xs-12 offcol-sm-6';

	if ( 5 == $columns ) {
		$col .= ' offcol-md-1-5';
	} else {
		$col .= ' offcol-md-' . 12 / $columns;
	}

	?>
	<div class="footer-widget off-columns-<?php echo esc_attr( $columns ) ?>">
		<div class="container">
			
			 <div class="mobilefootlogo visible-xs visible-sm">
			 		<div class="footer-sidebar footer-1 ">
						<?php
						ob_start();
						dynamic_sidebar( "footer-sidebar-1" );
						$outputx = ob_get_clean();
						echo apply_filters('supro_footer_widget_content',$outputx,1);
						?>
					</div>	
			 </div>
			
			<div class="masonry">
				<?php for ( $i = 1; $i <= $columns; $i ++ ) : ?>

					<div class="footer-sidebar masitem offfooter-<?php echo esc_attr( $i ) ?> <?php echo esc_attr( $col ) ?>  <?php  if($i == 1) echo 'hidden-xs hidden-sm'; ?>  ">
						
						<div class="innermason">
						<?php
						ob_start();
						dynamic_sidebar( "footer-sidebar-$i" );
						$output = ob_get_clean();
						echo apply_filters('supro_footer_widget_content',$output,$i);
						?>
						</div>
						
					</div>

				<?php endfor; ?>

			</div>
		</div>
	</div>
	<?php
}

/**
 *  Display footer copyright
 */
function supro_footer_copyright() {
	if (
		is_active_sidebar( 'footer-copyright-1' ) == false &&
		is_active_sidebar( 'footer-copyright-2' ) == false &&
		is_active_sidebar( 'footer-copyright-3' ) == false
	) {
		return;
	}

	if ( ! intval( supro_get_option( 'footer_copyright' ) ) ) {
		return;
	}

	$columns = max( 1, absint( supro_get_option( 'footer_copyright_columns' ) ) );
	$col     = 'col-md-12';

	if ( 5 == $columns ) {
		$col .= ' col-lg-1-5';
	} else {
		$col .= ' col-lg-' . 12 / $columns;
	}

	$classes = array(
		'footer-copyright',
		'columns-' . $columns,
		'style-' . supro_get_option( 'footer_copyright_menu_style' )
	);

	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ) ?>">
		<div class="container">
			<div class="row footer-copyright-row">
				<?php for ( $i = 1; $i <= $columns; $i ++ ) : ?>

					<div class="footer-sidebar footer-<?php echo esc_attr( $i ) ?> <?php echo esc_attr( $col ) ?>">
						<?php
						ob_start();
						dynamic_sidebar( "footer-copyright-$i" );
						$output = ob_get_clean();
						echo apply_filters('supro_footer_copyright_content',$output,$i);
						?>

					</div>

				<?php endfor; ?>
			</div>
		</div>
	</div>
	<?php
}