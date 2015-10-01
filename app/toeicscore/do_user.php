<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";

$_POST["email"]    = trim($_POST["email"]);
$_POST["password"] = trim($_POST["password"]);
$_POST["user_name"] = trim($_POST["user_name"]);
$_POST["last_name"]  = trim($_POST["last_name"]);
$_POST["first_name"] = trim($_POST["first_name"]);
$_POST["blog_url"]   = trim($_POST["blog_url"]);
$_POST["question"] = trim($_POST["question"]);
$_POST["answer"] = trim($_POST["answer"]);

$_SESSION["email"]    = trim($_POST["email"]);
$_SESSION["password"] = trim($_POST["password"]);
$_SESSION["user_name"]  = trim($_POST["user_name"]);
$_SESSION["last_name"]  = trim($_POST["last_name"]);
$_SESSION["first_name"] = trim($_POST["first_name"]);
$_SESSION["blog_url"]   = trim($_POST["blog_url"]);
$_SESSION["question"] = trim($_POST["question"]);
$_SESSION["answer"] = trim($_POST["answer"]);

$_SESSION['form_user_msg']=array();

//var_dump($_POST["question"]);
//var_dump($_POST["answer"]);
//exit;

//DB接続
try{
	if($_SESSION['form_user_mode'] === "insert"){
		//insert
		$USER = new user($dsn,$user,$password);
		$result = $USER->insert(
						trim($_POST["email"]),
						trim($_POST["password"]),
						trim($_POST["user_name"]),
						trim($_POST["last_name"]),
						trim($_POST["first_name"]),
						trim($_POST["blog_url"]),
						trim($_POST["question"]),
						trim($_POST["answer"]));
		
		if($result == false){
			$_SESSION["error_db"]=true;
			$_SESSION['form_user_msg'][]="New data couldn't be created";
			$_SESSION['form_user_error']=true;
		}
		
		if($result){
			$redirect_url ="http://".get_url("menu.php");
			header("Location: $redirect_url");
		}
	
	
	}elseif($_SESSION['form_user_mode'] === "update"){
		$USER = new user($dsn,$user,$password);
		$result = $USER->updateRowById(
						trim($_SESSION['user_id']),
						trim($_POST["email"]),
						trim($_POST["user_name"]),
						trim($_POST["last_name"]),
						trim($_POST["first_name"])
		);
		if($result){
			$redirect_url ="http://".get_url("menu.php");
			header("Location: $redirect_url");
	
		}else{
			$_SESSION["error_db"]=true;
			$_SESSION['form_user_error']=true;
			
		
		}
		//emailはデバックで楽なので残しておこうか。。。
		//emailを変更したら、関連テーブルも削除
		//$result = $USER->updateRowByEmail();
	}elseif($_SESSION['form_user_mode'] === "delete"){
		//物理削除はやめて
		//削除フラグをオンにしよう
		
	}
	unset($USER);
	
} catch(PDOException $e){
	unset($USER);
	echo $e->getMessage();
	
} catch (Exception $e) {
	unset($USER);
	echo "例外キャッチ：", $e->getMessage(), "\n";
}

if ($_SESSION['form_user_error']==true){
	$back_url  ="http://".get_url("form_user.php");
	header("Location: $back_url");
	

}else{
//save users data in SESSION except for password
	$_SESSION["email"]=$_POST["email"];
	$_SESSION["user_name"]=$_POST["user_name"];
	$_SESSION["last_name"]=$_POST["last_name"];
	$_SESSION["first_name"]=$_POST["first_name"];

	unset($_SESSION['form_user_msg']);
	unset($_SESSION['form_user_error_email']);
	unset($_SESSION['form_user_error_password']);
	unset($_SESSION['form_user_error_user_name']);
	unset($_SESSION['form_user_error_last_name']);
	unset($_SESSION['form_user_error_first_name']);
	unset($_SESSION['form_user_error_answer']);
	$redirect_url ="http://".get_url("mypage.php");
	header("Location: $redirect_url");

}
