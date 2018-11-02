<?php
    // OAUTH Configuration
    $oauthClientID = '280891686179-g6g0n4efuce4qpb9osu0o1224ar4ghlm.apps.googleusercontent.com';
    $oauthClientSecret = 'ZsHDoQ7ccfR-vI8eM1MzHWVz';
    $baseUri = 'https://mina24h.com/wp-content/themes/theme3us/video-upload/';
    $redirectUri = 'https://mina24h.com/wp-content/themes/theme3us/video-upload/youtube_upload.php';
    
    define('OAUTH_CLIENT_ID',$oauthClientID);
    define('OAUTH_CLIENT_SECRET',$oauthClientSecret);
    define('REDIRECT_URI',$redirectUri);
    define('BASE_URI',$baseUri);
    
    // Include google client libraries
    require_once 'src/Google/autoload.php'; 
    require_once 'src/Google/Client.php';
    require_once 'src/Google/Service/YouTube.php';
    session_start();
    
    $client = new Google_Client();
    $client->setClientId(OAUTH_CLIENT_ID);
    $client->setClientSecret(OAUTH_CLIENT_SECRET);
    $client->setScopes('https://www.googleapis.com/auth/youtube');
    $client->setRedirectUri(REDIRECT_URI);
    
    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);
    
?>