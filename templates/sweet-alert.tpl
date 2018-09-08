<script type="text/javascript" src="class/sweet-alert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="class/sweet-alert/sweetalert.css" />
<script type="text/javascript">
  function delete_user(id){
    swal({
      title: "確定要刪除嗎？",
      text: "刪除後資料就消失救不回來囉！",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "是！含淚刪除！",
      cancelButtonText: "不...別刪",
      closeOnConfirm: false
    }, function(){
      swal("OK！刪掉惹！", "該資料已經隨風而逝了...", "success");

      location.href='user.php?op=delete_user&id=' + id;
    });
  }
</script>
