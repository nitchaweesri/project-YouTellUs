    <br>
    <br>

    <br>

    <br>

<div class="custom-file">
    <input type="file" class="custom-file-input" id="imgInp" required>
    <label class="custom-file-label" for="customInput">Choose file...</label>
</div>
<img id="blah" src="#" alt="your image" />

  
<script>


function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#imgInp").change(function() {
  readURL(this);
});

</script>