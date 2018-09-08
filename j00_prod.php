<?php
//引入檔案（設定）
require "index_check.php";
require_once "header.php";

$tbl    = 'kyc_repair_00_prod';
$tblFix = 'kyc_repair_00_prod_fix';
$search_data = isset($_REQUEST['search_data']) ? htmlspecialchars($_REQUEST['search_data'], ENT_QUOTES) : '';
$prod_id = isset($_REQUEST['prod_id']) ? intval($_REQUEST['prod_id']) : '';
$s1_prod_fix_id = isset($_REQUEST['s1_prod_fix_id']) ? intval($_REQUEST['s1_prod_fix_id']) : ''; // 建議維修零件檔 unique key 

try
{
    switch ($op) {
        case "form":
            $theme = "j00_prod_form.tpl";        
            form1($prod_id);
            break;
        case "show":
            $theme = "j00_prod_show.tpl";           
            show1($prod_id);
            break;    
        case "insert":
            $prod_id = save1("add" , "");
            header("location: j00_prod.php");
            exit;
        case "update":
            save1("update" , $prod_id);
            header("location: j00_prod.php");
            exit;    
        case "delete":
            delete1($prod_id);
            // header("location: j00_prod.php");
            exit;
        case "search_prod":
            echo get_prod($search_data);
            exit;    
        case "fix_insert": // 新增一筆資料至 產品建議維修零件 kyc_repair_00_prod_fix
            echo fix_save1("add" , "");
            exit;
        case "fix_update":// 新增一筆資料至 產品建議維修零件 kyc_repair_00_prod_fix
            echo fix_save1("update" , $s1_prod_fix_id);
            exit;    
        case "fix_delete":// 刪除一筆資料 產品建議維修零件 kyc_repair_00_prod_fix
            echo fix_delete1($s1_prod_fix_id);
            exit;                
        default:
            list1();
            $theme = "j00_prod_list.tpl";                
            $op = 'list';
            break;
    }
} catch (exception $e) {
    $error = $e->getMessage();
}

//結果送至樣板
$page_title = "雲端維修管理系統";
// $theme = "index_1.tpl";
require_once "footer.php";
/*-----------function區--------------*/
//新增文章的表單
function form1($prod_id=""){
    global $xoopsTpl, $xoopsDB, $xoopsUser , $tbl,  $TadUpFiles;
    $all    = array();
    if($prod_id){
       $sql="SELECT * FROM `{$tbl}` WHERE `prod_id` = '{$prod_id}'";
       $result = sqlExcuteForSelectData($sql); // $xoopsDB->query($sql) or web_error($sql);
       $val=sqlFetch_assoc($result);// sqlFetch_assoc($result);
       $prod_no = $val["prod_no"];

       $showPicArr=array();
       $showPicArr['pic_kind']  = "thumb"; 
       $showPicArr['col_name']  = "prod";
       $showPicArr['col_sn']    = $val['prod_id'];
       $pic = kyc_show_files($showPicArr); 
       $val['img'] = $pic;

       $op1 = "update";

       $tblNext = 'kyc_repair_00_prod_fix';

       // $sqlNext    = "SELECT * FROM `$tblNext` WHERE `prod_no` = '{$prod_no}'";
       $sqlNext    = "SELECT a.* , b.description , b.c_unit
       FROM   `$tblNext` as a INNER JOIN `$tbl` as b 
       ON     a.prod_no_fix = b.prod_no  WHERE a.prod_no = '{$prod_no}' ORDER BY a.c_seq";

       $resultNext = sqlExcuteForSelectData($sqlNext); // $xoopsDB->query($sqlNext) or web_error($sqlNext);      

       while($prods=sqlFetch_assoc($resultNext)){
           $all[]  = $prods;
       }

      }else{
       $val['prod_no']     = "";
       $val['description'] = "";
       $val['c_unit']      = ""; 
       $val['barcode']     = "";
       $val['inter_code']  = "";
       $val['c_locatn']    = "";
       $val['c_safe']      = "";
       $val['c_prod']      = "";
       $val['c_brand']     = "";
       $val['c_type']      = "";
       $val['in_price']    = 0;
       $val['sale_price']  = 0;
       $val['c_price1']    = 0;
       $val['c_price3']    = 0;
       $val['c_price2']    = 0;
       $val['c_price_av']  = 0;
       $val['c_return']    = 0;    
       $val['c_date']      = "";   
       $val['c_yn']        = 1;   
       $val['c_remark']    = "";  
       $val['title']       = "";
       $val['content']     = "";
       $val['img'] = "";       
       $op1 = "insert";
    }

    $options=get_kind_prod_option("BRAND" , $val['c_brand']);
    $val['sele_brand']=$options;
    $options=get_kind_prod_option("MTNO_TYPE" , $val['c_type']);
    $val['sele_type']=$options;

    $xoopsTpl->assign('VAL', $val);
    $xoopsTpl->assign('op1', $op1);
    $xoopsTpl->assign('alls', $all); // 建議維修零件表  
    // die(var_dump($all));
}

