<?php
//引入檔案（設定）
require "index_check.php";
require_once "header.php";
try
{
    switch ($op) {
        case 'upload':
            $theme = "index_1.tpl";                      
            trans_data();
            break;
        default:
            $theme = "j90_upload.tpl";        
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
function upload()
{
    $target_dir    = "uploads/";
    $target_file   = $target_dir . basename($_FILES["fileToUpload"]["name"]); // uploads/a00_trans_car.txt
    $uploadOk      = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // 取得副檔名

    // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // Allow certain file formats
    // die(basename($_FILES["fileToUpload"]["name"]));
    if (basename($_FILES["fileToUpload"]["name"]) != "a00_mysql_ele.txt") {
        throw new Exception("轉檔原始檔錯誤!!");
        return false;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["tmp_name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
function trans_data()
{
    ?>
      <!DOCTYPE html>
      <html lang="zh-Hant">
        <head>
            <link rel="stylesheet" href="class/bootstrap/css/bootstrap.min.css">
            <script src="class/jquery.min.js"></script>
        </head>
        <body>
            <div id = "trans1" class="panel panel-primary" style="margin:100px">
                <div class="panel-heading">開始轉入資料</div>
                <div class="panel-body">
                   <h3>
                   <div id="information1" ></div>
                   </h3>
                   <div id="progressbar" style="border:1px solid #ccc; border-radius: 5px; "></div>
                   <br>
                   <h3>
                   <div id="information2" ></div>
                   </h3>
                </div>
            </div>
        </body>
      </html>
    <?php

    if ($_FILES['fileToUpload']['error'] != 0) {
        throw new Exception("請選取欲轉入之 txt 檔!!");
    }
    $tmp = explode('.', $_FILES['fileToUpload']['name']);
    $ext = strtolower(end($tmp));
    if ($ext != "txt") {
        throw new Exception("只能載入副檔名為 txt 之文字檔!!");
    }
    $trans_file = $_FILES['fileToUpload']['tmp_name'];
    // $trans_file = "uploads/a00_trans_car.txt";
    // if (!file_exists($trans_file)) {
    //     throw new Exception("a00_trans_car.txt 不存在<br>無法轉檔");
    // }
    if (($file = fopen($trans_file, 'r')) == false) {
        throw new Exception("檔案載入錯誤!!");
    }
    ini_set('max_execution_time', 0);
    $file  = fopen($trans_file, "r");
    $total = 0;
    while ($a = fgets($file)) {
        $total++;
    }
    fclose($file);
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];
    // 先清除檔案
    clear_data("kyc_repair_00_kinds");
    clear_data("kyc_repair_00_fail");
    clear_data("kyc_repair_00_customer");
    clear_data("kyc_repair_00_customer_memo");  
    clear_data("kyc_repair_00_suply");
    clear_data("kyc_repair_00_employ");
    clear_data("kyc_repair_00_prod");
    clear_data("kyc_repair_00_prod_fix");
    clear_data("kyc_repair_01_stock");
    clear_data("kyc_repair_12_fix");
    clear_data("kyc_repair_12_fix_detail");
    clear_data("kyc_repair_50_system_news");
    clear_data("kyc_repair_files_center");
    //

    $kyc_spilt = ""; // CHR(02)
    $wkcount   = 0;
    $file      = fopen($trans_file, "r");
    while (!feof($file)) {
        $percent = intval($wkcount / $total * 100) . "%";
        $t_msg   = $wkcount . '／' . $total;
        //
        echo '<script>
        document.getElementById("progressbar").innerHTML="<div style=\"width:' . $percent . ';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
        document.getElementById("information1").innerHTML="<div style=\"text-align:center; font-weight:bold\">處理百分比：' . $percent . '</div>";
        document.getElementById("information2").innerHTML="<div style=\"text-align:center; font-weight:bold\">處理筆數：' . $t_msg . '</div>";</script>';

        // ob_flush();
        flush();
        //
        $kyc_01 = fgets($file);
        $ka     = explode($kyc_spilt, $kyc_01);
        $array1 = array();
        switch($ka[0]) {
         case "11": // 客戶檔 kyc_repair_00_customer
           insert_customer($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "11A": // 客戶備註檔 kyc_repair_00_customer
           insert_customer_memo($ka);
           $wkcount = $wkcount + 1 ;
           break;        
         case "12": //  廠商檔
           insert_suply($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "13": //  員工檔
           insert_employ($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "15": // 產品檔
           insert_prod($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "15A": // 產品維修零件檔
           insert_prod_fix($ka);
           $wkcount = $wkcount + 1 ;
           break;        
         case "16": // 庫存檔
           insert_stock($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "19": // 片語代號檔
           insert_kinds($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "19A": // 故障片語代號檔
           insert_fail($ka);
           $wkcount = $wkcount + 1 ;
           break;        
         case "22": // 維修彙總檔
           insert_fix($ka);
           $wkcount = $wkcount + 1 ;
           break;
         case "22A": // 維修明細檔
           insert_fix_detail($ka);
           $wkcount = $wkcount + 1 ;
           break;
        } // end switch        
    } //  end while
    fclose($file);
    echo '<script>
        $(\'#trans1\').css("display", "none");
        </script>';

    kyc_show_msg("總共 " . $wkcount . " 筆資料 轉檔成功!!");   
}
function insert_customer($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['cust_no']    = kyc_filter_var($data[1]); // 客戶編號
    $sqlArr['c_name']     = kyc_filter_var($data[2]); // 客戶名稱
    $sqlArr['allname']    = kyc_filter_var($data[3]); // 公司名稱
    $sqlArr['birth_yy']   = kyc_filter_var($data[4]); // 出生年份
    $sqlArr['birth']      = kyc_filter_var($data[5]); // 出生月份+日期
    $sqlArr['tel1']       = kyc_filter_var($data[6]); // 電話1
    $sqlArr['tel2']       = kyc_filter_var($data[7]); // 電話2
    $sqlArr['brief_no']   = kyc_filter_var($data[8]); // 客戶簡碼
    $sqlArr['big']        = kyc_filter_var($data[9]); // 行動電話
    $sqlArr['fax']        = kyc_filter_var($data[10]); // 傳真
    $sqlArr['atten']      = kyc_filter_var($data[11]); // 連絡人
    $sqlArr['bbcall']     = kyc_filter_var($data[12]); // 連絡人電話
    $sqlArr['boss']       = kyc_filter_var($data[13]); // 負責人
    $sqlArr['e_mail']     = kyc_filter_var($data[14]); // e_mail
    $sqlArr['http']       = kyc_filter_var($data[15]); // http
    $sqlArr['bsno']       = kyc_filter_var($data[16]); // 統一編號
    $sqlArr['zip']        = kyc_filter_var($data[17]); // 郵遞區號
    $sqlArr['addr']       = kyc_filter_var($data[18]); // address
    $sqlArr['addr_ok']    = kyc_filter_var($data[19]); // 1:address ok
    $sqlArr['amt1']       = kyc_filter_var($data[20]); // 信用額度
    $sqlArr['cust_type']  = kyc_filter_var($data[21]); // 客戶類別
    $sqlArr['cust_loca']  = kyc_filter_var($data[22]); // 區域別
    $sqlArr['data_type']  = kyc_filter_var($data[23]); // 資料類別 (1:客戶 2:同行)
    $sqlArr['price_type'] = kyc_filter_var($data[24]); // 售價採用 (1:依一般單價 2:依同行批發價格 3:依大賣埸價格)
    $sqlArr['sex']        = kyc_filter_var($data[25]); // 性別 (1:其他  2:男生 3:女生)
    $sqlArr['prt_ctrl']   = kyc_filter_var($data[26]); // 列印控制碼
    $sqlArr['username']   = kyc_filter_var($data[27]); // 輸入者代號
    $sqlArr['createdate'] = kyc_filter_var($data[28]); // 建檔日期
    $sqlArr['editdate']   = kyc_filter_var($data[29]); // 最近修改日期
    $sqlArr['c_remark']   = kyc_filter_var($data[30]); // 備註
    
    $tbl= 'kyc_repair_00_customer';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_customer_memo($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['c_class']    = kyc_filter_var($data[1]); // 類別  1客戶指送檔  2 客戶發票檔'
    $sqlArr['cust_no']    = kyc_filter_var($data[2]); // 客戶編號
    $sqlArr['c_seq']      = kyc_filter_var($data[3]); // 序號    
    $sqlArr['c_desc1']    = kyc_filter_var($data[4]); // 連絡人(公司抬頭)
    $sqlArr['c_desc2']    = kyc_filter_var($data[5]); // 連絡人電話(公司統編)
    $sqlArr['c_desc3']    = kyc_filter_var($data[6]); // 連絡人address(發票住址)

    $tbl= 'kyc_repair_00_customer_memo';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_suply($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['suply_no']   = kyc_filter_var($data[1]);  // 廠商編號
    $sqlArr['name1']      = kyc_filter_var($data[2]);  // 廠商簡稱
    $sqlArr['name2']      = kyc_filter_var($data[3]);  // 廠商全稱
    $sqlArr['brief_no']   = kyc_filter_var($data[4]);  // 注音簡碼
    $sqlArr['tel1']       = kyc_filter_var($data[5]);  // 電話 1
    $sqlArr['tel2']       = kyc_filter_var($data[6]);  // 電話 2
    $sqlArr['big']        = kyc_filter_var($data[7]);  // 行動
    $sqlArr['bbcall']     = kyc_filter_var($data[8]);  // 其他電話
    $sqlArr['fax']        = kyc_filter_var($data[9]);  // 傳真
    $sqlArr['bsno']       = kyc_filter_var($data[10]); // 統一編號
    $sqlArr['boss']       = kyc_filter_var($data[11]); // 負責人
    $sqlArr['atten']      = kyc_filter_var($data[12]); // 連絡人
    $sqlArr['e_mail']     = kyc_filter_var($data[13]); // 電子信箱
    $sqlArr['http']       = kyc_filter_var($data[14]); // 網址
    $sqlArr['zipc']       = kyc_filter_var($data[15]); // 公司住址郵遞區號
    $sqlArr['companyadd'] = kyc_filter_var($data[16]); // 公司住址
    $sqlArr['zipm']       = kyc_filter_var($data[17]); // 通訊住址郵遞區號
    $sqlArr['commuaddr']  = kyc_filter_var($data[18]); // 通訊住址
    $sqlArr['username']   = kyc_filter_var($data[19]); // 輸入者代號
    $sqlArr['createdate'] = kyc_filter_var($data[20]); // 建檔日期
    $sqlArr['editdate']   = kyc_filter_var($data[21]); // 最近修改日期
    $sqlArr['c_remark']   = kyc_filter_var($data[22]); // 備註 

    $tbl= 'kyc_repair_00_suply';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_employ($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['employ_no']  = kyc_filter_var($data[1]);   // 員工編號
    $sqlArr['c_name']     = kyc_filter_var($data[2]);   // 員工姓名
    $sqlArr['sex']        = kyc_filter_var($data[3]);   // 性別  (1:男生  2:女生)
    $sqlArr['birth']      = kyc_filter_var($data[4]);   // 生日
    $sqlArr['idno']       = kyc_filter_var($data[5]);   // 身份証
    $sqlArr['school']     = kyc_filter_var($data[6]);   // 學歷
    $sqlArr['wktitle']    = kyc_filter_var($data[7]);   // 職稱
    $sqlArr['datest']     = kyc_filter_var($data[8]);   // 到職日
    $sqlArr['dateed']     = kyc_filter_var($data[9]);   // 離職日
    $sqlArr['telno1']     = kyc_filter_var($data[10]);  // 電話1
    $sqlArr['telno2']     = kyc_filter_var($data[11]);  // 電話2
    $sqlArr['big']        = kyc_filter_var($data[12]);  // 行動
    $sqlArr['bbcall']     = kyc_filter_var($data[13]);  // 其他電話
    $sqlArr['zip']        = kyc_filter_var($data[14]);  // 戶籍郵遞
    $sqlArr['addr']       = kyc_filter_var($data[15]);  // 戶籍地址
    $sqlArr['zip1']       = kyc_filter_var($data[16]);  // 通訊郵遞
    $sqlArr['addr1']      = kyc_filter_var($data[17]);  // 通訊地址
    $sqlArr['username']   = kyc_filter_var($data[18]);  // 輸入者代號
    $sqlArr['createdate'] = kyc_filter_var($data[19]);  // 建檔日期
    $sqlArr['editdate']   = kyc_filter_var($data[20]);  // 最近修改日期
    $sqlArr['c_remark']   = kyc_filter_var($data[21]);  // 備註

    $tbl= 'kyc_repair_00_employ';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_prod($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']     = $comp_id;
    $sqlArr['fact_id']     = $fact_id;
    $sqlArr['prod_no']     = kyc_filter_var($data[1]);   // 產品編號
    $sqlArr['barcode']     = kyc_filter_var($data[2]);   // 條碼編號
    $sqlArr['inter_code']  = kyc_filter_var($data[3]);   // 國際碼
    $sqlArr['c_brand']     = kyc_filter_var($data[4]);   // 產品廠牌(國際.日立....)
    $sqlArr['c_type']      = kyc_filter_var($data[5]);   // 產品類別(冷氣.電視.冰箱)
    $sqlArr['description'] = kyc_filter_var($data[6]);   // 產品名稱
    $sqlArr['c_unit']      = kyc_filter_var($data[7]);   // 單位
    $sqlArr['c_prod']      = kyc_filter_var($data[8]);   // 產品類別
    $sqlArr['c_safe']      = kyc_filter_var($data[9]);   // 安全庫存量
    $sqlArr['c_locatn']    = kyc_filter_var($data[10]);  // 儲位
    $sqlArr['in_price']    = kyc_filter_var($data[11]);  // 進貨單價
    $sqlArr['sale_price']  = kyc_filter_var($data[12]);  // 一般銷貨單價
    $sqlArr['c_price1']    = kyc_filter_var($data[13]);  // 同行批發價
    $sqlArr['c_price3']    = kyc_filter_var($data[14]);  // 賣廠批發價
    $sqlArr['c_price2']    = kyc_filter_var($data[15]);  // 客戶建議售價
    $sqlArr['c_price_av']  = kyc_filter_var($data[16]);  // 平均單價
    $sqlArr['c_return']    = kyc_filter_var($data[17]);  // 回收處理廢
    $sqlArr['c_date']      = kyc_filter_var($data[18]);  // 作廢日期
    $sqlArr['c_yn']        = kyc_filter_var($data[19]);  // 管理庫存  (1:是  2:否)
    $sqlArr['username']    = kyc_filter_var($data[20]);  // 輸入者代號
    $sqlArr['create_date'] = kyc_filter_var($data[21]);  // 建立日期
    $sqlArr['update_date'] = kyc_filter_var($data[22]);  // 更新日期
    $sqlArr['c_remark']    = kyc_filter_var($data[23]);  // 備註

    $tbl= 'kyc_repair_00_prod';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_prod_fix($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']     = $comp_id;
    $sqlArr['fact_id']     = $fact_id;
    $sqlArr['prod_no']     = kyc_filter_var($data[1]); // 產品編號
    $sqlArr['c_seq']       = kyc_filter_var($data[2]); // 序號
    $sqlArr['prod_no_fix'] = kyc_filter_var($data[3]); // 維修零件編號
    $sqlArr['c_qty']       = kyc_filter_var($data[4]); // 數量
    $sqlArr['c_wage']      = kyc_filter_var($data[5]); // 工資
    $sqlArr['c_cost']      = kyc_filter_var($data[6]); // 成本單價
    $sqlArr['c_sale']      = kyc_filter_var($data[7]); // 銷售單價
    $sqlArr['c_remark']    = kyc_filter_var($data[8]); // 備註 

    $tbl= 'kyc_repair_00_prod_fix';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_stock($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']     = $comp_id;
    $sqlArr['fact_id']     = $fact_id;
    $sqlArr['prod_no']     = kyc_filter_var($data[1]); // 產品編號
    $sqlArr['c_house']     = kyc_filter_var($data[2]); // 倉庫別
    $sqlArr['c_datein']    = kyc_filter_var($data[3]); // 進貨日期
    $sqlArr['c_qty']       = kyc_filter_var($data[4]); // 現有庫存
    $sqlArr['c_cost']      = kyc_filter_var($data[5]); // 進貨單價
    $tbl= 'kyc_repair_01_stock';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_kinds($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']  = $comp_id;
    $sqlArr['fact_id']  = $fact_id;
    $sqlArr['kind']     = kyc_filter_var($data[1]); // 片語類別(BRAND,C_TYPE)
    $sqlArr['code']     = kyc_filter_var($data[2]); // 片語代碼',
    $sqlArr['desc']     = kyc_filter_var($data[3]); // 片語說明(BRAND國際.日立.大金)(C_TYPE分離式冷氣.變頻冷氣.窗型冷氣)
    $sqlArr['c_note2']  = kyc_filter_var($data[4]); // 補充說明2
    $sqlArr['c_note3']  = kyc_filter_var($data[5]); // 補充說明3
    $sqlArr['sort']     = kyc_filter_var($data[6]); // 排序
    $sqlArr['c_num2']   = kyc_filter_var($data[7]); // 數字2
    $sqlArr['c_num3']   = kyc_filter_var($data[8]); // 數字3
    $tbl= 'kyc_repair_00_kinds';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_fail($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['c_class']    = kyc_filter_var($data[1]); // 片語類別  1:故障說明  2:處理說明
    $sqlArr['c_type']     = kyc_filter_var($data[2]); // 類別群組,對應到kyc_repair_00_kinds kind
    $sqlArr['desc']       = kyc_filter_var($data[3]); // 說明
    $sqlArr['brief_no']   = kyc_filter_var($data[4]); // 簡碼
    $sqlArr['sort']       = kyc_filter_var($data[5]); // 排序

    $tbl= 'kyc_repair_00_fail';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_fix($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['c_workno']          = kyc_filter_var($data[1]); // 維修單號
    $sqlArr['ser_type']          = kyc_filter_var($data[2]); // 處理別(1:內修  2:外修  3:服務  4:銷售  5:代工)
    $sqlArr['c_pri']             = kyc_filter_var($data[3]); // 處理序順
    $sqlArr['c_date']            = kyc_filter_var($data[4]); // 叫修日期+時間
    $sqlArr['reservation_date']  = kyc_filter_var($data[5]); // 客戶預約日期+時間
    $sqlArr['dispatch_date']     = kyc_filter_var($data[6]); // 派工日期 + 時間
    $sqlArr['construction_date'] = kyc_filter_var($data[7]); // 施工日期 + 時間
    $sqlArr['estimate_date']     = kyc_filter_var($data[8]); // 預訂完成日期
    $sqlArr['connect_man']       = kyc_filter_var($data[9]); // 連絡人
    $sqlArr['connect_tel']       = kyc_filter_var($data[10]); // 連絡電話
    $sqlArr['connect_addr']      = kyc_filter_var($data[11]); // 施工地點
    $sqlArr['c_recept']    = kyc_filter_var($data[12]); // 接待人員
    $sqlArr['c_arrange']   = kyc_filter_var($data[13]); // 接洽人員
    $sqlArr['cusid']       = kyc_filter_var($data[14]); // 客戶編號
    $sqlArr['c_name']      = kyc_filter_var($data[15]); // 客戶姓名
    $sqlArr['telno']       = kyc_filter_var($data[16]); // 客戶電話
    $sqlArr['c_address']   = kyc_filter_var($data[17]); // 住址
    $sqlArr['c_brand']     = kyc_filter_var($data[18]); // 產品廠牌(國際.日立....)
    $sqlArr['c_type']      = kyc_filter_var($data[19]); // 產品類別(冷氣.電視.冰箱)
    $sqlArr['pur_date']    = kyc_filter_var($data[20]); // 購買日期
    $sqlArr['prod_no']     = kyc_filter_var($data[21]); // 產品編號
    $sqlArr['c_serial']    = kyc_filter_var($data[22]); // 機號(產品序號)
    $sqlArr['c_card']      = kyc_filter_var($data[23]); // 保證卡編號
    $sqlArr['c_overpro']   = kyc_filter_var($data[24]); // 保固類別  (0:新裝  1:保固內  2:過保固  3:外購)'
    $sqlArr['pur_amt']     = kyc_filter_var($data[25]); // 機種原購買金額'
    $sqlArr['c_fail']      = kyc_filter_var($data[26]); // 故障說明
    $sqlArr['c_process']   = kyc_filter_var($data[27]); // 處理情形
    $sqlArr['out_suply']   = kyc_filter_var($data[28]); // 外修廠商
    $sqlArr['out_date']    = kyc_filter_var($data[29]); // 外修日期+時間
    $sqlArr['out_cost']    = kyc_filter_var($data[30]); // 外修成本
    $sqlArr['in_cost']     = kyc_filter_var($data[31]); // 零件成本
    $sqlArr['amt_part']    = kyc_filter_var($data[32]); // 零件費
    $sqlArr['amt_ser']     = kyc_filter_var($data[33]); // 服務費
    $sqlArr['c_amt']       = kyc_filter_var($data[34]); // 金額小計 
    $sqlArr['c_taxinv']    = kyc_filter_var($data[35]); // 稅額 
    $sqlArr['c_total']     = kyc_filter_var($data[36]); // 合計應收     
    $sqlArr['amt_acp']     = kyc_filter_var($data[37]); // 已收金額
    $sqlArr['amt_dis']     = kyc_filter_var($data[38]); // 折讓金額
    $sqlArr['c_invono']    = kyc_filter_var($data[39]); // 發票號碼
    $sqlArr['c_dateinv']   = kyc_filter_var($data[40]); // 發票日期
    $sqlArr['c_invtype']   = kyc_filter_var($data[41]); // 發票類別
    $sqlArr['close_date']  = kyc_filter_var($data[42]); // 修妥日期
    $sqlArr['acp_date']    = kyc_filter_var($data[43]); // 收款日期
    $sqlArr['coll_type']   = kyc_filter_var($data[44]); // 收款類別
    $sqlArr['take_date']   = kyc_filter_var($data[45]); // 客戶取回日期
    $sqlArr['employ']      = kyc_filter_var($data[46]); // 維修人員(json格式)
    $sqlArr['employ_rat']  = kyc_filter_var($data[47]); // 維修人員獎金比率(json格式)
    $sqlArr['c_remark']    = kyc_filter_var($data[48]); // 備註
    $sqlArr['username']    = kyc_filter_var($data[49]); // 輸入者代號
    $sqlArr['create_date'] = kyc_filter_var($data[50]); // 建立日期
    $sqlArr['update_date'] = kyc_filter_var($data[51]); // 更新日期

    $tbl= 'kyc_repair_12_fix';
    $id = sqlInsert($tbl ,$sqlArr);
}

function insert_fix_detail($data="") {
    global $xoopsDB ;
    $sqlArr=array();
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];   

    $sqlArr['comp_id']    = $comp_id;
    $sqlArr['fact_id']    = $fact_id;
    $sqlArr['c_workno']   = kyc_filter_var($data[1]);  // 服務單號
    $sqlArr['c_seq']      = kyc_filter_var($data[2]);  // 序號
    $sqlArr['c_house']    = kyc_filter_var($data[3]);  // 倉庫別
    $sqlArr['prod_no']    = kyc_filter_var($data[4]);  // 維修零件編號
    $sqlArr['c_note1']    = kyc_filter_var($data[5]);  // 零件補充說明
    $sqlArr['c_qty']      = kyc_filter_var($data[6]);  // 數量
    $sqlArr['c_price']    = kyc_filter_var($data[7]);  // 維修單價
    $sqlArr['c_amt']      = kyc_filter_var($data[8]);  // 維修金額
    $sqlArr['c_cost']     = kyc_filter_var($data[9]);  // 成本單價
    $sqlArr['c_remark']   = kyc_filter_var($data[10]); // 備註

    $tbl= 'kyc_repair_12_fix_detail';
    $id = sqlInsert($tbl ,$sqlArr);
}

function clear_data($file_name="") {
  global $xoopsDB;
  $tbl= $file_name;
  $comp_id = $_SESSION["comp_id"];
  $fact_id = $_SESSION["fact_id"];   

  $sql="DELETE FROM `" . $tbl . "` WHERE `comp_id`='{$comp_id}' and `fact_id`='{$fact_id}'";

  $xoopsDB->query($sql) or die($xoopsDB->error);

  // if ($xoopsDB->query($sql)) {  
  //     throw new Exception($xoopsDB->error);
  // }    
    
}
