<?php
define('SITE_NAME','takescript.in');
define('DATE_TIME',date('Y-m-d H:i:s'));
define('DATE',date('Y-m-d'));
define('TIME',date('H:i:s'));
define('USER_FLD_PATH','downloads/usr_fldrs/');
define('ADMIN_EMAIL','Takescript <admin@takescript.in>');
define('DEMO_MAX_INPUT_FIELD_VALUE','3');
define('DEMO_MAX_FORM_VALUE_PER_DAY','3');
define('DEMO_DAYS','3');


$class_path = 'classes/';
$libs_path = '/libs/';
if($_SERVER['HTTP_HOST'] == 'localhost'){
	define('DB_HOST','127.0.0.1');
	define('DB_USER','root');
	define('DB_PWD','');
	define('DB_NAME','tcode');
} else {
	define('DB_HOST','127.0.0.1');
	define('DB_USER','u808646647_tcode');
	define('DB_PWD','lamborghini&345');
	define('DB_NAME','u808646647_tcode');
}

define('CLASS_PATH',$class_path);
define('LIBS_PATH',$libs_path);