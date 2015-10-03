<?php
session_start();
mb_language('ja');
mb_internal_encoding('UTF-8'); //PHP内部の日本語をユニコードでエンコード
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";
require_once "./config/config.php";


if(isset($_GET['mode'])){
	switch(trim($_GET['mode'])){
		case "delete":
		$_SESSION['form_user_mode']="delete";
		break;
		
		case "update":
		$_SESSION['form_user_mode']="update";
		break;
		
		case "update_pass":
		$_SESSION['form_user_mode']="update_pass";
		break;
		
		
		case "insert":
		$_SESSION['form_user_mode']="insert";
		break;
	}
}

//session expiration check and login-in check
if(!$_SESSION['form_user_mode']=="insert"){//新規登録以外
	if(!isset($_SESSION['user_id'])){
		$login_url="http://".get_url("login.php");
		header("Location: $login_url");
	}
}

if(!isset($_SESSION['form_user_error'])){
	$_SESSION['form_user_error']=null;
}
if(!isset($_SESSION['form_user_error_email'])){
	$_SESSION['form_user_error_email']=null;
}     
if(!isset($_SESSION['form_user_error_password']  )){
	$_SESSION['form_user_error_password']=null;
}
if(!isset($_SESSION['form_user_error_password1']  )){
	$_SESSION['form_user_error_password1']=null;
}
if(!isset($_SESSION['form_user_error_user_name'] )){
	$_SESSION['form_user_error_user_name']=null;
}
if(!isset($_SESSION['form_user_error_last_name'] )){
	$_SESSION['form_user_error_last_name']=null;
}
if(!isset($_SESSION['form_user_error_first_name'])){
	$_SESSION['form_user_error_first_name']=null;
}

if(!isset($_SESSION['form_user_error_blog_url'])){
	$_SESSION['form_user_error_blog_url']=null;
}

if(!isset($_SESSION['form_user_error_answer']    )){
	$_SESSION['form_user_error_answer']=null;
}

if(!isset($_SESSION['form_user_msg'])){
	$_SESSION['form_user_msg']=null;
}
if(!isset($_SESSION['form_user_mode'])){
	$_SESSION['form_user_mode']=null;
}



if( $_SESSION['form_user_mode']=="insert" && 
   ( $_SESSION['form_user_error']==false ||
     $_SESSION['form_user_error']==null )){

	 $_SESSION["id"] = null;
	 $_SESSION["email"] = null;
     $_SESSION["password"]   = null;
	 $_SESSION["user_name"]   = null;
	 $_SESSION["first_name"]   = null;
	 $_SESSION["last_name"]   = null;
	 
}

