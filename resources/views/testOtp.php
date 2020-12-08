
<div class="container">
    <div class="p-2 mb-5 bg-white pd-top">
        <div class="row justify-content-center ">
            <div class="col-lg-7 col-md-10 col-sm-12 pt-lg-3 pt-md-3">
                
                <form
                    action="controllers/testOtpFunc.php"
                    method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col mb-2">
                            <label for="exampleFormControlInput1" class="text-primary h2 Bold">ทดสอบ OTP</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="tel" type="tel" class="form-control Bold" id="exampleFormControlInput1" required
                            placeholder="หมายเลขโทรศัพท์ที่ติดต่อได้" 
                            <?php echo isset($_SESSION['phoneNo']) ?  " value='".$_SESSION['phoneNo']."' readonly"  : "";?>
                            pattern="^0([8|9|6])([0-9]{8}$)">
                    </div>
                    <!-- <div class="col-lg-12 col-md-12 col-sm-12 p-0" style=" display: block;">
                        <?php  if (isset($_REQUEST['msg'])){ ?>
                            <label for="exampleInputEmail1" class="text-danger txt-wrong-otp Bold"><?php echo $_REQUEST['msg'] ?></label>
                        <?php }?>
                        <a id="countdown" class="text-primary txt-count-otp Bold"></a>
                    </div> -->
                    

                    <div class="row mt-3">
                        <div class="col ">
                            <input type="submit" name="genOtp" 
                                class="btn btn-primary rounded-pill d-flex justify-content-center Bold col-12 btn-submit-form"
                                value="ส่งเรื่องร้องเรียน">
                        </div>
                    </div>
                </form>
            </div>
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


