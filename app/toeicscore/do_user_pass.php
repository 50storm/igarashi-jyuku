<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";

$_POST["password"] = trim($_POST["password"]);
$_POST["new_password1"] = trim($_POST["new_password1"]);


$_SESSION["password"] = trim($_POST["password"]);
$_SESSION["new_password1"] = trim($_POST["new_password1"]);


try{
	$USER = new user($dsn,$user,$password);
	$result = $USER->updatePasswordById(
					trim($_SESSION["id"]),
					trim($_POST["new_password1"])
					);
	unset($USER);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    unset($USER);
}

$_SESSION['form_user_pass_msg']=array();
if($result){
	msg("updated");
	$_SESSION['form_user_pass_msg'][]="パスワードは正しく変更されました。";
	
	//新しいパスワードに移す
	//$_SESSION["password"] = $_SESSION["new_password1"];
	
	
	//セッション変数削除
	unset($_SESSION["password"]);
	unset($_SESSION["new_password1"]);
	unset($_SESSION["new_password2"]);
	unset($_SESSION['form_user_pass_error']);
	unset($_SESSION['form_user_pass_error_password']);
	unset($_SESSION['form_user_pass_error_new_password1']);
	unset($_SESSION['form_user_pass_error_new_password2']);
	//unset($_SESSION['form_user_pass_msg']);
	
	
	
}else{
	msg("failed");
	$_SESSION['form_user_pass_msg'][]="パスワード変更失敗。";
	

}

$redirect_url ="http://".get_url("confirm_user_pass.php");
header("Location: $redirect_url");
