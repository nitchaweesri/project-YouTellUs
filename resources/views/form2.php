<div class="container-sm">
    <div class="container mb-4 shadow-lg p-3 mb-5 bg-white rounded pd-top">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-5 pt-md-5">
                <form action="<?php echo isset($_POST['name']) ?  "src/views/thanks.php"  : "index.php?page=form2";?>"
                    method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1" class="text-primary h5 Regular"><?php echo constant("ข้อมูลส่วนตัว")?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="<?php echo constant("ชื่อ")?>"
                            required
                            <?php echo $_POST['name'] = isset($_POST['name']) ?  " value='".$_POST['name']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="idcard" id="idcard"
                            placeholder="<?php echo constant("หมายเลขบัตรประชาชน")?>" required
                            <?php echo $_POST['idcard'] = isset($_POST['idcard']) ?  " value='".$_POST['idcard']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameDelegate" id="nameDelegate"
                            placeholder="ชื่อ-สกุลของผู้ร้องเรียนแทน" required
                            <?php echo $_POST['nameDelegate'] = isset($_POST['nameDelegate']) ?  " value='".$_POST['nameDelegate']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="tel" id="tel"
                            placeholder="<?php echo constant("หมายเลขโทรศัพท์ที่ติดต่อได้")?>" required
                            <?php echo $_POST['tel'] = isset($_POST['tel']) ?  " value='".$_POST['tel']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="mail" id="mail" placeholder="<?php echo constant("อีเมล")?>"
                            required
                            <?php echo $_POST['mail'] = isset($_POST['mail']) ?  " value='".$_POST['mail']."' readonly"  : "";?>>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1"
                                class="text-primary h5 Regular">เรื่องร้องเรียน</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="service" id="service"
                            placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน" required
                            <?php echo $_POST['service'] = isset($_POST['service']) ?  " value='".$_POST['service']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="serviceID" id="serviceID"
                            placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน" required
                            <?php echo $_POST['serviceID'] = isset($_POST['serviceID']) ?  " value='".$_POST['serviceID']."' readonly"  : "";?>>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="text-left">ความสัมพันธ์ของท่านและเจ้าของหมายเลขบัญชีข้างต้น</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="parent"
                                    value="parent">
                                <label class="form-check-label" for="inlineCheckbox1">บิดา/มารดา</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="attorney"
                                    value="attorney">
                                <label class="form-check-label" for="inlineCheckbox2">ผู้รับมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="child"
                                    value="child">
                                <label class="form-check-label" for="inlineCheckbox1">บุตร</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="other"
                                    value="other">
                                <label class="form-check-label" for="inlineCheckbox2">อื่น ๆ (โปรดระบุ)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="relative"
                                    value="relative">
                                <label class="form-check-label" for="inlineCheckbox1">ญาติ / พี่น้อง</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <textarea class="form-control" id="detail" rows="3" name="detail"
                            placeholder="<?php echo constant("รายละเอียดข้อร้องเรียน")?>" required
                            <?php echo $_POST['detail'] = isset($_POST['detail']) ?  " value='".$_POST['detail']."' readonly"  : "";?>></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1"
                                class="text-primary h5 Regular"><?php echo constant("เอกสารประกอบข้อร้องเรียน")?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="copyOfDelegate" type="checkbox"
                                    id="copyOfDelegate" value="copyOfDelegate" onclick="validate()">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้ร้องเรียนแทน</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-copyOfDelegate1" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-copyOfDelegate1" />
                                <label class="custom-file-label" for="input-copyOfDelegate1">Choose file</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-copyOfDelegate2" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-copyOfDelegate2" />
                                <label class="custom-file-label" for="input-copyOfDelegate2">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="copyOfOwner" type="checkbox" id="copyOfOwner"
                                    value="copyOfOwner" onclick="validate()">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-copyOfOwner1" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-copyOfOwner1" />
                                <label class="custom-file-label" for="input-copyOfOwner1">Choose file</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-copyOfOwner2" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-copyOfOwner2" />
                                <label class="custom-file-label" for="input-copyOfOwner2">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="powerOfAttorney" type="checkbox"
                                    id="powerOfAttorney" value="powerOfAttorney" onclick="validate()">
                                <label class="form-check-label" for="inlineCheckbox1">หนังสือมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-powerOfAttorney1" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-powerOfAttorney1" />
                                <label class="custom-file-label" for="input-powerOfAttorney1">Choose file</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-powerOfAttorney2" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-powerOfAttorney2" />
                                <label class="custom-file-label" for="input-powerOfAttorney2">Choose file</label>
                            </div>
                        </div>
                    </div>

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
                            <input type="submit"
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

// ---------------------------------Custom Input File------------------------------------

$('#input-copyOfDelegate1').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
    document.getElementById('file-copyOfDelegate2').style.display = 'flex';
})

$('#input-copyOfDelegate2').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

// --------------------------------------------

$('#input-copyOfOwner1').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
    document.getElementById('file-copyOfOwner2').style.display = 'flex';
})

$('#input-copyOfOwner2').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

// --------------------------------------------

$('#input-powerOfAttorney1').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
    document.getElementById('file-powerOfAttorney2').style.display = 'flex';
})

$('#input-powerOfAttorney2').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

// -------------------------------------------------------------------------------------

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

function validate() {
    if (document.getElementById('copyOfDelegate').checked) {
        if(document.getElementById("input-copyOfDelegate1").files.length != 0){
            document.getElementById('file-copyOfDelegate2').style.display = 'flex';
        }
        document.getElementById('file-copyOfDelegate1').style.display = 'flex';
    } else {
        document.getElementById('file-copyOfDelegate1').style.display = 'none';
        document.getElementById('file-copyOfDelegate2').style.display = 'none';
    }

    if (document.getElementById('copyOfOwner').checked) {
        if(document.getElementById("input-copyOfOwner1").files.length != 0){
            document.getElementById('file-copyOfOwner2').style.display = 'flex';
        }
        document.getElementById('file-copyOfOwner1').style.display = 'flex';
    } else {
        document.getElementById('file-copyOfOwner1').style.display = 'none';
        document.getElementById('file-copyOfOwner2').style.display = 'none';
    }

    if (document.getElementById('powerOfAttorney').checked) {
        if(document.getElementById("input-powerOfAttorney1").files.length != 0){
            document.getElementById('file-powerOfAttorney2').style.display = 'flex';
        }
        document.getElementById('file-powerOfAttorney1').style.display = 'flex';
    } else {
        document.getElementById('file-powerOfAttorney1').style.display = 'none';
        document.getElementById('file-powerOfAttorney2').style.display = 'none';
    }
}
</script>