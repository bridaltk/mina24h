<?php 
get_header(); ?>
<?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>
<?php $avatar_id = get_field( 'avatar', 'user_' . $curauth->ID );
	if( $avatar_id ) {
		$avatar_url = wp_get_attachment_image_src( $avatar_id, 'full' );
		$avatar_url = $avatar_url[0];
	} else {
		$avatar_url = get_avatar_url(  $curauth->ID, array('size' => 1000) );
	};
?>
<div class="banner-author">
	<div class="banner-author-bg" style="background-image: url( <?php echo $avatar_url; ?> );"></div>
	<div class="author-avatar">
		<?php echo threeus_get_avatar(  $curauth->ID , 170 ); ?>
		<h1 class="member-name"><?php echo $curauth->display_name; ?></h1>
		<?php if( get_field('user_job','user_'. $curauth->ID) ) : ?>
			<span class="member-job"><?php echo get_field('user_job','user_'. $curauth->ID); ?></span>
		<?php endif; ?>
	</div>
</div>
<div class="author-grid">
	<div class="container">
		<?php if( get_field('user_about','user_' . $curauth->ID) ) : ?>
		<div class="author-paragraph">
			<?php echo get_field('user_about','user_' . $curauth->ID); ?>
		</div>
		<?php endif; ?>
		<div class="author-box">
			<div class="row">
				<?php
					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
					$args = array(
                        'author'        =>  $curauth->ID,
                        'posts_per_page' => 12,
                        'paged'          => $paged,
                    );
                    $loop = new WP_Query( $args );
                    while ( $loop->have_posts() ) : $loop->the_post();
                ?>
               	<div class="col-lg-4 col-sm-6">
               		<?php get_template_part( 'content', 'blog-top' ); ?>
               	</div>
                <?php
					endwhile; wp_reset_query();
				?>
			</div>
		</div>
		<div class="page-navigation clearfix" role="navigation">
		    <nav class="page-nav">
		        <?php
		            $big = 999999999; // need an unlikely integer

		            echo paginate_links( array(
		                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		                'format' => '?paged=%#%',
		                'current' => max( 1, get_query_var('paged') ),
		                'total' => $loop->max_num_pages,
		                'type'      => 'plain',
		                'prev_text' => '<i class="fa fa-angle-left"></i>',
		                'next_text' => '<i class="fa fa-angle-right"></i>'
		            ) );
		        ?>
		    </nav>
		</div>
	</div>
</div>

<?php get_footer(); ?>
