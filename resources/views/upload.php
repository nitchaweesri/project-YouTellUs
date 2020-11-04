<style>
button {
    font-family: 'Mitr-Regular';
}

.topic {
    font-family: 'Mitr-Medium';
    font-size: 20px;
    margin: 0;
}

.detail {
    font-family: 'Mitr-Light';
    font-size: 14px;
}

.form-list {
    border-bottom: 1px solid #cecece;
    padding-bottom: 25px;
    padding-top: 12px;
}
</style>


<div class="container p-3 mb-5 bg-white pd-top">
    <form>
        <div class="form-list">
            <p class="topic text-primary">CC-041163-นพดล</p>
            <p class="detail text-primary">กรุณาอัพโหลดสำเนาบัตรประชาชน</p>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
        </div>
        <div>
            <p class="topic text-primary">PL-011163-นพดล</p>
            <p class="detail text-primary">กรุณาอัพโหลดสำเนาเอกสารเพิ่มเติม</p>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">อัพโหลด</button>
        </div>
    </form>

</div>