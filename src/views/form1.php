
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
            <div class="form-group">
                <label for="exampleFormControlInput1" class="text-primary h5">ข้อมูลส่วนตัว</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="ชื่อ - สกุล">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="หมายเลขบัตรประชาชน">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="E-mail Address">
            </div>

            <div class="form-group mt-4">
                <label for="exampleFormControlInput1" class="text-primary h5">เรื่องร้องเรียน</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน">
            </div>
            <div class="form-group">
                <textarea rows="4" class="form-control" id="validationTextarea" placeholder="รายละเอียดข้อร้องเรียน" required></textarea>
            </div>

            <!-- <div class="form-group">
                <label for="exampleFormControlSelect1">Example select</label>
                <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            </div> -->
            <div class="form-group">
                <label for="exampleFormControlSelect2">Example multiple select</label>
                <select multiple class="form-control" id="exampleFormControlSelect2">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Example textarea</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            </form>
        </div>
    </div>
</div>


</body>
</html>






