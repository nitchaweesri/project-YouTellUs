<script src="public/js/setparam.js"></script>
<?php // $countMistake = "<script>document.write(sessionStorage.getItem('countMistake'));</script>"; ?>
<!-- 
################
SESSION lang is : <?php echo isset($_SESSION['form'])? $_SESSION['form']:'no'; ?> 
################
-->

<nav class="navbar navbar-light fixed-top test pl-0" style="background-color:#ffffff; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
	<div class="container col-lg-7">
		<div class="logo">
    		<a  href="javascript:history.go(-1)" onclick="history.go(-1);"><img src="public/img/chevron-left.png" width="" height="20" class="d-inline-block align-top pt-1" alt="" loading="lazy"></a>
    	</div>

    	<div class="logo mx-auto">
		<div >
			<img src="public/img/icon.png" width="" height="40" class="d-inline-block align-top" alt="" loading="lazy">
		</div>
    		<!-- <a href="<?php echo isset($_SESSION['pending'])? "index.php?page=menuupload": "index.php?page=2" ?>"><img src="public/img/icon.png" width="" height="40" class="d-inline-block align-top" alt="" loading="lazy"></a> -->
    	</div>
    	<!-- <div class="lang-btn mr-lg-5">
    		<a <?php echo (@$lang == 'th') ? 'class="se"':'' ; ?> onclick="setGetParameter('lang','th')">ไทย</a>&nbsp; &Iota;&nbsp;
      		<a <?php echo (@$lang == 'en') ? 'class="se"':'' ; ?> onclick="setGetParameter('lang','en')">EN</a>
    	</div> -->
	</div>
</nav>
<!-- <script>
    document.getElementById("count").innerHTML = sessionStorage.getItem('countMistake') ;
</script> -->