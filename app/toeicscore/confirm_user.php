<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";
require_once "./config/config.php";



//セッション優先
//GETで飛んできた場合は、そちらを使う
//削除などGETで飛ばす予定
if(isset($_GET['mode'])){
	switch(trim($_GET['mode'])){
		case "delete":
		$_SESSION['form_user_mode']="delete";
		break;
		
		case "update":
		$_SESSION['form_user_mode']="update";
		
		break;
		
		case "insert":
		$_SESSION['form_user_mode']="insert";
		break;
	}
}

$title=null;
$question=null;

if($_SESSION['form_user_mode'] === "insert"){
	$title= "登録フォーム";
	
	$list_question = array(
					"母の旧姓は？",
					"初恋の人は？",
					"出身小学校は？",
					"出身中学校は？",
					"好きなスポーツは？",
					"好きな俳優は？",
					"好きな女優は？",
					"食べれない食べ物は？"
					);
	$question="<label>秘密の質問</label>" ;
	$question.="</br>"                    ;
	$question.='<select name="question">' ;
	for( $i=0 ; $i<=7 ; $i++ ){
		
		if((int)$_SESSION['question'] === $i)
		{
			$question.='<option value="' . $i . '" selected >' ;
		}else{
			$question.='<option value="' . $i . '">' ;
		}
		$question.=$list_question[$i];
		$question.='</option>';
	
	}
	$question.='</select>';
	
	//header('Content-Type: text/html; charset=utf-8');
	//msg($question); 
	if( $debug === "on" ){var_dump($_SESSION);}
	
	//exit;


}elseif($_SESSION['form_user_mode'] === "update"){
	$title= "登録情報変更";

}elseif($_SESSION['form_user_mode'] === "delete"){

}

//d($_SESSION['form_user_mode']);

//exit;

//session expiration check and login-in check
//新規以外
if(!isset($_SESSION["user_id"]) && $_SESSION['form_user_mode']!=="insert"){
	$login_url="http://".get_url("login.php");
	header("Location: $login_url");
}

if(!isset($_SESSION["error"])){
	$_SESSION["error"]=null;
	
}
if(!isset($_SESSION["msg"])){
	$_SESSION["msg"]=null;
}
if(!isset($_SESSION['form_user_mode'])){
	$_SESSION['form_user_mode']=null;
}



//var_dump($_SESSION["msg"]);

if( $debug === "on" ){var_dump($_SESSION);}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/Menu.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/main.css" type="text/css">   
<title><?php echo $title; ?></title>
</head>
<body>
<div id="wrapper">
	<!--header-->
	<header id="header">
		<h1>We are TOEICers</h1>
	</header>
	<!--Menu-->
	<?php 
	//if($_SESSION['form_user_mode'] === "update"  ||  $_SESSION['form_user_mode'] === "delete"){
	//	include"toeic_menu.php";
	//}
	?>
	<!--
	<div id="head">
		<p><?php echo $title; ?></p>
	</div>
	-->
	<div id="main">
		<form id="frmInput" name="frmInput" method="post" action="./do_user.php">
			<table  style="" >
			<caption><?php echo $title; ?></caption>
			<tr>
				<th></th>
				<th></th>
			</tr>
				<tr>
					<td>
					<label for="TextEmail" >メールアドレス</label>
					</td>
					<td>
						<input id="TextEmail"  class="input" name="email" type="text" id="email" value="<?php echo empty($_SESSION["email"]) ? "" : $_SESSION["email"] ; ?>" readonly />
					</td>
				</tr>
				<?php if($_SESSION['form_user_mode'] === "insert"): ?>
				<tr>
					<td>
						<label for="TextPass" >パスワード</label>
					</td>
					<td>
						<input id="TextPass"  name="password" type="password" id="password" size="35"  value="<?php echo empty($_SESSION["password"]) ? "" : $_SESSION["password"] ; ?>"  readonly />
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td>
						<label  >ユーザー名</label>
					</td>
					<td>
						<input class="input" name="user_name" type="text" value="<?php echo empty($_SESSION["user_name"]) ? "" : $_SESSION["user_name"] ; ?> " readonly />
					</td>
				</tr>
				<tr>
					<td>
						<label >姓</label>
					</td>      
					<td>
						<input class="input" name="last_name" type="text" value="<?php echo empty($_SESSION["last_name"]) ? "" : $_SESSION["last_name"] ; ?>"  readonly />
					</td>      
				</tr>          
                               
				<tr>           
					<td>
						<label >名</label>
					</td>
					<td>
						<input class="input" name="first_name" type="text" value="<?php echo empty($_SESSION["first_name"]) ? "" : $_SESSION["first_name"] ; ?>"  readonly />
					</td>
				</tr>
				<tr>           
					<td>
						<label for="blog_url" >ブログ</label>
					</td>
					<td>
						<input class="input" id="blog_url"  name="blog_url"  type="text" value="<?php echo empty($_SESSION["blog_url"]) ? "" : $_SESSION["blog_url"] ; ?>"  readonly />
					</td>
				</tr>
				<?php if($_SESSION['form_user_mode'] === "insert"): ?>
				<tr>           
					<td>
						<?php  echo $question; ?>
					</td>
					<td>
						<input class="input" name="answer" type="text" value="<?php echo empty($_SESSION["answer"]) ? "" : $_SESSION["answer"] ; ?>"/>
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<input id="login"  type="submit" value="送信する" /><a href="./form_user.php">やり直す</a>
			</form>

	</div>
</div>
</body>
</html>
