<?php
//上傳圖檔，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
function kyc_upload_file($uploadArr){
    global $xoopsDB;
    //  $uploadArr 傳過來的參數表
    $upname     = 'upfile'; // html 裡的 upload file name
    $col_name   =""; // 記載這張圖片的屬性 (PROD-->產品檔  FIX-->維修檔)
    $col_sn     =""; // 產品檔 或 維修檔 的 (unique key)
    $files_sn   = ""; // kyc_repair_files_center 的 unique key
    $subDir     = "uploads"; // 圖片存放的資料夾名稱 只記錄到 uploads/prod (沒記錄到 pic thumb file等資料夾)
    $desc       =""; // 每張圖片的說明
    $main_width = "1920"; // 大圖若超過此大小 則縮圖
    $thumb_width= "240";  // 小圖若超過此大小 則縮圖
    $return_col = "files_sn"; // 上傳完畢後要回傳 files_sn --> 所有上傳圖片所對應的 sn , file_name --> 上傳後的圖片名稱
    $prod_no    =""; // 記錄每張上傳圖片對的 產品編號或維修單號
    $tbl        = 'kyc_repair_files_center'; // 資料表名稱
    foreach ($uploadArr as $k => $val) {
         $$k = $val;
    }
    //die(var_dump($_FILES[$upname]));
    //引入上傳物件
    include_once "class/class.upload.php";

    //取消上傳時間限制
    set_time_limit(0);
    //設置上傳大小
    ini_set('memory_limit', '180M');

    $files = array();
    foreach ($_FILES[$upname] as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files)) {
                $files[$i] = array();
            }
            $files[$i][$k] = $v;
        }
    }

    // die(var_dump($files));
    $all_files_sn = array();
    foreach ($files as $file) {
        $sort = kyc_auto_sort($col_name , $col_sn , $tbl);
        //取得檔案
        $file_handle = new upload($file, "zh_TW");

        if ($file_handle->uploaded) {
            //取得副檔名
            $file_ext = $file_handle->file_src_name_ext;
            $ext      = strtolower($file_ext);

            //判斷檔案種類
            if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
                $kind = "img";
            } else {
                $kind = "file";
            }

            $file_handle->file_safe_name    = false;
            $file_handle->file_overwrite    = true;
            $file_handle->no_script         = false;
            $file_handle->file_new_name_ext = $ext;
            $new_filename = $file_handle->file_src_name_body;

            //die($new_filename);
            // $os_charset = (PATH_SEPARATOR == ':') ? "UTF-8" : "Big5";

            // if ($os_charset != _CHARSET) {
            //     $new_filename = iconv(_CHARSET, $os_charset, $new_filename);
            // }
            $file_handle->file_new_name_body = $new_filename;
            //若是圖片才縮圖
            if ($kind == "img" and !empty($main_width)) {
                if ($file_handle->image_src_x > $main_width) {
                    $file_handle->image_resize  = true;
                    $file_handle->image_x       = $main_width;
                    $file_handle->image_ratio_y = true;
                }
            }
            $path   = ($kind == "img") ? $subDir."/pic" : $subDir."/file";

            $file_handle->process($path);
            $file_handle->auto_create_dir = true;

            //若是圖片才製作小縮圖
            if ($kind == "img") {
                $file_handle->file_safe_name     = false;
                $file_handle->file_overwrite     = true;
                $file_handle->file_new_name_ext  = $ext;
                $file_handle->file_new_name_body = $new_filename;

                if ($file_handle->image_src_x > $thumb_width) {
                    $file_handle->image_resize  = true;
                    $file_handle->image_x       = $thumb_width;
                    $file_handle->image_ratio_y = true;
                }
                $file_handle->process($subDir."/thumb");
                $file_handle->auto_create_dir = true;
            }
            //上傳檔案
            if ($file_handle->processed) {
                $file_handle->clean();

                $file_name   = $file['name'];
                $description = is_null($desc) ? $file['name'] : $desc;

                chmod("{$path}/{$file_name}", 0755);
                if ($kind == "img") {
                    chmod("{$subDir}/thumb/{$file_name}", 0755);
                }

                $sqlArr=array();                    
                $sqlArr['comp_id']    = $_SESSION["comp_id"];        
                $sqlArr['fact_id']    = $_SESSION["fact_id"];    
                $sqlArr['col_name']   = $col_name; 
                $sqlArr['col_sn']     = $col_sn; 
                $sqlArr['sort']       = $sort; 
                $sqlArr['kind']       = $kind; 
                $sqlArr['description']= $desc;                 
                $sqlArr['file_name']  = $file_name; 
                $sqlArr['file_type']  = $file['type']; 
                $sqlArr['file_size']         = $file['size']; 
                $sqlArr['description']       = $description; 
                $sqlArr['counter']           = 0; 
                $sqlArr['original_filename'] = $file['name']; 
                $sqlArr['sub_dir']           = $subDir; 
                $sqlArr['c_remark']           = $prod_no; 
                if (!empty($files_sn)) {
                 $sqlArr['files_sn']           = $files_sn;   
                 sqlReplace($tbl , $sqlArr , "UPDATE");                    
                }else{
                 $insert_files_sn = sqlReplace($tbl , $sqlArr , "ADD");                            
                }
                $all_files_sn[] = $insert_files_sn;
                // }
            } else {
                redirect_header($_SERVER['PHP_SELF'], 3, "Error:" . $file_handle->error);
            }
        }
    }

    // die(var_dump($all_files_sn));
    if ($return_col == "files_sn"){
        return $all_files_sn;
    }else{
        return $file_name;
    }
}
//自動編號
function kyc_auto_sort($col_name , $col_sn, $tbl){
    $comp_id = $_SESSION["comp_id"];
    $fact_id = $_SESSION["fact_id"];      
    $condition=" `comp_id`='{$comp_id}' and `fact_id`='{$fact_id}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";
    $sql = "select max(sort) from `{$tbl}`  where {$condition}";

    $result    = sqlExcuteForSelectData($sql);
    list($max) = sqlFetch_row($result);
    // die("max=". ++$max);
    return ++$max;
}

