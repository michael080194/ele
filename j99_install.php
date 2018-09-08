
<?php
require_once 'header.php';
require_once 'function.php';


$result = "";
if (isset($_POST['submit']) && isset($_POST['setup'])) {
    $setup = $_POST['setup'];
    for ($i = 0; $i < Count($setup); $i++) {
        switch ($setup[$i]) {
            case "01": //產生資料表
                gen_table();
                break;
            default:
                break;
        }
    }
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>安裝設定程式</title>
  </head>
  <body>
    <h1>安裝設定程式</h1>
    <form name="form" method="post" action="">
      <input type="checkbox" value="01" name="setup[]"> 產生資料表<br>

      <p><input name="submit" type="submit" value="執行" /></p>
    </form>
    <p style="color:#FF0000;"><?php echo $result; ?></p>
    </div>
    </div>
  </body>
</html>
<?php
########################################
# 更新主程式
########################################
function gen_table()
{
    $web_path = str_replace("\\", "/", dirname(__FILE__));
    global $xoopsDB;
    mk_dir($web_path . "/uploads");

    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_user');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_kinds');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_fail');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_customer');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_customer_memo');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_suply');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_employ');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_prod');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_00_prod_fix');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_01_stock');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_12_fix');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_12_fix_detail');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_50_system_news');
    $xoopsDB->query('DROP TABLE IF EXISTS kyc_repair_files_center');    


    create_table();

    return true;
}
#####################################################################################
#  建立目錄
#####################################################################################
function mk_dir($dir = "")
{
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
########################################
# 建立資料表 show_kind
########################################
function create_table()
{

  global $xoopsDB;
  $sql = "CREATE TABLE `kyc_repair_00_user` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(20)      NOT NULL COMMENT '公司別',
    `fact_id` char(20)      NOT NULL COMMENT '廠別',
    `user`    char(20)      NOT NULL COMMENT '使用者帳號',
    `pass`    varchar(255)  NOT NULL COMMENT '使用者密碼',
    `name`    varchar(255)  NOT NULL COMMENT '使用者姓名',
    `email`   varchar(255)           COMMENT '使用者Email',
    `group`   varchar(255)           COMMENT '群組',
    `big_serial`   varchar(255)      COMMENT '手機序號',
    `big_enable`  enum('0','1') default '0'  COMMENT '手機啟用',
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));

  $sql = "CREATE TABLE `kyc_repair_00_kinds` (
    `kind_id`    int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',  
    `kind`       varchar(255) NOT NULL COMMENT '片語類別(BRAND,C_TYPE)',
    `code`       varchar(10)  NOT NULL COMMENT '片語代碼',
    `desc`       varchar(255) NOT NULL COMMENT '片語說明(BRAND國際.日立.大金)(C_TYPE分離式冷氣.變頻冷氣.窗型冷氣)',
    `c_note2`    varchar(255) DEFAULT '' COMMENT '補充說明2',
    `c_note3`    varchar(255) DEFAULT '' COMMENT '補充說明3',
    `sort`       smallint(5)  UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',  
    `c_num2`     int(10) UNSIGNED  DEFAULT '0' COMMENT '數字2',
    `c_num3`     int(10) UNSIGNED  DEFAULT '0' COMMENT '數字3',
    PRIMARY KEY (`kind_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));

  $sql = "CREATE TABLE `kyc_repair_00_fail` (
    `fail_id`    int(10)      unsigned NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04)     NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04)     NOT NULL DEFAULT '' COMMENT '廠別',  
    `c_class`    varchar(10)  NOT NULL            COMMENT '片語類別  1:故障說明  2:處理說明',
    `c_type`     varchar(10)  NOT NULL DEFAULT '' COMMENT '類別群組 對應到kyc_repair_00_kinds kind',
    `desc`       varchar(255) NOT NULL            COMMENT '說明',
    `brief_no`   varchar(20)  DEFAULT ''          COMMENT '簡碼',
    `sort`       smallint(5)  UNSIGNED NOT NULL DEFAULT   '0' COMMENT '排序',
    PRIMARY KEY (`fail_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));  

  $sql = "CREATE TABLE `kyc_repair_00_customer` (
    `cust_id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `cust_no`    char(20) NOT NULL DEFAULT '' COMMENT '客戶編號',
    `c_name`     varchar(100)      DEFAULT '' COMMENT '客戶名稱',
    `allname`    varchar(255)      DEFAULT '' COMMENT '公司名稱',
    `birth_yy`   smallint(5) UNSIGNED DEFAULT '0' COMMENT '出生年份',
    `birth`      char(10)          DEFAULT '' COMMENT '出生月份+日期',
    `tel1`       varchar(255)      DEFAULT '' COMMENT '電話1',
    `tel2`       varchar(255)      DEFAULT '' COMMENT '電話2',
    `brief_no`   char(20)          DEFAULT '' COMMENT '客戶簡碼',
    `big`        varchar(255)      DEFAULT '' COMMENT '行動電話',
    `fax`        varchar(255)      DEFAULT '' COMMENT '傳真',
    `atten`      varchar(100)      DEFAULT '' COMMENT '連絡人',
    `bbcall`     varchar(255)      DEFAULT '' COMMENT '連絡人電話',
    `boss`       varchar(100)      DEFAULT '' COMMENT '負責人',
    `e_mail`     varchar(255)      DEFAULT '' COMMENT 'e_mail',
    `http`       varchar(255)      DEFAULT '' COMMENT 'http',
    `bsno`       char(20)          DEFAULT '' COMMENT '統一編號',
    `zip`        char(10)          DEFAULT '' COMMENT '郵遞區號',
    `addr`       varchar(255)      DEFAULT '' COMMENT 'address',
    `addr_ok`    enum('1','0')     DEFAULT '1' COMMENT '1:address ok',
    `amt1`       int(10) UNSIGNED  DEFAULT '0' COMMENT '信用額度',
    `cust_type`  char(10)          DEFAULT '' COMMENT '客戶類別',
    `cust_loca`  char(10)          DEFAULT '' COMMENT '區域別',
    `data_type`  smallint(5) UNSIGNED NOT NULL DEFAULT '1' COMMENT '資料類別 (1:客戶 2:同行)',
    `price_type` smallint(5) UNSIGNED NOT NULL DEFAULT '1'  COMMENT '售價採用 (1:依一般單價   2:依同行批發價格  3:依大賣埸價格)',
    `sex` enum('1','2','3')     NOT NULL DEFAULT '1' COMMENT '性別 (1:其他  2:男生 3:女生)',
    `prt_ctrl`   char(10)      DEFAULT '' COMMENT '列印控制碼',
    `username`   varchar(100)  DEFAULT '' COMMENT '輸入者代號',
    `createdate` datetime      DEFAULT NULL COMMENT '建檔日期',
    `editdate`   datetime      DEFAULT NULL COMMENT '最近修改日期',
    `c_remark`   text          DEFAULT '' COMMENT '備註',
      PRIMARY KEY (`cust_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));  


  $sql = "CREATE TABLE `kyc_repair_00_customer_memo` (
    `cust_memo_id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id`  char(04) NOT NULL DEFAULT ''  COMMENT '公司別',
    `fact_id`  char(04) NOT NULL DEFAULT ''  COMMENT '廠別',   
    `c_class`     enum('1','2')     DEFAULT '1' COMMENT '類別  1客戶指送檔  2 客戶發票檔',    
    `cust_no`     char(20) NOT NULL DEFAULT ''  COMMENT '客戶編號',
    `c_seq`       smallint(5)   UNSIGNED   DEFAULT '0' COMMENT '序號',  
    `c_desc1`     varchar(100)      DEFAULT ''  COMMENT '連絡人(公司抬頭)',
    `c_desc2`     varchar(100)      DEFAULT ''  COMMENT '連絡人電話(公司統編)',
    `c_desc3`     varchar(100)      DEFAULT ''  COMMENT '連絡人address(發票住址)',
      PRIMARY KEY (`cust_memo_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));    

  $sql = "CREATE TABLE `kyc_repair_00_suply` (
    `suply_id`   int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04)      NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04)      NOT NULL DEFAULT '' COMMENT '廠別',   
    `suply_no`   varchar(20)   NOT NULL DEFAULT '' COMMENT '廠商編號',
    `name1`      varchar(100)  DEFAULT '' COMMENT '廠商簡稱',
    `name2`      varchar(255)  DEFAULT '' COMMENT '廠商全稱',
    `brief_no`   varchar(10)   DEFAULT '' COMMENT '注音簡碼',
    `tel1`       varchar(255)  DEFAULT '' COMMENT '電話 1',
    `tel2`       varchar(255)  DEFAULT '' COMMENT '電話 2',
    `big`        varchar(255)  DEFAULT '' COMMENT '行動',
    `bbcall`     varchar(255)  DEFAULT '' COMMENT '其他電話',
    `fax`        varchar(255)  DEFAULT '' COMMENT '傳真',
    `bsno`       varchar(10)   DEFAULT '' COMMENT '統一編號',
    `boss`       varchar(100)  DEFAULT '' COMMENT '負責人',
    `atten`      varchar(100)  DEFAULT '' COMMENT '連絡人',
    `e_mail`     varchar(255)  DEFAULT '' COMMENT '電子信箱',
    `http`       varchar(255)  DEFAULT '' COMMENT '網址',
    `zipc`       char(10)      DEFAULT '' COMMENT '公司住址郵遞區號',
    `companyadd` varchar(255)  DEFAULT '' COMMENT '公司住址',
    `zipm`       char(10)      DEFAULT '' COMMENT '通訊住址郵遞區號',
    `commuaddr`  varchar(255)  DEFAULT '' COMMENT '通訊住址',
    `username`   varchar(100)  DEFAULT '' COMMENT '輸入者代號',
    `createdate` datetime       DEFAULT NULL COMMENT '建檔日期',
    `editdate`   datetime       DEFAULT NULL COMMENT '最近修改日期',
    `c_remark`   text          DEFAULT ''  COMMENT '備註',
      PRIMARY KEY (`suply_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));    

  $sql = "CREATE TABLE `kyc_repair_00_employ` (
    `employ_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `employ_no`  varchar(20) NOT NULL DEFAULT '' COMMENT '員工編號',
    `c_name`     varchar(100)  DEFAULT '' COMMENT '員工姓名',
    `sex`        enum('1','2') COMMENT            '性別  (1:男生  2:女生)',
    `birth`      date          DEFAULT NULL COMMENT '生日',
    `idno`       varchar(20)   DEFAULT '' COMMENT '身份証',
    `school`     varchar(100)  DEFAULT '' COMMENT '學歷',
    `wktitle`    varchar(100)  DEFAULT '' COMMENT '職稱',
    `datest`     date          DEFAULT NULL COMMENT '到職日',
    `dateed`     date          DEFAULT NULL COMMENT '離職日',
    `telno1`     varchar(100)  DEFAULT '' COMMENT '電話1',
    `telno2`     varchar(100)  DEFAULT '' COMMENT '電話2',
    `big`        varchar(100)  DEFAULT '' COMMENT '行動',
    `bbcall`     varchar(100)  DEFAULT '' COMMENT '其他電話',
    `zip`        char(10)      DEFAULT '' COMMENT '戶籍郵遞',
    `addr`       varchar(255)  DEFAULT '' COMMENT '戶籍地址',
    `zip1`       char(10)      DEFAULT '' COMMENT '通訊郵遞',
    `addr1`      varchar(255)  DEFAULT '' COMMENT '通訊地址',
    `username`   varchar(100)  DEFAULT '' COMMENT '輸入者代號',
    `createdate` datetime       DEFAULT NULL COMMENT '建檔日期',
    `editdate`   datetime       DEFAULT NULL COMMENT '最近修改日期',
    `c_remark`   text          DEFAULT ''  COMMENT '備註',
      PRIMARY KEY (`employ_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));    

  $sql = "CREATE TABLE `kyc_repair_00_prod` (
    `prod_id`     int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `prod_no`     varchar(100)  NOT NULL DEFAULT '' COMMENT '產品編號',
    `barcode`     varchar(30)   DEFAULT '' COMMENT '條碼編號',
    `inter_code`  varchar(30)   DEFAULT '' COMMENT '國際碼',
    `c_brand`     varchar(50)  DEFAULT '' COMMENT '產品廠牌(國際.日立....)',
    `c_type`      varchar(50)  DEFAULT '' COMMENT '產品類別(冷氣.電視.冰箱)',
    `description` varchar(255)  DEFAULT '' COMMENT '產品名稱',
    `c_unit`      char(20)      DEFAULT '' COMMENT '單位',
    `c_prod`      char(10)      DEFAULT '' COMMENT '產品類別',
    `c_safe`      int(10) UNSIGNED   DEFAULT '0' COMMENT '安全庫存量',
    `c_locatn`    varchar(20)        DEFAULT '' COMMENT '儲位',
    `in_price`    int(10) UNSIGNED   DEFAULT '0' COMMENT '進貨單價',
    `sale_price`  int(10) UNSIGNED   DEFAULT '0' COMMENT '一般銷貨單價',
    `c_price1`    int(10) UNSIGNED   DEFAULT '0' COMMENT '同行批發價',
    `c_price3`    int(10) UNSIGNED   DEFAULT '0' COMMENT '賣廠批發價',
    `c_price2`    int(10) UNSIGNED   DEFAULT '0' COMMENT '客戶建議售價',
    `c_price_av`  int(10) UNSIGNED   DEFAULT '0' COMMENT '平均單價',
    `c_return`    int(10) UNSIGNED   DEFAULT '0' COMMENT '回收處理廢',
    `c_date`      date          DEFAULT NULL COMMENT '作廢日期',
    `c_yn`        enum('1','2') DEFAULT '1' COMMENT '管理庫存  (1:是  2:否)',
    `title`       text          DEFAULT '' COMMENT '產品摘要',
    `content`     text          DEFAULT '' COMMENT '產品內容',
    `enable`      enum('1','0')         NOT NULL DEFAULT '1' COMMENT '狀態',
    `sort`        smallint(5)  UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序',
    `counter`     int(10)      UNSIGNED NOT NULL DEFAULT '0' COMMENT '人氣',
    `username`    varchar(100) DEFAULT '' COMMENT '輸入者代號',
    `create_date` datetime     DEFAULT NULL COMMENT '建立日期',
    `update_date` datetime     DEFAULT NULL COMMENT '更新日期',
    `c_remark`    text         DEFAULT '' COMMENT '備註',
    PRIMARY KEY (`prod_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));  


  $sql = "CREATE TABLE `kyc_repair_00_prod_fix` (
    `prod_fix_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `prod_no`     varchar(100)  NOT NULL   DEFAULT '' COMMENT '產品編號',
    `c_seq`       smallint(5)   UNSIGNED   DEFAULT '0' COMMENT '序號',
    `prod_no_fix` varchar(255)  DEFAULT '' COMMENT '維修零件編號',
    `c_qty`       int(10)       UNSIGNED   DEFAULT '0' COMMENT '數量',
    `c_wage`      int(10)       UNSIGNED   DEFAULT '0' COMMENT '工資',
    `c_cost`      int(10)       UNSIGNED   DEFAULT '0' COMMENT '成本單價',
    `c_sale`      int(10)       UNSIGNED   DEFAULT '0' COMMENT '銷售單價',
    `create_date` datetime      DEFAULT NULL COMMENT '建立日期',
    `update_date` datetime      DEFAULT NULL COMMENT '更新日期',
    `c_remark`    text          DEFAULT ''        COMMENT '備註',
    PRIMARY KEY (`prod_fix_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));  

  $sql = "CREATE TABLE `kyc_repair_01_stock` (
    `stock_id`    int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `prod_no`     varchar(100)  NOT NULL   DEFAULT '' COMMENT '產品編號',
    `c_house`     char(10)      DEFAULT '' COMMENT '倉庫別 ',
    `c_qty`       int(10)       UNSIGNED   DEFAULT '0' COMMENT '庫存數量',
    `c_cost`      int(10)       UNSIGNED   DEFAULT '0' COMMENT '進貨單價',
    `c_datein`    datetime         DEFAULT NULL COMMENT '最後進貨日期',
    PRIMARY KEY (`stock_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));  


  $sql = "CREATE TABLE `kyc_repair_12_fix` (
    `repair_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `c_workno`   varchar(20)  NOT NULL DEFAULT '' COMMENT '維修單號',
    `ser_type`   char(10)     DEFAULT '' COMMENT '處理別(1:內修  2:外修  3:服務  4:銷售  5:代工)', 
    `c_pri`      smallint(5)  UNSIGNED DEFAULT '0' COMMENT '處理序順',   
    `c_date`            datetime      DEFAULT NULL COMMENT '叫修日期+時間',
    `reservation_date`  datetime      DEFAULT NULL COMMENT '客戶預約日期+時間',
    `dispatch_date`     datetime      DEFAULT NULL COMMENT '派工日期 + 時間',
    `construction_date` datetime      DEFAULT NULL COMMENT '施工日期 + 時間',  
    `estimate_date`     datetime      DEFAULT NULL COMMENT '預訂完成日期',
    `connect_man`       varchar(50)   DEFAULT ''  COMMENT '連絡人',
    `connect_tel`       varchar(255)  DEFAULT ''  COMMENT '連絡電話',
    `connect_addr`      varchar(255)  DEFAULT ''  COMMENT '施工地點',
    `c_recept`          varchar(50)   DEFAULT ''  COMMENT '接待人員',
    `c_arrange`         varchar(50)   DEFAULT ''  COMMENT '接洽人員',  
    `cusid`             varchar(20)   DEFAULT ''  COMMENT '客戶編號',
    `c_name`            varchar(100)  DEFAULT ''  COMMENT '客戶姓名',
    `telno`             varchar(255)  DEFAULT ''  COMMENT '客戶電話',
    `big`               varchar(255)  DEFAULT ''  COMMENT '行動電話',
    `c_address`         varchar(255)  DEFAULT ''  COMMENT '住址',
    `c_brand`           varchar(50)   DEFAULT ''  COMMENT '產品廠牌(國際.日立....)',
    `c_type`            varchar(50)   DEFAULT ''  COMMENT '產品類別(冷氣.電視.冰箱)',
    `pur_date`          date          DEFAULT NULL COMMENT '購買日期',  
    `prod_no`           varchar(100)  DEFAULT ''  COMMENT '產品編號',
    `c_serial`          varchar(50)   DEFAULT ''  COMMENT '機號(產品序號)',
    `c_card`            varchar(50)   DEFAULT ''  COMMENT '保證卡編號',
    `c_overpro`         char(10)      DEFAULT ''  COMMENT '保固類別  (0:新裝  1:保固內  2:過保固  3:外購)',
    `pur_amt`           int(7)        UNSIGNED    DEFAULT '0' COMMENT '機種原購買金額',  
    `c_fail`            text          DEFAULT ''  COMMENT '故障說明',
    `c_process`         text          DEFAULT ''  COMMENT '處理情形',
    `out_suply`         char(20)      DEFAULT ''  COMMENT '外修廠商',
    `out_date`          datetime      DEFAULT NULL COMMENT '外修日期+時間',
    `out_cost`    int(7)       UNSIGNED    DEFAULT '0' COMMENT '外修成本',
    `in_cost`     int(7)       UNSIGNED    DEFAULT '0' COMMENT '零件成本',
    `amt_part`    int(7)       UNSIGNED    DEFAULT '0' COMMENT '零件費',
    `amt_ser`     int(7)       UNSIGNED    DEFAULT '0' COMMENT '服務費',
    `c_amt`       int(7)       UNSIGNED    DEFAULT '0' COMMENT '金額小計',  
    `c_taxinv`    int(7)       UNSIGNED    DEFAULT '0' COMMENT '稅額',  
    `c_total`     int(7)       UNSIGNED    DEFAULT '0' COMMENT '合計應收',    
    `amt_acp`     int(7)       UNSIGNED    DEFAULT '0' COMMENT '已收金額',
    `amt_dis`     int(7)       UNSIGNED    DEFAULT '0' COMMENT '折讓金額',
    `c_invono`    varchar(50)  DEFAULT ''  COMMENT '發票號碼',
    `c_dateinv`   date         DEFAULT NULL COMMENT '發票日期',
    `c_invtype`   char(10)     DEFAULT ''  COMMENT '發票類別',
    `close_date`  datetime     DEFAULT NULL COMMENT '完工日期',
    `acp_date`    datetime     DEFAULT NULL COMMENT '收款日期',
    `coll_type`   char(10)     DEFAULT ''  COMMENT '收款類別',
    `take_date`   datetime     DEFAULT NULL COMMENT '客戶取回日期',
    `employ`      varchar(255) DEFAULT ''  COMMENT '維修人員(json格式)',
    `employ_rat`  varchar(255) DEFAULT ''  COMMENT '維修人員獎金比率(json格式)',
    `c_remark`    text         DEFAULT ''  COMMENT '備註',  
    `username`    varchar(100) DEFAULT ''  COMMENT '輸入者代號',
    `create_date` datetime     DEFAULT NULL COMMENT '建立日期',
    `update_date` datetime     DEFAULT NULL COMMENT '更新日期',
    PRIMARY KEY (`repair_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));  

  $sql = "CREATE TABLE `kyc_repair_12_fix_detail` (
    `fix_detail_id` int(10)       UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '建檔序號',
    `comp_id`    char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id`    char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `c_workno`      varchar(20)   NOT NULL   DEFAULT '' COMMENT '服務單號',
    `c_seq`         smallint(5)   UNSIGNED   DEFAULT '0' COMMENT '序號',
    `c_house`       char(10)      DEFAULT '' COMMENT '倉庫別 ',
    `prod_no`       varchar(100)  DEFAULT '' COMMENT '維修零件編號',
    `c_note1`       varchar(100)  DEFAULT '' COMMENT '零件補充說明',
    `c_qty`         int(10)       UNSIGNED   DEFAULT '0' COMMENT '數量',
    `c_price`       int(10)       UNSIGNED   DEFAULT '0' COMMENT '維修單價',
    `c_amt`         int(10)       UNSIGNED   DEFAULT '0' COMMENT '維修金額',
    `c_cost`        int(10)       UNSIGNED   DEFAULT '0' COMMENT '成本單價',
    `c_remark`      text          DEFAULT '' COMMENT '備註',
    `create_date`   datetime      DEFAULT NULL COMMENT '建立日期',
    `update_date`   datetime      DEFAULT NULL COMMENT '更新日期',
    PRIMARY KEY (`fix_detail_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));

  $sql = "CREATE TABLE `kyc_repair_50_system_news` (
    `news_id`    int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '訊息編號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別',   
    `title`      varchar(255) NOT NULL COMMENT '訊息摘要',
    `content`    text NOT NULL COMMENT '訊息內容',
    `news_type`  tinyint(2) unsigned NOT NULL COMMENT '訊息類別',
    `start_date` date NOT NULL COMMENT '公告日期',
    `end_date`   datetime NOT NULL COMMENT '截止日期',
    `uid`        int(10) unsigned NOT NULL COMMENT '發布者編號',
    `enable` enum('1','0') NOT NULL COMMENT '是否啟用',
    PRIMARY KEY (`news_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));

  $sql = "CREATE TABLE `kyc_repair_files_center` (
    `files_sn` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
    `comp_id` char(04) NOT NULL DEFAULT '' COMMENT '公司別',
    `fact_id` char(04) NOT NULL DEFAULT '' COMMENT '廠別', 
    `col_name` varchar(255) NOT NULL default '' COMMENT '欄位名稱',
    `col_sn` smallint(5) unsigned NOT NULL default 0 COMMENT '欄位編號',
    `sort` smallint(5) unsigned NOT NULL default 0 COMMENT '排序',
    `kind` enum('img','file') NOT NULL default 'img' COMMENT '檔案種類',
    `file_name` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
    `file_type` varchar(255) NOT NULL default '' COMMENT '檔案類型',
    `file_size` int(10) unsigned NOT NULL default 0 COMMENT '檔案大小',
    `description` text NOT NULL COMMENT '檔案說明',
    `counter` mediumint(8) unsigned NOT NULL default 0 COMMENT '下載人次',
    `original_filename` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
    `hash_filename` varchar(255) NOT NULL default '' COMMENT '加密檔案名稱',
    `sub_dir` varchar(255) NOT NULL default '' COMMENT '檔案子路徑',
    `c_remark` varchar(255) NOT NULL default '' COMMENT '記錄圖片對應之產品編號',    
    PRIMARY KEY (`files_sn`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
  ";

  $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));
  return true;
}

########################################
# 檢查資料表是否存在(資料表)
########################################
function chk_isTable($tbl_name = "")
{
    global $xoopsDB;
    if (!$tbl_name) {
        return;
    }

    $sql = "SHOW TABLES LIKE '{$tbl_name}'"; //die($sql);

    $result = $xoopsDB->query($sql) or die(printf("Error: %s <br>" . $sql, $xoopsDB->sqlstate));

    if ($result->num_rows) {
        return true;
    }
    //欄位存在
    return false; //欄位不存在
}
