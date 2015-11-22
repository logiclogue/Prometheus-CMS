<?php require_once('models/GetPost.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>
</head>
<body>
	<?php echo GetPost::call(array('title' => 'Test Title'))['content']; ?>


	<script src="js/Main.js"></script>
</body>
</html>