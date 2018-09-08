<?php
//引入檔案（設定）
require "index_check.php";
require_once "header.php";
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : '';
// echo '<script type="text/javascript">alert("op=' . $op . '")</script>';
// var_dump($_FILES,$_POST);
$tbl='kyc_repair_00_user';
$theme = "index_1.tpl";
try
{
    switch ($op) {
        case 'user_form':
            user_form($id);
            $theme = "j00_user_form.tpl";
            break;
        case 'save_user':
            save_user($id);
            header("location: index_1.php");
            exit;
        case 'delete_user':
            delete_user($id);
            header("location: j00_user.php");
            exit;
        case 'inq_user':
            if (isset($_REQUEST['inq_name'])) {
               $inq_name = isset($_REQUEST['inq_name']) ? htmlspecialchars($_REQUEST['inq_name']) : '';
               $_SESSION["inq_condi"]   = $inq_name;
               $_SESSION["inq_type"]   = "inq_user";
               $op = "user_list";
               user_list();
            }
            break;
        case 'user_list':
            user_list();
            break;
        default:
            if (isset($_REQUEST['g2p'])) {
                $inq_type = $_SESSION["inq_type"] ? $_SESSION["inq_type"] : '';
                switch ($inq_type) {
                   case 'inq_user':
                      user_list();
                      break;
                 }
            }
            break;
    }
} catch (exception $e) {
    $error = $e->getMessage();
}

//結果送至樣板
$page_title = "雲端維修管理系統";
// $theme = "index_1.tpl";
require_once "footer.php";

#################################
#
# 使用者註冊表單
#################################
function user_form($id = "") {
  global $xoopsDB, $xoopsTpl;

  #取得預設值
  if ($id) {
    #編輯
    $sql = "select * from `kyc_repair_00_user` where `id`='{$id}' ";
    $result = sqlExcute($sql);
    $row = sqlFetch_assoc($result);
    $row['form_title']  = "修改";
  } else {
    #新增
    $row = array();
    #預設值設定
    $row['id'] =  "";
    $row['comp_id'] =  "";
    $row['fact_id'] =  "";
    $row['user'] = "";
    $row['pass'] =  "";
    $row['name'] =  "";
    $row['email'] = "";
    $row['big_serial'] =  "";
    $row['big_enable'] =  0;
    $row['form_title'] = "新增";
  }


  #把變數送至樣板
  $xoopsTpl->assign('row', $row);
}
#################################
# 表單
# 儲存註冊資料
#################################
function save_user($id = "")
{
    global  $admin_user , $tbl;
    $user  = clean_var('user', '使用者帳號');
    $name  = clean_var('name', '姓名');
    $pass  = clean_var('pass', '密碼');
    $email = clean_var('email' , "");
    // $email = clean_var('email', 'Email', FILTER_VALIDATE_EMAIL);
    $pass  = password_hash($pass, PASSWORD_DEFAULT);
    $group = ($admin_user == $user) ? 'admin' : 'user';
    $comp_id  = clean_var('comp_id', '公司別');
    $fact_id  = clean_var('fact_id', '廠別');
    $big_serial  = clean_var('big_serial', '');
    $big_enable = isset($_REQUEST['big_enable']) ? $_REQUEST['big_enable'] : 0;

    $sqlArr=array();
    $sqlArr['user']       = $user;
    $sqlArr['name']       = $name;
    $sqlArr['pass']       = $pass;
    $sqlArr['email']      = $email;
    $sqlArr['group']      = $group;
    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['big_serial'] = $big_serial;
    $sqlArr['big_enable'] = $big_enable;

    #取得預設值
    if ($id) {
      sqlUpdate($tbl ,$sqlArr , "id" , $id);
      $return_id = $id;
    } else {
      $return_id = sqlInsert($tbl ,$sqlArr);
    }

    return $return_id;

}
#################################
# 表單
# 顯示使用者註冊資料
#################################
function user_list()
{

    global $db, $smarty;
    $inq_name = isset($_SESSION["inq_condi"]) ? $_SESSION["inq_condi"] : '';
    $where = ($inq_name != "") ? "where name Like '%$inq_name%'" : "";
    $sql   = "SELECT * FROM `car_user` $where order by id";
    include_once "class/PageBar.php";
    // getPageBar($mysqli, $sql, $show_num = 20, $page_list = 10, $to_page = "", $url_other = "")
    // $show_num = 20：每頁顯示資料數  $page_list = 10：分頁工具列呈現的頁數
    $PageBar = getPageBar($db, $sql, _EVERY_PAGE, _EVERY_TOOLBAR);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];
    $result  = $db->query($sql);
    if (!$result) {
        throw new Exception($db->error);
    }
    $users = array();
    while ($values = $result->fetch_assoc()) {
        $users[] = $values;
    }

    $smarty->assign('users', $users);
    $smarty->assign('bar', $bar);
    $smarty->assign('every_page', _EVERY_PAGE);
    $smarty->assign('total', $total);
}
//刪除 USER
function delete_user($id)
{
    global $db, $smarty;

    $sql = "DELETE FROM `car_user` WHERE `id`='$id'";
    if (!$result = $db->query($sql)) {
        throw new Exception($db->error);
    }
}