function save1($save_type , $prod_id){
    global $xoopsDB , $tbl;

    foreach ($_POST as $key => $value) {
        $$key = kyc_filter_var($value);
    }

    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];  
    //寫SQL
    $sqlArr=array();
    $sqlArr['comp_id']    = $comp_id;        
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['prod_no']    = $prod_no;
    $sqlArr['description']= $description;
    $sqlArr['c_unit']     = $c_unit; 
    $sqlArr['barcode']    = $barcode;
    $sqlArr['inter_code'] = $inter_code;
    $sqlArr['c_locatn']   = $c_locatn;
    $sqlArr['c_safe']     = $c_safe;
    $sqlArr['c_prod']     = $c_prod;
    $sqlArr['c_brand']    = $c_brand;
    $sqlArr['c_type']     = $c_type;
    $sqlArr['in_price']   = $in_price;
    $sqlArr['sale_price'] = $sale_price;
    $sqlArr['c_price1']   = $c_price1;
    $sqlArr['c_price3']   = $c_price3;
    $sqlArr['c_price2']   = $c_price2;
    $sqlArr['c_price_av'] = $c_price_av;
    $sqlArr['c_return']   = $c_return;    
    $sqlArr['c_date']     = $c_date;   
    $sqlArr['c_yn']       = $c_yn;   
    $sqlArr['c_remark']   = $c_remark;  
    $sqlArr['title']      = $title;
    $sqlArr['content']    = $content;
    $sqlArr['update_date']= "now()";

    if($save_type =="add") {
      $sqlArr['create_date']    = "now()";
      $prod_id = sqlReplace($tbl ,$sqlArr , "ADD");       
    } else {
      $sqlArr['prod_id']    = $prod_id;      
      sqlReplace($tbl ,$sqlArr , "UPDATE");    
    }

    if (isset($_FILES)) {   
        kycGenDir();
        $uploadArr=array();
        $uploadArr['upname']    = "pic";         
        $uploadArr['col_name']  = "prod"; 
        $uploadArr['col_sn']    = $prod_id; 
        $uploadArr['subDir']    = "uploads/".$comp_id.$fact_id."/prod"; 
        $uploadArr['prod_no']    = $prod_no;         
        $uploadArr['tbl']       = "kyc_repair_files_center";         
        kyc_upload_file($uploadArr);                        
        // kycUpFile($prod_id , "pic"); // upload picture
    }   
}

function delete1($prod_id){
    global $tbl;
    //刪除條件
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    // $delCondition=" `comp_id`='{$comp_id}' and `fact_id`='{$fact_id}' and `prod_id` = '{$prod_id}'";
    $delCondition=" `prod_id` = '{$prod_id}'";    
    sqlDelete($tbl ,  $delCondition);

    $delFileArr=array();
    $delFileArr['col_name']  = "prod"; 
    $delFileArr['col_sn']    = $prod_id; 
    kyc_del_files($delFileArr);          
}

