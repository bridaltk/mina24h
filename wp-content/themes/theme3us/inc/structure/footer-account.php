		<div class="popup-bg"></div>
		<div class="popup-withdraw">
		    <h2><?php echo esc_html_e( 'Yêu cầu rút tiền' , 'threeus' ) ?></h2>
		    <?php
		        $current_user = wp_get_current_user();
		        $user_point = get_field( 'user_point', 'user_' . $current_user->ID );
		    ?>
		    <p><?php echo esc_html_e( 'Xin chào: ' , 'threeus' ); ?><strong><?php echo $current_user->display_name; ?></strong></p>
		    <p><?php echo esc_html_e( 'Số Points hiện tại: ' , 'threeus' ); ?>
		        <strong id="checkpoint">
		            <?php if ($user_point) {
		                echo $user_point;
		            } else {
		                echo '0';
		            }  ?>   
		        </strong>
		    </p>
		    <form action="" method="post" class="wpcf7-form" id="withdraw_form">
		        <p><label><?php echo esc_html_e( 'Số Points cần rút: ' ) ?></label>
		            <span class="your-number">
		                <input type="number" id="withdraw_number" name="withdraw_number" onChange="format_curency(this);" value="" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-required wpcf7-validates-as-number" min="10" step="10" required="" aria-invalid="false">
		            </span>
		        </p>
		        <p><label><?php echo esc_html_e( 'Nội dung rút tiền:' ) ?></label>
		            <span class="your-content">
		                <textarea name="withdraw_content" required="" id="withdraw-content" cols="30" rows="3"></textarea>
		            </span>
		        </p>
		        <p>
		            <label class="submit-withdraw">
		                <input type="submit" name="withdrawal" value="Rút tiền" class="submit-money btn-money">
		            </label>
		        </p>
		    </form>
		</div>
	</main><!-- #main -->


<?php wp_footer(); ?>
</body>
</html>
