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
            <div class="col-lg-8 col-md-12 col-sm-12">
                <form action="data1" method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">ข้อมูลนิติบุคคล</h5>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="ชื่อบริษัท/ห้างหุ้นส่วน/องค์กร" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="numID" id="numID"
                            placeholder="เลขจดทะเบียนนิติบุคคล" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameAuthorizedPerson" id="nameAuthorizedPerson"
                            placeholder="ชื่อ-สกุลผู้มีอำนาจลงนาม" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="position" id="position" placeholder="ตำแหน่ง"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="tel" id="tel"
                            placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="mail" id="mail" placeholder="E-mail Address"
                            required>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">เรื่องร้องเรียน</h5>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="service" id="service"
                            placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="serviceID" id="serviceID"
                            placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nameOwner" id="nameOwner"
                            placeholder="ชื่อลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น" required>
                    </div>
                    <div class="form-group mt-2">
                        <textarea class="form-control" name="detail" id="detail" rows="4"
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
                                <input class="form-check-input" type="checkbox" name="copyOfOwner" id="copyOfOwner"
                                    value="copyOfOwner">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้มีอำนาจลงนาม</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="copyOfDelegate"
                                    id="copyOfDelegate" value="copyOfDelegate">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="companyCertificate"
                                    id="companyCertificate" value="companyCertificate">
                                <label class="form-check-label" for="inlineCheckbox1">สำเนาหนังสือรับรองนิติบุคคล
                                    (อายุไม่เกิน 6 เดือน)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="powerOfAttorney"
                                    id="powerOfAttorney" value="powerOfAttorney">
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