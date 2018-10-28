<?php 
	$page_layout = get_field( 'acf_page_layout', 'option' );

	switch ( $page_layout ) {
		case 'main':
			$sidebars[] = '';
			break;

		case 'left-main':
			$sidebars[] = get_sidebar_secondary();
			break;

		case 'main-right':
			$sidebars[] = get_sidebar_primary();
			break;

		case 'left-main-right':
			$sidebars[] = get_sidebar_primary();
			$sidebars[] = get_sidebar_secondary();
			break;

		default:
			$sidebars[] = get_sidebar_primary();
			break;
	}

	return $sidebars;
?>