//刪除實體檔案
function kyc_del_files($delArr){
    global $xoopsDB;
    // $delArr 傳過來的參數表
    $col_name   =""; // 記載這張圖片的屬性 (PROD-->產品檔  FIX-->維修檔)
    $col_sn     =""; // 產品檔 或 維修檔 的 (unique key)
    $files_sn   = ""; // kyc_repair_files_center 的 unique key    
    $tbl      = 'kyc_repair_files_center';

    foreach ($delArr as $k => $val) {
         $$k = $val;
    }

    $del_what = "";
    if (!empty($files_sn)) {
        $del_what = "`files_sn`='{$files_sn}'";
    } elseif (!empty($col_name) and !empty($col_sn)) {
        $del_what = "`col_name`='{$col_name}' and `col_sn`='{$col_sn}'";
    }

    if (empty($del_what)) {
        return false;
    }

    $sql = "select * from `{$tbl}`  where {$del_what}";
    // die($sql);
    $result = sqlExcuteForSelectData($sql);
    while ($datas=sqlFetch_assoc($result)){
        $comp_id   = $_SESSION["comp_id"];
        $fact_id   = $_SESSION["fact_id"]; 
        $files_sn  = $datas["files_sn"];     
        $kind      = $datas["kind"];     
        $file_name = $datas["file_name"];     
        $sub_dir   = $datas["sub_dir"];      

        $delCondition=" `comp_id`='{$comp_id}' and `fact_id`='{$fact_id}' and `files_sn` = '{$files_sn}'";
        sqlDelete($tbl ,  $delCondition);

        if ($kind == "img") {
            unlink("{$sub_dir}/pic/{$file_name}");
            unlink("{$sub_dir}/thumb/{$file_name}");
        } else {
            unlink("{$sub_dir}/file/{$file_name}");
        }

    }
    return true;
}

