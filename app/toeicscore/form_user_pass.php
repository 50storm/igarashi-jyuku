<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";
require_once "./config/config.php";


//session expiration check and login-in check
if(!isset($_SESSION['user_id'])){
	$login_url="http://".get_url("login.php");
	header("Location: $login_url");
}

if(!isset($_SESSION["form_user_pass_error"])){
	$_SESSION["form_user_pass_error"]=null;
}
if(!isset($_SESSION['form_user_pass_error_password'])){
	$_SESSION['form_user_pass_error_password']=null;
}
if(!isset($_SESSION['form_user_pass_error_new_password1'])){
	$_SESSION['form_user_pass_error_new_password1']=null;
}
if(!isset($_SESSION['form_user_pass_error_new_password2'])){
	$_SESSION['form_user_pass_error_new_password2']=null;
}

if(!isset($_SESSION['form_user_pass_msg'])){
	$_SESSION['form_user_pass_msg']=null;
}

$error_color ="red";
if($debug === "on"){
	var_dump($_SESSION);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/Menu.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/main.css" type="text/css"> 
<script src="./js/jquery-1.11.2.min.js" type="text/javascript"></script>
<style>
/*必須チェック*/
.blur { color: black; background-color:white; } 
.focus { color: black;  background-color:LightPink; } 
</style>
<script>
$(function () {
	//必須チェック
	$('#login').click(function(){
	
		var pass = $('#txtPass').val();
		if(pass==''){
			$('#txtPass').removeClass('blur');
			$('#txtPass').addClass('focus');
			$('#txtPass').focus();
			return false;
		}else{
			$('#txtPass').removeClass('focus');
			$('#txtPass').addClass('blur');
		}
		
		var pass1 = $('#txtPass1').val();
		if(pass1==''){
			$('#txtPass1').removeClass('blur');
			$('#txtPass1').addClass('focus');
			$('#txtPass1').focus();
			return false;
		}else{
			$('#txtPass1').removeClass('focus');
			$('#txtPass1').addClass('blur');

		}
		
		
		var pass2 = $('#txtPass2').val();
		if(pass2==''){
			$('#txtPass2').removeClass('blur');
			$('#txtPass2').addClass('focus');
			$('#txtPass2').focus();
			return false;
		}else{
			$('#txtPass2').removeClass('focus');
			$('#txtPass2').addClass('blur');

		}
		
	}
	)

	$('#txtPass').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
		
	})
	
	$('#txtPass').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
		
	})

	$('#txtPass1').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#txtPass1').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#txtPass2').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#txtPass2').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})


});

</script>


<title>Create user</title>
</head>
<body>
<div id="wrapper">
	<!--header-->
	<header id="header">
		<h1>TOEICスコア管理サイト</h1>
	</header>
	<!--Menu-->
	<?php // include"toeic_menu.php"; ?>
	
	<div id="main">
			<?php if($_SESSION['form_user_pass_error'] == true) :?>
				<ul>
					<?php foreach($_SESSION['form_user_pass_msg'] as $msg) :?>
							<li><?php  echo $msg; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>


		<form id="frmInput" name="frmInput" method="post" action="./validate_user_pass.php">
		<table>
			<caption>パスワード変更</caption>
				<tr>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<tr>
					<td>
						<label for="txtPass" >現在のパスワード</label>
					</td>
					<td>
						<input id="txtPass"  name="password" type="password" id="password" size="35"  value="<?php echo empty($_SESSION["password"]) ? "" : $_SESSION["password"] ; ?>" />
					</td>
					<td>
						<span style="color:<?php echo $error_color;?>;"><?php echo $_SESSION['form_user_pass_error_password']==false ? "" : "*" ; ?></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="txtPass1" >新しいパスワード</label>
					</td>
					<td>
						<input id="txtPass1"  name="new_password1" type="password" id="password" size="35"  value="<?php echo empty($_SESSION["new_password1"]) ? "" : $_SESSION["new_password1"] ; ?>" />
					</td>
					<td>
						<span style="color:<?php echo $error_color;?>;"><?php echo $_SESSION['form_user_pass_error_new_password1']==false ? "" : "*" ; ?></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="txtPass2" >新しいパスワード(確認用)</label>
					</td>
					<td>
						<input id="txtPass2"  name="new_password2" type="password" id="password" size="35"  value="<?php echo empty($_SESSION["new_password2"]) ? "" : $_SESSION["new_password2"] ; ?>" />
					</td>
					<td>
						<span style="color:<?php echo $error_color;?>;"><?php echo $_SESSION['form_user_pass_error_new_password2']==false ? "" : "*" ; ?></span>
					</td>
				</tr>
				</table>
				<input id="login"  type="submit" value="確認画面へ" />
		</form>

	</div>
</div>
</body>
</html>
