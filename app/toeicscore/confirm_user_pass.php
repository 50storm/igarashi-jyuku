<?php
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";
require_once "./config/config.php";

session_start();
var_dump($_SESSION);

//session expiration check and login-in check
if(!isset($_SESSION["user_id"])){
	$login_url="http://".get_url("login.php");
	header("Location: $login_url");
}

if(!isset($_SESSION['form_user_pass_error'])){
	$_SESSION['form_user_pass_error']=null;
}
if(!isset($_SESSION['form_user_pass_msg'])){
	$_SESSION['form_user_pass_msg']=null;
}

if( $debug === "on" ){var_dump($_SESSION);}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/Menu.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/main.css" type="text/css">   
<style>
.water { color: #ccc; } 
.focus { color: black; } 
</style>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
	google.load("jquery", "1.6.1");
</script>
<script>
/*
$(function () {
	//必須チェック
	$('#login').click(function(){
		var email　=　$('#TextEmail').val();
		if(email==''){
			alert("mail");
			$('#TextEmail').css('background-color', 'Lime');
			return false;
		}else{
		
			$('#TextEmail').css('background-color', 'wite');
		}
		
		var pass= $('#TextPass').val();
		if(pass==''){
			alert("pass");
			$('#TextEmail').css('background-color', 'Lime');
			return false;
		}else{
			$('#TextEmail').css('background-color', 'wite');
		}
	})

	$('#TextEmail').blur(function(){
			$(this).addClass('water');
	})

	$('#TextEmail').focus(function(){
		$(this).removeClass('water');
	})
 
	$('#TextPass').blur(function(){
		$(this).addClass('water');
		
	})
	
	$('#TextPass').focus(function(){
		$(this).removeClass('water');
		
	  })

});
*/
</script>
<title>Create user</title>
</head>
<body>
<div id="wrapper">
	<!--header-->
	<header id="header">
		<h1>We are TOEICers</h1>
	</header>
	<!--Menu-->
	<?php //include"toeic_menu.php"; ?>
	
	
	<div id="main">
		<div  style="background-color:red;width:380px;" >
			<ul>
					<?php foreach($_SESSION['form_user_pass_msg'] as $msg) :?>
							<li><?php  echo $msg; ?></li>
					<?php endforeach; ?>
			</ul>

		</div>
		<form id="frmInput" name="frmInput" method="post" action="./do_user_pass.php">
			<table  style="background-color:blue;" >
			<caption>パスワード変更</caption>
				<tr>
					<th></th>
					<th></th>
				</tr>
				<tr>
					<td>
						<label for="TextPass" >現在のパスワード</label>
					</td>
					<td>
						<input id="TextPass"  name="password" type="password" id="password" size="35"  value="<?php echo $_SESSION["password"] ?>" readonly />
					</td>
				</tr>
				<tr>
					<td>
						<label for="TextPass" >新しいパスワード</label>
					</td>
					<td>
						<input id="TextPass"  name="new_password1" type="password" id="password" size="35"  value="<?php echo $_SESSION["new_password1"]; ?>"  readonly />
					</td>
				</tr>
			</table>
			<input id=""  type="submit" value="送信する" />
		</form>
	</div>
</div>
</body>
</html>
