<?php
require_once "header.php";

try
{
    switch ($op) {
        case 'logout':
            logout();
            redirect_header("index.php", 3000, '登出成功！！');
            // header("location: index.php");
            exit;
    }
} catch (exception $e) {
    $op    = "";
    $error = $e->getMessage();
}

//結果送至樣板
$page_title = "雲端維修管理系統";
$theme = "index_1.tpl";
require_once "footer.php";

// **********************************************************

function logout()
{
    // unset($_SESSION["user"]);
    // unset($_SESSION["pass"]);
    // unset($_SESSION["name"]);
    // unset($_SESSION["comp_id"]);
    // unset($_SESSION["fact_id"]);
    // unset($_SESSION["is_admin"]);
    session_destroy();
}

