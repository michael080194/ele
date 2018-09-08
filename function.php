<?php
include_once "function_sql.php";
include_once "function_search.php";
include_once "function_upload.php";
#####################################################################################
#  kyc 上傳檔案
####################################################################################
function kycGenDir(){
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"]; 
    $dir = "uploads/".$comp_id.$fact_id; 
    mk_dir($dir);
    $dir = "uploads/".$comp_id.$fact_id."/prod"; 
    mk_dir($dir);  
    $dir = "uploads/".$comp_id.$fact_id."/fix"; 
    mk_dir($dir);  
    $dir = "uploads/".$comp_id.$fact_id."/prod/pic"; 
    mk_dir($dir);  
    $dir = "uploads/".$comp_id.$fact_id."/prod/thumb"; 
    mk_dir($dir);  
    $dir = "uploads/".$comp_id.$fact_id."/prod/file"; 
    mk_dir($dir);      
    $dir = "uploads/".$comp_id.$fact_id."/fix/pic"; 
    mk_dir($dir);  
    $dir = "uploads/".$comp_id.$fact_id."/fix/thumb"; 
    mk_dir($dir);  
    $dir = "uploads/".$comp_id.$fact_id."/fix/file"; 
    mk_dir($dir);                        
}
#####################################################################################
#  建立目錄
#####################################################################################
if (!function_exists("mk_dir")) {
  function mk_dir($dir = "") {
    #若無目錄名稱秀出警告訊息
    if (empty($dir)) {
      return;
    }

    #若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
      umask(000);
      //若建立失敗秀出警告訊息
      mkdir($dir, 0777);
    }
  }
}
########################################
# 得到類別選項
########################################
function get_kind_prod_option($sub_kind="" , $sub_str="")
{
  global $xoopsDB;
  $tbl='kyc_repair_00_kinds';
  $sql="SELECT * FROM `{$tbl}` WHERE `kind` = '{$sub_kind}' ORDER BY sort";


  $result = sqlExcuteForSelectData($sql);
  $options="";
  $first="YES";
  while($datas=sqlFetch_assoc($result) ){
    $str1 = kyc_htmlSpecialChars($datas['desc']);
    if($first == "YES"){ 
       $emptyStr="";
       $selected = ($emptyStr == $sub_str)?" selected":"";
       $options .="<option value='{$emptyStr}'{$selected}>{$emptyStr}</option>\n";
       $first="NO";
    }
    $selected = ($str1 == $sub_str)?" selected":"";
    $options .="<option value='{$str1}'{$selected}>{$str1}</option>\n";
  }
  return $options;
}
########################################
# 得到類別選項
########################################
function get_kind_chinese($kind="")
{
  switch ($kind) {
      case "BRAND":
          return "產品廠牌";
          break;   
      case "C_TYPE":
          return "產品類別";
          break;     
      default:
          return "類別不明";
          break;
  }
}
########################################################################
//檢查並傳回欲拿到資料使用的變數
########################################################################
function clean_var($var = '', $title = '', $filter = '')
{
    global $xoopsDB;
    $clean_var = $xoopsDB->real_escape_string($_REQUEST[$var]);

    if (empty($title)) {
        return $clean_var;
    }

    if (empty($clean_var)) {
        throw new Exception("{$title}為必填！");
    }
    if ($filter) {
        $clean_var = filter_var($clean_var, $filter);
        if (!$clean_var) {
            throw new Exception("不合法的{$title}");
        }
    }
    return $clean_var;
}
########################################################################
//檢查並傳回欲拿到資料使用的變數
########################################################################
function kyc_htmlSpecialChars($var = '')
{
  global $xoopsDB;
  return htmlSpecialChars($var);
}
########################################################################
//檢查並傳回欲拿到資料使用的變數
########################################################################
function kyc_filter_var($var = '')
{
  global $xoopsDB;
  return $xoopsDB->real_escape_string($var);
}
########################################################################
//檢查並傳回欲拿到資料使用的變數
########################################################################
function system_CleanVars(&$global, $key, $default = '', $type = 'int')
{
    switch ($type) {
        case 'array':
            $ret = (isset($global[$key]) && is_array($global[$key])) ? $global[$key] : $default;
            break;
        case 'date':
            $ret = isset($global[$key]) ? strtotime($global[$key]) : $default;
            break;
        case 'string':
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
            break;
        case 'int':
        default:
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
            break;
    }
    if ($ret === false) {
        return $default;
    }

    return $ret;
}
########################################################################
function addSlashes_var($var = '')
{
    $var = addSlashes($var);
    return $var;
}

