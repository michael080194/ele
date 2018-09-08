<{include file='header.tpl'}>
<link rel="stylesheet" href="kyc/css/j00_prod_form.css">
<link rel="stylesheet" type="text/css" href="class/datatable/datatable.min.css" media="screen">
<link rel="stylesheet" type="text/css" href="class/datatable/datatable-bootstrap.min.css" media="screen">
<script type="text/javascript" src="class/datatable/datatable.min.js"></script>
<script type="text/javascript" src="class/datatable/datatable.jquery.min.js"></script>

<span id="tab-1">1</span>
<span id="tab-2">2</span>
<span id="tab-3">3</span>
<span id="tab-4">4</span>

<div id="tab">
  <ul>
    <li><a href="#tab-1">基本資料</a></li>
    <li><a href="#tab-2">建議維修零件表</a></li>
  </ul>

  <div class="tab-content-1" style="padding-top: 10px">
    <form action="j00_prod.php" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">產品編號</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="prod_no"  name="prod_no"  value="<{$VAL.prod_no}>">
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">產品名稱</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="description " name="description" value="<{$VAL.description}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">單位</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_unit"  name="c_unit"  value="<{$VAL.c_unit}>" >
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">條碼編號</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="barcode"  name="barcode"  value="<{$VAL.barcode}>" >
          </div>
          <label class="col-md-1" style="text-align: right; padding-right: 0;">國際碼</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="inter_code"  name="inter_code"  value="<{$VAL.inter_code}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">存放儲位</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_locatn"  name="c_locatn"  value="<{$VAL.c_locatn}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">安全庫存量</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_safe"  name="c_safe"  value="<{$VAL.c_safe}>" >
          </div>

        </div>      
      </div>

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">大類別</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_prod"  name="c_prod"  value="<{$VAL.c_prod}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">產品廠牌</label>
          <div class="col-md-2">
            <select name="c_brand" class="form-control" size="1" style="height: 34px;">
              <{$VAL.sele_brand}>
            </select>
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">產品類別</label>
          <div class="col-md-2">
            <select name="c_type" class="form-control" size="1" style="height: 34px;">
              <{$VAL.sele_type}>
            </select>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">進貨價格</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="in_price"  name="in_price"  value="<{$VAL.in_price}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">一般銷貨價</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="sale_price"  name="sale_price"  value="<{$VAL.sale_price}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">同行批發價</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_price1"  name="c_price1"  value="<{$VAL.c_price1}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">賣廠批發價</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_price3"  name="c_price3"  value="<{$VAL.c_price3}>" >
          </div>

        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">客戶端建議售價</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_price2"  name="c_price2"  value="<{$VAL.c_price2}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">平均單價</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_price_av"  name="c_price_av"  value="<{$VAL.c_price_av}>" >
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">回收處理廢</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_return"  name="c_return"  value="<{$VAL.c_return}>" >
          </div>


          <label class="col-md-1" style="text-align: right; padding-right: 0;">作廢日期</label>
          <div class="col-md-2">
            <input type="text" class="form-control" id="c_date"  name="c_date"  value="<{$VAL.c_date}>" >
          </div>

        </div>
      </div>

      <div class="row">
        <script src="<{$xoops_url}>/modules/tadtools/cal.php" type="text/javascript"></script>

        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">管理庫存</label>
          <div class="col-md-2">
            <input type='radio' name='c_yn' id='c_yn_1' value='1' <{if $VAL.c_yn==1}>checked<{/if}>>
              <label for='c_yn_1'>是</label>&nbsp;&nbsp;
            <input type='radio' name='c_yn' id='c_yn_2' value='2' <{if $VAL.c_yn==2}>checked<{/if}>>
              <label for='c_yn_2'>否</label>
          </div>

          <label class="col-md-1" style="text-align: right; padding-right: 0;">備註</label>
          <div class="col-md-8">
            <input type="text" class="form-control" id="c_remark " name="c_remark" value="<{$VAL.c_remark}>" >
          </div>
        </div>
      </div>

   

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">產品摘要</label>
          <div class="col-md-8">
            <textarea class="form-control" rows="3" id="title" name="title"><{$VAL.title}></textarea>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">詳細內容</label>
          <div class="col-md-8">
            <textarea class="form-control" rows="3" id="content" name="content"><{$VAL.content}></textarea>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label class="col-md-1" style="text-align: right; padding-right: 0;">產品圖片</label>
          <div class="col-md-6">
             <input type="file" class="form-control" name="pic[]" id="pic" multiple>
          </div>
        </div>
      </div>

      <div class="form-group">
          <input type="hidden" name="prod_id" value="<{$VAL.prod_id}>" />
          <input type="hidden" name="op" value="<{$op1}>" />
          <div class="col-md-2 col-md-offset-5">
            <button type="submit" class="btn btn-primary btn-block">儲存</button>
          </div>
      </div>

      <div class="row">
          <{$VAL.img}>
      </div>      
    </form>
  </div>

  <div class="tab-content-2" style="padding-top: 10px">
    <div class="row">
       <div class="col-sm-12">
           <div class="text-right">
               <button type="button" id="addDetail" class="btn btn-primary">新增明細</button>
           </div>
       </div>
    </div>

    <table class="table table-bordered table-hover table-striped" id="myTable">
      <thead>
        <tr>
          <th>序號</th>
          <th>維修零件編號</th>
          <th>中文說明</th>            
          <th>數量</th>  
          <th>單位</th>      
          <th>工資</th>
          <th>成本單價</th>
          <th>銷售單價</th>        
          <th>備註</th>        
          <th>功能</th>               
        </tr> 
      </thead>

      <tbody>
        <{foreach from=$alls key=i item=prods}>
          <tr>
            <td> <{$prods.c_seq}> </td>
            <td> <{$prods.prod_no_fix}> </td>
            <td> <{$prods.description}> </td>
            <td> <{$prods.c_qty}> </td>
            <td> <{$prods.c_unit}> </td>
            <td> <{$prods.c_wage}> </td>
            <td> <{$prods.c_cost}> </td>
            <td> <{$prods.c_sale}> </td>
            <td> <{$prods.c_remark}> </td>
            <td>
              <a href="javascript:void(0)" class="edit1   btn btn-warning btn-xs" sn="<{$prods.prod_fix_id}>" >編輯</a>
              <a href="javascript:void(0)" class="delete1 btn btn-danger btn-xs" sn="<{$prods.prod_fix_id}>" sn-msg="<{$prods.prod_no_fix}>">刪除</a>              
            </td>            
          </tr>
        <{/foreach}> 
      </tbody>  

     </table>   
  </div>

