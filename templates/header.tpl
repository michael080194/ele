<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><{$page_title}></title>
    <!--BootStrap-->
    <link rel="stylesheet" href="class/bootstrap/css/bootstrap.min.css">
    <!--jQuery-->
    <script src="class/jquery.min.js"></script>
    <script src="class/jquery-migrate.min.js"></script>
    <!--jQuery UI-->
    <link rel="stylesheet" href="class/jquery-ui/jquery-ui.min.css">
    <script src="class/jquery-ui/jquery-ui.min.js"></script>
    <!--Font awesome-->
    <link rel="stylesheet" href="class/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="kyc/css/kyc_comm.css">
    <script src="class/bootbox.min.js"></script>    
    <link rel="stylesheet" type="text/css" href="class/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="class/slick/slick-theme.css">
    <script src="class/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="kyc/js/kyc_comm_fun.js"></script>          
</head>

<body>
        <nav class="navbar navbar-inverse" style="border-radius: 0px;">
          <div class="container-fluid">
            <div class="container">
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><{$page_title}></a>
              </div>
              <ul class="nav navbar-nav">
                <li class="active"><a href="j95_app_install.html">安裝 APP</a></li>
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">維修管理
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">維修資料建立</a></li>
                  </ul>
                </li>

                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">基本檔案
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">員工基本資料</a></li>
                    <li><a href="#">客戶基本資料</a></li>
                    <li><a href="#">廠商基本資料</a></li>   
                    <li><a href="j00_prod.php">產品基本資料</a></li>
                  </ul>
                </li>

                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">系統管理
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="j00_user.php?op=user_form">註冊</a></li>
                    <li><a href="j90_upload.php">轉入資料</a></li>
                  </ul>
                </li>
                <li><a href="index_1.php?op=logout">登出</a></li>
              </ul>
            </div>
          </div>
        </nav>
    <div class="container">
        <{if $error != ""}>
        <div class="row">
          <{include file='alert_error.tpl'}>
        </div>
        <{/if}>
        <{include file='j95_show_msg.tpl'}>
        <div class="row">
            <div class="col-sm-12 col-md-12" style="font-size: 1.1em;">
