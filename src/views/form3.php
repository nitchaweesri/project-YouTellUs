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
    <div class="container mb-4 shadow-lg p-3 mb-5 bg-white rounded pd-top">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 col-sm-12 pt-lg-5 pt-md-5">
                <form action="form3-submit" method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-primary text-left">ข้อมูลนิติบุคคล</h5>
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
    
    <?php include 'footer.php';?>

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