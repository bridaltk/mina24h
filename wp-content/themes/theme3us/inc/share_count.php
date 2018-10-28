<?php 

/**
 * Display number of shares using PHP cURL library
 *
 * @param string $url ID We want to get number of shares of this URL
 */
function threeus_get_shares( $url ){
	$access_token = '313677769198071|a4e73112cdd2eb16561a7ceed796c66f';
	$api_url = 'https://graph.facebook.com/v3.0/?id=' . urlencode( $url ) . '&fields=engagement&access_token=' . $access_token;
	$fb_connect = curl_init(); // initializing
	curl_setopt( $fb_connect, CURLOPT_URL, $api_url );
	curl_setopt( $fb_connect, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $fb_connect, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $fb_connect ); // connect and get json data
	curl_close( $fb_connect ); // close connection
	$body = json_decode( $json_return );
	return intval( $body->engagement->share_count );
}

function threeus_post_icon() {
	$blog_type = get_field( 'blog_type' );
	if( $blog_type == 'video' ) {
		return '<span class="post-icon video-icon"><i class="fa fa-video-camera"></i></span>';
	} else {
		return '<span class="post-icon image-icon"><i class="fa fa-picture-o"></i></span>';
	}
}

function getGplusShares($url) {
    $url = sprintf('https://plusone.google.com/u/0/_/+1/fastbutton?url=%s', urlencode($url));
    preg_match_all('/{c: (.*?),/', file_get_contents($url), $match, PREG_SET_ORDER);
    return (1 === sizeof($match) && 2 === sizeof($match[0])) ? intval($match[0][1]) : 0;
}

function getPinterestShares($url) {
    $receiveCount = 'https://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url='.urlencode($url);
    $pi_connect = curl_init(); // initializing
	curl_setopt( $pi_connect, CURLOPT_URL, $receiveCount );
	curl_setopt( $pi_connect, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $pi_connect, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $pi_connect ); // connect and get json data
	curl_close( $pi_connect ); // close connection
	$body = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $json_return);
	$json_decode = json_decode( $body );
    return intval( $json_decode->count );
}
?>