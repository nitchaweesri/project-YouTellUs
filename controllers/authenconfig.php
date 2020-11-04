<?php

/* -----------------------------------------------------------------------
 * lineconfig.php
 * -----------------------------------------------------------------------
 * Purpose : SCB channel account aulthen configuration file
 * Author  : Kittikorn  poonporn <kittikorn@tellvoice.com>
 * Created : 27 Aug 2019
 * History :
 *  27 Aug 2019 - Create file
 * -----------------------------------------------------------------------
 */

define('VALID_PASSWORDS', array ("tvss" => "password"));
define('VALID_USER',array_keys(VALID_PASSWORDS));
define('LINECHANNELID', 'SCB_CONNECT');

define('URLHOSTEAPI', 'https://intapigw-sit.se.scb.co.th:8448/');
define('URLHOSTPORTEAPI', 'http://10.254.113.233:8080/');

define('RMID_PREFIX', '0014');
define('LENGTHRMID', 30);

define('API_KEY_EAPI', 'l7xx1d3a0487b45d4203a5648642972aec1b');
define('API_SECRET_EAPI', '45e3a95d80204b88a7c5491c0e52d425');
define('SOURCE_SYSTEM', 'TVSS');
define('EVENT_CODE', '00500301');
define('EVENT_DESC', 'Customer Contact');
define('TOPIC_STRING', 'SCB/EVENT/CUSTOMERSERVICE/CASEMANAGEMENT/NONVOICECHANNEL');

define('MESSAGEOTP', 'ใช้ <OTP $OTP> <Ref. $PAC> ใน 3 นาที ห้ามบอก OTP นี้แก่ผู้อื่นไม่ว่ากรณีใด');

define('MASTER_FEEDTYPE', array('LN' => 'Line', 'FB' => 'Facebook', 'PT' => 'Pantip', 'TT' => 'Twitter', 'EM' => 'Email', 'IG' => 'Instagram', 'YT' => 'Youtube'));
define('MASTER_FEEDSUBTYPE', array('ME' => 'Inbox',
                              'CM' => 'Comment',
                              'CR' => 'Subcomment',
                              'HT' => 'Hashtag',
                              'EM' => 'EMAIL',
                              'KW' => 'Keyword',
                              'MT' => 'Mention',
                              'FP' => 'Post',
                              'PT' => 'Post',
                              'YP' => 'Post',
                              'IP' => 'Post'));

?>
