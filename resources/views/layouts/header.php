<nav class="navbar navbar-light  fixed-top"
    style="background-color:#ffffff; box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);">
        <div class="logo mr-auto ml-lg-5">
            <a href="index.php?page=2"><img src="public/img/icon.png" width="" height="40" class="d-inline-block align-top"
                    alt="" loading="lazy"></a>
        </div>
        <div class="lang-btn mr-lg-5">
            <a <?php echo (@$lang == 'th') ? 'class="se"':'' ; ?>
                href="<?php echo $url_lang.'?lang=th'; ?>">ไทย</a>&nbsp; &frasl;&nbsp;
            <a <?php echo (@$lang == 'en') ? 'class="se"':'' ; ?> href="<?php echo $url_lang.'?lang=en'; ?>">EN</a>
        </div>
    </a>
</nav>