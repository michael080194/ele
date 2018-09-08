
<{include file='header.tpl'}>

<div class="row">
  <div class="loading col-sm-2 ml-sm-auto mr-sm-auto">
      <img src="kyc/images/ajax-loader.gif" style="margin: 20%;" />
  </div>
  <div class="row">
     <div class="col-sm-6">
       <h2>產品列表<small>（共 <{$total}> 筆資料）</small></h2>
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

    <{foreach from=$all key=i item=prods}>
      <tr>
        <td style="width:80px;height: 80px;">
            <img src="<{$prods.img}>" alt="<{$prods.title}>" class="rounded cover img-responsive"  >
        </td>
        <td><{$prods.prod_no}></td>
        <td><{$prods.description}></td>
        <td><{$prods.barcode}></td>
        <td><{$prods.c_brand}></td>
        <td><{$prods.c_type}></td>
        <td><{$prods.in_price}></td>
        <td><{$prods.sale_price}></td>

        <td>
          <{if $prods.enable!=1}>
            <span class="label label-danger">下架</span>
          <{/if}>
        </td>

        <td>
          <a href="j00_prod.php?op=show&prod_id=<{$prods.prod_id}>" class="btn btn-info btn-xs" role="button">詳情</a>
          <{* <{if $smarty.session.prodsAdmin}> *}>
          <a href="j00_prod.php?op=form&prod_id=<{$prods.prod_id}>" class="btn btn-warning btn-xs">編輯</a>
          <a href="javascript:void(0)" class="del_prods btn btn-danger btn-xs" smsg="<{$prods.prod_no}>" sn="<{$prods.prod_id}>">刪除</a>
          <{* <{/if}> *}>
        </td>
      </tr>
    <{/foreach}>
    </table>
    <{$bar}>
</div>

<script>
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

</script>
<{include file='footer.tpl'}>

