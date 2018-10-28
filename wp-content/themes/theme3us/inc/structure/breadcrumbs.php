<?php

$home      = __( 'Trang chủ', 'threeus' ); // text for the 'Home' link
$blog      = __( 'Tin mới nhất', 'threeus' ); // text for the 'Home' link
$shop      = __( 'Sản phẩm', 'threeus' ); // text for the 'Home' link
$before    = '<li class="current">'; // tag before the current crumb
$after     = '</li>'; // tag after the current crumb

global $post;

if ( is_front_page() ) {

	// echo '<ul class="breadcrumbs"><li><a href="' . esc_url( home_url() ) . '">' . $home . '</a></li></ul>';

} elseif ( is_home() ) {

	echo '<ul class="breadcrumbs">
	<li><a href="' . esc_url( home_url() ) . '">' . $home . '</a></li>
	</ul>';

} else {

	echo '<ul class="breadcrumbs"><li><a href="' . esc_url( home_url() ) . '">' . $home . '</a></li>';

	if ( is_category() ) {
		$thisCat = get_category( get_query_var( 'cat' ), false );
		if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' ' );
		echo $before . single_cat_title( '', false ) . $after;

	} elseif ( class_exists( 'Woocommerce' ) && is_product_category() ) {
		$category = get_queried_object();
		$taxonomy = 'product_cat';
		$parent_id = $category->parent;
		if( $parent_id ) {
			$parent = get_term( $parent_id, $taxonomy );
			$parent_name = $parent->name;
			$parent_link = get_term_link( $parent, $taxonomy );
			echo '<li><a href="' . $parent_link . '">' . $parent_name . '</a></li>';
		};
		echo $before . single_term_title("", false) . $after;

	} elseif ( is_search() ) {
		echo $before . 'Kết quả tìm kiếm với từ khóa "' . get_search_query() . '"' . $after;

	} elseif ( is_day() ) {
		echo '<li><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
		echo '<li><a href="' . esc_url( get_month_link( get_the_time( 'Y' ) ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';
		echo $before . get_the_time( 'd' ) . $after;

	} elseif ( is_month() ) {
		echo '<li><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
		echo $before . get_the_time( 'F' ) . $after;

	} elseif ( is_year() ) {
		echo $before . get_the_time( 'Y' ) . $after;

	} elseif ( class_exists( 'Woocommerce' ) && is_singular( 'product' ) ) {
		$taxonomy = 'product_cat';
		$terms = wp_get_post_terms( $post->ID, $taxonomy );
		$parent_id = '';
		foreach ($terms as $key => $term) {
			$parent_id = $term->term_id;
		}		
		if( $parent_id ) {
			$parent = get_term( $parent_id, $taxonomy );
			if( $parent->parent ) {
				$parents_id = $parent->parent;
				$parents = get_term( $parents_id, $taxonomy );
				$parents_name = $parents->name;
				$parents_link = get_term_link( $parents, $taxonomy );
				echo '<li><a href="' . $parents_link . '">' . $parents_name . '</a></li>';
			}
			$parent_name = $parent->name;
			$parent_link = get_term_link( $parent, $taxonomy );
			echo '<li><a href="' . $parent_link . '">' . $parent_name . '</a></li>';
		};
		echo $before . get_the_title() . $after;

	} elseif ( is_single() && ! is_attachment() ) {
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object( get_post_type() );
			$slug = $post_type->rewrite;
			echo '<li><a href="' . esc_url( home_url() ) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
			echo ' ' . $before . get_the_title() . $after;
		} else {
			$cat = get_the_category(); $cat = $cat[0];
			$cats = get_category_parents( $cat, TRUE, ' ' );
			$cats = '<li>' . preg_replace( "#^(.+)\s\s$#", "$1", $cats ) . '</li>';
			echo $cats;
			echo ' ' . $before . get_the_title() . $after;
		}

	} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
		$post_type = get_post_type_object( get_post_type() );
		echo $before . $post_type->labels->singular_name . $after;

	} elseif ( is_attachment() ) {
		$parent = get_post( $post->post_parent );
		$cat = get_the_category( $parent->ID ); $cat = $cat[0];
		echo get_category_parents( $cat, TRUE, ' ' );
		echo '<li><a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
		echo ' ' . $before . get_the_title() . $after;

	} elseif ( is_page() && ! $post->post_parent ) {
		echo $before . get_the_title() . $after;

	} elseif ( is_page() && $post->post_parent ) {
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ( $parent_id ) {
			$page = get_page( $parent_id );
			$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a></li>';
			$parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse( $breadcrumbs );
		for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
			echo $breadcrumbs[$i];
			if ( $i != count( $breadcrumbs )-1 ) echo ' ';
		}
		echo ' ' . $before . get_the_title() . $after;

	} elseif ( is_tag() ) {
		echo $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;

	} elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata( $author );
		echo $before . 'Articles posted by ' . $userdata->display_name . $after;

	} elseif ( is_404() ) {
		echo $before . 'Error 404' . $after;
	}

	if ( get_query_var( 'paged' ) ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		echo $before . __( 'Page', 'threeus' ) . ' ' . get_query_var( 'paged' ) . $after;
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	}

	echo '</ul>';

}