function fix_save1($save_type , $prod_fix_id){
    global $xoopsDB , $tblFix;
    // die(var_dump($_POST));
    foreach ($_POST as $key => $value) {
        $$key = kyc_filter_var($value);
    }

    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];  
    //寫SQL
    $sqlArr=array();
    $sqlArr['comp_id']     = $comp_id;        
    $sqlArr['fact_id']     = $fact_id;
    $sqlArr['prod_no']     = $s1_ori_prod_no; // 產品編號
    $sqlArr['prod_no_fix'] = $s1_prod_no; // 建議 維修零件編號
    $sqlArr['c_qty']       = $s1_c_qty; // 數量
    $sqlArr['c_wage']      = $s1_c_wage; // 工資
    $sqlArr['c_cost']      = $s1_c_cost; // 成本單價
    $sqlArr['c_sale']      = $s1_c_sale; // 銷售單價
    $sqlArr['c_remark']    = $s1_c_remark; // 銷售單價    
    $sqlArr['update_date'] = "now()";

    if($save_type =="add") {
      $sqlArr['create_date']    = "now()";
      $prod_fix_id = sqlReplace($tblFix ,$sqlArr , "ADD");       
    } else {
      $sqlArr['prod_fix_id']    = $prod_fix_id;      
      sqlReplace($tblFix ,$sqlArr , "UPDATE");    
    }

  $r['responseStatus']  = "SUCCESS";
  $r['responseMessage'] = "";
  $r['responseData']   = $prod_fix_id;

  return json_encode($r, JSON_UNESCAPED_UNICODE);       
}
function fix_delete1($prod_fix_id){
    global $tblFix;
    //刪除條件
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $delCondition=" `prod_fix_id` = '{$prod_fix_id}'";
    sqlDelete($tblFix ,  $delCondition);
    $r['responseStatus']  = "SUCCESS";
    $r['responseMessage'] = "";
    $r['responseData']   = $prod_fix_id;

    return json_encode($r, JSON_UNESCAPED_UNICODE);     

}
//顯示預設頁面內容
function list1(){
    global $xoopsTpl, $xoopsDB, $isAdmin , $tbl, $TadUpFiles;
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   
    $Condition=" `comp_id`='{$comp_id}' and `fact_id`='{$fact_id}' ";       
    $sql="SELECT * FROM `{$tbl}`  WHERE {$Condition} ORDER BY `prod_id` DESC";

    include_once "class/PageBar.php";
    $PageBar = getPageBar($xoopsDB, $sql, 6, 10);
    $bar = $PageBar['bar'];
    $sql = $PageBar['sql'];
    $total = $PageBar['total'];

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('total', $total);
    //送至資料庫
    $result = sqlExcuteForSelectData($sql) ; // sqlExcute($sql); // $xoopsDB->query($sql) or web_error($sql);
    //取回資料
    $all    = array();
    while($prods=sqlFetch_assoc($result)){
        $prods['content']  = mb_substr(strip_tags($prods['content']), 0, 90) ; // displayTarea($prods['content'], 1, 0, 0, 0, 0);
        $prods['title']    = kyc_htmlSpecialChars($prods['title']);

        $getPicArr=array();
        $getPicArr['pic_kind']  = "thumb"; 
        $getPicArr['col_name']  = "prod";
        $getPicArr['col_sn']    = $prods['prod_id'];

        $prods['img'] = kyc_get_pic_file($getPicArr);
        $all[]        = $prods;
    }
    // die(var_dump($all));
    $xoopsTpl->assign('all', $all);


}

function show1($prod_id=""){
    global $xoopsTpl, $xoopsDB , $tbl;
 
    $sql    = "SELECT * FROM `$tbl` WHERE `prod_id` = '{$prod_id}'";
    // $result = $xoopsDB->query($sql) or web_error($sql);
    $result = sqlExcuteForSelectData($sql) ; // sqlExcute($sql); // $xoopsDB->query($sql) or web_error($sql);

    $all    = array();
    while($prods=sqlFetch_assoc($result)){
        $prods['content']  = mb_substr(strip_tags($prods['content']), 0, 90);
        $prods['title']    = kyc_htmlSpecialChars($prods['title']);

        $showPicArr=array();
        $showPicArr['pic_kind']  = "thumb"; 
        $showPicArr['col_name']  = "prod";
        $showPicArr['col_sn']    = $prods['prod_id'];

        $pic = kyc_show_files($showPicArr); 
        $prods['img'] = $pic;
        
        // $prods['img'] = $TadUpFiles->show_files('pic', false);
        $all         = $prods;
    }
    // genMsgFile("showPicArr_1","txt",print_r($all, true));
    $xoopsTpl->assign('alls', $all);

}
