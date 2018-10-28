<?php 
	if( !is_user_logged_in() ) {
		wp_redirect( site_url() );
		exit;
	}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
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
		<header id="header_account" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div class="header-main header-account-main">
				<div class="clearfix">
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
					<div class="header-right clearfix">
						<?php
					        $current_user = wp_get_current_user();
					        $user_point = get_field( 'user_point', 'user_' . $current_user->ID );
					    ?>
						<div class="points">
							<i class="fa fa-usd"></i> <span><?php echo $user_point . ' ' . __( 'Points', 'threeus' ); ?></span>	
						</div>

						<div class="notification">
							<div class="notification-icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
							<div class="noti-detail">
								<?php
				                    $current_user = wp_get_current_user();
				                    $notic = get_user_meta( $current_user->ID, 'notic', true );
				                    $notics = explode(',',$notic);
				                    if( $notic ) {
								?>
								<ul>
									<?php 
										foreach ($notics as $key => $value) {
									?>
										
				                    	<li class="read"><?php echo esc_html_e('Bài viết: "'); ?><i><?php echo get_the_title( $value ); ?></i><?php echo esc_html_e('" đã được phê duyệt'); ?></li>
				                    	
				                    <?php }; ?>
								</ul>
								<?php } ?>
								<input type="hidden" name="current_user" value="<?php echo $current_user->ID; ?>">
							</div><!-- .noti-detail -->
							<div class="noti-bg"></div>
						</div>
						<div class="member-meta">
							<?php
	                            $current_user = wp_get_current_user();
	                        ?>
							<div class="member-title clearfix">
								<div class="member-avatar"><?php echo threeus_get_avatar(  $current_user->ID , 30 ); ?></div>
								<div class="member-info"><?php echo $current_user->display_name; ?></div>
							</div>
							<div class="member-alert">
								<ul>
									<li class="clearfix">
										<div class="member-avatar"><?php echo threeus_get_avatar( $current_user->ID , 50 ); ?></div>
										<div class="member-info">
											<div class="member-name"><?php echo $current_user->display_name; ?></div>
											<div class="member-job"><?php echo get_field('user_job','user_'. $current_user->ID); ?></div>
										</div>
									</li>
									<li>
										<a href="<?php echo wp_logout_url( home_url()); ?>"><i class="fa fa-power-off" aria-hidden="true"></i><?php echo esc_html_e('Đăng xuất'); ?></a>
									</li>
								</ul>
							</div>
							<div class="member-bg"></div>
						</div>

						<a href="#" class="hamburger trigger-menu">
					        <span class="divider"></span>
					        <span class="divider"></span>
					        <span class="divider"></span>
					        <span class="divider"></span>
					    </a>
					</div>
				</div>
			</div><!-- .header-main -->
                                             
		</header><!-- .site-header -->

		<main id="main" class="site-main" role="main" itemscope itemprop="mainContentOfPage">


