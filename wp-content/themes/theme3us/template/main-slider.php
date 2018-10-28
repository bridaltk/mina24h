<?php
	$style = get_field( 'acf_style', 'option' );
	if( !$style ) {
		$style = 'container';
	}
	$main_slider = get_field( 'acf_slider', 'option' );
	if( $main_slider ) :

		$navigation = get_field( 'acf_navigation', 'option' );
		$pagination = get_field( 'acf_pagination', 'option' );
		$pause = get_field( 'acf_pause', 'option' );
		$speed = get_field( 'acf_speed', 'option' );
		$play = get_field( 'acf_play', 'option' );
		if( $navigation != false ) {
			$nav = 'false';
		} else {
			$nav = 'true';
		}

		if( $pagination ) {
			$pagi = 'false';
		} else {
			$pagi = 'true';
		}

		if( $play ) {
			$autoplay = 'false';
		} else {
			$autoplay = 'true';
		}

		if( !$pause ) {
			$pause = 5000;
		}

		if( !$speed ) {
			$speed = 700;
		}
?>
<div class="main-slider" data-nav="<?php echo $nav; ?>" data-pagi="<?php echo $pagi; ?>" data-autoplay="<?php echo $autoplay; ?>" data-speed="<?php echo $speed; ?>">
	<div class="<?php echo $style; ?>">
		<div class="sliders">
			<div class="owl-carousel">
				<?php foreach ($main_slider as $key => $slider) { 
					$img = $slider['image']['ID'];
					$image = wp_get_attachment_image( $img, 'main_slider' );
					$link = $slider['link'];
					$content = $slider['content'];
				?>
				<div class="item">
					<?php 
						if( $image && $link ) {
							echo '<a href="' . $link . '">' . $image . '</a>';
						} elseif ( $image ) {
							echo $image;
						}

						if( $content ) {
							echo '<div class="slider-content">' . $content . '</div>';
						}
					?>
				</div>
				<?php }; ?>
			</div><!-- .owl-carousel -->
		</div><!-- .sliders -->
	</div><!-- .container -->
</div><!-- .main-slider -->

<?php 
	
?>
<?php endif; ?>