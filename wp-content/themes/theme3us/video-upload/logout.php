<?php
require_once 'config.php';

unset($_SESSION['token']);
unset($_SESSION['state']);
unset($_SESSION['google_data']); //Google session data unset
$client->revokeToken();
session_destroy();
$id = $_SESSION['post_id'];
header('Location:http://vnjpblog.testyoursite.top/wp-admin/post.php?post=' . $id . '&action=edit');exit;
?>