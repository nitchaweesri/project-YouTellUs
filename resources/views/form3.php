<div class="container-sm">
    <div class="container mb-4 shadow-lg p-3 mb-5 bg-white rounded pd-top">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-5 pt-md-5">
                <form
                    action="<?php echo isset($_POST['name']) ?  "../../src/views/thanks.php"  : "../../src/views/form3.php";?>"
                    method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col">
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
                        <input type="text" class="form-control" name="tel" id="tel"
                            placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้" required
                            <?php echo $_POST['tel'] = isset($_POST['tel']) ?  " value='".$_POST['tel']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="mail" id="mail" placeholder="E-mail Address"
                            required
                            <?php echo $_POST['mail'] = isset($_POST['mail']) ?  " value='".$_POST['mail']."' readonly"  : "";?>>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1" class="text-primary h5 Regular">เรื่องร้องเรียน</label>
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
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameOwner" id="nameOwner"
                            placeholder="ชื่อลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น" required
                            <?php echo $_POST['nameOwner'] = isset($_POST['nameOwner']) ?  " value='".$_POST['nameOwner']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group mt-2">
                        <textarea class="form-control" name="detail" id="detail" rows="4"
                            placeholder="รายละเอียดข้อร้องเรียน" required
                            <?php echo $_POST['detail'] = isset($_POST['detail']) ?  " value='".$_POST['detail']."' readonly"  : "";?>></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1" class="text-primary h5 Regular">เอกสารประกอบข้อร้องเรียน</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="copyOfOwner" id="copyOfOwner"
                                    value="copyOfOwner" onclick="validate()">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้มีอำนาจลงนาม</label>
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
                                <input class="form-check-input" type="checkbox" name="copyOfDelegate"
                                    id="copyOfDelegate" value="copyOfDelegate" onclick="validate()">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ</label>
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
                                <input class="form-check-input" type="checkbox" name="companyCertificate"
                                    id="companyCertificate" value="companyCertificate" onclick="validate()">
                                <label class="form-check-label" for="inlineCheckbox1">สำเนาหนังสือรับรองนิติบุคคล
                                    (อายุไม่เกิน 6 เดือน)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-companyCertificate1" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-companyCertificate1" />
                                <label class="custom-file-label" for="input-companyCertificate1">Choose file</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-file" id="file-companyCertificate2" style="display: none;">
                                <input type="file" class="custom-file-input" id="input-companyCertificate2" />
                                <label class="custom-file-label" for="input-companyCertificate2">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="powerOfAttorney"
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

// -------------------------------------------------------------------------------------

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

$('#input-companyCertificate1').on('change', function() {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
    document.getElementById('file-companyCertificate2').style.display = 'flex';
})

$('#input-companyCertificate2').on('change', function() {
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

function validate() {
    if (document.getElementById('copyOfOwner').checked) {
        if(document.getElementById("input-copyOfOwner1").files.length != 0){
            document.getElementById('file-copyOfOwner2').style.display = 'flex';
        }
        document.getElementById('file-copyOfOwner1').style.display = 'flex';
    } else {
        document.getElementById('file-copyOfOwner1').style.display = 'none';
        document.getElementById('file-copyOfOwner2').style.display = 'none';
    }

    if (document.getElementById('copyOfDelegate').checked) {
        if(document.getElementById("input-copyOfDelegate1").files.length != 0){
            document.getElementById('file-copyOfDelegate2').style.display = 'flex';
        }
        document.getElementById('file-copyOfDelegate1').style.display = 'flex';
    } else {
        document.getElementById('file-copyOfDelegate1').style.display = 'none';
        document.getElementById('file-copyOfDelegate2').style.display = 'none';
    }

    if (document.getElementById('companyCertificate').checked) {
        if(document.getElementById("input-companyCertificate1").files.length != 0){
            document.getElementById('file-companyCertificate2').style.display = 'flex';
        }
        document.getElementById('file-companyCertificate1').style.display = 'flex';
    } else {
        document.getElementById('file-companyCertificate1').style.display = 'none';
        document.getElementById('file-companyCertificate2').style.display = 'none';
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