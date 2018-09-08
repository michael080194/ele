<?php
header('Access-Control-Allow-Origin: *');//
header("Content-Type:text/html; charset=utf-8");
require_once "header.php";
#強制關除錯
// ugm_module_debug_mode(0);
// ob_end_clean(); //清除鍰衝區
/*-----------執行動作判斷區----------*/
$search_con  = isset($_REQUEST['search_con']) ? htmlspecialchars($_REQUEST['search_con'], ENT_QUOTES) : '';
// genMsgFile("xx1","txt",print_r($_POST, true)); 
switch($op){
  case "login": // 帳密檢查
    echo login();
    exit;
  case "kind_get": // 抓取產品廠牌及類別
    echo kind_get();
    exit;
  case "prod_search": // 搜尋產品資料
    echo prod_search();
    exit;
  case "prod_detail": // 單一產品詳細資料
    echo prod_detail();
    exit;
  case "scanBarcode": // 掃條碼帶出產品詳細資料
    echo prod_detail();
    exit;
  case "fix_search": // 搜尋維修資料
    echo fix_search();
    exit;
  case "fix_detail": // 單一維修詳細資料
    echo fix_detail();
    exit;
  case "fix_update": // 更新維修資料
    echo fix_update("update");
    exit;
  case "fix_insert": // 新增維修資料
    echo fix_update("insert");
    exit;
  case "fix_showPic": // 將目前維修單號己上傳圖片傳到手機
    echo fix_showPic();
    exit;
  case "fix_uploadPic": // 將目前維修單號己上傳圖片傳到手機
    echo fix_uploadPic();
    exit;
  case "fix_deletePic": // 刪除己上傳至 xoops 之圖片
    echo fix_deletePic();
    exit;
  case "get_prod": // 
    echo get_prod($search_con);
  case "kyc_get_prod_dt": // DataTable.js 專用資料查詢
    echo kyc_get_prod_dt();    
    exit;    
}

################################
# 檢查帳號、密碼是否正確
#################################
function login(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  # ---------------------------------------------------
  #此處目前 post get 都可，正式上線時，只能 POST
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);
  // genMsgFile("login3","txt",$uname."and".$pass);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $r['responseStatus'] = "SUCCESS";
    $r['responseMessage'] = "登錄成功！！";
    $r['responseArray'] = "";
  }
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 抓取產品廠牌及類別
#################################
function kind_get(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);
  // genMsgFile("login3","txt",$uname."and".$pass);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $kinds  = array();
    $kinds["c_brand"] = get_kindArray("BRAND");
    $kinds["c_type"] = get_kindArray("C_TYPE");
    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $kinds;
  }

  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 不正確返回 "FAIL"
