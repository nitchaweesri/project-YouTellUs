<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-4">
				<img src="public/img/YTU.jpg?v=2020" alt="SCB YouTellUs" style="max-width: 88px !important;">
			</div>
			<div class="col-lg-8 col-md-8 col-8 text_thx">
				ทุกๆ<strong>ความคิดเห็น</strong>...เป็นเรื่อง<strong>สำคัญ</strong>
			</div>
		</div>
	</div>
</footer>
<a href="javascript:;" class="back-to-top"><i>&uarr;</i></a>

<script type="text/javascript">
	!(function($) {
		  // Toggle .header-scrolled class to #header when page is scrolled
		  $(window).scroll(function() {
		    if ($(this).scrollTop() > 100) {
		      $('#header').addClass('header-scrolled');
		    } else {
		      $('#header').removeClass('header-scrolled');
		    }
		  });

		  if ($(window).scrollTop() > 100) {
		    $('#header').addClass('header-scrolled');
		  }

		  // Back to top button
		  $(window).scroll(function() {
		    if ($(this).scrollTop() > 100) {
		      $('.back-to-top').fadeIn('slow');
		    } else {
		      $('.back-to-top').fadeOut('slow');
		    }
		  });

		  $('.back-to-top').click(function() {
		    $('html, body').animate({
		      scrollTop: 0
		    }, 1500, 'easeInOutExpo');
		    return false;
		  });

		})(jQuery);
	</script>