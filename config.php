<?php 
    ////////////////////////  dev  //////////////////////////
    // if (!defined('DATABASE_HOSTNAME')) define('DATABASE_HOSTNAME', 'devscbdb01');
    // if (!defined('DATABASE_USER')) define('DATABASE_USER', 'tellvoice');
    // if (!defined('DATABASE_PASSWORD')) define('DATABASE_PASSWORD', 'eciovllet');
    // if (!defined('DATABASE_DBNAME')) define('DATABASE_DBNAME', 'scbytu_dev');
    // if (!defined('DATABASE_HOSTPORT')) define('DATABASE_HOSTPORT', '9306');
    //////////////////     localhost     //////////////////
    if (!defined('DATABASE_HOSTNAME')) define('DATABASE_HOSTNAME', 'localhost');
    if (!defined('DATABASE_USER')) define('DATABASE_USER', 'root');
    if (!defined('DATABASE_PASSWORD')) define('DATABASE_PASSWORD', '');
    if (!defined('DATABASE_DBNAME')) define('DATABASE_DBNAME', 'scbytu_dev');
    if (!defined('DATABASE_HOSTPORT')) define('DATABASE_HOSTPORT', '3306');

    if (!defined('TIME_OTP')) define('TIME_OTP', 20); // minute
    if (!defined('TIME_BLOCK_EXPIRE')) define('TIME_BLOCK_EXPIRE', 1); // minute
    if (!defined('POSSIBLE_ERROR_OTP')) define('POSSIBLE_ERROR_OTP', 3);

    
?>