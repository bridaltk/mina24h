<?php get_header(); ?>

    <div class="container">

        <div class="row">
            <?php 
				$obj = get_queried_object();
				$cat_id = $obj->term_id;
			 ?>
                <div id="content" class="site-content <?php echo main_bootstrap_class(); ?>">
                    <h1 class="title"><?php single_cat_title(); ?></h1>

                    <?php if ( have_posts() ) :  ?>
                        <div class="top-blogs">
                            <div class="row">
                                <?php
			                    $i = 0;
			                    while ( have_posts() ) : the_post();
				                    $i++;
				                    if( $i == 1 ) {
				                    	echo get_template_part( 'content', 'blog-top' );

				                    } elseif( ($i > 1) && ($i <= 5) ) {
				                    	echo get_template_part( 'content', 'top-list' );
				                    };
			                	endwhile; 
			                ?>
                            </div>
                        </div>
                        <!-- .top-blogs -->

                        <?php if( get_field('acf_gg_adword','option') ) : ?>
                            <div class="banner-ads-bw">
                                <?php echo get_field('acf_gg_adword','option'); ?>
                            </div>
                            <?php endif; ?>

                                <div class="list-posts">
                                    <?php
            			                $e=0;
            		                    while ( have_posts() ) : the_post();
            			                    $e++;
            			                    if ($e > 5) {
            									get_template_part( 'content', get_post_format() );
            								}
            							endwhile;
            						?>
                                </div>
                                <!-- .list-posts -->
                                <?php threeus_pagination(); ?>
                                    <?php else : ?>
                                        <?php echo get_template_part( 'content', 'none' ); ?>
                                            <?php endif; ?>
                                                <?php 
                                	            	$cat_currents = get_queried_object();
                                					$cat_current =  $cat_currents->term_id;
                                	            	$categories = get_categories();
                                					shuffle( $categories );
                                					$cat_array = array_slice( $categories, 0, 2 );
                                					if ( ($cat_array[0]->term_id == $cat_current) || ($cat_array[1]->term_id == $cat_current) ) {
                                						$cat_array = array_slice( $categories, 2, 4 );
                                					}
                                					if( $cat_array ) :

                                	            ?>
                                                    <div class="next-pre-cat clearfix">
                                                        <?php foreach ($cat_array as $key => $term) { ?>
                                                            <?php if( $key == 1 ) { ?>
                                                                <div class="next-cat blogs-category">
                                                                    <?php } else { ?>
                                                                        <div class="pre-cat blogs-category">
                                                                            <?php }; ?>

                                                                                <h2 class="title"><?php echo $term->name; ?></h2>
                                                                                <?php 
                                                						            $args = array(
                                                						                'posts_per_page'    => 5,
                                                						                'post_type'         => 'post',
                                                						                'cat'           => $term->term_id,
                                                						            );
                                                						            $the_query = new WP_Query( $args ); 
                                                                                ?>
                                                                                    <?php if ( $the_query->have_posts() ) : ?>
                                                                                        <?php
                                            							                    $i=0;
                                            							                    while ( $the_query->have_posts() ) : $the_query->the_post();
                                            							                        $i++;
                                            							                        if ($i==1) {
                                            							                            echo get_template_part( 'content', 'cat-first' );

                                            							                        } else {
                                            							                            echo get_template_part( 'content', 'cat-item' );
                                            							                        };
                                            							                    endwhile;
                                            							                    wp_reset_postdata(); 
                                            							                ?>
                                                                                            <?php else : ?>
                                                                                                <?php echo get_template_part( 'content', 'none' ); ?>
                                                                                                    <?php endif; ?>
                                                                        </div>
                                                                        <!-- .pre-cat.blogs-category -->
                                                                        <?php }; ?>
                                                                </div>
                                                                <!-- .next-pre-cat -->
                                                                <?php endif; ?>

                                                    </div>
                                                    <!-- #content -->

                                                    <?php get_sidebar_primary(); ?>

                </div>

        </div>
        <!-- .container -->

        <?php get_footer(); ?>