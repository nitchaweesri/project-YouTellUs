<br>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<label for="cars">Choose a car:</label>

<select name="cars" id="cars">
  <option data-text="volvo-text" value="volvo">Volvo</option>
  <option data-text="saab-text" value="saab">Saab</option>
  <option data-text="mercedes-text" value="mercedes">Mercedes</option>
  <option data-text="audi-text" value="audi">Audi</option>
</select>

<div id='test'></div>
<div id='aioConceptName'></div>

<script>

$('#cars').on('change',function () {

  $('#test').text($('#cars :selected').val());
  $('#aioConceptName').text($('#cars :selected').data('text'));

  // $('#aioConceptName').find(":selected").text();

}
);


</script>