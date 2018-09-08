<?php
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>雲端維修管理</title>

    <!-- Bootstrap -->
    <link href="class/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js 讓 IE8 支援 HTML5 元素與媒體查詢 -->
    <!-- 警告：Respond.js 無法在 file:// 協定下運作 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (Bootstrap 所有外掛均需要使用) -->
    <script src="class/jquery.min.js"></script>
    <!-- 依需要參考已編譯外掛版本（如下），或各自獨立的外掛版本 -->
    <script src="class/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="class/sweet-alert/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="class/sweet-alert/sweetalert.css" />

    <script language="JavaScript">

     function chkinput(form1){
       if(form1.user.value ==""){
        alert("請輸入使用者帳號!");
        form1.user.select();
        return(false);
        }
      if(form1.pass.value ==""){
        alert("請輸入用於密碼!");
        form1.pass.select();
        return(false);
        }

       if(form1.input_code.value ==""){
         alert("請輸入驗証碼!");
         form1.input_code.select();
         return(false);
         }
       if(form1.test_code.value != form1.input_code.value){
         alert("驗証碼輸入錯誤!");
         form1.test_code.select();
         return(false);
         }
       return(true);
     }
     </script>
    <style>
        * {
          font-family: "微軟正黑體";
          transition: .5s;
        }

        h2 {
          text-align: center;
          margin-bottom: 30px;
        }

        label, input {
          font-size: 1.5em;
        }

        .form-group {
          margin: 0 10% 10%;
        }

        .indexText {
          background: rgba(0, 0, 0, 0);
          border-radius: 0px;
          box-shadow: none;
          border: 0px ;
          border-bottom: thin solid rgba(0, 0, 0, .3) !important;
        }

        .form-control {
          font-size: 1.3em; }
          .form-control:focus {
            box-shadow: none;
        }

        .verifyCode {
          width: 17%;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top:40px;min-height:550px;">
      <div class="row">
        <div class="col-md-4 col-md-offset-2" style="padding: 0px; box-sizing: border-box;">
          <div style="height: 503px; background: #E2EAFF;padding-top:20px;">
            <h2>系統版本：V1.0 Beta </h2>
            <h2>上線日期：2018-06-11</h2>
          </div>
        </div>

        <div class="col-md-4 bg-success" style="padding:20px;">
          <form name="form1" action="index.php" method="post" onsubmit="return chkinput(this)">
            <h2>雲端維修管理系統</h2>
            <div class="form-group">
              <label>帳號</label>
              <input type="text" class="form-control indexText" id="user" name="user" placeholder="帳號" autocomplete="off">
              <!-- <p class="help-block">請輸入帳號，最多8個字元</p> -->
            </div>

            <div class="form-group">
              <label>密碼</label>
              <input type="password" class="form-control indexText" id="pass"  name="pass" placeholder="密碼" autocomplete="off">
              <!-- <p class="help-block">請輸入密碼，最多8個字元</p> -->
            </div>

            <div class="form-group">
              <label style="display: block;">驗證碼</label>
              <input type="text" class="form-control indexText" id="input_code" name="input_code" placeholder="驗證碼" style="display: inline-block; width: 28%;" autocomplete="off">
              <?php
                $num  = str_shuffle("123456789");
                $nums = substr($num, 0, 4);
                for ($i = 0; $i < 4; $i++) {
                    echo "<img class='verifyCode' src=kyc/images/" . substr(strval($num), $i, 1) . ".png>";
                }
                ?>
            </div>

            <input type="hidden" name="test_code" value="<?=$nums?>">
            <center><button type="submit" name="submit" class="btn btn-default" style="border-radius: 50px; font-size: 2em;">登入</button></center>
          </form>
        </div>
      </div>
    </div>
</body>

</html>
<?php

if (isset($_POST["submit"])) {
    global $admin_user, $admin_pass, $xoopsDB;

    $user = clean_var('user', '使用者帳號');
    $pass = clean_var('pass', '密碼');

    if ($user == $admin_user and $pass == $admin_pass) // 若有此使用者
    {
        $_SESSION["user"]     = $user;
        $_SESSION["pass"]     = $pass;
        $_SESSION["comp_id"]  = "Z000";
        $_SESSION["fact_id"]  = "X000";
        $_SESSION["name"]     = "管理者";
        $_SESSION["isAdmin"] = 1;      

        echo "<script>window.location.href='index_1.php';</script>";
    }

    $sql    = "SELECT * FROM `kyc_repair_00_user` WHERE `user`='$user'";
    $result = sqlExcuteForSelectData($sql); 
    // $result = $xoopsDB->query($sql);

    if (!$result) {
        echo "<script type='text/javascript'>sweetAlert('無法執行Sql命令 !!');</script>";
        return;
    }

    if ($result->num_rows == 0) {
        kyc_show_msg_js("使用者帳號輸入錯誤!!");
        // echo "<script type='text/javascript'>sweetAlert('使用者帳號輸入錯誤 !!');</script>";
        return;
    }

    $data = sqlFetch_assoc($result); //$result->fetch_assoc();
    // echo '<script type="text/javascript">sweetAlert("pass=' . $pass . '");</script>';
    // echo '<script type="text/javascript">sweetAlert("$data[pass]' . $data["pass"] . '");</script>';
    // return;
    if (password_verify($pass, $data['pass'])) {
        $_SESSION["user"]     = $user;
        $_SESSION["pass"]     = $pass;
        $_SESSION["name"]     = $data['name'];
        $_SESSION["comp_id"]  = $data['comp_id'];
        $_SESSION["fact_id"]  = $data['fact_id'];
        $_SESSION["isUser"] = 1;
        echo "<script>window.location.href='index_1.php';</script>";
    } else {
        echo "<script type='text/javascript'>sweetAlert('使用者密碼輸入錯誤 !!');</script>";
        return;
    }

}

?>