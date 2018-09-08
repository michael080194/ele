{include file='sweet-alert.tpl'}
<div class="panel panel-primary">
    <div class="panel-body">
        <form class="form-horizontal" action="user.php" method="post" role="form">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="inq_name">使用者名稱</label>
                <div class="col-sm-9">
                    <input type="text" name="inq_name" id="inq_name" class="form-control" placeholder="請輸入 使用者名稱">
                    <button type="submit" name="op" value="inq_user" class="btn btn-primary">搜尋</button>
                </div>
            </div>
        </form>
    </div>
</div>

 {if isset($users) }
  <h2>查詢筆數<small>（共 {$total} 筆）</small></h2>
  <table class="table table-bordered table-hover table-striped">
    <thead>
      <tr>
        <th>序號</th>
        <th>使用者</th>
        <th>密碼</th>
        <th>者姓名</th>
        <th>公司別</th>
        <th>廠別</th>
        <th>Email</th>
        <th>手機序號</th>
        <th>手機啟用</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
        {foreach $users as $user}
          <tr>
            <td>{$user@iteration + (($g2p-1)*$every_page)}</td>
            <td>{$user.user}</td>
            <td>{$user.pass}</td>
            <td>{$user.name}</td>
            <td>{$user.comp_id}</td>
            <td>{$user.fact_id}</td>
            <td>{$user.email}</td>
            <td>{$user.big_serial}</td>
            <td>{$user.big_enable}</td>
            <td>
               <a href="j00_user.php?op=user_form&id={$user.id}" class="btn btn-warning btn-xs">編輯</a>
               <a href="javascript:delete_user({$user.id})" class="btn btn-danger btn-xs">刪除</a>
            </td>
          </tr>
        {/foreach}
    </tbody>
  </table>
  {$bar}
{/if}
