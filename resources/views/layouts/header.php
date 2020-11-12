<script src="public/js/setparam.js"></script>
<?php 
// $countMistake = "<script>document.write(sessionStorage.getItem('countMistake'));</script>";
?>
<nav class="navbar navbar-light  fixed-top"
    style="background-color:#ffffff; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
        <div class="logo mr-auto ml-lg-5">
            <a href="<?php echo isset($_SESSION['pending'])? "index.php?page=menuupload": "index.php?page=2" ?>"><img src="public/img/icon.png" width="" height="40" class="d-inline-block align-top"
                    alt="" loading="lazy">
            </a>
        </div>
        <div class="logo mr-auto ml-lg-5">
            <h5 class="regular" id="count"><?php echo isset($_SESSION['countMistake'])? $_SESSION['countMistake']:'no' ?></h5>
        </div>
        <div class="lang-btn mr-lg-5">
            <a <?php echo (@$lang == 'th') ? 'class="se"':'' ; ?> onclick="setGetParameter('lang','th')">ไทย</a>&nbsp; &frasl;&nbsp;
            <a <?php echo (@$lang == 'en') ? 'class="se"':'' ; ?> onclick="setGetParameter('lang','en')">EN</a>
        </div>
    </a>
</nav>


<!-- <script>
    document.getElementById("count").innerHTML = sessionStorage.getItem('countMistake') ;
</script> -->
