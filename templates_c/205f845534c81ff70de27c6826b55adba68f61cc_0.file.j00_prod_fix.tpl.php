<?php
/* Smarty version 3.1.29, created on 2018-06-20 01:36:22
  from "/Users/michaelchang/Documents/michael/php/ele/templates/j00_prod_fix.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_5b299376d5a792_52611941',
  'file_dependency' => 
  array (
    '205f845534c81ff70de27c6826b55adba68f61cc' => 
    array (
      0 => '/Users/michaelchang/Documents/michael/php/ele/templates/j00_prod_fix.tpl',
      1 => 1529362849,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b299376d5a792_52611941 ($_smarty_tpl) {
?>
<style>
.j00_prod_fix_modal-dialog {
          width: 60%;
          height: 80% !important;
        }
.j00_prod_fix_modal-body {
    /* 80% of window height */
    min-height: 500px;
    background-color:#E5FFCC;
}        
.j00_prod_fix_modal-header {
    background-color: #1caa5d;
    padding:5px 5px;
    color:#000;
    border-bottom:2px dashed #1caa5d;
 }

</style>

<div class="modal fade" id="j00_prod_fix" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog j00_prod_fix_modal-dialog">
  <div class="modal-content">
   <div class="modal-header j00_prod_fix_modal-header">
      <h4 class="modal-title text-center">建議維修零件輸入</h4>
   </div>
   <div class="modal-body text-center  j00_prod_fix_modal-body" >
        <form class="form-horizontal" role="form" id="j00_prod_fix_form">
           <div class="form-group">             
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">產品編號</label>
                   <div class="col-md-4">
                     <input  type="text"   class="form-control" id="s1_prod_no"  name="s1_prod_no">
                     <div class="input-group-btn">
                         <button class="btn btn-default s1_prod_no_btn" type="button" ><i class="glyphicon glyphicon-search"></i></button>
                     </div>                
                   </div>
              </div> 
           </div>  

           <div class="form-group">             
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">產品名稱</label>
                   <div class="col-md-9">
                     <input type="text" class="form-control" id="s1_description" name="s1_description" disabled>
                   </div>
              </div> 
           </div>  

           <div class="form-group">               
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">單位</label>
                   <div class="col-md-2">
                     <input type="text" class="form-control" id="s1_c_unit"  name="s1_c_unit" disabled>
                   </div>
              </div> 
           </div>  

           <div class="form-group">               
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">數量</label>
                   <div class="col-md-3">
                     <input type="number" class="form-control" id="s1_c_qty"  name="s1_c_qty">
                   </div>
              </div> 
           </div>  

           <div class="form-group">               
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">工資</label>
                   <div class="col-md-3">
                     <input type="number" class="form-control" id="s1_c_wage"  name="s1_c_wage">
                   </div>
              </div> 
           </div>  

           <div class="form-group">               
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">成本單價</label>
                   <div class="col-md-3">
                     <input type="number" class="form-control" id="s1_c_cost"  name="s1_c_cost">
                   </div>
              </div> 
           </div> 

           <div class="form-group">               
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">銷售單價</label>
                   <div class="col-md-3">
                     <input type="number" class="form-control" id="s1_c_sale"  name="s1_c_sale">
                   </div>
              </div> 
           </div> 

           <div class="form-group">               
              <div class="row">
                   <label class="col-md-2" style="text-align: right; padding-right: 0;">備註</label>
                   <div class="col-md-9">
                     <input type="text" class="form-control" id="s1_c_remark"  name="s1_c_remark">
                   </div>
              </div> 
           </div> 

           <div class="text-center">
              <div class="btn-group">
                 <input  type="hidden" name="s1_ori_prod_no" id="s1_ori_prod_no"/>                
                 <input  type="hidden" name="s1_prod_fix_id" id="s1_prod_fix_id"/>
                 <input  type="hidden" name="op" id="op"/>                
                 <button type="button" id="save1"     class="btn btn-primary">儲存</button>     
                 <button type="button" id="cancel1"   class="btn btn-warning">取消</button>
              </div>
           </div>    
        </form>    
   </div>

  </div><!-- /.modal-content -->
 </div><!-- /.modal -->
</div><?php }
}