#################################
function get_kindArray($sub_kind=""){
  global $xoopsDB;
  $tbl=$xoopsDB->prefix('kyc_repair_kinds');
  $sql="SELECT * FROM `{$tbl}` WHERE `kind` = '{$sub_kind}' ORDER BY sort";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

  $rows=array();
  $myts  = MyTextSanitizer::getInstance();
  while($datas=$xoopsDB->fetchArray($result)){
    $datas['desc'] = $myts->htmlSpecialChars($datas['desc']);
    $rows[] = $datas['desc'];
  }
  return $rows;
}
################################
# 搜尋產品資料
#################################
function prod_search(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $searchTitle  = $myts->htmlSpecialChars($_REQUEST['prod_name']);
  $searchBrand  = $myts->htmlSpecialChars($_REQUEST['c_brand']);
  $searchType  = $myts->htmlSpecialChars($_REQUEST['c_type']);
  $searchBsale  = $myts->htmlSpecialChars($_REQUEST['bsale']);
  $searchEsale  = $myts->htmlSpecialChars($_REQUEST['esale']);

  // genMsgFile("login3","txt",$uname."and".$pass);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $where = "WHERE  `enable`='1' ";
    if ($searchTitle != "") {
        $where .= "and  `description` Like '%$searchTitle%' ";
    }

    if ($searchBsale != 0) {
        $where .= "and  `sale_price` >= '$searchBsale' ";
    }

    if ($searchEsale != 0) {
        $where .= "and  `sale_price` <= '$searchEsale' ";
    }

    if ($searchBrand != "") {
        $where .= "and  `c_brand` = '$searchBrand' ";
    }

    if ($searchType != "") {
        $where .= "and  `c_type` = '$searchType' ";
    }

    $myts = MyTextSanitizer::getInstance();
    $tbl=$xoopsDB->prefix('kyc_repair_prod');
    $sql="SELECT * FROM `$tbl` $where ORDER BY `update_date` DESC";
    //送至資料庫
    $result = $xoopsDB->query($sql) or web_error($sql);
            //取回資料
    $all = array();
    $myts              = MyTextSanitizer::getInstance();
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles = new TadUpFiles("kyc_repair" , "/prod");
    while($datas=$xoopsDB->fetchArray($result)){
        $datas['content']  = $myts->displayTarea($datas['content'], 1, 0, 0, 0, 0);
        $datas['title'] = $myts->htmlSpecialChars($datas['title']);
        $TadUpFiles->set_col('prod_id', $datas['prod_id']);
        $datas['img'] = $TadUpFiles->get_pic_file('thumb');
        // $datas['img']  = XOOPS_UPLOAD_URL . "/kyc_repair/prod/thumb/thumb_".$datas['prod_id'].".png";
        $all[] = $datas;
    }

    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $all;
  }
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 單一產品詳細資料
#################################
function prod_detail(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $prod_id  = $myts->htmlSpecialChars($_REQUEST['prod_id']);
  $op       = $myts->htmlSpecialChars($_REQUEST['op']);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $tbl=$xoopsDB->prefix('kyc_repair_prod');
    if($op == "prod_detail") {
      $sql ="SELECT * FROM `$tbl` WHERE `prod_id` = '{$prod_id}'";
    } else {
      $sql ="SELECT * FROM `$tbl` WHERE `barcode` = '{$prod_id}'";
    }

    $result = $xoopsDB->query($sql) or web_error($sql);
    $all = array();
    $myts  = MyTextSanitizer::getInstance();
    while($datas=$xoopsDB->fetchArray($result)){
        $datas['content']  = $myts->displayTarea($datas['content'], 1, 0, 0, 0, 0);
        $datas['title'] = $myts->htmlSpecialChars($datas['title']);
        $datas['description'] = $myts->htmlSpecialChars($datas['description']);
        // $datas['img']  = XOOPS_UPLOAD_URL . "/kyc_repair/prod/thumb/thumb_".$datas['prod_id'].".png";
        $datas['img'] = get_prod_detail_img('prod_id', $datas['prod_id']);
        $all[] = $datas;
    }

    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $all;
  }
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
########################################
#
########################################
function get_prod_detail_img($col_name="" , $col_sn="")
{
  global $xoopsDB;
  $tbl=$xoopsDB->prefix('kyc_repair_files_center');
  $sql="SELECT * FROM `{$tbl}` WHERE `col_name` = '{$col_name}' and `col_sn` = '{$col_sn}' ORDER BY sort";


  $result = $xoopsDB->query($sql) or web_error($sql);
  $alls="";
  $myts              = MyTextSanitizer::getInstance();
  while($datas=$xoopsDB->fetchArray($result)){
    $str1  = XOOPS_UPLOAD_URL . "/kyc_repair/prod/image/.thumbs/".$datas['file_name'];
    $alls .= '<img src="' . $str1 . '" align="bottom" class="fit">';
  }
  return $alls;
}
################################
# 搜尋維修資料
#################################
function fix_search(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $searchName  = $myts->htmlSpecialChars($_REQUEST['cust_name']);
  $searchTelno  = $myts->htmlSpecialChars($_REQUEST['cust_telno']);
  $searchBig  = $myts->htmlSpecialChars($_REQUEST['cust_big']);
  $searchAddr  = $myts->htmlSpecialChars($_REQUEST['cust_addr']);
  $searchBrand  = $myts->htmlSpecialChars($_REQUEST['c_brand']);
  $searchType  = $myts->htmlSpecialChars($_REQUEST['c_type']);

  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $where = "WHERE  1=1 ";
    if ($searchName != "") {
        $where .= "and  `c_name` Like '%$searchName%' ";
    }
    if ($searchTelno != "") {
        $where .= "and  `telno` Like '%$searchTelno%' ";
    }
    if ($searchBig != "") {
        $where .= "and  `big` Like '%$searchBig%' ";
    }
    if ($searchAddr != "") {
        $where .= "and  `c_address` Like '%$searchAddr%' ";
    }

    if ($searchBrand != "") {
        $where .= "and  `c_brand` = '$searchBrand' ";
    }

    if ($searchType != "") {
        $where .= "and  `c_type` = '$searchType' ";
    }

    $myts = MyTextSanitizer::getInstance();
    $tbl=$xoopsDB->prefix('kyc_repair_fix');
    $sql="SELECT * FROM `$tbl` $where ORDER BY `c_date` DESC";
    //送至資料庫
    $result = $xoopsDB->query($sql) or web_error($sql);
            //取回資料
    $all = array();
    $myts              = MyTextSanitizer::getInstance();
    while($datas=$xoopsDB->fetchArray($result)){
      $datas['c_workno'] = $myts->htmlSpecialChars($datas['c_workno']);
      $datas['c_date'] = $myts->htmlSpecialChars($datas['c_date']);
      $datas['cusid'] = $myts->htmlSpecialChars($datas['cusid']);
      $datas['c_name'] = $myts->htmlSpecialChars($datas['c_name']);
      $datas['telno'] = $myts->htmlSpecialChars($datas['telno']);
      $datas['big'] = $myts->htmlSpecialChars($datas['big']);
      $datas['c_address'] = $myts->htmlSpecialChars($datas['c_address']);
      $datas['c_brand'] = $myts->htmlSpecialChars($datas['c_brand']);
      $datas['c_type'] = $myts->htmlSpecialChars($datas['c_type']);
      $datas['c_partno'] = $myts->htmlSpecialChars($datas['c_partno']);
      $datas['c_card'] = $myts->htmlSpecialChars($datas['c_card']);
      $datas['c_fail'] = $myts->htmlSpecialChars($datas['c_fail']);
      $datas['c_process'] = $myts->htmlSpecialChars($datas['c_process']);
      $datas['close_date'] = $myts->htmlSpecialChars($datas['close_date']);
      $datas['c_amt'] = $myts->htmlSpecialChars($datas['c_amt']);
      $datas['employ'] = $myts->htmlSpecialChars($datas['employ']);
      $all[] = $datas;
    }

    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $all;
  }
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 單一維修詳細資料
#################################
function fix_detail(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $repair_id  = $myts->htmlSpecialChars($_REQUEST['repair_id']);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $tbl=$xoopsDB->prefix('kyc_repair_fix');
    $sql    = "SELECT * FROM `$tbl` WHERE `repair_id` = '{$repair_id}'";
    $result = $xoopsDB->query($sql) or web_error($sql);
    $all = array();
    $myts  = MyTextSanitizer::getInstance();
    while($datas=$xoopsDB->fetchArray($result)){
      $datas['c_workno'] = $myts->htmlSpecialChars($datas['c_workno']);
      $datas['c_date'] = $myts->htmlSpecialChars($datas['c_date']);
      $datas['cusid'] = $myts->htmlSpecialChars($datas['cusid']);
      $datas['c_name'] = $myts->htmlSpecialChars($datas['c_name']);
      $datas['telno'] = $myts->htmlSpecialChars($datas['telno']);
      $datas['big'] = $myts->htmlSpecialChars($datas['big']);
      $datas['c_address'] = $myts->htmlSpecialChars($datas['c_address']);
      $datas['c_brand'] = $myts->htmlSpecialChars($datas['c_brand']);
      $datas['c_type'] = $myts->htmlSpecialChars($datas['c_type']);
      $datas['c_partno'] = $myts->htmlSpecialChars($datas['c_partno']);
      $datas['c_card'] = $myts->htmlSpecialChars($datas['c_card']);
      $datas['c_fail'] = $myts->htmlSpecialChars($datas['c_fail']);
      $datas['c_process'] = $myts->htmlSpecialChars($datas['c_process']);
      $datas['close_date'] = $myts->htmlSpecialChars($datas['close_date']);
      $datas['c_amt'] = $myts->htmlSpecialChars($datas['c_amt']);
      $datas['employ'] = $myts->htmlSpecialChars($datas['employ']);
      $all[] = $datas;
    }

    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $all;
  }
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 更新維修資料
#################################
function fix_update($op=""){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $repair_id  = $myts->htmlSpecialChars($_REQUEST['repair_id']);// 客戶姓名
  $c_date  = $myts->htmlSpecialChars($_REQUEST['c_date']);// 叫修日期
  $c_name  = $myts->htmlSpecialChars($_REQUEST['c_name']);// 客戶姓名
  $telno  = $myts->htmlSpecialChars($_REQUEST['telno']);// 客戶電話
  $big  = $myts->htmlSpecialChars($_REQUEST['big']); // 行動電話
  $c_address  = $myts->htmlSpecialChars($_REQUEST['c_address']);// 客戶住址
  $c_brand  = $myts->htmlSpecialChars($_REQUEST['c_brand']);// 產品廠牌
  $c_type  = $myts->htmlSpecialChars($_REQUEST['c_type']);// 產品類別
  $c_fail  = $myts->htmlSpecialChars($_REQUEST['c_fail']);// 故障說明
  $c_process  = $myts->htmlSpecialChars($_REQUEST['c_process']);// 處理情形
  $close_date  = $myts->htmlSpecialChars($_REQUEST['close_date']);// 完工日期
  $c_amt  = $myts->htmlSpecialChars($_REQUEST['c_amt']);// 收費金額
  $c_partno  = $myts->htmlSpecialChars($_REQUEST['c_partno']);// 產品機型
  $c_card  = $myts->htmlSpecialChars($_REQUEST['c_card']);// 產品機號
  $employ  = $myts->htmlSpecialChars($_REQUEST['employ']);// 維修人員
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $tbl=$xoopsDB->prefix('kyc_repair_fix');
    $sqlArr=array();
    $sqlArr['c_date']     = $c_date;
    $sqlArr['c_name']     = $c_name;
    $sqlArr['telno']      = $telno;
    $sqlArr['big']        = $big;
    $sqlArr['c_address']  = $c_address;
    $sqlArr['c_brand']    = $c_brand;
    $sqlArr['c_type']     = $c_type;
    $sqlArr['c_partno']   = $c_partno;
    $sqlArr['c_card']     = $c_card;
    $sqlArr['c_fail']     = $c_fail;
    $sqlArr['c_process']  = $c_process;
    $sqlArr['close_date'] = $close_date;
    $sqlArr['c_amt']      = $c_amt;
    $sqlArr['employ']     = $employ;

    if($op =="update"){
      sqlUpdate($tbl ,$sqlArr , "repair_id" , $repair_id);
    } else {
      $repair_id = sqlInsert($tbl ,$sqlArr);
    }

    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $all;
  }
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 將目前維修單號己上傳圖片傳到手機
#################################
function fix_showPic(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $repair_id  = $myts->htmlSpecialChars($_REQUEST['repair_id']);

  // genMsgFile("login3","txt",$uname."and".$pass);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    $wkpath = XOOPS_UPLOAD_URL . "/kyc_repair/fix/image/.thumbs/";
    $myts = MyTextSanitizer::getInstance();
    $tbl=$xoopsDB->prefix('kyc_repair_files_center');
    $where = "WHERE  `col_name` = 'FIX' and   `col_sn` = '$repair_id'";
    $sql="SELECT * FROM `$tbl` $where ORDER BY `sort`";
    //送至資料庫
    $result = $xoopsDB->query($sql) or web_error($sql);
            //取回資料
    $all = array();
    $myts              = MyTextSanitizer::getInstance();
    while($datas=$xoopsDB->fetchArray($result)){
      $datas['files_sn'] = $myts->htmlSpecialChars($datas['files_sn']);
      $datas['description'] = $myts->htmlSpecialChars($datas['description']);
      $datas['file_name'] = $wkpath . $myts->htmlSpecialChars($datas['file_name']);
      $all[] = $datas;
    }
    // $datas[0]['file_sn']  = 1;
    // $datas[0]['description'] = "第一張圖";
    // $datas[0]['file_name']  = $wkpath . "thumb_1.png";

    // $datas[1]['file_sn']  = 2;
    // $datas[1]['description'] = "第二張圖";
    // $datas[1]['file_name']  = $wkpath . "thumb_2.png";

    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $all;
  }
  // genMsgFile("fix_showPic","json",json_encode($r, JSON_UNESCAPED_UNICODE));
  return json_encode($r, JSON_UNESCAPED_UNICODE);
}

