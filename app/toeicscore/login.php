<?php
session_start();
require_once "./config/config.php";

if(!isset($_SESSION["msg"])){
	$_SESSION["msg"]=null;
}
if(!isset($_SESSION["error"])){
	$_SESSION["error"]=null;
}

if( $debug === "on" ){
	var_dump($_SESSION);
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="./js/jquery-1.11.2.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<link href="./bootstrap3.3.1/css/bootstrap.min.css" rel="stylesheet">
<script src="./bootstrap3.3.1/js/bootstrap.min.js"></script>
        <style>
            div {
                /*border: 1px solid red;*/
            }
        </style>
 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!--
<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
-->
<style>
/*必須チェック*/
.blur { color: black; background-color:white; }
.focus { color: black;  background-color:LightPink; }
</style>
<script>
function getUA() {
    var userAgent = window.navigator.userAgent.toLowerCase();
    if(userAgent.indexOf('opera') != -1 || userAgent.indexOf('opr') != -1) {
		return 'opera';
	}else if (userAgent.indexOf('msie') != -1 || userAgent.indexOf('trident') != -1) {
		var array, version; array = /(msie|rv:?)\s?([\d\.]+)/.exec(userAgent);
		version = (array) ? array[2] : '';
		return 'ie ie' + version;
	}else if (userAgent.indexOf('chrome') != -1) {
		return 'chrome';
	}else if (userAgent.indexOf('safari') != -1) {
		return 'safari';
	}else if (userAgent.indexOf('firefox') != -1) {
		return 'firefox';
	}else {
		return false;
	}
}
//	document.writeln(window.navigator.userAgent.toLowerCase());
//	document.writeln(getUA());

</script>

<script>
//TODO:jQueryに組み込む
$(function () {
	//必須チェック
	$('#login').click(function(){
		var email　=　$('#txtEmail').val();
		if(email==''){
			$('#txtEmail').removeClass('blur');
			$('#txtEmail').addClass('focus');
			$('#txtEmail').focus();
			return false;
		}else{
			$('#txtEmail').removeClass('focus');
			$('#txtEmail').addClass('blur');

		}

		var pass= $('#txtPass').val();
		if(pass==''){
			$('#txtPass').removeClass('blur');
			$('#txtPass').addClass('focus');
			$('#txtPass').focus();
			return false;

		}else{
			$('#txtPass').removeClass('focus');
			$('#txtPass').addClass('blur');

		}
	})

	$('#txtEmail').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})

	$('#txtEmail').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#txtPass').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})

	$('#txtPass').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

});

</script>
<style>
.lbl{
	/*
	width:400px;

	background-color:aqua;
	*/
}
.txt{
	/*
	background-color:aqua;
	*/
}
*/
</style>
<title>Login</title>
</head>
<body>
<div class="container">
	<div class="container">
		<header id="header">
			<div class="row">
				<div class="col-sm-3 hidden-xs" style="/*background-color:gray;*/">
				&nbsp;　
				</div>
				<div class="col-sm-6 col-xs-12" style="/*background-color:green;*/">
					<h1>We are TOEICers</h1>
				</div>
				<div class="col-sm-3  hidden-xs"  style="/*background-color:orange;*/">
				&nbsp;　
				</div>
			</div>
		</header>

	</div>
	<div class="container">
		<form id="frmInput" name="frmInput" method="post" action="./validate_login.php">
		<div class="container">
			<div class="form-group has-error">
					<div class="col-sm-3"></div>
					<div id="msg" class="msg　 col-sm-7" style="">
						<?php if($_SESSION["error"] == true) :?>
							<ul class="msg " style="list-style:none;padding-left:0px;" >
								<?php foreach($_SESSION["msg"] as $msg) :?>
										<li class="form-control"><?php  echo $msg; ?></li>
								<?php endforeach; ?>
							</ul>
						<!--
							<?php foreach($_SESSION["msg"] as $msg) :?>
							<p class="form-control">
								<?php  echo $msg; ?>
							</p>
							<?php endforeach; ?>
						-->
						<?php endif; ?>
					</div>
					<div  class="col-sm-2"></div>
			</div>
		</div>
		<div class="container">

		<div class="row">
				<div class="col-sm-3">
				</div>
				<div class="col-sm-2">
					<label for="txtEmail"  class="lbl" >メールアドレス</label>
				</div>
				<div  class="col-sm-7">
					<input id="txtEmail"  class="txt" name="email" type="text" id="email"  placeholder="email" value="<?php echo empty($_SESSION["email"]) ? "" : $_SESSION["email"] ; ?>"/>
				</div>
		</div>

			<div class="row">
				<div class="col-sm-3">
				</div>
				<div class="col-sm-2">
					<label for="txtPass" class="lbl" >パスワード</label>
				</div>
				<div   class="col-sm-7">
					<input id="txtPass"  class="txt" name="password" type="password" id="password"   placeholder="password" size="35"  value="<?php echo empty($_SESSION["password"]) ? "" : $_SESSION["password"] ; ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3" style="/*background-color:red;*/" >
				</div>
				<!--
				<div class="col-sm-1"  style="/*background-color:green;*/" >
					<input id="login"  type="submit" value="ログイン" class="btn btn-info" />
				</div>
				-->
				<div class="col-sm-9"  style="/*background-color:lime;*/" >
					<div class="btn-group">
						<input id="login"  type="submit" value="ログイン" class="btn btn-info"  />
						<a href="./form_user.php?mode=insert" class="btn btn-default"  >新規登録はこちら</a>
						<a href="./form_pass_question.php" class="btn btn-default" >パスワードを忘れた？</a>
						<!--
						<button type="button" class="btn btn-default" >
							<a href="./form_user.php?mode=insert">新規登録はこちら</a>
						</button>
						-->
						<!--
						<button type="button" class="btn btn-default" >
							<a href="./form_pass_question.php">パスワードを忘れた？</a>
						</button>
						-->
					</div>
					<a href="https://www.facebook.com/hiroshibook">Prodced by Hiroshi Igarashi</a>


				</div>

			</div>
			</div>

			<!--
			<div class="row">
				<div class="col-sm-3">
				</div>
				<div class="col-sm-2">
					<a href="./form_user.php?mode=insert">新規登録はこちら</a>
				</div>
				<div class="col-sm-2">
					<a href="./form_pass_question.php">パスワードを忘れた？</a>
				</div>
				<div class="col-sm-5">
				</div>

			</div>
			-->
		</form>
	</div>
</div>
</body>
</html>
