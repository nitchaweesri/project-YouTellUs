<style>
@media (min-width: 1025px) and (max-width: 1960px) {
    .container {
        padding: 0px 306px !important;
    }
}

@media (min-width: 768px) and (max-width: 1024px) {
    .container {
        padding: 0px 210px !important;
    }
}

@media (min-width: 320px) and (max-width: 767px) {}
</style>

<div class="container mb-4 p-4 mb-5 bg-white rounded pd-top">
    <form action="index.php?page=2" method="post" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="exampleInputEmail1">กรอกรหัส OTP</label>
            <input type="text" class="form-control" id="tell" placeholder="รหัส OTP" required>
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-center">
                <button type="submit" class="btn btn-primary rounded-pill  Regular col-12">ส่งรหัส OTP</button>
            </div>
        </div>
    </form>
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