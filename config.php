<?php
$admin_user = 'mi??';
$admin_pass = '52??';
define("_EVERY_PAGE", 10);
define("_EVERY_TOOLBAR", 20);
if ($_SERVER["SERVER_NAME"] == "localhost") {
    //資料庫位址
    define('_DB_LOCATON', 'localhost');
    //資料庫帳號
    define('_DB_ID', 'root');
    //資料庫密碼
    define('_DB_PASS', '??????');
    //資料庫名稱
    define('_DB_NAME', '??????');
} else {
    //資料庫位址
    define('_DB_LOCATON', 'localhost');
    //資料庫帳號
    define('_DB_ID', '??????');
    //資料庫密碼
    define('_DB_PASS', '??????');
    //資料庫名稱
    define('_DB_NAME', '???');
}
