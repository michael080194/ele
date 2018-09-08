
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>訊息視窗</title>
    <!--BootStrap-->
    <link rel="stylesheet" href="class/bootstrap/css/bootstrap.min.css">
    <!--jQuery-->
    <script src="class/jquery.min.js"></script>
    <script src="class/jquery-migrate.min.js"></script>
    <!--jQuery UI-->
    <link rel="stylesheet" href="class/jquery-ui/jquery-ui.min.css">
    <script src="class/jquery-ui/jquery-ui.min.js"></script>
    <!--Font awesome-->
    <link rel="stylesheet" href="class/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="kyc/css/kyc.css">
</head>
<body>
	<{* 頁面轉向 *}>
  <{if $redirect}>
    <{include file="file:$redirectFile"}> 
  <{/if}>
  <div class="container" style="margin-top:20px;">
  	<div class="alert alert-danger" role="alert">
      <h1>訊息視窗！</h1>
  		<{$error}>	  		
  	</div>
    
  </div>
</body>
</html>