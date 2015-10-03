<?php
//文字化け対応
header("Content-Type: text/html; charset=UTF-8");
//headerでリダイレクトまえにechoしてると、リダイレクトできないので注意

//var_dump("debug");
//echo "</br>";

session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";
//var_dump("debug2");


$_SESSION["email"]    = $_POST["email"];
$_SESSION["password"] = $_POST["password"];

$_SESSION["error"]=false;
$_SESSION["error_email"]=false;
$_SESSION["error_password"]=false;
$_SESSION["error_db"]=false;

$_SESSION["msg"]=array();
//var_dump($_SESSION);
//echo "</br>";

$back_url  ="http://".get_url("login.php");
$redirect_url ="http://".get_url("mypage.php");
//var_dump($back_url);
//echo "</br>";

//var_dump($redirect_url);
//echo "</br>";


if (empty($_POST['email'])) {
	$_SESSION["error_email"]=true;
	$_SESSION["msg"][]="メールアドレスが入力されていません。";
   
}else{
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {

		} else {
			$_SESSION["error_email"]=true;
			$_SESSION["msg"][]="メールアドレスの形式が正しくありません。";
		}
}

  
if (empty($_POST['password'])) {
	$_SESSION["error"]=true;
	$_SESSION["msg"][]="パスワードが入力されていません。";
}

//var_dump($_SESSION["msg"]);
//echo "</br>";
//exit;

if($_SESSION["error_email"] || $_SESSION["error_password"]){
	$_SESSION["error"]=true;
	header("Location: $back_url");
	exit;
}

//echo "DB接続</br>";

//DB接続
try{
	$USER = new user($dsn, $user, $password);
	$row  = $USER->getRowByEmailAndPassword($_POST['email'], $_POST['password']);
	if($row == false){
		$_SESSION["error_db"]=true;
		$_SESSION["msg"][]="パスワードかメールアドレスが正しくありません。";
		$_SESSION["error"]=true;
		unset($USER);
	}


} catch(PDOException $e){
	unset($USER);
	echo $e->getMessage();

} catch (Exception $e) {
	unset($USER);
	echo "例外キャッチ：", $e->getMessage(), "\n";

}

//echo "リダイレクト前</br>";

if ($_SESSION["error"]==true){
	//echo "リダイレクト</br>";
	//var_dump($_SESSION["msg"]);
	
	header("Location: $back_url");
	exit;

}else{
	//save users data in session
	$_SESSION['user_id']   = h($row["id"]);
	$_SESSION['email']     = h($row["email"]);
	$_SESSION['user_name'] = h($row["user_name"]);
	$_SESSION['last_name'] = h($row["last_name"]);
	$_SESSION['first_name']= h($row["first_name"]);
	$_SESSION['blog_url']= h($row["blog_url"]);
	$_SESSION['created_at']= h($row["created_at"]);

	unset($_SESSION["password"]);
	unset($_SESSION['msg']);
	unset($_SESSION["error"]);

	//var_dump($redirect_url);
	header("Location: $redirect_url");
	exit();
	//リダイレクトしない？
	//var_dump($redirect_url);
}