</div>

<{include file='j00_prod_fix.tpl'}>
<{include file='k10_inq_prod.tpl'}>

<script>
  var last_seq = 0 ;
  var replace_index = 0;
  var replace_tr = null;
  var op_type = "";
  var conditionObj = {'prod_no':'產品編號',
                      'description':'產品名稱',
                      'c_brand':'產品廠牌',
                      'c_type' :'產品類別'};  // 產品搜尋條件
  $(document).ready(function() {

    disEnterKey(); // disable EnterKey

    // 在基本資料頁面(j00_prod_form.tpl) img 欄位的 slick 輪播圖 設定  
    $(".kyc_slick_regular").slick({
      dots: true,
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 5,
      autoplay: true,
      autoplaySpeed: 5000
    });

    form_get_data_add_condition("form_get_data"); // 先產生一列挑選條件相關欄位(參數為 k10_inq_prod.tpl form ID)

    // 在建議維修零件清單列表(j00_prod_form.tpl)按到新增按鈕
    $('#addDetail').on("click",function(e){
      clear_tr();
      op_type = "fix_insert"        
      $("#op").val("fix_insert");  
      $("#s1_ori_prod_no").val($("#prod_no").val());                         
      if($('#myTable >tbody >tr').length > 0) {
        var trs = $('#myTable tr:last') ; // $('#myTable > tbody:first');          
        var tds = trs.find('td');
        last_seq = tds.eq(0).text();
      }
      $('#j00_prod_fix').modal('show'); 
    });  

    // 在建議維修零件清單列表(j00_prod_form.tpl)按到 編輯按鈕
    $(document).on('click', '.edit1', function (e) {   
      clear_tr();   
      op_type = "fix_update"         
      var sn = $(this).attr("sn");       
      var obj2 = $(this).parents('td').parents('tr'); 
      replace_index = $("#myTable > tbody tr").index(obj2); // 記錄目前的 tr 的 index , 暫時不用
      replace_tr = obj2; 
      last_seq = obj2.find('td:eq(0)').text().trim();     
      $("#s1_prod_fix_id").val(sn); 
      $("#s1_ori_prod_no").val($("#prod_no").val());           
      $("#op").val("fix_update");                
      $("#s1_prod_no").val(obj2.find('td:eq(1)').text().trim());       
      $("#s1_description").val(obj2.find('td:eq(2)').text().trim());               
      $("#s1_c_qty").val(obj2.find('td:eq(3)').text().trim());       
      $("#s1_c_unit").val(obj2.find('td:eq(4)').text().trim());   
      $("#s1_c_wage").val(obj2.find('td:eq(5)').text().trim());       
      $("#s1_c_cost").val(obj2.find('td:eq(6)').text().trim());                   
      $("#s1_c_sale").val(obj2.find('td:eq(7)').text().trim());       
      $("#s1_c_remark").val(obj2.find('td:eq(8)').text().trim());           
      $('#j00_prod_fix').modal('show');     
      // $(".form2").css("display", "flex");
    });  

    // 在建議維修零件清單列表(j00_prod_form.tpl)按到 刪除按鈕
    $(document).on('click', '.delete1', function (e) {             
      var sn = $(this).attr("sn"); 
      var obj2 = $(this).parents('td').parents('tr');       
      var sMsg = "確定刪除 " + $(this).attr("sn-msg") + " 此產品編號嗎?"; 
      bootbox.confirm({
          message: sMsg,
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
                //
                var pass0 = {};
                pass0.op  = "fix_delete";  
                pass0.s1_prod_fix_id  = sn;             
                $.ajax({ //调用jquery的ajax方法
                    type: "POST",
                    url:  "j00_prod.php",
                    data: pass0,
                    success: function (smsg) {
                      // *****
                      var data1 = jQuery.parseJSON(smsg);
                      var ret_status = data1.responseStatus;//相同data1["responseStatus"]
                      var ret_msg    = data1["responseMessage"]; // message description
                       if(ret_status == "SUCCESS"){
                        }else{
                         $(".loading").css("display", "none");
                         alert("資料更新失敗");
                         return(false);
                       }            
                      // *****
                    },
                    error: function (jqXHR, exception) {
                        return "連線錯誤";
                    },
                    beforeSend: function () {
                        $(".loading").css("display", "flex");
                    },
                    complete: function () {                                 
                        $(".loading").css("display", "none");
                    }
                });
                obj2.closest('tr').remove();                  
                //
              }
          }
      });

      return ;    
    });  

    // 在建議維修零件輸入時(j00_prod_fix.tpl)按到 取消按鈕
    $('#cancel1').on("click",function(e){
      $('#j00_prod_fix').modal('hide');        
    });  

    // 在建議維修零件輸入時(j00_prod_fix.tpl)按到 儲存按鈕
    $('#save1').on("click",function(e){
      if(op_type == "fix_insert") {
         var temp_seq = parseInt(last_seq) + 1;
      } else {   
         var temp_seq = parseInt(last_seq) ;
      }   
      var temp_op_type = op_type;  
      // 更新 建議維修零件 
      $.ajax({
          type: "POST",
          url: "j00_prod.php",            
          data: $("#j00_prod_fix_form").serialize(),
          timeout: 15000,
          success: function(smsg) {
               var data1 = jQuery.parseJSON(smsg);
               var ret_status = data1.responseStatus;     //相同data1["responseStatus"]
               var ret_msg    = data1["responseMessage"]; // message description
               var ret_data   = data1["responseData"]; // message description               
               if(ret_status != "SUCCESS"){                   
                  return false;
               }

          },
          complete: function() {
          }
      });      

      var str1 = "<tr>";
      str1 += "<td>" + temp_seq + "</td>";            
      str1 += "<td>" + $('#s1_prod_no').val() + "</td>";        
      str1 += "<td>" + $('#s1_description').val() + "</td>";  
      str1 += "<td>" + $('#s1_c_qty').val() + "</td>";                   
      str1 += "<td>" + $('#s1_c_unit').val() + "</td>";                     
      str1 += "<td>" + $('#s1_c_wage').val() + "</td>";        
      str1 += "<td>" + $('#s1_c_cost').val() + "</td>";     
      str1 += "<td>" + $('#s1_c_sale').val() + "</td>";     
      str1 += "<td>" + $('#s1_c_remark').val() + "</td>"; 
      str1 += "<td>";
      str1 += "<a href='javascript:void(0)' class='edit1   btn btn-warning btn-xs'"; 
      str1 += "sn='<{$prods.prod_fix_id}>' >編輯</a>";
      str1 += "<a href='javascript:void(0)' class='delete1 btn btn-danger  btn-xs'";
      str1 += "sn='<{$prods.prod_fix_id}>' sn-msg='<{$prods.prod_no_fix}>'>刪除</a>";           
      str1 += "</td>";
      str1 += "</tr>";
      if(temp_op_type == "fix_insert") {
         $('#myTable > tbody:last').append(str1);
      } else {   
         replace_tr.replaceWith(str1);
      }   
      clear_tr();
      $('#j00_prod_fix').modal('hide');              
      // $(".form2").css("display", "none");
    }); 

    // 在建議維修零件輸入時(j00_prod_fix.tpl) 按下產品編號旁邊查詢鈕
    $('.s1_prod_no_btn').on("click",function(e){
      $("#my-table-body").empty();
      $('#formProdModal').modal('show');
    });  

    // 在查詢產品時(k10_inq_prod.tpl),按到取回鈕 , 取回所選擇到的產品編號
    // 取回鈕(return_sel)是由程式動態產生的(參考 function_search.php -> get_prod())
    $(document).on('click', '.return_sel', function (e) {    
      var obj2 = $(this).parents('td').parents('tr'); 
      // var str1 = obj2.find('td:eq(0)').text().trim(); 
      $("#s1_prod_no").val(obj2.find('td:eq(0)').text().trim()); // 產品編號
      $("#s1_description").val(obj2.find('td:eq(1)').text().trim()); // 產品名稱
      $("#s1_c_unit").val(obj2.find('td:eq(2)').text().trim()); // 單位
      $('#formProdModal').modal('hide');
      $("#s1_c_qty").focus();    
    });  

    // 在查詢產品時(k10_inq_prod.tpl), 按下 查詢項目 下拉式選單時 自動產生 一列資料(後來改成要人工按 + 鈕)
    // $(document).on('change', '.newoption', function(){
    //   $("#form_get_data .row > div:last-child").append(form_get_data_add_condition1());         
    // });

    // 在查詢產品時(k10_inq_prod.tpl), 按下 [ + ] 鈕 , 自動產生  搜尋欄位 一列資料
    $(document).on('click', '.addConditionBtn', function(){    
      form_get_data_add_condition("form_get_data"); // 先產生一列挑選條件相關欄位(參數為 k10_inq_prod.tpl form ID)         
    });

    // 在查詢產品時(k10_inq_prod.tpl), 按下 [ - ] 鈕 ,  刪除 搜尋欄位 一列資料
    $(document).on('click', '.delConditionBtn', function(e){
       form_get_data_remove_condition( $(this).parent().parent() );
       // var obj2 = $(this).parent().parent();         
       // var totalObj = $('.searchID');  
       // if(totalObj.length <= 1){
       //   return false;
       // }
       // obj2.remove();
    });

    // 在查詢產品時(k10_inq_prod.tpl), 按下 [ 返回 ] 鈕 , hide 搜尋畫面
    $('#form_get_data_cancel').on("click",function(e){
      $('#formProdModal').modal('hide');      
    });  

    // 在查詢產品時(k10_inq_prod.tpl), 按下 [ 搜尋 ] 鈕 , hide 搜尋畫面
    $('#form_get_data_take').on("click",function(e){
      var str1 = "";
      var searchIDs = $('div[class*="searchID"]');
      searchIDs.each(function() {
         var searchStr = $(this).find('.searchStr').val().trim();       
         var selects = $(this).find('select');
         selects.each(function(i) {
            var options = $(this).find('option:selected');
            if (options.eq(0).text().trim() == "查詢項目"){
              return false;            
            }  

            str1 += options.eq(0).val() + " " ;  
            if(i == 1){ 
              str1 += options.eq(0).val()=="LIKE" ? "'%"+ searchStr + "%' " : "'"+ searchStr + "' ";
            }                      
         });
      });
      str1 = str1.trim();
      var len1 =  str1.length;
      var str2 = str1.substr(len1 - 2 ,  2) ;

      if(str2 == "OR") {
          str1 = str1.substr(0 , str1.trim().length - 2) ;
      } else {
          str2 = str1.substr(len1 - 3 ,  3) ;
          if(str2 == "AND") { 
            str1 = str1.substr(0 , str1.trim().length - 3) ;           
          }         
      }

      if(str1 !=""){
         form_get_data_take_show(str1); // 抓取符合 搜尋條件 的產品資料 以便 show 在 k10_inq_prod.tpl
      }else{
          show_bootbox_msg("請輸入搜尋條件");
      }

    });      
  });  
  
    
  function form_get_data_take_show(pCondi) {
      var myJson = new Object();
      myJson.data1 = [];   
      var pass0 = {};
      pass0.op  = "search_prod";  // 請參考 function_search.php --> get_prod()
      pass0.search_data  = pCondi;             
      $.ajax({ //调用jquery的ajax方法
          type: "POST",
          url:  "j00_prod.php",
          data: pass0,
          success: function (smsg) {
            // *****
            var data1 = jQuery.parseJSON(smsg);
            var ret_status = data1.responseStatus;//相同data1["responseStatus"]
            var ret_msg    = data1["responseMessage"]; // message description
             if(ret_status == "SUCCESS"){
               var data2 = data1.responseArray;
               $.each(data2, function(index2, item2) {
                     myJson.data1.push({    
                          prod_no:     item2.prod_no,
                          description: item2.description,
                          c_unit:      item2.c_unit,
                          in_price:    item2.in_price,
                          sale_price:  item2.sale_price,
                          c_brand:     item2.c_brand,
                          c_type:      item2.c_type,  
                          sele_but:    item2.sele_but                                                    
                     });                   
               });
              }else{
               $(".loading").css("display", "none");
               alert("抓取資料錯誤");
               return(false);
             }            
            // *****
          },
          error: function (jqXHR, exception) {
              return "連線錯誤";
          },
          beforeSend: function () {
              $(".loading").css("display", "flex");
          },
          complete: function () {
             var myTable = $('#my-table').datatable({     
                 pageSize: 10,
                 sort: [true, true, true,true,true,true,true,false],
                 filters: [true, true,'select',true,true,true,true,false],
                 filterText: 'Type to filter... ',
                 pagingDivSelector: "#paging-first-datatable",        
                 data: myJson.data1
              });   
             
              $(".loading").css("display", "none");
          }
      });
  }



  // 清除 建議維修零件清單列表 中所有欄位
  function clear_tr(){
      last_seq = 0 ;
      $("#s1_prod_fix_id").val(""); 
      $("#op").val("");         
      $("#s1_prod_no").val("");       
      $("#s1_description").val("");               
      $("#s1_c_qty").val("");       
      $("#s1_c_unit").val("");   
      $("#s1_c_wage").val("");       
      $("#s1_c_cost").val("");                   
      $("#s1_c_sale").val("");       
      $("#s1_c_remark").val("");     
  }   
</script>

<{include file='footer.tpl'}>


