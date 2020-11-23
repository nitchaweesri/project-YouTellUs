
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
body {overflow-x:hidden;}
.loaded_content_wrapper { 
    overflow:hidden; 
    margin-left:100%; 
    width:100%; 
    position:absolute;
}
</style>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

</head>
<body>
<br>
<br>
<br>
<br>
<br>
<ul class="menu">
   <li ><a href="home.php">Home</a></li>
   <li ><a href="about.php">About</a></li>
   <li ><a  href="services.php">Services</a></li>
   <button >test</button>
   
</ul>


<div id="contents">
 <!-- Place the loaded contents here -->
</div>




<script>



function loadContent(href){

    /* Create the content wrapper and append it to div#contents 
       then load the contents to the wrapper 
    */
    var wrapper = $('#contents'); 
    wrapper.addClass('loaded_content_wrapper').appendTo('#contents').load(href, function(){
        /* When the content is completely loaded 
           animate the new content from right to left 
           also the previous content slide to left and remove afterwards.
        */
        $(this).animate({marginLeft:0}, 'slow').prev().animate({marginLeft:'-100%'}, 'slow', function(){
          // window.location.replace(href)
            $(this).remove(); //remove previous content once the animation is complete
        });
    })
}

$('a').click(function(e){
  // alert('yse')
    e.preventDefault();
    // var urlParams = new URLSearchParams(window.location.search); //get all parameters
    // urlParams.set('location',"location");
    var href = $(this).attr('href');
    loadContent(href)
})


</script>


</body>
</html>










































<!-- <style>
  /* body { margin: 0; padding: 0; } */

/* .Header   { position: absolute; left: 0; top: 0; width: 100%; height: 30px; line-height: 30px; text-align: center; background: #000; color: #fff; }
.Footer   { position: absolute; left: 0; bottom: 0; width: 100%; height: 30px; line-height: 30px; text-align: center; background: #000; color: #fff; } */

.SlideContainer { position: absolute; left: 0; top: 30px; width: 100%; overflow: hidden; }
.Slides { position: absolute; left: 0; top: 0; height: 100%; }
.Slides > div { float: left; height: 100%; overflow: scroll; }

.Slides .Content { margin-top: 100px; text-align: center; }
.Slides .Content a { font-size: 30px; }

</style>







<div class="Header">
  absolutely positioned header
</div>

<div class="SlideContainer">
  <div class="Slides">

    <div class="Slide">
      <div class="Content">
        <h1>Slide 1</h1>
        <a href="#" class="Left">&laquo;</a>
      </div>
    </div>

    <div class="Slide">
      <div class="Content">
        <h1>Slide 2</h1>
        <a href="#" class="Left">&laquo;</a>
        <a href="#" class="Right">&raquo;</a>

      </div>
    </div>

    <div class="Slide">
      <div class="Content">
        <h1>Slide 3</h1>
        <a href="#" class="Right">&raquo;</a>
      </div>
    </div>

  </div>
</div>

<div class="Footer">
  absolutely positioned footer
</div>







<script>


var w = $(window).width();
var h = $(window).height();
var slides = $('.Slides > div');
$('.SlideContainer').css({ height: (h-60) + 'px' });
$('.Slides').css({ width: slides.length + '00%' });
slides.css({ width: w + 'px' });

var pos = 0;

$('.Left').click(function(){
  pos--;
  $('.Slides').animate({ left: (pos * w) + 'px' });
});
$('.Right').click(function(){
  pos++;
  $('.Slides').animate({ left: (pos * w) + 'px' });
});


</script> -->