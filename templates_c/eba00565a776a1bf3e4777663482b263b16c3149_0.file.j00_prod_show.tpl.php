<?php
/* Smarty version 3.1.29, created on 2018-06-20 00:08:45
  from "/Users/michaelchang/Documents/michael/php/ele/templates/j00_prod_show.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b297eed07fb36_28970892',
  'file_dependency' => 
  array (
    'eba00565a776a1bf3e4777663482b263b16c3149' => 
    array (
      0 => '/Users/michaelchang/Documents/michael/php/ele/templates/j00_prod_show.tpl',
      1 => 1529390089,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5b297eed07fb36_28970892 ($_smarty_tpl) {
?>


<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php echo $_smarty_tpl->tpl_vars['alls']->value['img'];?>

<p>產品編號：<?php echo $_smarty_tpl->tpl_vars['alls']->value['prod_no'];?>
</p>
<p>產品名稱：<?php echo $_smarty_tpl->tpl_vars['alls']->value['description'];?>
</p>
<p>條碼編號：<?php echo $_smarty_tpl->tpl_vars['alls']->value['barcode'];?>
</p>
<p>產品廠牌：<?php echo $_smarty_tpl->tpl_vars['alls']->value['c_brand'];?>
</p>
<p>產品類別：<?php echo $_smarty_tpl->tpl_vars['alls']->value['c_type'];?>
</p>
<p>產品摘要：<?php echo $_smarty_tpl->tpl_vars['alls']->value['title'];?>
</p>
<p>產品內容：<?php echo $_smarty_tpl->tpl_vars['alls']->value['content'];?>
</p>
<p>產品進價：<?php echo $_smarty_tpl->tpl_vars['alls']->value['in_price'];?>
</p>
<p>產品售價：<?php echo $_smarty_tpl->tpl_vars['alls']->value['sale_price'];?>
</p>


    


<?php echo '<script'; ?>
 src="kyc/js/kyc_comm_fun.js"><?php echo '</script'; ?>
>  
<?php echo '<script'; ?>
>
 $(document).ready(function() {

  $(".kyc_slick_regular").slick({
    dots: true,
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 5,
    autoplay: true,
    autoplaySpeed: 5000
  });

 });   
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php }
}
