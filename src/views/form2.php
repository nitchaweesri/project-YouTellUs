<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>
<style>
p,
label,
input,
button,
textarea {
    font-family: 'Mitr-Light', Fallback, sans-serif;
}

h5 {
    font-family: 'Mitr-Regular', Fallback, sans-serif;
}
</style>

<body>
    <?php include 'navbar.php';?>
    <div style="height:80px"></div>
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 col-sm-12 ">
                <form class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">ข้อมูลส่วนตัว</h5>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" placeholder="ชื่อ-สกุลของลูกค้า" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="idcard" placeholder="หมายเลขบัตรประชาชนของลูกค้า" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nameDelegate"
                            placeholder="ชื่อ-สกุลของผู้ร้องเรียนแทน" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="tel" placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="mail" placeholder="E-mail Address" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">เรื่องร้องเรียน</h5>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="service"
                            placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="serviceID"
                            placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน" required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="text-left">ความสัมพันธ์ของท่านและเจ้าของหมายเลขบัญชีข้างต้น</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="parent">
                                <label class="form-check-label" for="inlineCheckbox1">บิดา/มารดา</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="attorney">
                                <label class="form-check-label" for="inlineCheckbox2">ผู้รับมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="child">
                                <label class="form-check-label" for="inlineCheckbox1">บุตร</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="other">
                                <label class="form-check-label" for="inlineCheckbox2">อื่น ๆ (โปรดระบุ)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="relative">
                                <label class="form-check-label" for="inlineCheckbox1">ญาติ / พี่น้อง</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <textarea class="form-control" id="detail" rows="3"
                            placeholder="รายละเอียดข้อร้องเรียน" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">เอกสารประกอบข้อร้องเรียน</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="copyOfDelegate"
                                    value="copyOfDelegate">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้ร้องเรียนแทน</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="copyOfOwner" value="copyOfOwner">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="powerOfAttorney"
                                    value="powerOfAttorney">
                                <label class="form-check-label" for="inlineCheckbox1">หนังสือมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <p class="text-primary text-left">แนบเอกสารประกอบ</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="image-upload">
                                <label for="file-input" class="btn btn-primary col">
                                    <div class="row justify-content-center">
                                        <img src="public/img/upload.png" width="22px" class="white-img mb-1" />
                                    </div>
                                    <div class="row justify-content-center">
                                        <h7 class="text-white">upload</h7>
                                    </div>
                                </label>
                                <input id="file-input" type="file" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="image-upload">
                                <label for="file-input" class="btn btn-primary col">
                                    <div class="row justify-content-center">
                                        <img src="public/img/upload.png" width="22px" class="white-img mb-1" />
                                    </div>
                                    <div class="row justify-content-center">
                                        <h7 class="text-white">upload</h7>
                                    </div>
                                </label>
                                <input id="file-input" type="file" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="image-upload">
                                <label for="file-input" class="btn btn-primary col">
                                    <div class="row justify-content-center">
                                        <img src="public/img/upload.png" width="22px" class="white-img mb-1" />
                                    </div>
                                    <div class="row justify-content-center">
                                        <h7 class="text-white">upload</h7>
                                    </div>
                                </label>
                                <input id="file-input" type="file" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="image-upload ">
                                <label for="file-input" class="btn btn-primary col">
                                    <div class="row justify-content-center">
                                        <img src="public/img/upload.png" width="22px" class="white-img mb-1" />
                                    </div>
                                    <div class="row justify-content-center">
                                        <h7 class="text-white">upload</h7>
                                    </div>
                                </label>
                                <input id="file-input" type="file" />
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
                        <div class="col d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary rounded-pill">ยอมรับและส่งข้อร้องเรียน</button>
                        </div>
                    </div>
                </form>
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
    </script>
</body>

</html>