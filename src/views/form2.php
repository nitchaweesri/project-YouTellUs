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
                <form action="form2-submit" method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">ข้อมูลส่วนตัว</h5>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ-สกุลของลูกค้า" required
                        <?php echo $_POST['name'] = isset($_POST['name']) ?  " value='".$_POST['name']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="idcard" id="idcard" placeholder="หมายเลขบัตรประชาชนของลูกค้า" required
                        <?php echo $_POST['idcard'] = isset($_POST['idcard']) ?  " value='".$_POST['idcard']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameDelegate" id="nameDelegate"
                            placeholder="ชื่อ-สกุลของผู้ร้องเรียนแทน" required
                        <?php echo $_POST['nameDelegate'] = isset($_POST['nameDelegate']) ?  " value='".$_POST['nameDelegate']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="tel" id="tel" placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้" required
                        <?php echo $_POST['tel'] = isset($_POST['tel']) ?  " value='".$_POST['tel']."' readonly"  : "";?>>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="mail" id="mail" placeholder="E-mail Address" required
                        <?php echo $_POST['mail'] = isset($_POST['mail']) ?  " value='".$_POST['mail']."' readonly"  : "";?>>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">เรื่องร้องเรียน</h5>
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
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="parent" value="parent">
                                <label class="form-check-label" for="inlineCheckbox1">บิดา/มารดา</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="attorney" value="attorney">
                                <label class="form-check-label" for="inlineCheckbox2">ผู้รับมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="child" value="child">
                                <label class="form-check-label" for="inlineCheckbox1">บุตร</label>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="other" value="other">
                                <label class="form-check-label" for="inlineCheckbox2">อื่น ๆ (โปรดระบุ)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="relationOptions" type="checkbox" id="relative" value="relative">
                                <label class="form-check-label" for="inlineCheckbox1">ญาติ / พี่น้อง</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <textarea class="form-control" id="detail" rows="3" name="detail" placeholder="รายละเอียดข้อร้องเรียน" required
                        <?php echo $_POST['detail'] = isset($_POST['detail']) ?  " value='".$_POST['detail']."' readonly"  : "";?>></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">เอกสารประกอบข้อร้องเรียน</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="copyOfDelegate" type="checkbox" id="copyOfDelegate"
                                    value="copyOfDelegate">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้ร้องเรียนแทน</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="copyOfOwner" type="checkbox" id="copyOfOwner" value="copyOfOwner">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" name="powerOfAttorney" type="checkbox" id="powerOfAttorney"
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
                                <input id="file-input" name="file1" type="file" />
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
                                <input id="file-input" name="file2" type="file" />
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
                                <input id="file-input" name="file3" type="file" />
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
                                <input id="file-input" name="file4" type="file" />
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
    </script>
</body>

</html>