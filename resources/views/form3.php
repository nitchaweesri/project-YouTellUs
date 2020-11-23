<?php 
include 'controllers/case.php';
include 'controllers/uploadfile.php';

$result = ytu_product();
?>
<div class="container">
    <div class="container mb-4 p-2 mb-5 bg-white pd-top">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12 col-sm-12 pt-lg-3 pt-md-3">
                <form
                    action="<?php echo isset($_POST['name']) ?  "controllers/createcase.php"  : "index.php?page=JP";?>"
                    method="post" class="needs-validation" novalidate enctype="multipart/form-data">

                    <!-- <input type="hidden" name="feedtype" value="<?php echo $_REQUEST['page']?>" >
                    <input type="hidden" name="feedsubtype" value="<?php echo $_POST['feedsubtype']?>" > -->
                    
                    <input type="hidden" name="feedtype" value="OC" >
                    <input type="hidden" name="feedsubtype" value="<?php echo $_REQUEST['page']?>" >
                    <input type="hidden" name="relationOptions" value="<?php echo $_POST['relationOptions']?>" >
                    <?php 
                    if(isset($file)){ 
                        foreach ($file as $key => $value) {
                          echo   '<input type="hidden" name="file[]" value="'.$value.'" >';
                        }
                        foreach ($linkFile as $key1 => $value1) {
                            echo   '<input type="hidden" name="linkFile[]" value="'.$value1.'" >';
                          }
                    }
                    ?>
 
                    <div class="row">
                        <div class="col mb-2">
                            <label for="exampleFormControlInput1" class="text-primary h5 Regular">ข้อมูลนิติบุคคล</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="ชื่อบริษัท/ห้างหุ้นส่วน/องค์กร" required
                            <?php echo $_POST['name'] = isset($_POST['name']) ?  " value='".$_POST['name']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="numID" id="numID"
                            placeholder="เลขจดทะเบียนนิติบุคคล" required
                            <?php echo $_POST['numID'] = isset($_POST['numID']) ?  " value='".$_POST['numID']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameAuthorizedPerson" id="nameAuthorizedPerson"
                            placeholder="ชื่อ-สกุลผู้มีอำนาจลงนาม" required
                            <?php echo $_POST['nameAuthorizedPerson'] = isset($_POST['nameAuthorizedPerson']) ?  " value='".$_POST['nameAuthorizedPerson']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="position" id="position" placeholder="ตำแหน่ง"
                            required
                            <?php echo $_POST['position'] = isset($_POST['position']) ?  " value='".$_POST['position']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input name="tel" type="tel" class="form-control Light" id="tel"
                            placeholder="<?php echo constant("หมายเลขโทรศัพท์ที่ติดต่อได้")?>" required
                            <?php echo isset($_SESSION['phoneNo']) ?  " value='".$_SESSION['phoneNo']."' readonly"  : "";?>
                            pattern="^0([8|9|6])([0-9]{8}$)">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="mail" placeholder="<?php echo constant("อีเมล")?>"
                            required
                            <?php echo $_POST['email'] = isset($_POST['email']) ?  " value='".$_POST['email']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group mt-4">
                        <label for="feedsubtype" class="text-primary h5 Regular mb-2">เรื่องร้องเรียน</label>
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
                    <div class="form-group" id="other" <?php echo isset($_POST['other'])? '': 'style="display: none;"' ?> >
                        <input name="other" type="text" class="form-control Light" id="other"
                            placeholder="<?php echo constant('ระบุ')?>" requiredss
                            <?php echo $_POST['other'] = isset($_POST['other']) ?  " value='".$_POST['other']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="serviceID" id="serviceID"
                            placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน" required
                            <?php echo $_POST['serviceID'] = isset($_POST['serviceID']) ?  " value='".$_POST['serviceID']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameOwner" id="nameOwner"
                            placeholder="ชื่อลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น" required
                            <?php echo $_POST['nameOwner'] = isset($_POST['nameOwner']) ?  " value='".$_POST['nameOwner']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group mt-2">
                        <textarea name="description" type="text" rows="4" maxlength="3000" class="form-control Light "
                            id="validationTextarea" placeholder="<?php echo constant("รายละเอียดข้อร้องเรียน")?>" required
                            <?php echo isset($_POST['description']) ?  " readonly"  : "";?>><?php echo isset($_POST['description']) ?  $_POST['description']  : "";?></textarea>
                        <div id="characters-left" class="characters-left"></div>
                    </div>
                    
                    <?php include 'formfile.php' ?>

                    <div class="row mt-3">
                        <div class="col">
                            <p class="text-left">ข้อร้องเรียนของท่านจะถูกส่งเข้าระบบในวันทำการถัดไป
                                และธนาคารจะใช้ระยะเวลาในการดำเนินการตอบกลับข้อร้องเรียนของท่านภายใน 15
                                วันทำการนับจากวันที่ข้อร้องเรียนเข้าสู่ระบบโดนธนาคารจะติดต่อกลับท่านในช่วงวันและเวลาทำการของธนาคาร
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="text-left">หากท่านต้องการติดต่อธนาคารกรณีเร่งด่วน กรุณาติดต่อศูนย์บริการลูกค้า
                                02-777-7777</p>
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
                <div class="btn-out">
                    <button class="button-clear" onclick="modalClear()">Clear Session</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#idcard').on('keyup', function() {
        if ($.trim($(this).val()) != '' && $(this).val().length == 13) {
            id = $(this).val().replace(/-/g, "");
            var result = Script_checkID(id);
            if (result === false) {
                $('#idcard').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#idcard').removeClass('is-invalid').addClass('is-valid');
            }
        } else {
            $('span.error').removeClass('true').text('');
        }
    })
});

function modalClear() {
    $('#modal-clear').on('show.bs.modal', function (event) {
        var modal = $(this)
            modal.find('.modal-title').text('Clear Session')        
        })
    $('#modal-clear').modal('show')
};

// ---------------------------------Custom Input File------------------------------------

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
        var forms = document.getElementsByClassName('needs-validation');
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

// -------------------------------------------------------------------------------------

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



$("#exampleFormControlSelect1").change(function(){
    var select = $('#exampleFormControlSelect1 option');
    if(select.filter(':selected').text() == select.filter('option:last').text() ){
        $('#other').css("display", "block").prop('required',true);;
    }else{
        $('#other').css("display", "none");
    }

});

</script>