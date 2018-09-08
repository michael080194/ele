<?php
########################################################################
# 資料庫連線
########################################################################
function link_db()
{
    //實體化
    $mysqli = new mysqli(_DB_LOCATON, _DB_ID, _DB_PASS, _DB_NAME);
    if ($mysqli->connect_error) {
        throw new Exception('無法連上資料庫：' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}
#####################################################################################
#  新增資料至資料庫
#####################################################################################
function sqlInsert($tbl , $sqlArray){
    global $xoopsDB;
    $field="";
    $value="";
    foreach ($sqlArray as $key => $val) {
        $field .= ($field == "") ? "`".$key."`" : ",`".$key."`";
        $value .= ($value == "") ? "'".$val."'" : ",'".$val."'";
    }
    $sql = "INSERT INTO `$tbl` (" .$field . ") VALUES (" . $value . ")";
    sqlExcute($sql);    
    $id = $xoopsDB->insert_id; //取得最後新增的編號

    return $id;
}
#####################################################################################
#  新增資料至資料庫 By REPLACE
#####################################################################################
function sqlReplace($tbl , $sqlArray , $type){
    global $xoopsDB;
    $field="";
    $value="";
    foreach ($sqlArray as $key => $val) {
        $field .= ($field == "") ? "`".$key."`" : ",`".$key."`";
        $value .= ($value == "") ? "'".$val."'" : ",'".$val."'";
    }
    $sql = "REPLACE INTO  `$tbl` (" .$field . ") VALUES (" . $value . ")";
    sqlExcute($sql);    
    if($type == "ADD"){
       $id = $xoopsDB->insert_id; //取得最後新增的編號
       return $id;
    } else {
       return "";
    }

}
#####################################################################################
#  更新資料至資料庫
#####################################################################################
function sqlUpdate($tbl , $sqlArray , $delCondition){
    global $xoopsDB;
    if($tbl != "" and $delCondition != "" ){
       $field="";
       foreach ($sqlArray as $key => $val) {
           $temStr="`" . $key . "` = '" . $val . "'";
           $field .= ($field == "") ? $temStr : "," . $temStr;
       }
       $sql = "UPDATE `$tbl` SET " . $field . " WHERE " . $delCondition;
       sqlExcute($sql);            
    }
}
#####################################################################################
#  更新資料至資料庫
#####################################################################################
function sqlDelete($tbl = "",  $delCondition=""){
    global $xoopsDB;
    if($tbl != "" and $delCondition != "" ){
       $sql = "DELETE FROM `$tbl` WHERE " . $delCondition ;
       sqlExcute($sql);       
    }
}

#####################################################################################
#  執行 資料庫異動的 Sql 命令
#####################################################################################
function sqlExcute($sql){
    global $xoopsDB;
    return $xoopsDB->query($sql) or die($xoopsDB->error);
}
#####################################################################################
#  執行 資料庫異動的 Sql 命令
#####################################################################################
function sqlExcuteForSelectData($sql){
    global $xoopsDB;
    $result = $xoopsDB->query($sql) or die($xoopsDB->error);    
    return $result;
}
#####################################################################################
#  執行 fetch_assoc 命令
#####################################################################################
function sqlFetch_assoc($result){
    return $result->fetch_assoc();
}
#####################################################################################
#  執行 fetch_assoc 命令
#####################################################################################
function sqlFetch_row($result){
    return $result->fetch_row();
}
