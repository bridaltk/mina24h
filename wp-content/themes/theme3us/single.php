<?php get_header(); ?>
	
	<div class="container">
		<div class="row">
			<div id="content" class="site-content <?php echo main_bootstrap_class(); ?>">
				<?php if( get_field('acf_gg_adword','option') ) : ?>
					<div class="banner-ads-bw">
						<?php echo get_field('acf_gg_adword','option'); ?>
					</div>
				<?php endif; ?>

				<?php include_once get_template_directory() . '/inc/structure/breadcrumbs.php'; ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<?php echo wpb_set_post_views(get_the_ID()); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
		
					<div class="post-info">
						<h1 class="post-title title entry-title" itemprop="name headline"><?php the_title(); ?></h1>

						<?php echo threeus_post_meta(); ?>

						<div class="content-wrapper">
							<?php 
								$post_id = $post->ID;
								$title = get_the_title( $post_id );
								$link = get_permalink( $post_id );
								$min_count = 0; // how much number to show if there are no tweets to the post yet
								$count = ( $count = get_post_meta( $post_id, 'post_tweets', true ) ) ? $count : $min_count;

							?>
							<div class="content-main clearfix">
								<div class="content-left">
									<ul class="sharing">
										<li>
											<a class="fl chiasefb" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>" rel="nofollow"><i class="fa fa-facebook"></i></a>
											<span><?php echo threeus_get_shares( get_the_permalink() ); ?></span>
										</li>
										<li>
											<a rel="nofollow" title="Twitter" href="https://twitter.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
											<span><?php echo $count; ?></span>
										</li>
										<li>
											<a rel="nofollow" title="Googleplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>
											<span><?php echo getGplusShares( get_the_permalink() ); ?></span>
										</li>
										<li class="comment-count">
											<a rel="nofollow" href="#comment-form-area"><i class="fa fa-commenting"></i></a>
											<span><?php echo get_comments_number( $post->ID ); ?></span>
										</li>
										<li class="like-fb">
											<?php echo do_shortcode( '[wp_ulike]' ); ?>
										</li>
									</ul><!-- .sharing -->
								</div><!-- .content-left -->
								
								<div class="content-right">
									<div class="post-excerpt">
										<?php 
								        	$term = get_the_category();
											if( $term ) {
												echo '<a style="background-color: ' . get_field( 'background_color', 'category_' . $term[0]->term_id ) . '" class="single-post-cat post-cat" href="' . get_term_link( $term[0] ) . '">' . $term[0]->cat_name . '</a>';
											}
								        ?>
										<?php the_excerpt(); ?>
									</div>
									<?php 
									$post_objects = get_field('post_related');
									if ($post_objects): ?>
										<ul class="related-post">
										 	<?php foreach( $post_objects as $post): ?>
       	 									<?php setup_postdata($post); ?>
											<li>
									        	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
									        </li>
									        <?php endforeach; ?>
										</ul>
									<?php wp_reset_postdata(); endif; ?>

									<?php $post_thumb = get_field( 'acf_post_thumb', 'option' ); ?>
									<?php if( has_post_thumbnail() && !$post_thumb ) : ?>
										<div class="post-thumbnail">
											<?php the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); ?>
										</div>	
									<?php endif; ?>

									<div class="entry-content" itemprop="articleBody">
										<?php the_content(); ?>
									</div>
									
									<?php if(function_exists("kk_star_ratings")) : ?>
										<div class="review">
											<?php echo kk_star_ratings(); ?>
											<?php  
												if( get_field( 'acf_rating_note', 'option' ) ) :
													echo '<div class="rating-note">' . get_field( 'acf_rating_note', 'option' ) . '</div>';
												endif;
											?>
										</div>
									<?php endif; ?>
								</div><!-- .content-right -->
							</div>
							
							<?php if( get_the_tags() || get_the_category() ) : ?>
								<div class="post-meta meta-bottom clearfix">
									<?php if( get_the_category() ) : ?>
										<div class="post-category">
											<i class="fa fa-folder-open-o" aria-hidden="true"></i><?php the_category();?>
										</div>
									<?php endif; ?>
									<?php if( get_the_tags() ) : ?>
										<div class="post-tags">
											<i class="fa fa-tags" aria-hidden="true"></i><?php the_tags() ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<div id="comment-form-area" class="comment-form-area">
								<?php $post = $wp_query->post; comments_template(); ?>
							</div><!-- .comment-form-area -->

							<section class="related-section"> 
								<h2 class="title"><?php esc_html_e( 'Tin cùng chuyên mục', 'threeus' ); ?></h2>
								<div class="row">
									<?php
									$post = $wp_query->post;
										$related = get_posts( 
											array( 
												'category__in' => wp_get_post_categories($post->ID),
											 	'numberposts' => 6, 
											 	'post__not_in' => array($post->ID) 
											 ) );
										if( $related ) foreach( $related as $post ) {
										setup_postdata($post); ?>
									        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
									        	<?php echo get_template_part( 'content', 'cat-same' ); ?>
									        </div>
										<?php }
										wp_reset_postdata(); ?>
								</div>
							</section> 
						</div>
					</div><!-- .post-info -->
				</article><!-- #post -->
					
				<?php endwhile; ?>
				
			</div><!-- #content -->

			<?php get_sidebar_primary(); ?>

		</div>

	</div><!-- .container -->
	<div class="content-bottom">
		<div class="container">
			<?php get_sidebar_secondary(); ?>
		</div>
	</div>

<?php get_footer(); ?>