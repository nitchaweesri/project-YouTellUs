<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>

<body>
    <?php include 'navbar.php';?>
    <div style="height:80px"></div>
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 col-sm-12 ">
                <form>
                    <div class="row">
                        <div class="col">
                            <h3 class="text-primary text-left">ข้อมูลนิติบุคคล</h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" placeholder="ชื่อบริษัท/ห้างหุ้นส่วน/องค์กร">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="numID" placeholder="เลขจดทะเบียนนิติบุคคล">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nameAuthorizedPerson"
                            placeholder="ชื่อ-สกุลผู้มีอำนาจลงนาม">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="position" placeholder="ตำแหน่ง">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="tel" placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="mail" placeholder="E-mail Address">
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3 class="text-primary text-left">เรื่องร้องเรียน</h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="service" placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="serviceID"
                            placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nameOwner"
                            placeholder="ชื่อลูกค้า/เจ้าของหมายเลขบัญชีข้างต้น">
                    </div>
                    <div class="form-group mt-2">
                        <textarea class="form-control" id="detail" rows="4"
                            placeholder="รายละเอียดข้อร้องเรียน"></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3 class="text-primary text-left">เอกสารประกอบข้อร้องเรียน</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="copyOfOwner" value="copyOfOwner">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้มีอำนาจลงนาม</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="copyOfDelegate" value="copyOfDelegate">
                                <label class="form-check-label"
                                    for="inlineCheckbox1">สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="powerOfAttorney" value="powerOfAttorney">
                                <label class="form-check-label" for="inlineCheckbox1">สำเนาหนังสือรับรองนิติบุคคล (อายุไม่เกิน 6 เดือน)</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="powerOfAttorney" value="powerOfAttorney">
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
                        <div class="col-3">
                            <div class="custom-file">
                                <input type="file1" class="custom-file-input" id="file1">
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="custom-file">
                                <input type="file2" class="custom-file-input" id="file2">
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="custom-file">
                                <input type="file3" class="custom-file-input" id="file3">
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="custom-file">
                                <input type="file4" class="custom-file-input" id="file4">
                                <label class="custom-file-label" for="customFile"></label>
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


</body>

</html>