<?php
/* Smarty version 3.1.29, created on 2018-09-08 07:37:34
  from "/Users/michaelchang/Documents/michael/php/ele/templates/j90_upload.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b93601e4016e3_28550163',
  'file_dependency' => 
  array (
    'a7e4f2e103dac4ae85474b577e2ea55bfeff280c' => 
    array (
      0 => '/Users/michaelchang/Documents/michael/php/ele/templates/j90_upload.tpl',
      1 => 1529392828,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5b93601e4016e3_28550163 ($_smarty_tpl) {
?>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="panel panel-primary">
    <div class="panel-heading">上傳檔案</div>
    <div class="panel-body">
        <form action="j90_upload.php"  enctype="multipart/form-data" method="post" >
            <div class="form-group">
                <label class="col-sm-3 control-label" for="fileToUpload">請選擇檔案上傳</label>
                <div class="col-sm-6">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
            </div>

            <div class="col-sm-3">
                <button type="submit" id="op1" name="op1" value="upload" class="btn btn-primary">上傳</button>
                <input  type="hidden" value="upload" name="op">
            </div>
        </form>
    </div>
    <div  style="margin:50px 100px">
       <img class="lodingLogin" src="images/ajax-loader.gif" style="display: none"/>
       <h2  class="lodingLogin" style="display: none">檔案上傳中，請稍待....</h2>
    </div>
</div>

<?php echo '<script'; ?>
 language="JavaScript">
$("#op1").click(function () {
   $(".lodingLogin").css("display", "block");
});
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
