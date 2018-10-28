<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
	    google_ad_client: "ca-pub-8682339380959039",
	    enable_page_level_ads: true
	  });
	</script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127982974-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-127982974-1');
	</script>

</head>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	<?php if ( get_field( 'pageloader', 'option' ) ) : ?>
		<div id="pageloader">
			<div class="load">
			    <i></i>
			    <i></i>
			    <i></i>
			</div>
		</div>
	<?php endif; ?>

	<div id="wrapper" class="hfeed site">
		<header id="header" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
			<?php 
				$banner_image = get_field( 'banner_image', 'option' );
				$banner_color = get_field( 'banner_color', 'option' );
				$banner_link = get_field( 'banner_link', 'option' );
				if( $banner_image ) :
			?>
				<div class="banner-header" <?php if( $banner_color ) echo 'style="background-color: ' . $banner_color . '"'; ?>>
					<div class="close"></div>
					<div class="container">
						<a href="<?php echo esc_url( $banner_link ); ?>" target="_blank">
							<?php echo wp_get_attachment_image( $banner_image, 'full' ); ?>
						</a>
					</div>
				</div><!-- .banner-header -->
			<?php endif; ?>

			<?php if( get_field( 'acf_searchbox', 'option' ) != true ) { ?>
				<div class="menu-search">
					<div class="container">
						<form action="<?php echo home_url( '/' ); ?>">
							<div class="search-input">
								<input type="text" value="<?php echo get_search_query() ?>" placeholder="Search..." name="s">
								<button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
							</div>
						</form>
					</div>
				</div><!-- .menu-search -->
			<?php } ?>

			<div class="header-main">
				<div class="container clearfix">
					<div class="site-brand">
						<a href="<?php echo site_url(); ?>" class="logo">
						<?php
							$logo = get_field( 'acf_logo', 'option' );
							if( $logo ) {
								echo '<img src="' . $logo['url'] .'" alt="' . get_bloginfo('name') . '" />';
							} else {
								echo '<img src="' . get_template_directory_uri() . '/images/assets/logo.png" alt="' . get_bloginfo('name') . '" />';
							}
						?>
						</a>
					</div><!-- .site-brand -->
					<div class="header-main-right">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'top_menu',
								)
							);
						?>	
						<div class="hmr-user">
							<?php if( is_user_logged_in() ) { ?>
							<a href="<?php echo get_field('acf_account','option'); ?>"><i class="fa fa-user-plus"></i> <?php esc_html_e( 'My Mina', 'threeus' ); ?></a>
							<?php } else { ?>
								<?php 
									global $wp;
									$current_url = home_url( add_query_arg( array(), $wp->request ) );
								?>
							<a href="<?php echo wp_login_url( $current_url ); ?>" class="account show-login-form"><i class="fa fa-unlock"></i> <?php esc_html_e( 'Đăng nhập', 'threeus' ); ?></a>
							<?php } ?>
						</div>
						<div class="hmr-publish">
							<?php if( is_user_logged_in() ) { ?>
								<a class="pri-button" href="<?php echo get_field('acf_new_post', 'option') ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span><?php esc_html_e( 'Viết bài', 'threeus' ); ?></span></a>

							<?php } else { ?>
								<a class="show-login-form pri-button" href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span><?php esc_html_e( 'Viết bài', 'threeus' ); ?></span></a>
							<?php }; ?>
						</div>

						<div class="search-button">
							<a href="#">
								<i class="fa fa-search" aria-hidden="true"></i>
							</a>
						</div><!-- .search-button -->
					</div>

					<a href="#" class="hamburger trigger-menu">
				        <span class="divider"></span>
				        <span class="divider"></span>
				        <span class="divider"></span>
				        <span class="divider"></span>
				    </a>
				</div>
			</div><!-- .header-main -->

			<nav class="main-menu">
				<div class="container">
					<div class="menu-main-container">
						<?php if( get_field( 'acf_searchbox', 'option' ) != true ) { ?>
						<div class="menu-search mobile-show">
							<form action="<?php echo home_url( '/' ); ?>">
								<div class="search-input">
									<input type="text" value="<?php echo get_search_query() ?>" placeholder="<?php esc_html_e('Nhập nội dung tìm kiếm...'); ?>" name="s">
									<button class="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
								</div>
							</form>
						</div><!-- .menu-search -->
						<?php } ?>
						<div class="menu-mob-hidden">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'main_menu',
								)
							);
						?>	
						</div>
						<div class="menu-mob">
							<div class="menu_mob_top">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'menu_mob_top',
									)
								);
							?>	
							</div>
							<div class="menu_mob_bottom">
							<?php
								echo '<h4>' . esc_html__( 'Danh sách chuyên mục', 'threeus' ) . '</h4>';
								wp_nav_menu(
									array(
										'theme_location' => 'menu_mob_bottom',
									)
								);
							?>
							</div>	
						</div>
					</div>
				</div>
			</nav><!-- .main-menu -->
		</header><!-- .site-header -->

		<main id="main" class="site-main" role="main" itemscope itemprop="mainContentOfPage">


