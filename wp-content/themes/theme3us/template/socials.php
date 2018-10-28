<?php
	$socials = get_field( 'acf_social', 'option' );
	if( $socials ) {
		echo '<nav class="socials"><ul>';

		foreach ($socials as $key => $social) {
			echo '<li class="'. $social['name'] .'">';
				echo '<a target="_blank" href="' . $social['link'] . '">';
					echo '<i class="fa fa-' . $social['icon'] . '"></i>';
				echo '</a>';
			echo '</li>';
		}

		echo '</ul></nav>';
	}
?>