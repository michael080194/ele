<?php
/* Smarty version 3.1.29, created on 2018-06-19 09:38:03
  from "/Users/michaelchang/Documents/michael/php/ele/templates/j00_prod_list.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b28b2dbc46f56_56189899',
  'file_dependency' => 
  array (
    '6db9d0ac7e8821e531c14b1d655f96a56f457df0' => 
    array (
      0 => '/Users/michaelchang/Documents/michael/php/ele/templates/j00_prod_list.tpl',
      1 => 1529388663,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5b28b2dbc46f56_56189899 ($_smarty_tpl) {
?>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="row">
  <div class="loading col-sm-2 ml-sm-auto mr-sm-auto">
      <img src="kyc/images/ajax-loader.gif" style="margin: 20%;" />
  </div>
  <div class="row">
     <div class="col-sm-6">
       <h2>產品列表<small>（共 <?php echo $_smarty_tpl->tpl_vars['total']->value;?>
 筆資料）</small></h2>
     </div>
     <div class="col-sm-12">
         <div class="text-right">
             <a href="j00_prod.php?op=form" class="btn btn-primary">新增產品</a>
         </div>
     </div>
  </div>
  <table class="table table-bordered table-hover table-striped">
    <tr>
      <th>縮圖</th>
      <th>產品編號</th>
      <th>產品名稱</th>
      <th>條碼</th>
      <th>產品廠牌</th>
      <th>產品類別</th>
      <th>進貨價格</th>
      <th>銷貨價格</th>
      <th>狀態</th>
      <th>功能</th>
    </tr>

    <?php
$_from = $_smarty_tpl->tpl_vars['all']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_prods_0_saved_item = isset($_smarty_tpl->tpl_vars['prods']) ? $_smarty_tpl->tpl_vars['prods'] : false;
$__foreach_prods_0_saved_key = isset($_smarty_tpl->tpl_vars['i']) ? $_smarty_tpl->tpl_vars['i'] : false;
$_smarty_tpl->tpl_vars['prods'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['prods']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['prods']->value) {
$_smarty_tpl->tpl_vars['prods']->_loop = true;
$__foreach_prods_0_saved_local_item = $_smarty_tpl->tpl_vars['prods'];
?>
      <tr>
        <td style="width:80px;height: 80px;">
            <img src="<?php echo $_smarty_tpl->tpl_vars['prods']->value['img'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['prods']->value['title'];?>
" class="rounded cover img-responsive"  >
        </td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['prod_no'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['description'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['barcode'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['c_brand'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['c_type'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['in_price'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['prods']->value['sale_price'];?>
</td>

        <td>
          <?php if ($_smarty_tpl->tpl_vars['prods']->value['enable'] != 1) {?>
            <span class="label label-danger">下架</span>
          <?php }?>
        </td>

        <td>
          <a href="j00_prod.php?op=show&prod_id=<?php echo $_smarty_tpl->tpl_vars['prods']->value['prod_id'];?>
" class="btn btn-info btn-xs" role="button">詳情</a>
          
          <a href="j00_prod.php?op=form&prod_id=<?php echo $_smarty_tpl->tpl_vars['prods']->value['prod_id'];?>
" class="btn btn-warning btn-xs">編輯</a>
          <a href="javascript:void(0)" class="del_prods btn btn-danger btn-xs" smsg="<?php echo $_smarty_tpl->tpl_vars['prods']->value['prod_no'];?>
" sn="<?php echo $_smarty_tpl->tpl_vars['prods']->value['prod_id'];?>
">刪除</a>
          
        </td>
      </tr>
    <?php
$_smarty_tpl->tpl_vars['prods'] = $__foreach_prods_0_saved_local_item;
}
if ($__foreach_prods_0_saved_item) {
$_smarty_tpl->tpl_vars['prods'] = $__foreach_prods_0_saved_item;
}
if ($__foreach_prods_0_saved_key) {
$_smarty_tpl->tpl_vars['i'] = $__foreach_prods_0_saved_key;
}
?>
    </table>
    <?php echo $_smarty_tpl->tpl_vars['bar']->value;?>

</div>

<?php echo '<script'; ?>
>
    var sn = "" , smsg="";
    var obj1 = "";
    $('.del_prods').click(function () {
        sn = $(this).attr("sn");
        smsg = $(this).attr("smsg");        
        obj1 = $(this).parents('tr');
        bootbox.confirm({
            message: "你確定要刪產品編號 " + smsg +"?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                  delete1();
                }
            }
        });
    });

    function delete1() {
        $.ajax({ //调用jquery的ajax方法
            type: "POST",
            url: "j00_prod.php",
            data: "op=delete&prod_id=" + sn,
            success: function (msg) {
            },
            error: function (jqXHR, exception) {
                return "連線錯誤";
            },
            beforeSend: function () {
                $(".loading img").css("display", "block");
            },
            complete: function () {
                // $(".loading img").css("display", "none");
                obj1.remove();
            }
        });
    }

<?php echo '</script'; ?>
>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php }
}
