<?php
session_start();
//header('Content-Type: text/html; charset=utf-8');

require_once "./module/utility.php";
require_once "./module/user.php";
require_once "./module/db_setting.php";

$_POST["password"] = trim($_POST["password"]);
$_POST["new_password1"] = trim($_POST["new_password1"]);
$_POST["new_password2"] = trim($_POST["new_password2"]);


$_SESSION["password"] = trim($_POST["password"]);
$_SESSION["new_password1"] = trim($_POST["new_password1"]);
$_SESSION["new_password2"] = trim($_POST["new_password2"]);

$_SESSION['form_user_pass_error']  =false;
$_SESSION['form_user_pass_error_password']  =false;
$_SESSION['form_user_pass_error_new_password1']  =false;
$_SESSION['form_user_pass_error_new_password2']  =false;
$_SESSION['form_user_pass_msg']=array();

$back_url   = "http://".get_url("form_user_pass.php");
$url_confirm   = "http://".get_url("confirm_user_pass.php");

//入力確認
if ( empty($_POST["password"]) ){
	$_SESSION['form_user_pass_msg'][]="現在のパスワードが入力されていません。";
	$_SESSION['form_user_pass_error_password']=true;
}else{
	$_SESSION['form_user_pass_error_password']=false;
}

if ( empty($_POST["new_password1"]) ){
	$_SESSION['form_user_pass_msg'][]="新しいパスワードが入力されていません。";
	$_SESSION['form_user_pass_error_new_password1']  =true;
}else{
	$_SESSION['form_user_pass_error_new_password1']  =false;
}

if ( empty($_POST["new_password2"]) ){
	$_SESSION['form_user_pass_msg'][]="新しいパスワード（確認用）が入力されていません。";
	$_SESSION['form_user_pass_error_new_password2']  =true;
}else{
	$_SESSION['form_user_pass_error_new_password2']  =false;
}

//入力確認NGだったら画面戻す
if ( $_SESSION['form_user_pass_error_password'] || $_SESSION['form_user_pass_error_new_password1'] || $_SESSION['form_user_pass_error_new_password2'] ) {
	$_SESSION['form_user_pass_error']=true;
	header("Location: $back_url");

}else{
	$_SESSION['form_user_pass_error']=false;
}


//Userに登録されてるパスワードか確認
try{
	$USER = new user($dsn,$user,$password);
	$row = $USER->getRowByEmailAndPassword($_SESSION["email"], $_POST["password"]);
	unset($USER);
	if($row==false){
		$_SESSION['form_user_pass_msg'][].= "現在のパスワードが正しくありません。";
		$_SESSION['form_user_pass_error_password']=true;
	}else{
		$_SESSION['form_user_pass_error_password']=false;
		
	}
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    unset($USER);
}

if($_SESSION['form_user_pass_error_password']){
	$_SESSION['form_user_pass_error']=true;
	header("Location: $back_url");
}else{
	$_SESSION['form_user_pass_error']=false;
}

$result_new_password1=is_password($_POST["new_password1"]);
if ( !empty($result_new_password1) && !$result_new_password1==true) {
		$_SESSION['form_user_pass_error_new_password1']=true;
		$_SESSION['form_user_pass_msg'][].=$result_new_password1."[新しいパスワード]";
}else{
		$_SESSION['form_user_pass_error_new_password1']=false;

}

if($_SESSION['form_user_pass_error_new_password1']){
	$_SESSION['form_user_pass_error']=true;
	header("Location: $back_url");
}


$result_new_password2=is_password($_POST["new_password2"]);
if ( !empty($result_new_password2) && !$result_new_password2==true ) {
		$_SESSION['form_user_pass_error_new_password2']=true;
		$_SESSION['form_user_pass_msg'][].=$result_new_password2."[新しいパスワード(確認用)]";
}else{
		$_SESSION['form_user_pass_error_new_password2']=false;
}

if($_SESSION['form_user_pass_error_new_password2']){
	$_SESSION['form_user_pass_error']=true;
	header("Location: $back_url");
}


//mistyped?
if( strcmp(  $_POST["new_password1"] , $_POST["new_password2"] ) !== 0 )
{

	$_SESSION['form_user_pass_error_new_password1']=true;
	$_SESSION['form_user_pass_error_new_password2']=true;
	$_SESSION['form_user_pass_msg'][].= "新しいパスワードの入力が間違っています。";
}else{
	$_SESSION['form_user_pass_error_new_password1']=false;
	$_SESSION['form_user_pass_error_new_password2']=false;
}



//TODO:途中・・・・・
if(  $_SESSION['form_user_pass_error_new_password1']  ||   $_SESSION['form_user_pass_error_new_password2']   ){
	$_SESSION['form_user_pass_error']=true;
	header("Location: $back_url");
}


//Same password?
if( strcmp( $_POST["new_password1"] , $_POST["password"] ) == 0)
{
	$_SESSION['form_user_pass_error_new_password1']=true;
	$_SESSION['form_user_pass_error_password']=true;
	$_SESSION['form_user_pass_msg'][].= "新しいパスワードが現在のパスワードと同じです。";
}else{
	$_SESSION['form_user_pass_error_new_password1']=false;
	$_SESSION['form_user_pass_error_password']=false;

}

if( $_SESSION['form_user_pass_error_new_password1'] || 
    $_SESSION['form_user_pass_error_new_password2'] ){
	$_SESSION['form_user_pass_error']=true;
		header("Location: $back_url");
}else{
	$_SESSION['form_user_pass_error']=false;
}

//var_dump($_SESSION);exit;
if($_SESSION['form_user_pass_error']){
	header("Location: $back_url");

}else{
	header("Location: $url_confirm");//TODO:確認画面ではなく更新しよう

}

