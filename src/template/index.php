<?php 
$page = @$_REQUEST['page'] != '' ? $_REQUEST['page'] : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title> SCB You tell us </title>
	<meta content="" name="descriptison">
	<meta content="" name="keywords">

  	<link href="assets/img/favicon.png" rel="icon">
  	<link href="assets/img/favicon.png" rel="apple-touch-icon">

	<?php include_once 'inc/meta.php'; ?>
</head>
<body>
	<?php include_once 'inc/header.php'; ?>
	<main id="main">
        <section id="contact" class="contact">
    		<div class="container">
    		<?php 
    		if ($page == '' || $page == 1) {
    		    include_once 'form-data.php';         /*  === form YouTellUs ===  */
    		}
    		?>
          	</div>
    	</section>
	</main>
	<?php 
	include_once 'inc/footer.php'; 
	include_once 'inc/footer-meta.php';
	include_once 'js/btn-up.php';
	?>
</body>
</html>