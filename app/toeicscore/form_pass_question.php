<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";

if( $debug === "on" ){var_dump($_SESSION);}


//セッション優先
//GETで飛んできた場合は、そちらを使う
//削除などGETで飛ばす予定


$question=null;
$title= "パスワード確認";


if(!isset($_SESSION["error"])){
	$_SESSION["error"]=null;
	
}
if(!isset($_SESSION["msg"])){
	$_SESSION["msg"]=null;
}
if(!isset($_SESSION["mode"])){
	$_SESSION["mode"]=null;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' type='text/css' href='../css/com.css' />  

<title><?php echo $title; ?></title>
</head>
<body>
<div id="wrap">
	<div id="head">
		<h1><?php echo $title; ?></h1>
	</div>
	<div id="content">
		<div>
			<?php if($_SESSION["error"] == true) :?>
				<ul>
					<?php foreach($_SESSION["msg"] as $msg) :?>
							<li><?php  echo $msg; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<form id="frmInput" name="frmInput" method="post" action="./do_user_pass_get_question.php">
			<table  style="" >
				<tr>
					<td>
					<label for="TextEmail" >メールアドレス</label>
					</td>
					<td>
						<input id="TextEmail"  class="input" name="email" type="text" id="email" value="<?php echo empty($_SESSION["email"]) ? "" : $_SESSION["email"] ; ?>"   />
					</td>
				</tr>
			</table>
			<input id="login"  type="submit" value="秘密の質問へ" />
		</form>

	</div>
</div>
</body>
</html>