//取得單一圖片 $kind=images（大圖）,thumb（小圖）,file（檔案）$kind="url","dir"
function kyc_get_pic_file($getPicArr)
    {
        global $xoopsDB;
        // $getPicArr 傳過來的參數表
        $pic_kind  = "images"; // "images"（大圖）,"thumb"（小圖）,"file"（檔案）  
        $show_kind = "url";    // 圖片顯示方式 by "url" 或實體路徑 "dir"
        $files_sn  = "";       // kyc_repair_files_center 的 unique key  
        $col_name  = "prod";   // 記載這張圖片的屬性 (PROD-->產品檔  FIX-->維修檔)
        $col_sn    = "";       // 產品檔 或 維修檔 的 (unique key)    
        $tbl       = "kyc_repair_files_center";

        $comp_id = $_SESSION["comp_id"];
        $fact_id = $_SESSION["fact_id"]; 
        $dir1 = "/uploads/". $comp_id . $fact_id . "/" . $col_name ;

        foreach ($getPicArr as $k => $val) {
             $$k = $val;
        }    

        if ((empty($col_sn) or empty($col_name)) and empty($files_sn)) {
            return;
        }


        $where = $files_sn ? "where `files_sn`='{$files_sn}'" : 
        "where `col_name`='{$col_name}' and `col_sn`='{$col_sn}' order by sort limit 0,1";

        $sql = "select * from `{$tbl}` $where";
        // die($sql);
        $result = sqlExcuteForSelectData($sql);
        $files  = array();
        while ($all = sqlFetch_assoc($result) ) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            $path  = ($show_kind == "dir") ? XOOPS_ROOT_PATH : XOOPS_URL;
            if ($pic_kind == "thumb") {
                $path  .=  $dir1 . "/thumb";
                $file_path = XOOPS_ROOT_PATH . $dir1 . "/thumb";
                $files = (file_exists("{$file_path}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            } elseif ($pic_kind == "file") {
                $path  .=  $dir1 . "/file";
                $file_path = XOOPS_ROOT_PATH . $dir1 . "/file";             
                $files = (file_exists("{$file_path}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            } else {
                $path  .=  $dir1 . "/pic";
                $file_path = XOOPS_ROOT_PATH . $dir1 . "/pic";              
                $files = (file_exists("{$file_path}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            }
        }
        // die(var_dump($files));
        return $files;
}

//取得單一圖片 $kind=images（大圖）,thumb（小圖）,file（檔案）$kind="url","dir"
function kyc_show_files($showPicArr)
    {
        global $xoopsDB;
        // $getPicArr 傳過來的參數表
        $pic_kind  = "images"; // "images"（大圖）,"thumb"（小圖）,"file"（檔案）  
        $show_kind = "url";    // 圖片顯示方式 by "url" 或實體路徑 "dir"
        $col_name  = "prod";   // 記載這張圖片的屬性 (PROD-->產品檔  FIX-->維修檔)
        $col_sn    = "";       // 產品檔 或 維修檔 的 (unique key)    
        $tbl       = "kyc_repair_files_center";

        $comp_id = $_SESSION["comp_id"];
        $fact_id = $_SESSION["fact_id"]; 
        $dir1 = "/uploads/". $comp_id . $fact_id . "/" . $col_name ;

        foreach ($showPicArr as $k => $val) {
             $$k = $val;
        }    

        if ((empty($col_sn) or empty($col_name)) ) {
            return;
        }

        $where = "where `col_name`='{$col_name}' and `col_sn`='{$col_sn}' order by sort ";

        $sql = "select * from `{$tbl}` $where";
        // die($sql);
        $result = sqlExcuteForSelectData($sql);

        $slick = "<section class='kyc_slick_regular slider'>";
        while ($all = sqlFetch_assoc($result) ) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            $files  = "";
            $path  = ($show_kind == "dir") ? XOOPS_ROOT_PATH : XOOPS_URL;
            if ($pic_kind == "thumb") {
                $path  .=  $dir1 . "/thumb";
                $file_path = XOOPS_ROOT_PATH . $dir1 . "/thumb";
                $files = (file_exists("{$file_path}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            } elseif ($pic_kind == "file") {
              $files  = "";
            } else {
                $path  .=  $dir1 . "/pic";
                $file_path = XOOPS_ROOT_PATH . $dir1 . "/pic";              
                $files = (file_exists("{$file_path}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            }
            if($files != ""){
                $temp_file = '\"' . $files . '\"';
                $slick .= "<div>";
                $slick .= "<img src='" . $files . "' ";
                $slick .= "onclick='show_pic(" . $temp_file . ");' >";
                $slick .= "</div>";
            }
        }
        $slick .= "</section>";
        // die(var_dump($files));
        return $slick;
}

//其他自訂的共同的函數 應該沒在用了 107-06-20
function upload_file($sn , $subdir=""){
    global $xoopsDB,$xoopsUser;
    if (isset($_FILES)) {
        mk_dir(XOOPS_ROOT_PATH."/uploads/".$subdir);
        mk_dir(XOOPS_ROOT_PATH."/uploads/".$subdir."/prod");
        mk_dir(XOOPS_ROOT_PATH."/uploads/".$subdir."/prod/thumb/");
        $coverPath=XOOPS_ROOT_PATH."/uploads/".$subdir."/prod/";
        $thumbPath=XOOPS_ROOT_PATH."/uploads/".$subdir."/prod/thumb/";
        require_once XOOPS_ROOT_PATH."/modules/tadtools/upload/class.upload.php";
        $foo = new Upload($_FILES['pic']);
        if ($foo->uploaded) {
            $foo->file_new_name_body = 'cover_' . $sn;
            $foo->image_resize       = true;
            $foo->image_convert      = png;
            $foo->image_x            = 1200;
            $foo->image_ratio_y      = true;
            $foo->Process($coverPath);
            if ($foo->processed) {
                $foo->file_new_name_body = 'thumb_' . $sn;
                $foo->image_resize       = true;
                $foo->image_convert      = png;
                $foo->image_x            = 400;
                $foo->image_ratio_y      = true;
                $foo->Process($thumbPath);
            }
        }
    }

}