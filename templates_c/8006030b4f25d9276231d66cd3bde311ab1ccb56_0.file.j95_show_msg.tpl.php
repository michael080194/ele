<?php
/* Smarty version 3.1.29, created on 2018-06-20 03:24:07
  from "/Users/michaelchang/Documents/michael/php/ele/templates/j95_show_msg.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b29acb7669bc1_31683357',
  'file_dependency' => 
  array (
    '8006030b4f25d9276231d66cd3bde311ab1ccb56' => 
    array (
      0 => '/Users/michaelchang/Documents/michael/php/ele/templates/j95_show_msg.tpl',
      1 => 1529228797,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b29acb7669bc1_31683357 ($_smarty_tpl) {
?>
<style>
/*.modal-dialog {
          width: 360px;
          height:600px !important;
        }*/
.kyc_modal-content {
    /* 80% of window height */
    height: 80%;
    background-color:#BBD6EC;
}        
.kyc_modal-header {
    background-color: #337AB7;
    padding:16px 16px;
    color:#FFF;
    border-bottom:2px dashed #337AB7;
 }

</style>

<div class="modal fade" id="formMsgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content kyc_modal-content">
   <div class="modal-header kyc_modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
       &times;
      </button>
      <h4 class="modal-title text-center">訊息視窗</h4>
   </div>
   <div class="modal-body text-center kyc_modal-body" >
       
   </div>

  </div><!-- /.modal-content -->
 </div><!-- /.modal -->
</div><?php }
}
