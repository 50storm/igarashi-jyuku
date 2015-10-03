<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";

$_POST["email"]  = trim($_POST["email"]);
$_POST["password"]   = trim($_POST["password"]);
$_POST["password1"]   = trim($_POST["password1"]);
$_POST["user_name"]   = trim($_POST["user_name"]);
$_POST["last_name"]  = trim($_POST["last_name"]);
$_POST["first_name"] = trim($_POST["first_name"]);
$_POST["blog_url"]   = trim($_POST["blog_url"]);
$_POST['question']   = trim($_POST['question']);
$_POST['answer']     = trim($_POST['answer']);


$_SESSION["email"]      = trim($_POST["email"]);
$_SESSION["password"]   = trim($_POST["password"]);
$_SESSION["password1"]   = trim($_POST["password1"]);
$_SESSION["user_name"]  = trim($_POST["user_name"]);
$_SESSION["last_name"]  = trim($_POST["last_name"]);
$_SESSION["first_name"] = trim($_POST["first_name"]);
$_SESSION["blog_url"]   = trim($_POST["blog_url"]);
$_SESSION['question']   = trim($_POST['question']); 
$_SESSION['answer']     = trim($_POST['answer']);




$_SESSION['form_user_error']=false;
$_SESSION['form_user_error_email']     =false;
$_SESSION['form_user_error_password']  =false;
$_SESSION['form_user_error_password1'] =false;
$_SESSION['form_user_error_user_name'] =false;
$_SESSION['form_user_error_last_name'] =false;
$_SESSION['form_user_error_first_name']=false;
$_SESSION['form_user_error_answer']    =false;
$_SESSION['form_user_error_blog_url']  =false;
$_SESSION['form_user_msg']=array();

if (empty($_POST["email"])) {
	$_SESSION['form_user_error_email']=true;
	$_SESSION['form_user_msg'][]="Eメールが入力されていません。";

}else{
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST["email"])) {

		} else {
			$_SESSION['form_user_error_email']=true;
			$_SESSION['form_user_msg'][]="Eメール形式がおかしいです。";
		}
}

//登録時のみ
if($_SESSION['form_user_mode'] === "insert"){
	if (empty($_POST["password"])) {
		$_SESSION['form_user_error_password']=true;
		$_SESSION['form_user_msg'][]="パスワードが入力されていません。";
		
	}
	
	if (empty($_POST["password1"])) {
		$_SESSION['form_user_error_password1']=true;
		$_SESSION['form_user_msg'][]="パスワード(確認用)が入力されていません。";
		
	}
	
	if( strcmp( $_POST["password"] , $_POST["password1"] ) ==  0  ){
		
	}else{
		$_SESSION['form_user_error_password']=true;
		$_SESSION['form_user_error_password1']=true;
		$_SESSION['form_user_msg'][]="パスワードとパスワード(確認用)が異なっています。";
	}
	
	//TODO:パスワードチェック追加	
	$ret_pswd = is_password($_POST["password"]);
	if ( !$ret_pswd == true) {
		$_SESSION['form_user_error_password']=true;
		$_SESSION['form_user_msg'][].=$result_new_password1."[新しいパスワード]";
	}else{
		$_SESSION['form_user_error_password']=false;
	}

	$ret_pswd1 = is_password($_POST["password1"]);
	if ( !$ret_pswd1 ==true) {
		$_SESSION['form_user_error_password1']=true;
		$_SESSION['form_user_msg'][].=$result_new_password1."[新しいパスワード]";
	}else{
		$_SESSION['form_user_error_password1']=false;
	}
	
	
	//email重複チェック
	try{
		$USER = new user($dsn,$user,$password);
		$ret = $USER->getRowByEmail($_POST["email"]);
		//emptyに関数いれるとエラー起こる
		//Fatal error: Can't use method return value in write context in
		
		if( !empty( $ret ) ) {
			$_SESSION['form_user_error_email']=true;
			$_SESSION['form_user_msg'][]="Eメールは既に、登録されています。";
		}
	} catch(PDOException $e){
		unset($USER);
		echo $e->getMessage();
		$_SESSION['form_user_error_email']=true;
	} catch (Exception $e) {
		unset($USER);
		echo "例外キャッチ：", $e->getMessage(), "\n";
		$_SESSION['form_user_error_email']=true;
	}

}

if (empty($_POST["user_name"])) {
	$_SESSION['form_user_error_user_name']=true;
	$_SESSION['form_user_msg'][]="ユーザー名が入力されていません。";

	}
/*
if (empty($_POST["last_name"])) {
	$_SESSION['form_user_error_last_name']=true;
	$_SESSION['form_user_msg'][]="性が入力されていません。";

}

if (empty($_POST["first_name"])) {
	$_SESSION['form_user_error_first_name']=true;
	$_SESSION['form_user_msg'][]="名が入力されていません。";
	
}
*/
if (!empty($_POST["blog_url"])) {
	if(!is_url($_POST["blog_url"])){
		$_SESSION['form_user_error_blog_url']=true;
		$_SESSION['form_user_msg'][]="ブログのURLの形式が正しくありません。";
	}
}
if($_SESSION['form_user_mode'] === "insert"){

	if (empty($_POST["answer"])) {
		$_SESSION['form_user_error_answer']=true;
		$_SESSION['form_user_msg'][]="秘密の答えが入力されていません。";
	
	}
}


//必須項目
//メアド、ユーザー名、パスワード、秘密の質問
if($_SESSION['form_user_error_email']     || $_SESSION['form_user_error_password'] ||
   $_SESSION['form_user_error_user_name'] || $_SESSION["form_user_error_answer"] || $_SESSION["form_user_error_blog_url"] ){
	$_SESSION['form_user_error']=true;
	//$back_url   = "http://".get_url("form_user.php");
	//header("Location: $back_url");
	//var_dump(get_url('form_user.php'));
	header("Location: http://" .get_url('form_user.php'));
}else{
	//エラーがなければ、確認画面へ
	$_SESSION['form_user_error']=false;
	//$url_confirm   = "http://".get_url("confirm_user.php");
	//header("Location: $url_confirm");
	//var_dump(get_url('confirm_user.php'));
	header("Location: http://" .get_url('confirm_user.php'));

}

