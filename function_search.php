<?php
########################################
# 得到類別選項
########################################
function get_prod($sub_condi="")
{
  global $xoopsDB;

  $comp_id = isset($_SESSION["comp_id"]) ? $_SESSION["comp_id"] : '';  
  $fact_id = isset($_SESSION["fact_id"]) ? $_SESSION["fact_id"] : '';  
  $sub_condi = "where comp_id = '{$comp_id}' and fact_id = '{$fact_id}' and (" . $_POST["search_data"] . ")"; 
  $tbl='kyc_repair_00_prod';
  // $sql="SELECT * FROM `{$tbl}` WHERE `description` LIKE '%機%' ORDER BY prod_no";

  $sql="SELECT * FROM `{$tbl}` $sub_condi  ORDER BY prod_no";

  $result = sqlExcuteForSelectData($sql); 

  $all = array();  
  while($datas=sqlFetch_assoc($result)){
    $arr1 = array();      
    $arr1['prod_no']    = kyc_htmlSpecialChars($datas['prod_no']);
    $arr1['description']= kyc_htmlSpecialChars($datas['description']);
    $arr1['c_unit']     = kyc_htmlSpecialChars($datas['c_unit']);        
    $arr1['in_price']   = kyc_htmlSpecialChars($datas['in_price']);
    $arr1['sale_price'] = kyc_htmlSpecialChars($datas['sale_price']);
    $arr1['c_brand']    = kyc_htmlSpecialChars($datas['c_brand']);  
    $arr1['c_type']     = kyc_htmlSpecialChars($datas['c_type']); 
    $arr1['sele_but']   = '<a href="javascript:void(0)" class="return_sel btn btn-primary btn-xs">取回</a>';            
    $all[] = $arr1;
  }

  $r['responseStatus']  = "SUCCESS";
  $r['responseMessage'] = "";
  $r['responseArray']   = $all;
  $r['data']   = $all;
  return json_encode($r, JSON_UNESCAPED_UNICODE);    
}
########################################
# 得到類別選項
########################################
function kyc_get_prod_dt()
{
  global $xoopsDB;
  //獲取Datatables送過來的参數 必要
  $draw = $_POST['draw'];//這個值會直接返回给前台
  //排序
  $order_column = $_POST['order']['0']['column'];//那一列排序，從0開始
  $order_dir = $_POST['order']['0']['dir'];//ase desc 升序或者降序
  $order_field = $_POST['order_field'];    // 排序欄位名稱
  //生成排序sql
  $orderSql = "";
  if(isset($order_column)){  
     $orderSql = " order by ".$order_field[intval($order_column)] . " " . $order_dir;   
  }    
  //搜索
  $search = kyc_htmlSpecialChars($_POST['search']['value']);//獲取前台傳過來的過濾條件
  $searchStr = "";  
  if(strlen($search)>0){
     $searchStr = " and (prod_no     LIKE '%{$search}%'
                    or   description LIKE '%{$search}%'
                    or   c_unit      LIKE '%{$search}%'     
                    or   in_price    LIKE '%{$search}%'
                    or   sale_price  LIKE '%{$search}%'     
                    or   c_brand     LIKE '%{$search}%'
                    or   c_type      LIKE '%{$search}%'                                                     
    )";     
  }   
  if(strlen($_POST['individual_search'])>0){
     $searchStr .= $_POST['individual_search'];                                            
  }     
  genMsgFile("kyc_get_prod_dt","txt",$searchStr);
  //分頁
  $start = $_POST['start'];   // 抓取資料起始位置
  $length = $_POST['length'];  //抓取長度機
  $limitSql = '';
  $limitFlag = isset($_POST['start']) && $length != -1 ;
  if ($limitFlag ) {
      $limitSql = " LIMIT ".intval($start).", ".intval($length);
  }
  //定義查詢數據總記錄數sql
  $comp_id = isset($_SESSION["comp_id"]) ? $_SESSION["comp_id"] : '00';  
  $fact_id = isset($_SESSION["fact_id"]) ? $_SESSION["fact_id"] : '01';    
  $sumSql = "SELECT count(prod_id) as sum FROM `kyc_repair_00_prod` where comp_id = '{$comp_id}' and fact_id = '{$fact_id}'";
  //條件過濾後記錄數 必要
  $recordsFiltered = 0;
  //資料表的總記錄數 必要
  $recordsTotal = 0;
  $recordsTotalResult = sqlExcuteForSelectData($sumSql);  
  while ($row = sqlFetch_assoc($recordsTotalResult)) {
      $recordsTotal =  $row['sum'];
  }
  //定義查询過濾後的記錄數sql
  if(strlen($searchStr)>0){
      $sumSql .= $searchStr ;
      $recordsFilteredResult = sqlExcuteForSelectData($sumSql);  
      while ($row = sqlFetch_assoc($recordsFilteredResult)) {
          $recordsFiltered =  $row['sum'];
      }
  }else{
      $recordsFiltered = $recordsTotal;
  }
  //query data
  $sql = "SELECT * FROM `kyc_repair_00_prod` where comp_id = '{$comp_id}' and fact_id = '{$fact_id}'";   
  if(strlen($searchStr)>0){  
     $sql .=  $searchStr;
  }
  $sql =  $sql . $orderSql . $limitSql ;
  $dataResult = sqlExcuteForSelectData($sql); 
  $all = array();  
  while ($datas = sqlFetch_assoc($dataResult)) {
    $arr1 = array();      
    $arr1['prod_no']    = kyc_htmlSpecialChars($datas['prod_no']);
    $arr1['description']= kyc_htmlSpecialChars($datas['description']);
    $arr1['c_unit']     = kyc_htmlSpecialChars($datas['c_unit']);        
    $arr1['in_price']   = kyc_htmlSpecialChars($datas['in_price']);
    $arr1['sale_price'] = kyc_htmlSpecialChars($datas['sale_price']);
    $arr1['c_brand']    = kyc_htmlSpecialChars($datas['c_brand']);  
    $arr1['c_type']     = kyc_htmlSpecialChars($datas['c_type']); 
    $arr1['sele_but']   = '<a href="javascript:void(0)" class="return_sel btn btn-primary btn-xs">取回</a>';
    $all[] = $arr1;
  }
  $r['draw']  = intval($draw);
  $r['recordsTotal'] = intval($recordsTotal);
  $r['recordsFiltered']   = intval($recordsFiltered);
  $r['data']   = $all;
  return json_encode($r, JSON_UNESCAPED_UNICODE);    
}
########################################################################
// 抓取零件資料
########################################################################
function kyc_get_partno($fun_comp_id = "", $fun_fact_id = "", $fun_type = "", $fun_partno = "")
{
    // fun_type 1:零件 2:工資
    global $db;
    $sql    = "select comp_id , fact_id , c_type , c_partno , c_descrp , c_unit from car_mstock  where comp_id = '{$fun_comp_id}' and fact_id = '{$fun_fact_id}' and c_type = '{$fun_type}' and  c_partno = '{$fun_partno}' ";
    $result = $db->query($sql);
    $row    = array();
    $row['c_descrp'] = "";
    $row['c_unit']   = "";
    while ($values = $result->fetch_array(MYSQLI_BOTH)) {
        $row['c_descrp'] = $values['c_descrp'];
        $row['c_unit']   = $values['c_unit'];
    }
    return $row;
}

########################################################################
// 抓取廠商資料
########################################################################
function kyc_get_suply($fun_comp_id = "", $fun_fact_id = "", $fun_suply = "")
{
    global $db;
    $sql    = "select *  from car_suply where comp_id = '{$fun_comp_id}' and fact_id = '{$fun_fact_id}' and  suply_no = '{$fun_suply}' ";
    $result = $db->query($sql);
    $row    = array();
    $row['c_name']   = "";
    while ($values = $result->fetch_array(MYSQLI_BOTH)) {
        $row['c_name'] = $values['c_name'];
    }
    return $row;
}