<?php 
// Template Name: Page Author
get_header(); ?>
<div class="container">
	<div class="row">	
		<div id="content" class="site-content site-author col-md-9">
			<div class="author-order">
				<form method="GET">
				<div class="orderby">
					<span><?php echo esc_html__('Sắp xếp theo: '); ?></span>
					<?php 
						$filter = array(
							array(
								'label' => __( 'Bài viết nhiều nhất', 'threeus' ),
								'value' => 'post_count'
							),
							array(
								'label' => __( 'Mới gia nhập', 'threeus' ),
								'value' => 'order_new'
							),
							array(
								'label' => __( 'Đánh giá cao nhất', 'threeus' ),
								'value' => 'order_rating'
							)
						);
					?>
					<div class="field-select">
						<select name="orderby">
							<?php 
								foreach ($filter as $key => $option) {
									if( $option['value'] == $_GET['orderby'] ) {
										echo '<option selected value="' .  $option['value']. '">' . $option['label'] . '</option>';
									} else {
										echo '<option value="' .  $option['value']. '">' . $option['label'] . '</option>';
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="order">
					<button type="submit" name="view" value="grid"><i class="fa fa-th" aria-hidden="true"></i></button>
					<button type="submit" name="view" value="list"><i class="fa fa-list" aria-hidden="true"></i></button>
				</div>
				</form>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$( 'select[name="orderby"]' ).on( 'change', function(event) {
						event.preventDefault();
						var newUrl = '<?php echo get_the_permalink(); ?>';
						var orderby = $( this ).val();
						if( orderby ) {
							newUrl = newUrl + '?orderby=' + orderby;
						}
						window.location.href = newUrl;
					});
				});
			</script>
			<div class="site-author-content">
				<?php 
					$number   = 12;
					$paged    = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$offset   = ($paged - 1) * $number;
					if( isset( $_GET['orderby'] ) && $_GET['orderby'] == 'post_count' ) {
						$args = array(
							'offset'  => $offset,
							'number'  => $number,
							'orderby' => 'post_count',
							'order'	  => 'DESC',
						);
					} elseif( isset( $_GET['orderby'] ) && $_GET['orderby'] == 'order_rating' ) {
						$args = array(
							'offset'  => $offset,
							'number'  => $number,
							'meta_key' => 'rating_average',
							'orderby' => 'meta_value_num',
							'order'	  => 'DESC',
						);
					} elseif( isset( $_GET['orderby'] ) && $_GET['orderby'] == 'order_new' ) {
						$args = array(
							'offset'  => $offset,
							'number'  => $number,
							'orderby' => 'user_registered',
							'order'	  => 'DESC',
						);
					} else {
						$args = array(
							'offset'  => $offset,
							'number'  => $number,
							'orderby' => 'post_count',
							'order'	  => 'DESC',
						);
					}
					$authors = get_users( $args );
					// var_dump( $authors );
					
					// $point = get_field('user_point','user_' . $author->ID);
					// var_dump( $author );
					// if ($point > 0) {
					
					$users_args = array(
						'orderby' => 'post_count',
						'order'	  => 'DESC',
						'role__in'	  => array( 'author', 'administrator' )
					);
					$users       = get_users($users_args);
					$total_users = count($users);
					$total_query = count($authors);
					$total_pages = intval($total_users / $number);
				?>
						
						<?php if( isset( $_GET['view'] ) && $_GET['view'] == 'list' ) : ?>
						<table class="member-list table table-bordered table-customize table-responsive">
							<thead>
								<tr>
									<th><?php echo esc_html__( 'Tác giả', 'threeus' ); ?></th>
									<th><?php echo esc_html__( 'Nghề nghiệp', 'threeus' ); ?></th>
									<th><?php echo esc_html__( 'Số bài viết', 'threeus' ); ?></th>
									<th><?php echo esc_html__( 'Đánh giá', 'threeus' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($authors as $author) { ?>
									<?php if( count_user_posts( $author->ID ) > 0 ) : ?>
										<tr>
											<td data-title="<?php echo esc_html__( 'Tác giả', 'threeus' ); ?>">
												<a href="<?php echo get_author_posts_url( $author->ID ) ; ?>">
													<?php echo threeus_get_avatar( $author->ID , 40 ); ?>
													<span><?php the_author_meta('display_name', $author->ID); ?></span>
												</a>
											</td>
											<td data-title="<?php echo esc_html__( 'Nghề nghiệp', 'threeus' ); ?>">
												<?php echo get_field('user_job','user_'. $author->ID); ?>
											</td>
											<td data-title="<?php echo esc_html__( 'Số bài viết', 'threeus' ); ?>">
												<?php echo count_user_posts($author->ID) . ' bài'; ?>
											</td>
											<td data-title="<?php echo esc_html__( 'Đánh giá', 'threeus' ); ?>">
												<?php
													$args = array(
						                                'author'        =>  $author->ID,
						                                'posts_per_page' => -1
						                            );
						                            $loop = new WP_Query( $args );
						                            $posts_id = [];
						                            while ( $loop->have_posts() ) : $loop->the_post();
						                            	array_push($posts_id,get_the_ID());
													endwhile; wp_reset_query();
													$count_posts = wp_count_posts();
													$published_posts = $count_posts->publish;
													$sum = 0;
													$i = 0;
													$kk = kk_star_ratings_get(intval($published_posts));
					                            	foreach($kk as $post){
					                            		if (in_array( $post->ID, $posts_id )) {
					                            			$sum = $sum + $post->ratings;
					                            			$i++;
					                            		}
					                            	}
					                            	if ($i == 0) {
					                            		echo '<span class="rating">Chưa có đánh giá</span>';
					                            		update_field( 'rating_average', 0 , 'user_' . $author->ID );
					                            	} else{
					                            		$rating = number_format((floatval($sum) / (int)$i), 1);
					                            		update_field( 'rating_average', $rating , 'user_' . $author->ID );
					                            		$rating_per = ( $rating / 5 ) * 100;
					                            		?>
															<span class="rating">
																<span class="rating_star"><span style="width: <?php echo $rating_per; ?>%"></span></span>
															</span>
					                            		<?php
					                            	}
												?>
											</td>
										</tr>
									<?php endif; ?>
								<?php } ?>
							</tbody>
						</table>
						<?php
							if ($total_users > $total_query) {
							echo '<div class="page-navigation clearfix" role="navigation">';
							echo '<nav class="page-nav">';
								$current_page = max(1, get_query_var('paged'));
								$big = 999999999;
								echo paginate_links(array(
								    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								    'format' => 'page/%#%/',
								    'current' => $current_page,
								    'total' => $total_pages,
								    'type'      => 'plain',
					                'prev_text' => '<i class="fa fa-angle-left"></i>',
					                'next_text' => '<i class="fa fa-angle-right"></i>'
								    ));
							echo '</nav>';
							echo '</div>';
							}
						?>
						<?php else : ?>
						<div class="row">
							<?php foreach($authors as $author) { ?>
								<?php if( count_user_posts( $author->ID ) > 0 ) : ?>
									<div class="col-lg-3 col-md-4 col-sm-12 col-12">
										<div class="member-item">
											<div class="member-avatar">
												<a class="hover" href="<?php echo get_author_posts_url( $author->ID ) ; ?>">
													<?php echo threeus_get_avatar( $author->ID , 195 ); ?>
												</a>
											</div><!-- member-thumb -->
											<div class="member-info">
												<h3 class="member-name"><a href="<?php echo get_author_posts_url( $author->ID ) ; ?>"><?php the_author_meta('display_name', $author->ID); ?></a></h3>
												<span class="member-job"><?php echo get_field('user_job','user_'. $author->ID); ?></span>
												<div class="member-bot">
													<div class="member-rating">
														<?php
															$args = array(
								                                'author'        =>  $author->ID,
								                                'posts_per_page' => -1
								                            );
								                            $loop = new WP_Query( $args );
								                            $posts_id = [];
								                            while ( $loop->have_posts() ) : $loop->the_post();
								                            	array_push($posts_id,get_the_ID());
															endwhile; wp_reset_query();
															$count_posts = wp_count_posts();
															$published_posts = $count_posts->publish;
															$sum = 0;
															$i = 0;
															$kk = kk_star_ratings_get(intval($published_posts));
							                            	foreach($kk as $post){
							                            		if (in_array( $post->ID, $posts_id )) {
							                            			$sum = $sum + $post->ratings;
							                            			$i++;
							                            		}
							                            	}
							                            	if ($i == 0) {
							                            		echo '<span class="rating">Chưa có đánh giá</span>';
							                            		update_field( 'rating_average', 0 , 'user_' . $author->ID );
							                            	} else{
							                            		$rating = number_format((floatval($sum) / (int)$i), 1);
							                            		update_field( 'rating_average', $rating , 'user_' . $author->ID );
							                            		$rating_per = ( $rating / 5 ) * 100;
							                            		?>
																	<span class="rating">
																		<?php esc_html_e( 'Đánh giá', 'threeus' ); ?>
																		<span class="rating_star"><span style="width: <?php echo $rating_per; ?>%"></span></span>
																	</span>
							                            		<?php
							                            	}
														?>

													</div>
													<div class="member-count"><span><?php echo esc_html__('Số bài viết: ') ?></span><?php echo count_user_posts($author->ID); ?></div>
												</div>


											</div><!-- .member-info -->
										</div><!-- .member-item -->
									</div>
								<?php endif; ?>
							<?php } ?>
						</div>
						<?php
							if ($total_users > $total_query) {
							echo '<div class="page-navigation clearfix" role="navigation">';
							echo '<nav class="page-nav">';
								$current_page = max(1, get_query_var('paged'));
								echo paginate_links(array(
								    'base' => get_pagenum_link(1) . '%_%',
								    'format' => 'page/%#%/',
								    'current' => $current_page,
								    'total' => $total_pages,
								    'type'      => 'plain',
					                'prev_text' => '<i class="fa fa-angle-left"></i>',
					                'next_text' => '<i class="fa fa-angle-right"></i>'
								    ));
							echo '</nav>';
							echo '</div>';
							}	
						?>
						<?php endif; ?>
					<?php // }; ?>
				</div>
		</div><!-- .site-content -->

		<?php get_sidebar_primary(); ?>
	</div>
	
</div><!-- .container -->

<!-- <div class="content-bottom">
	<div class="container">
		 get_sidebar_secondary(); ?>
	</div>
</div> -->

<?php get_footer(); ?>
