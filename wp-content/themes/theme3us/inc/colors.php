<?php 
function color_schemes_output() {
	// Get color schemes option
	$main_color = get_field( 'acf_main_color', 'option' );
?>
	<style type="text/css">

	<?php if ( $main_color ) : ?>
		body{
			background-color:<?php echo $body_bg; ?>;
		}
	<?php endif; ?>

	</style>
	
<?php
}
add_action( 'wp_head', 'color_schemes_output', 100001 );
?>