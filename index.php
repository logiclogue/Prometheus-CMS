<?php require_once('models/GetPost.php'); session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Prometheus CMS</title>
</head>
<body>
	<?php GetPost::call(array('title' => 'Test Post')); ?>
</body>
</html>