########################################################################
function tw_dc_date($twdate = '')
{
    $strlen = strlen($twdate);
    $wkyy   = "0000";
    $wkmm   = "00";
    $wkdd   = "00";
    //民國年轉西元年
    if ($strlen == 6) {
        $wkyy = substr($twdate, 0, 2) + 1911;
        $wkmm = substr($twdate, 2, 2);
        $wkdd = substr($twdate, 4, 2);
    }
    if ($strlen == 7) {
        $wkyy = substr($twdate, 0, 3) + 1911;
        $wkmm = substr($twdate, 3, 2);
        $wkdd = substr($twdate, 5, 2);
    }
    $date = new DateTime($wkyy . "-" . $wkmm . "-" . $wkdd);
    return $date->format("Y-m-d ");
}
###############################################################################
#  轉向函數
###############################################################################
function redirect_header($url = "", $time = 3000, $message = '已轉向！！',$error='') {
  $_SESSION['redirect'] = "\$.jGrowl('{$message}', {  life:{$time} , position: 'center', speed: 'slow' });";
  $_SESSION['error'] = $error ? $message :"";
  $url = $error ?  "message.php":$url;
  header("location:{$url}");
  exit;
}
########################################################################
//Show Message By Exception
########################################################################
function kyc_show_msg($msg = '')
{
    throw new Exception($msg);  
}
########################################################################
//Show Message By sweetAlert
########################################################################
function kyc_show_msg_js($msg = '')
{
    echo "<script type='text/javascript'>sweetAlert('" . $msg ."');</script>";    
}
########################################################################
#  產生訊息檔,以供 debug
########################################################################
function genMsgFile($fileName="msg",$fileType="txt",$msgText="") {
 // genMsgFile("op_home","txt",print_r($homes, true)); array
 // genMsgFile("op_home","json",$json);
 // genMsgFile("op_static_sn","txt",$_POST['sn']);
 $file = "uploads/".$fileName.strtotime("now").".".$fileType;
 $f = fopen($file, 'w'); //以寫入方式開啟文件
 fwrite($f, $msgText); //將新的資料寫入到原始的文件中
 fclose($f);
}

#################
if (!function_exists('kyc_get_url')) {
    function kyc_get_url()
    {
        $http = 'http://';
        if (!empty($_SERVER['HTTPS'])) {
            $http = ($_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        }

            //$u = parse_url($http . $_SERVER["HTTP_HOST"] . $port . $_SERVER['REQUEST_URI']);
            $u = parse_url($http . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI']);
            /*
            $_SERVER["HTTP_HOST"] 本身就會有 port 資料 ，如 localhost:8080
            如果是正常 port 80 443 等，網址本身就無須再多加 port 號

             */
            if (!empty($u['path']) and preg_match('/\/modules/', $u['path'])) {
                $XMUrl = explode("/modules", $u['path']);
            } elseif (!empty($u['path']) and preg_match('/\/themes/', $u['path'])) {
                $XMUrl = explode("/themes", $u['path']);
            } elseif (!empty($u['path']) and preg_match('/\/upgrade/', $u['path'])) {
                $XMUrl = explode("/upgrade", $u['path']);
            } elseif (!empty($u['path']) and preg_match('/\/include/', $u['path'])) {
                $XMUrl = explode("/include", $u['path']);
            } elseif (!empty($u['path']) and preg_match('/.php/', $u['path'])) {
                $XMUrl[0] = dirname($u['path']);
            } elseif (!empty($u['path'])) {
                $XMUrl[0] = $u['path'];
            } else {
                $XMUrl[0] = "";
            }

            $my_url = str_replace('\\', '/', $XMUrl['0']);
            if (substr($my_url, -1) == '/') {
                $my_url = substr($my_url, 0, -1);
            }

            $port = isset($u['port']) ? ":{$u['port']}" : '';
            /*
            如果有切出 port 號，在前面加入 : 號，傳出網址

             */

            $url = "{$u['scheme']}://{$u['host']}$port{$my_url}";

            return $url;
}
}
