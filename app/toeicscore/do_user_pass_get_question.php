<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";

$_POST["email"]    = trim($_POST["email"]);
$_SESSION["email"]    = trim($_POST["email"]);

$_SESSION["error"]=false;
$_SESSION["msg"]=array();

$USER = new user($dsn,$user,$password);
$result = $USER->getQuestion(
					trim($_POST["email"])
					);
if($result){
	$_SESSION["error"]=false;
	$_SESSION["question"]=$result['question'];
	$foward_url="http://".get_url("form_pass_answer.php");
	header("Location: $foward_url");

}else{
	$_SESSION["error"]=true;
	$_SESSION["msg"][]="メールアドレスが間違っています。";
	$back_url ="http://".get_url("form_pass_question.php");
	header("Location: $back_url");

}
