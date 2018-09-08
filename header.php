<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "config.php";
require_once 'function.php';
require_once 'smarty/libs/Smarty.class.php';
error_reporting(E_ALL);@ini_set('display_errors', true); //設定所有錯誤都顯示

#網站實體路徑(不含 /)  Users/michaelchang/Documents/michael/php/ele
define('XOOPS_ROOT_PATH', str_replace("\\", "/", dirname(__FILE__)));

#$_SERVER["DOCUMENT_ROOT"] ==> /Users/michaelchang/Documents/michael/php
#網站URL(不含 /) http://localhost/ele
// define('XOOPS_URL', $http . $_SERVER["HTTP_HOST"] . str_replace($_SERVER["DOCUMENT_ROOT"], "", XOOPS_ROOT_PATH));
define('XOOPS_URL',kyc_get_url());
#--------- WEB -----
#程式檔名(含副檔名)
$WEB['file_name'] = basename($_SERVER['PHP_SELF']); //index.php
//basename(__FILE__)
$WEB['moduleName'] = basename(__DIR__);//ugm_p
$WEB['version'] = "1.0";
// echo __DIR__."<br>";
// echo __FILE__;die();
#除錯
$WEB['debug'] = 0;
#--------- WEB END -----
// die("url:".kyc_get_url());
//實體化
$xoopsTpl = new Smarty;
#指定左標籤定義符
$xoopsTpl->left_delimiter = "<{"; //指定左標籤
#指定左標籤定義符
$xoopsTpl->right_delimiter = "}>"; //指定右標籤
//連線資料庫
$xoopsDB = link_db();
// throw new Exception(var_dump($smarty));

$op     = isset($_REQUEST['op']) ? htmlspecialchars($_REQUEST['op'], ENT_QUOTES) : '';
$sql_op = isset($_REQUEST['sql_op']) ? htmlspecialchars($_REQUEST['sql_op'], ENT_QUOTES) : '';
$g2p = isset($_REQUEST['g2p']) ? intval($_REQUEST['g2p']) : 1; // 查詢時頁次控制
$error = $content = '';

#判斷是否登入	
$_SESSION['isUser'] = isset($_SESSION['isUser']) ? $_SESSION['isUser'] :false;
$_SESSION['isAdmin'] = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] :false;
$xoopsTpl->assign("isUser", $_SESSION['isUser']);
$xoopsTpl->assign("isAdmin", $_SESSION['isAdmin']);

#轉向頁面
$_SESSION['redirect']=isset($_SESSION['redirect'])?$_SESSION['redirect']:"";
$redirectFile = XOOPS_ROOT_PATH ."/class/jGrowl/redirect_header.tpl";
$xoopsTpl->assign("redirect", $_SESSION['redirect']);
$xoopsTpl->assign("redirectFile", $redirectFile);

$_SESSION['error'] = isset($_SESSION['error'])?$_SESSION['error']:"";
#只有管理員才能看錯誤訊息
$_SESSION['error'] = $_SESSION['isAdmin']?$_SESSION['error']:"程式發生錯誤，請聯絡管理員！";
$xoopsTpl->assign("error", $_SESSION['error']);

$_SESSION['redirect']=$_SESSION['error']="";
