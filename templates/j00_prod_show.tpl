

<{include file='header.tpl'}>

<{$alls.img}>
<p>產品編號：<{$alls.prod_no}></p>
<p>產品名稱：<{$alls.description}></p>
<p>條碼編號：<{$alls.barcode}></p>
<p>產品廠牌：<{$alls.c_brand}></p>
<p>產品類別：<{$alls.c_type}></p>
<p>產品摘要：<{$alls.title}></p>
<p>產品內容：<{$alls.content}></p>
<p>產品進價：<{$alls.in_price}></p>
<p>產品售價：<{$alls.sale_price}></p>

<{* <{if $smarty.session.allsAdmin}> *}>
<{*
    <div class="text-center">
        <a href="javascript:delete1(<{$alls.prod_id}>)" class="del_article btn btn-danger">刪除</a>
        <a href="<{$xoops_url}>/modules/kyc_repair/j00_prod.php?op=form&prod_id=<{$alls.prod_id}>" class="btn btn-warning">修改</a>
    </div>
*}>    
<{* <{/if}> *}>

<script src="kyc/js/kyc_comm_fun.js"></script>  
<script>
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
</script>

<{include file='footer.tpl'}>

