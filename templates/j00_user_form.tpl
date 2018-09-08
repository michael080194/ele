
<{include file='header.tpl'}>

<div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">使用者註冊--<{$row.form_title}></h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" action="j00_user.php" method="post" role="form">
            <input type="hidden" name="id" id="id" value="{$row.id}">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="user">使用者帳號</label>
                <div class="col-sm-9">
                    <input type="text" name="user" id="user" class="form-control" placeholder="請輸入使用者帳號"  value="<{$row.user}>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pass">使用者密碼</label>
                <div class="col-sm-9">
                    <input type="text" name="pass" id="pass" class="form-control" placeholder="請輸入使用者密碼" value="<{$row.pass}>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="name">姓名</label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="form-control" placeholder="請輸入姓名"  value="<{$row.name}>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Email</label>
                <div class="col-sm-9">
                    <input type="text" name="email" id="email" class="form-control" placeholder="請輸入Email"  value="<{$row.email}>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="comp_id">公司別</label>
                <div class="col-sm-9">
                    <input type="text" name="comp_id" id="comp_id" class="form-control" placeholder="請輸入公司別"  value="<{$row.comp_id}>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="fact_id">廠別</label>
                <div class="col-sm-9">
                    <input type="text" name="fact_id" id="fact_id" class="form-control" placeholder="請輸入廠別"  value="<{$row.fact_id}>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="big_serial">手機序號</label>
                <div class="col-sm-9">
                    <input type="text" name="big_serial" id="big_serial" class="form-control" placeholder="請輸入廠別"  value="<{$row.big_serial}>">
                </div>
            </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="big_enable">手機狀態</label>
                <div class="col-sm-9">
                <input type="radio" name="big_enable" id="big_enable_1" value="1" <{if $row.big_enable == 1}>
                checked<{/if}>>
                <label for="big_enable_1">啟用</label>&nbsp;&nbsp;
                <input type="radio" name="big_enable" id="big_enable_0" value="0" <{if $row.big_enable == 0}>
                checked<{/if}>>
                <label for="big_enable_0">關閉</label>
                </div>
              </div>

            <div class="text-center">
                <button type="submit" name="op" value="save_user" class="btn btn-primary">
                    <{$row.form_title}> 存檔</button>
            </div>
        </form>
    </div>
</div>

<{include file='footer.tpl'}>

<script src="kyc/js/kyc_comm_fun.js"></script>  
<script>
 $(document).ready(function() {
    disEnterKey(); 
    $('form').submit(function () {
        if ($.trim($('#user').val())  === '') {
            $('.kyc_modal-body').text('使用者帳號不能空白');
            $('#formMsgModal').modal('show');
            return false;
        }

        if ($.trim($('#pass').val())  === '') {
            $('.kyc_modal-body').text('使用者密碼不能空白');
            $('#formMsgModal').modal('show');
            return false;
        }        

        if ($.trim($('#name').val())  === '') {
            $('.kyc_modal-body').text('姓名不能空白');
            $('#formMsgModal').modal('show');
            return false;
        }     

        if ($.trim($('#comp_id').val())  === '') {
            $('.kyc_modal-body').text('公司別不能空白');
            $('#formMsgModal').modal('show');
            return false;
        }   

        if ($.trim($('#fact_id').val())  === '') {
            $('.modal-body').text('廠別不能空白');
            $('#formMsgModal').modal('show');
            return false;
        }                        
    });     
 });   
</script>