################################
# 上傳圖片至 雲端(xoops)
#################################
function fix_uploadPic(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $repair_id  = $myts->htmlSpecialChars($_REQUEST['repair_id']);
  $title  = $myts->htmlSpecialChars($_REQUEST['title']);
  $op  = $myts->htmlSpecialChars($_REQUEST['op']);

  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles = new TadUpFiles("kyc_repair","/fix");
    // $table1 = $TadUpFiles->TadUpFilesTblName;
    // $TadUpFiles->set_dir('subdir',"repair");
    $TadUpFiles->set_dir('subdir',"/fix");
    $TadUpFiles->set_col('FIX', $repair_id);
    $TadUpFiles->upload_one_file($_FILES['file']['name'],$_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['size']);
    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = $datas;
  }

  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 刪除己上傳至 xoops 之圖片
#################################
function fix_deletePic(){
  global $xoopsDB, $xoopsModule;
  #---- 過濾資料 --------------------------
  $myts = &MyTextSanitizer::getInstance();
  $uname = $myts->htmlSpecialChars($_REQUEST['uname']);
  $pass  = $myts->htmlSpecialChars($_REQUEST['pass']);

  $files_sn  = $myts->htmlSpecialChars($_REQUEST['files_sn']);
  #帳號、密碼認證
  $uid=check_user($uname,$pass);
  $r = array();
  if($uid == "FAIL"){
    $r['responseStatus'] = "FAIL";
    $r['responseMessage'] = "帳號、密碼錯誤！！";
    $r['responseArray'] = "";
  } else {
    // genMsgFile("fix_deletePic","txt",$files_sn);
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles = new TadUpFiles("kyc_repair");
    // $TadUpFiles->set_dir('subdir',"/prod");
    // $TadUpFiles->set_col('FIX', $files_sn);
    $TadUpFiles->del_files($files_sn);
    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseArray']   = "";
  }

  return json_encode($r, JSON_UNESCAPED_UNICODE);
}
################################
# 檢查帳號、密碼是否正確
# 正確返回 "OK"
# 不正確返回 "FAIL"
#################################
function check_user($uname="",$pass=""){
  global $xoopsDB;
  if(!$uname or !$pass)return;
  $sql="select uid , pass
        from ".$xoopsDB->prefix("users")."
        where uname = '{$uname}'
  ";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
  $row = $xoopsDB->fetchArray($result);
  if(password_verify($pass, $row['pass'])){
    return "OK";
  }else{
    return "FAIL";
  }
}


?>
