
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php';?>

<body>
<?php include 'navbar.php';?>
<div style="height:80px"></div>
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 col-sm-12 ">
        <form action="data1" method="post">
            <div class="form-group">
                <label for="exampleFormControlInput1" class="text-primary h5 Regular">ข้อมูลส่วนตัว</label>
                <input name="name" type="text" class="form-control Light" id="name"  placeholder="ชื่อ - สกุล">
            </div>
            <div class="form-group">
                <input name="idcard" type="tell" id="idcard" maxlength="13" class="form-control Light" placeholder="หมายเลขบัตรประชาชน" required>
            </div>
            <div class="form-group">
                <input name="tell" type="tell" class="form-control Light" id="exampleFormControlInput1" placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้">
            </div>
            <div class="form-group">
                <input name="email" type="email" class="form-control Light" id="exampleFormControlInput1" placeholder="E-mail Address">
            </div>

            <div class="form-group mt-4">
                <label for="exampleFormControlInput1" class="text-primary h5 Regular">เรื่องร้องเรียน</label>
                <input type="email" class="form-control Light" id="exampleFormControlInput1" placeholder="ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน">
            </div>
            <div class="form-group">
                <input type="email" class="form-control Light" id="exampleFormControlInput1" placeholder="หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน">
            </div>
            <div class="form-group">
                <textarea rows="4" class="form-control Light" id="validationTextarea" placeholder="รายละเอียดข้อร้องเรียน" ></textarea>
            </div>

            <div class="form-group mt-4">
                <label for="exampleFormControlInput1" class="text-primary h5 Regular">เอกสารประกอบข้อร้องเรียน</label>
                <label for="exampleFormControlInput1" class="text-primary h6 Regular">แนบเอกสารประกอบ</label>
                <div class="row">
                    <div class="col">
                        <div class="image-upload">
                            <label for="file-input" class="btn btn-primary col">
                                <div class="row justify-content-center">
                                    <img src="public/img/upload.png" width="22px" class="white-img mb-1"/>
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
                                    <img src="public/img/upload.png" width="22px" class="white-img mb-1"/>
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
                                    <img src="public/img/upload.png" width="22px" class="white-img mb-1"/>
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
                                    <img src="public/img/upload.png" width="22px" class="white-img mb-1"/>
                                </div>
                                <div class="row justify-content-center">
                                    <h7 class="text-white">upload</h7>
                                </div>
                            </label>
                            <input id="file-input" type="file" />
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row mt-4">
                <div class="col">
                    <h6 class="ExtraLight">
                    *ข้อร้องเรียนของท่านจะถูกส่งเข้าระบบในวันทำการถัดไป และธนาคารจะใช้ระยะเวลาดำเนินการในการตอบกลับข้อร้องเรียนของท่านภายใน 15 วันทำการนับจากวันที่ข้อร้องเรียนเข้าสู่ระบบ โดยธนาคารจะติดต่อกลับท่านในช่วงวันและเวลาทำการของธนาคาร 
หากท่านต้องการติดต่อธนาคารกรณีเร่งด่วน กรุณาติดต่อศูนย์บริการลูกค้า 02-777-7777

                    </h6>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col ">
                    <input type="submit" class="btn btn-primary rounded-pill d-flex justify-content-center Regular col-12" value="ยอมรับและส่งข้อร้องเรียน">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('#idcard').on('keyup',function(){
            if($.trim($(this).val()) != '' && $(this).val().length == 13){
            id = $(this).val().replace(/-/g,"");
            var result = Script_checkID(id);
            if(result === false){
                $('#idcard').removeClass('is-valid').addClass('is-invalid');
            }else{
                $('#idcard').removeClass('is-invalid').addClass('is-valid');
            }
            }else{
            $('span.error').removeClass('true').text('');
            }
        })
    });

    function Script_checkID(id){
        if(! IsNumeric(id)) return false;
        if(id.substring(0,1)== 0) return false;
        if(id.length != 13) return false;
        for(i=0, sum=0; i < 12; i++)
            sum += parseFloat(id.charAt(i))*(13-i);
        if((11-sum%11)%10!=parseFloat(id.charAt(12))) return false;
        return true;
    }
    function IsNumeric(input){
        var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
        return (RE.test(input));
    }
</script>

</body>
</html>








