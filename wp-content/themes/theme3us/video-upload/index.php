<?php
if(session_id() != '') session_destroy();
if(isset($_GET['err'])){
	if($_GET['err'] == 'bf'){
		$errorMsg = 'Please select a video file for upload.';
	}elseif($_GET['err'] == 'ue'){
		$errorMsg = 'Sorry, there was an error uploading your file.';
	}elseif($_GET['err'] == 'fe'){
		$errorMsg = 'Sorry, only MP4, AVI, MPEG, MPG, MOV & WMV files are allowed.';
	}else{
		$errorMsg = 'Some problems occured, please try again.';
	}
}

if( isset( $_GET['title'] ) ) {
	$title = $_GET['title'];
}

if( isset( $_GET['source'] ) ) {
	$source = $_GET['source'];
}

if( isset( $_GET['id'] ) ) {
	$id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload video to YouTube using PHP</title>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
	<div class="youtube-box">
		<h1>Upload video to YouTube using PHP</h1>
		<form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="https://mina24h.com/wp-content/themes/theme3us/video-upload/youtube_upload.php">
		<?php echo (!empty($errorMsg))?'<p class="err-msg">'.$errorMsg.'</p>':''; ?>
		<label for="title">Title:</label><input type="text" name="title" id="title" value="<?php echo $title; ?>" />
		<label for="description">Description:</label> <textarea name="description" id="description" cols="20" rows="2" ></textarea>
		<label for="tags">Tags:</label> <input type="text" name="tags" id="tags" value="" />
		<label for="video_file">Choose Video File:</label>	<input value="<?php echo $source; ?>" type="file" name="videoFile" id="videoFile" >
		<input name="post_id" type="hidden" value="<?php echo $id; ?>">
		<input name="videoSubmit" id="submit" type="submit" value="Upload">
		</form>
	</div>
</body>
</html>