<style>
.k10_inq_prod_modal-dialog {
          width: 80%;
          height: 80% !important;
        }
.k10_inq_prod_modal-content {
    /* 80% of window height */
    min-height: 500px;
    background-color:#DEEBF5;
}        
.k10_inq_prod_modal-header {
    background-color: #337AB7;
    padding:5px 5px;
    color:#FFF;
    border-bottom:2px dashed #337AB7;
 }

</style>

<div class="modal fade" id="formProdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog k10_inq_prod_modal-dialog">
  <div class="modal-content k10_inq_prod_modal-content">
   <div class="modal-header k10_inq_prod_modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
       &times;
      </button>
      <h4 class="modal-title text-center">查詢產品資料</h4>
   </div>
   <div class="modal-body text-center" >
        <form class="form-horizontal" id="form_get_data" role="search">
         <div class="row">
             <div class="btn-group col-md-3 col-md-push-9">
                <button type="button" id="form_get_data_cancel" class="btn btn-warning">返回</button>
                <button type="button" id="form_get_data_take"   class="btn btn-primary">搜尋</button>       
             </div>

             <div class="form-group col-md-9 col-md-pull-3">
             </div>
         </div>

        </form>   
        <div id="form_get_data_table"  > 
           <table class="table table-bordered table-hover table-striped" id="my-table">
               <thead>
                 <tr>
                   <th>產品編號</th>
                   <th>產品名稱</th>
                   <th>單位</th>            
                   <th>進價</th>  
                   <th>售價</th>      
                   <th>產品廠牌</th>
                   <th>產品類別</th>
                   <th>功能</th>                   
                 </tr> 
               </thead>
               <tbody id="my-table-body">

               </tbody>
           </table>  
           <div id="paging-first-datatable"></div>                      
        </div>  
   </div>

  </div><!-- /.modal-content -->
 </div><!-- /.modal -->
</div>
