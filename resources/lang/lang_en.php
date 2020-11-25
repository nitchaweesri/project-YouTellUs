<?php 
/////verify/////////
define('หมายเลขโทรศัพท์สำหรับรับรหัส OTP','Telephone number for receiving OTP');
define('ส่งรหัส OTP','sent OTP');
define('หมายเลขโทรศัพท์','Phone number');
define('คุณไม่ใส่ OTP ในระยะเวลาที่กำหนด กรุณาทำรายการใหม่อีกครั้ง','You did not enter the OTP for the specified period. Please try again.');


/////otp/////////
define('กรอกรหัส OTP','Enter OTP');
define('รหัส OTP','OTP');
define('ส่งรหัส OTP ใหม่อีกครั้ง','Resend OTP');
define('โปรดใส่รหัสก่อน','Enter code before');
define('วินาที','seconds');
define('รหัส OTP ไม่ถูกต้อง','Invalid OTP');

/////memuUpload////

define('อัพโหลดไฟล์เอกสาร','Upload');
define('ร้องเรียน','Report');


/////memu//
define('กรุณาระบุประเภทการร้องเรียน','Please specify your complaint type');
define('ร้องเรียนทั่วไป','General complaints');
define('ร้องเรียนแทนบุคคลอื่น','Complain on behalf of another person');
define('ร้องเรียนในนามนิติบุคคล','Complaint on behalf of a juristic person');


///form///
define('ข้อมูลส่วนตัว','Personal information');
define('ชื่อ','Name');
define('นามสกุล','Surname');
define('หมายเลขบัตรประชาชน','ID card number');
define('หมายเลขโทรศัพท์ที่ติดต่อได้','Tel');
define('อีเมล','E-mail Address');
define('รายละเอียดข้อร้องเรียน','Detail');
define('เอกสารประกอบข้อร้องเรียน','Attachment');
define('เรื่องร้องเรียน','Complaint Details');
define('หมายเลขบัญชีผลิตภัณฑ์ที่ต้องการร้องเรียน','Account Number (related to the complaint)');
define('ระบุ','specify');
define('บิดา/มารดา','parent');
define('ผู้รับมอบอำนาจ','attorney');
define('บุตร','child');
define('อื่น ๆ (โปรดระบุ)','other');
define('ญาติ / พี่น้อง','relative');
define('ระบุได้อีก','');
define('ตัวอักษร',' characters left');
define('หมายเหตุ: คำร้องหลัง 17.00 น. จะถูกส่งเข้าระบบในวันทำการถัดไป','Remark: Complaint submitted after 17.00 hrs will be uploaded into the system on the next business day.');
define('ธนาคารจะใช้ระยะเวลาดำเนินการในการตอบกลับคำร้องของท่านภายใน 15 วันนับจากวันที่ธนาคารได้รับเอกสารครบถ้วนและได้นำข้อร้องเรียนของท่านเข้าสู่ระบบ โดยธนาคารจะติดต่อกลับท่านในช่วงวันและเวลาทำการของธนาคาร หากท่านต้องการติดต่อธนาคารกรณีเร่งด่วน กรุณาติดต่อศูนย์บริการลูกค้า 02-777-7777','SCB will respond to your complaint within 15 days starting from the day that SCB completely receives the required documents and your complaint is uploaded to the system. SCB will contact you on working days during business hours. 
If you need urgent assistance, please contact the SCB Customer Center at 02-777-7777.');
define('ส่งเรื่องร้องเรียน','Submit Complaint');

///form-behalf of others///
define('ชื่อ-สกุลผู้รับมอบอำนาจ','Full Name of Attorney-in-Fact');
define('ผลิตภัณฑ์หรือบริการที่ต้องการร้องเรียน','Product or service (related to the complaint)');
define('โปรดระบุความสัมพันธ์ของท่านต่อเจ้าของบัญชี','Please specify your relationship to the account owner');
define('ข้อมูลทั่วไป','General Information');

///form-juristic person///
define('ชื่อบริษัท/ห้างหุ้นส่วน/องค์กร','Name of Company / Partnership / Organization');
define('เลขจดทะเบียนนิติบุคคล','Registration Number (Juristic Person)');
define('ชื่อ-สกุลผู้มีอำนาจลงนาม','Full Name of Authorized Person');
define('ตำแหน่งผู้มีอำนาจลงนาม','Job Position of Authorized Person');

define('หมายเลขบัตรประชาชนผู้มีอำนาจลงนาม','Passport Number of Authorized Person (ID Card for Thai citizen)');
define('ชื่อ-สกุลผู้รับมอบอำนาจลงนาม','Full Name of Attorney-in-Fact');
define('หมายเลขบัตรประชาชนผู้รับมอบอำนาจลงนาม','Passport Number of Attorney-in-Fact (ID Card Number for Thai Citizen)');
define('ปัญหาที่เกิดขึ้น','Please explain what has happened');
define('สิ่งที่ต้องการให้ธนาคารดำเนินการ','Please explain how you would like SCB to proceed');



///modal///
define('ยกเลิก','Cancel');
define('ยืนยัน','Comfirm');
define('มี','Yes');
define('ไม่มี','No');
define('ท่านมีสำเนาบัตรประจำตัวประชาชนเพื่อใช้ประกอบข้อร้องเรียนหรือไม่','Do you have the following documents for filing a complaint?');
define('สำเนาบัตรประจำตัวประชาชนของเจ้าของบัญชี','Copy of passport of account owner (ID Card for Thai citizen)');
define('สำเนาบัตรประจำตัวประชาชนของผู้รับมอบอำนาจ','Copy of passport of Attroney-in-Fact (ID Card for Thai citizen)');
define('หนังสือมอบอำนาจ','Letter of Authorization');
define('สำเนาบัตรประจำตัวประชาชนของผู้มีอำนาจลงนาม','Copy of passport of Authorized Person (ID Card for Thai citizen)');
define('สำเนาหนังสือรับรองนิติบุคคล (อายุไม่เกิน 6 เดือน)','Copy of company / partnership certificate issued within a 6-month period');
define('นโยบายความเป็นส่วนตัวธนาคารไทยพาณิชย์ จำกัด (มหาชน)','Privacy Notice The Siam Commercial Bank Public Company Limited');
define('คลิก','Click');

///condition///
define('เงื่อนไขการร้องเรียน','Term & Conditions');
define('ยอมรับและดำเนินการต่อ','Accept and continue proceed');




?>