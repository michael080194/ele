<?php
/* Smarty version 3.1.29, created on 2018-06-20 03:24:07
  from "/Users/michaelchang/Documents/michael/php/ele/templates/header.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b29acb7664be7_76870245',
  'file_dependency' => 
  array (
    '75c521e5c82a2c002c740b39cadde88affec7064' => 
    array (
      0 => '/Users/michaelchang/Documents/michael/php/ele/templates/header.tpl',
      1 => 1529457795,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:alert_error.tpl' => 1,
    'file:j95_show_msg.tpl' => 1,
  ),
),false)) {
function content_5b29acb7664be7_76870245 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>
    <!--BootStrap-->
    <link rel="stylesheet" href="class/bootstrap/css/bootstrap.min.css">
    <!--jQuery-->
    <?php echo '<script'; ?>
 src="class/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="class/jquery-migrate.min.js"><?php echo '</script'; ?>
>
    <!--jQuery UI-->
    <link rel="stylesheet" href="class/jquery-ui/jquery-ui.min.css">
    <?php echo '<script'; ?>
 src="class/jquery-ui/jquery-ui.min.js"><?php echo '</script'; ?>
>
    <!--Font awesome-->
    <link rel="stylesheet" href="class/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="kyc/css/kyc_comm.css">
    <?php echo '<script'; ?>
 src="class/bootbox.min.js"><?php echo '</script'; ?>
>    
    <link rel="stylesheet" type="text/css" href="class/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="class/slick/slick-theme.css">
    <?php echo '<script'; ?>
 src="class/slick/slick.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="kyc/js/kyc_comm_fun.js"><?php echo '</script'; ?>
>          
</head>

<body>
        <nav class="navbar navbar-inverse" style="border-radius: 0px;">
          <div class="container-fluid">
            <div class="container">
              <div class="navbar-header">
                <a class="navbar-brand" href="#"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</a>
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
        <?php if ($_smarty_tpl->tpl_vars['error']->value != '') {?>
        <div class="row">
          <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:alert_error.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        </div>
        <?php }?>
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:j95_show_msg.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <div class="row">
            <div class="col-sm-12 col-md-12" style="font-size: 1.1em;">
<?php }
}
