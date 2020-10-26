
<div class="container-sm">
<div class="container mb-4 shadow-lg p-3 mb-5 bg-white rounded pd-top">
    <div class="row justify-content-center ">
        <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-5 pt-md-5">
        <form action="<?php echo isset($_POST['name']) ?  "../../src/controller/createcase.php"  : "../../src/views/form1.php";?>" method="post" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="exampleFormControlInput1" class="text-primary h5 Regular">ข้อมูลส่วนตัว</label>
                <input name="name" type="text" class="form-control Light" id="name"  placeholder='ชื่อ - สกุล' required 
                <?php echo $_POST['name'] = isset($_POST['name']) ?  " value='".$_POST['name']."' readonly"  : "";?>
                >
            </div>
            <div class="form-group">
                <input name="idcard" type="tell" id="idcard" maxlength="13" class="form-control Light" placeholder="หมายเลขบัตรประชาชน" required
                <?php echo $_POST['idcard'] = isset($_POST['idcard']) ?  " value='".$_POST['idcard']."' readonly"  : "";  ?>  pattern="[0-9]{13}"
                oninput="valid_creditcard(this)" >
            </div>
            <div class="form-group">
                <input name="tell" type="tell" class="form-control Light" id="exampleFormControlInput1" placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้" required
                <?php echo $_POST['tell'] = isset($_POST['tell']) ?  " value='".$_POST['tell']."' readonly"  : "";?> pattern="^0([8|9|6])([0-9]{8}$)">
            </div>
            <div class="form-group">
                <input name="email" type="email" class="form-control Light" id="exampleFormControlInput1" placeholder="E-mail Address" required
                <?php echo $_POST['email'] = isset($_POST['email']) ?  " value='".$_POST['email']."' readonly"  : "";?>  pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
            </div>

            <div class="form-group mt-4">
                <label for="exampleFormControlInput1" class="text-primary h5 Regular">เรื่องร้องเรียน</label>
                <input name="title" type="text" class="form-control Light" id="exampleFormControlInput1" placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน" required
                <?php echo $_POST['title'] = isset($_POST['title']) ?  " value='".$_POST['title']."' readonly"  : "";?>>
            </div>
            <div class="form-group">
                <input name="iduser" type="text" class="form-control Light" id="exampleFormControlInput1" placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน" required
                <?php echo $_POST['iduser'] = isset($_POST['iduser']) ?  " value='".$_POST['iduser']."' readonly"  : "";?>>
            </div>
            <div class="form-group">
                <textarea name="description" type="text" rows="4" class="form-control Light " id="validationTextarea" placeholder="รายละเอียดข้อร้องเรียน" required
                <?php echo $_POST['description'] = isset($_POST['description']) ?  " value='".$_POST['description']."' readonly"  : "";?>></textarea>
            </div>

            <div class="form-group mt-4">
                <div class="row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="text-primary h5 Regular">เอกสารประกอบข้อร้องเรียน</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="text-primary h6 Regular">แนบเอกสารประกอบ</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="image-upload">
                            <label for="file1" class="btn btn-primary col">
                                <div class="row justify-content-center">
                                    <img src="public/img/upload.png" width="22px" height="22px" class="white-img mb-1"/>
                                </div>
                                <div class="row justify-content-center">
                                    <h7 class="text-white">upload</h7>
                                </div>
                            </label>
                            <input name="file1" id="file1" type="file"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="image-upload">
                            <label for="file2" class="btn btn-primary col">
                                <div class="row justify-content-center">
                                    <img src="public/img/upload.png" class="white-img mb-1"/>
                                </div>
                                <div class="row justify-content-center">
                                    <h7 class="text-white">upload</h7>
                                </div>
                            </label>
                            <input name="file2" id="file2" type="file" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="image-upload">
                            <label for="file3" class="btn btn-primary col">
                                <div class="row justify-content-center">
                                    <img src="public/img/upload.png" class="white-img mb-1"/>
                                </div>
                                <div class="row justify-content-center">
                                    <h7 class="text-white">upload</h7>
                                </div>
                            </label>
                            <input name="file3" id="file3" type="file" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="image-upload ">
                            <label for="file4" class="btn btn-primary col">
                                <div class="row justify-content-center">
                                    <img src="public/img/upload.png" class="white-img mb-1"/>
                                </div>
                                <div class="row justify-content-center">
                                    <h7 class="text-white">upload</h7>
                                </div>
                            </label>
                            <input name="file4" id="file4" type="file" />
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row mt-4">
                <div class="col">
                    <h6 class="ExtraLight">
                    *ข้อร้องเรียนของท่านจะถูกส่งเข้าระบบในวันทำการถัดไป และธนาคารจะใช้ระยะเวลาดำเนินการในการตอบกลับข้อร้องเรียนของท่านภายใน 15 วันทำการนับจากวันที่ข้อร้องเรียนเข้าสู่ระบบ โดยธนาคารจะติดต่อกลับท่านในช่วงวันและเวลาทำการของธนาคาร 
หากท่านต้องการติดต่อธนาคารกรณีเร่งด่วน กรุณาติดต่อศูนย์บริการลูกค้า 02-777-7777
                    </h6>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col ">
                    <input type="submit" name="submit" class="btn btn-primary rounded-pill d-flex justify-content-center Regular col-12" value="ยอมรับและส่งข้อร้องเรียน">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>



function valid_creditcard(obj){
    var pattern_otp = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    if (!obj.value.match(pattern_otp)) {
        obj.setCustomValidity('invalid');
    }if (obj.value.substring(0,1)== 0) {
        obj.setCustomValidity('invalid');
    }if (obj.length != 13) {
        obj.setCustomValidity('invalid');
    }
    for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(obj.value.charAt(i))*(13-i);
    if ((11-sum%11)%10!=parseFloat(obj.value.charAt(12))) {
        obj.setCustomValidity('invalid');
    }
    else{
        obj.setCustomValidity('');
    }
   
       
    // obj.setCustomValidity(obj.value.match(pattern_otp)?"":"invalid");

}
(function() {
  'use strict';

  window.addEventListener('load', function() {
      
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission

    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();



/////////////////// validate id card ///////////
$(document).ready(function(){
    $('#idcard').on('keyup',function(){
        if($.trim($(this).val()) != '' && $(this).val().length == 13){
        id = $(this).val().replace(/-/g,"");
        console.log(id);
        var result = Script_checkID(id);
        if(result === false){
            $('#idcard').removeClass('was-validated').removeClass('is-valid').addClass('is-invalid');
        }else{
            $('#idcard').removeClass('was-validated').removeClass('is-invalid').addClass('is-valid');
        }
        }else{
        $('span.error').removeClass('true').text('');
        }
    })
});

function Script_checkID(id){
    if(! IsNumeric(id)) return false;
    if(id.substring(0,1)== 0) return false;
    if(id.length != 13) return false;
    for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(id.charAt(i))*(13-i);
    if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
    return true;
}
function IsNumeric(input){
    var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    return (RE.test(input));
}

</script>







