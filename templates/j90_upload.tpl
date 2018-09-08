
<{include file='header.tpl'}>
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

<script language="JavaScript">
$("#op1").click(function () {
   $(".lodingLogin").css("display", "block");
});
</script>

<{include file='footer.tpl'}>