$title=null;
$submit=null;
if($_SESSION['form_user_mode'] === "insert"){
	$title= "登録フォーム";

}elseif($_SESSION['form_user_mode'] === "update"){
	$title= "登録情報変更";

}

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
<style>
/*必須チェック*/
.blur { color: black; background-color:white; } 
.focus { color: black;  background-color:LightPink; } 
</style>
<script src="./js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script>
$(function () {
	//必須チェック
	$('#btnSubmit').click(function(){
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
		
		var pass= $('#txtPass1').val();
		if(pass==''){
			$('#txtPass1').removeClass('blur');
			$('#txtPass1').addClass('focus');
			$('#txtPass1').focus();
			return false;

		}else{
			$('#txtPass1').removeClass('focus');
			$('#txtPass1').addClass('blur');
			
		}
		var user_name= $('#user_name').val();
		if(user_name==''){
			$('#user_name').removeClass('blur');
			$('#user_name').addClass('focus');
			$('#user_name').focus();
			return false;

		}else{
			$('#user_name').removeClass('focus');
			$('#user_name').addClass('blur');
			
		}
		

		var last_name= $('#last_name').val();
		if(last_name==''){
			$('#last_name').removeClass('blur');
			$('#last_name').addClass('focus');
			$('#last_name').focus();
			return false;

		}else{
			$('#last_name').removeClass('focus');
			$('#last_name').addClass('blur');
			
		}
		
		
		var first_name= $('#first_name').val();
		if(first_name==''){
			$('#first_name').removeClass('blur');
			$('#first_name').addClass('focus');
			$('#first_name').focus();
			return false;

		}else{
			$('#first_name').removeClass('focus');
			$('#first_name').addClass('blur');
			
		}
		
		var answer= $('#answer').val();
		if(answer==''){
			$('#answer').removeClass('blur');
			$('#answer').addClass('focus');
			$('#answer').focus();
			return false;

		}else{
			$('#answer').removeClass('focus');
			$('#answer').addClass('blur');
			
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

	$('#txtPass1').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#txtPass1').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#user_name').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#user_name').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#last_name').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#last_name').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#first_name').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#first_name').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#blog_url').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#blog_url').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#answer').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#answer').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})
});


</script>
<title><?php echo $title; ?></title>
</head>
<body>
<div id="wrapper">
	<!--header-->
	<header id="header">
		<h1>TOEICスコア管理サイト</h1>
	</header>
	<?php 
	//if($_SESSION['form_user_mode'] === "update"){
	//	include"toeic_menu.php";
	//}
	?>
	<div id="main">
		<?php if($_SESSION['form_user_error'] == true ) :?>
			<ul>
				<?php foreach($_SESSION['form_user_msg'] as $msg) :?>
						<li><?php  echo $msg; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<form id="frmInput" name="frmInput" method="post" action="./validate_user.php">
		<table>
			<caption><?php echo $title; ?></caption>
			<tr>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<td>
				<label for="txtEmail" >メールアドレス</label>
				</td>
				<td>
					<input id="txtEmail"  class="input" name="email" type="text" id="email" value="<?php echo empty($_SESSION["email"]) ? "" : $_SESSION["email"] ; ?>"/>
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_email']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			<?php if($_SESSION['form_user_mode'] === "insert"): ?>
			<tr>
				<td>
					<label for="txtPass" >パスワード</label>
				</td>
				<td>
					<input id="txtPass"  name="password" type="password" id="password" size="35"  value="<?php echo empty($_SESSION["password"]) ? "" : $_SESSION["password"] ; ?>" />
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_password']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="txtPass1" >パスワード(確認用)</label>
				</td>
				<td>
					<input id="txtPass1"  name="password1" type="password" id="password1" size="35"  value="<?php echo empty($_SESSION["password1"]) ? "" : $_SESSION["password1"] ; ?>" />
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_password1']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td>
					<label for="user_name" >ユーザー名</label>
				</td>
				<td>
					<input class="input" id="user_name" name="user_name" type="text" value="<?php echo empty($_SESSION["user_name"]) ? "" : $_SESSION["user_name"] ; ?>"/>
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_user_name']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			<tr>
				<td>
					<label for="last_name"  >姓</label>
				</td>      
				<td>
					<input class="input" id="last_name" name="last_name" type="text" value="<?php echo empty($_SESSION["last_name"]) ? "" : $_SESSION["last_name"] ; ?>"/>
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_last_name']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>          
			<tr>           
				<td>
					<label for="first_name" >名</label>
				</td>
				<td>
					<input class="input" id="first_name"  name="first_name"  type="text" value="<?php echo empty($_SESSION["first_name"]) ? "" : $_SESSION["first_name"] ; ?>"/>
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_first_name']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			<!---TODO:ブログ--->
			<tr>           
				<td>
					<label for="blog_url" >ブログ</label>
				</td>
				<td>
					<input class="input" id="blog_url"  name="blog_url"  type="text" value="<?php echo empty($_SESSION["blog_url"]) ? "" : $_SESSION["blog_url"] ; ?>"/>
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_blog_url']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			
			<?php if($_SESSION['form_user_mode'] === "insert"): ?>
			<tr>           
				<td>       
					<label for="question" >秘密の質問</label></br>
					<select name="question">
					<option value="0">母の旧姓は？</option>
					<option value="1">初恋の人は？</option>
					<option value="2">出身小学校は？</option>
					<option value="3">出身中学校は？</option>
					<option value="4">好きなスポーツは？</option>
					<option value="5">好きな俳優は？</option>
					<option value="6">好きな女優は？</option>
					<option value="7">食べれない食べ物は？</option>
					</select>
				</td>
				<td>
					<input class="input" id="answer"  name="answer" type="text" value="<?php echo empty($_SESSION["answer"]) ? "" : $_SESSION["answer"] ; ?>"/>
				</td>
				<td>
					<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_user_error_answer']==false) ? "" : "*" ; ?></span>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<input id="btnSubmit" type="submit" value="送信確認画面へ" />
	</form>
	</div>
</div>
</body>
</html>
