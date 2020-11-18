
<?php 
include 'controllers/case.php';
include 'controllers/uploadfile.php';

$result = ytu_product();
?>

<div class="container-sm">
    <div class="container mb-4 p-3 mb-5 bg-white pd-top">
        <div class="row justify-content-center ">
            <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-3 pt-md-3">
                <form
                    action="<?php echo isset($_POST['name']) ?  "controllers/createcase.php"  : "index.php?page=GN";?>"
                    method="post" class="needs-validation" novalidate enctype="multipart/form-data">

                    <input type="hidden" name="feedtype" value="<?php echo $_REQUEST['page']?>" >
                    <input type="hidden" name="feedsubtype" value="<?php echo $_POST['feedsubtype']?>" >
                    <?php 
                    if(isset($file)){ 
                        foreach ($file as $key => $value) {
                          echo   '<input type="hidden" name="file[]" value="'.$value.'" >';
                        }
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="text-primary h5 Regular mb-3"><?php echo constant("ข้อมูลส่วนตัว")?></label>
                        <input name="name" type="text" class="form-control Light" id="name" placeholder='<?php echo constant("ชื่อ")?>'
                            required
                            <?php echo $_POST['name'] = isset($_POST['name']) ?  " value='".$_POST['name']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input name="idcard" type="tel" id="idcard" maxlength="13" class="form-control Light"
                            placeholder="<?php echo constant("หมายเลขบัตรประชาชน")?>" required
                            <?php echo $_POST['idcard'] = isset($_POST['idcard']) ?  " value='".$_POST['idcard']."' readonly"  : "";  ?>
                            pattern="[0-9]{13}" oninput="valid_creditcard(this)">
                    </div>
                    <div class="form-group">
                        <input name="tel" type="tel" class="form-control Light" id="exampleFormControlInput1"
                            placeholder="<?php echo constant("หมายเลขโทรศัพท์ที่ติดต่อได้")?>" required
                            <?php echo isset($_SESSION['phoneNo']) ?  " value='".$_SESSION['phoneNo']."' readonly"  : "";?>
                            pattern="^0([8|9|6])([0-9]{8}$)">
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control Light" id="exampleFormControlInput1"
                            placeholder="<?php echo constant("อีเมล")?>" required
                            <?php echo $_POST['email'] = isset($_POST['email']) ?  " value='".$_POST['email']."' readonly"  : "";?>
                            pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    </div>

                    <div class="form-group mt-4">
                        <label for="feedsubtype" class="text-primary h5 Regular mb-3"><?php echo constant('เรื่องร้องเรียน')?></label>
                        <select <?php echo isset($_POST['feedsubtype'])? 'disabled': ''?>  name="feedsubtype" class="form-control Light" id="exampleFormControlSelect1" required>
                            <option value=""> <?php echo !isset($_SESSION['lang']) || $_SESSION['lang'] == 'th'? 'เลือก': 'select'?></option>
                            <?php foreach ($result as $key => $value) {
                                if (isset($_POST['feedsubtype']) && $value['PRODUCTCODE']== $_POST['feedsubtype']) {
                                    echo "<option selected='selected' value='".$value['PRODUCTCODE']."'>".$value['PRODUCTTITLE_'.strtoupper(isset($_SESSION['lang'])? $_SESSION['lang']: 'th')]."</option>";

                                }else{
                                    echo "<option  value='".$value['PRODUCTCODE']."'>".$value['PRODUCTTITLE_'.strtoupper(isset($_SESSION['lang'])? $_SESSION['lang']: 'th')]."</option>";

                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="iduser" type="text" class="form-control Light" id="exampleFormControlInput1"
                            placeholder="<?php echo constant('หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน')?>" required
                            <?php echo $_POST['iduser'] = isset($_POST['iduser']) ?  " value='".$_POST['iduser']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <textarea name="description" type="text" rows="4" maxlength="3000" class="form-control Light "
                            id="validationTextarea" placeholder="<?php echo constant("รายละเอียดข้อร้องเรียน")?>" required
                            <?php echo isset($_POST['description']) ?  " readonly"  : "";?>><?php echo isset($_POST['description']) ?  $_POST['description']  : "";?></textarea>
                        <div id="characters-left" class="characters-left"></div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="row">
                            <div class="col mb-2 mt-2">
                                <label for="exampleFormControlInput1"
                                    class="text-primary h5 Regular"><?php echo constant("เอกสารประกอบข้อร้องเรียน")?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" name="copyOfIDCard" type="checkbox" checked disabled
                                        id="copyOfIDCard" value="copyOfIDCard" onclick="validate()">
                                    <label class="form-check-label" for="copyOfIDCard">สำเนาบัตรประจำตัวประชาชน</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-2">
                                <?php  if(isset($file)){ 
                                    foreach ($file as $key => $value) {
                                        echo '<label class="form-check-label">'.$value.'</label><br>' ;
                                    }
                               
                                }else{ 
                                echo '<div class="custom-file" id="file-copyOfIDCard1" style="display: block;" >
                                        <input name="file[]" type="file" class="custom-file-input" id="input-copyOfIDCard1" required/>
                                        <label class="custom-file-label" for="input-copyOfIDCard1">Choose file</label>
                                    </div>';
                                }?>
                                
                            </div>
                            <div class="col-sm-12 col-md-6 mb-2">
                                <div class="custom-file" id="file-copyOfIDCard2" style="display: none;">
                                    <input name="file[]" type="file" class="custom-file-input" id="input-copyOfIDCard2" />
                                    <label class="custom-file-label" for="input-copyOfIDCard2">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <h6 class="ExtraLight">
                                *ข้อร้องเรียนของท่านจะถูกส่งเข้าระบบในวันทำการถัดไป
                                และธนาคารจะใช้ระยะเวลาดำเนินการในการตอบกลับข้อร้องเรียนของท่านภายใน 15
                                วันทำการนับจากวันที่ข้อร้องเรียนเข้าสู่ระบบ
                                โดยธนาคารจะติดต่อกลับท่านในช่วงวันและเวลาทำการของธนาคาร
                                หากท่านต้องการติดต่อธนาคารกรณีเร่งด่วน กรุณาติดต่อศูนย์บริการลูกค้า 02-777-7777
                            </h6>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col ">
                            <input type="submit" name="create_case" 
                                class="btn btn-primary rounded-pill d-flex justify-content-center Regular col-12"
                                value="ยอมรับและส่งข้อร้องเรียน">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ---------------------------------Custom Input File------------------------------------

$('#input-copyOfIDCard1').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
    document.getElementById('file-copyOfIDCard2').style.display = 'flex';
})

$('#input-copyOfIDCard2').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

// --------------------------------------------

function valid_creditcard(obj) {
    var pattern_otp =
        /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    if (!obj.value.match(pattern_otp)) {
        obj.setCustomValidity('invalid');
    }
    if (obj.value.substring(0, 1) == 0) {
        obj.setCustomValidity('invalid');
    }
    if (obj.length != 13) {
        obj.setCustomValidity('invalid');
    }
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(obj.value.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(obj.value.charAt(12))) {
        obj.setCustomValidity('invalid');
    } else {
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
$(document).ready(function() {
    $('#idcard').on('keyup', function() {
        if ($.trim($(this).val()) != '' && $(this).val().length == 13) {
            id = $(this).val().replace(/-/g, "");
            console.log(id);
            var result = Script_checkID(id);
            if (result === false) {
                $('#idcard').removeClass('was-validated').removeClass('is-valid').addClass(
                'is-invalid');
            } else {
                $('#idcard').removeClass('was-validated').removeClass('is-invalid').addClass(
                'is-valid');
            }
        } else {
            $('span.error').removeClass('true').text('');
        }
    })
});

function Script_checkID(id) {
    if (!IsNumeric(id)) return false;
    if (id.substring(0, 1) == 0) return false;
    if (id.length != 13) return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12))) return false;
    return true;
}

function IsNumeric(input) {
    var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    return (RE.test(input));
}

// -------------------------------------------------------------------------------------

function validate() {
    if (document.getElementById('copyOfIDCard').checked) {
        if(document.getElementById("input-copyOfIDCard1").files.length != 0){
            document.getElementById('file-copyOfIDCard2').style.display = 'flex';
        }
        document.getElementById('file-copyOfIDCard1').style.display = 'flex';
    } else {
        document.getElementById('file-copyOfIDCard1').style.display = 'none';
        document.getElementById('file-copyOfIDCard2').style.display = 'none';
    }
}

// -------------------------------------------------------------------------------------

var textarea = document.getElementById('validationTextarea');

window.onload = textareaLengthCheck();

function textareaLengthCheck() {
    var textArea = textarea.value.length;
    var charactersLeft = 3000 - textArea;
    var count = document.getElementById('characters-left');
    count.innerHTML = charactersLeft + "/3000";
}

textarea.addEventListener('keyup', textareaLengthCheck, false);
textarea.addEventListener('keydown', textareaLengthCheck, false);

</script>