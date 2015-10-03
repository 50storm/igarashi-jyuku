<?php
session_start();
//To Do
//1. change the validation by using reg_match;
//2. want show each erroer message.
//3. Ajax 
//4. Add validations in Javascript or jQuery
//if an error is detected , set True
//if an error is not detected , set False
//header('Content-Type: text/plain; charset=utf-8');//デバック時の文字化け防止//to avoid displaying garbage characters
//header('Content-Type: text/html; charset=utf-8');//デバック時の文字化け防止//to avoid displaying garbage characters
require_once "./module/db_setting.php";
require_once "./module/utility.php";

 
$_POST['year']=trim($_POST['year']);
$_POST['month']=trim($_POST['month']);
$_POST['day']=trim($_POST['day']);
$_POST['score']=trim($_POST['score']);
$_POST['reading_score']=trim($_POST['reading_score']);
$_POST['listening_score']=trim($_POST['listening_score']);
$_POST['comment']=trim($_POST['comment']);



//In order to show the value they enter
//save the date in Session.
$_SESSION['year']  =trim($_POST['year']);
$_SESSION['month'] =trim($_POST['month']);
$_SESSION['day']   =trim($_POST['day']);
$_SESSION['score'] =trim($_POST['score']);
$_SESSION['reading_score']  =trim($_POST['reading_score']);
$_SESSION['listening_score']=trim($_POST['listening_score']);
$_SESSION['comment']        =trim($_POST['comment']);

//initialize error flag
$_SESSION['form_toeic_error']=false;//エラーフラグをクリア
$_SESSION['form_toeic_error_year']=false;
$_SESSION['form_toeic_error_month']=false;
$_SESSION['form_toeic_error_day']=false;
$_SESSION['form_error_score']=false;
$_SESSION['form_toeic_error_reading_score']=false;
$_SESSION['form_toeic_error_listening_score']=false;
$_SESSION['form_toeic_msg']=array();//init

if(preg_match("/^[0-9]{4}$/", $_POST['year'])){
	$_SESSION['form_toeic_error_year']=false;
	//msg("Year has no error");
	
}else{
	$_SESSION['form_toeic_error_year']=true;
	//$_SESSION['form_toeic_msg'][]="Year is invalid";
	$_SESSION['form_toeic_msg'][]="年の入力が間違っています。(2014のように入力)";
	//msg("Year has an error");
	//d($_SESSION['form_toeic_msg']);
	
}

//month
if(isMonth($_POST['month'])){
	$_SESSION['form_toeic_error_month']=false;
	//msg("Month has nos error");

}else{
	$_SESSION['form_toeic_error_month']=true;
	//$_SESSION['form_toeic_msg'][]="Month is invalid";
	$_SESSION['form_toeic_msg'][]="月の入力が間違っています。";
	
	//msg("Month has an error");
	//d($_SESSION['form_toeic_msg']);
}


if(isDay($_POST['day'])){
	$_SESSION['form_toeic_error_day']=false;
	//msg("Day has no error");
}else{
	$_SESSION['form_toeic_error_day']=true;
	//$_SESSION['form_toeic_msg'][]="Day is invalid";
	$_SESSION['form_toeic_msg'][]="月の入力が間違っています。";
	//msg("Day has an error");
	//d($_SESSION['form_toeic_msg']);

}

if(is_score($_POST['score'])){
	$_SESSION['form_toeic_error_score']=false;
	//msg("soore has no error");

}else{
	$_SESSION['form_toeic_error_score']=true;
	//msg("Score has an error");
	//$_SESSION['form_toeic_msg'][]="Score is invalid";
	$_SESSION['form_toeic_msg'][]="スコアの入力が間違っています。";
	//d($_SESSION['form_toeic_msg']);

}


if(!is_listening_reading_score($_POST['reading_score'])){
	$_SESSION['form_toeic_error_reading_score']=true;
	//msg("reading_score has an error");
	$_SESSION['form_toeic_msg'][]="reading_score is invalid";
	$_SESSION['form_toeic_msg'][]="リーディング　スコアの入力が間違っています。";
	//d($_SESSION['form_toeic_msg']);

}else{
	$_SESSION['form_toeic_error_reading_score']=false;
	//msg("reading_score has an error");
	//d($_SESSION['form_toeic_msg']);
}


if(!is_listening_reading_score($_POST['listening_score'])){
	$_SESSION['form_toeic_error_listening_score']=true;
	//msg("listening_score has an error");
	//$_SESSION['form_toeic_msg'][]="listening_score is invalid";
	$_SESSION['form_toeic_msg'][]="リスニング　スコアの入力が間違っています。";
	//d($_SESSION['form_toeic_msg']);

}else{
	$_SESSION['form_toeic_error_listening_score']=false;
	//msg("listening_score has no errors");
	//d($_SESSION['form_toeic_msg']);
}


//exit;

//socre =listening_score+reading_score
$toeic_LR = (int)$_POST['listening_score']+(int)$_POST['reading_score'];

if($toeic_LR == (int)$_POST['score'] &&
    (int)$_POST['score'] >=10 && (int)$_POST['score'] <= 990 ){
//no erroers
	$_SESSION['form_toeic_error_score']          =false;
	$_SESSION['form_toeic_error_reading_score']  =false;
	$_SESSION['form_toeic_error_listening_score']=false; 
	
}else{
//False
	$_SESSION['form_toeic_error_score']          =true;
	$_SESSION['form_toeic_error_reading_score']  =true;
	$_SESSION['form_toeic_error_listening_score']=true; 
	//$_SESSION['form_toeic_msg'][]="TOEIC Score(=Listeing+Reading)";
	$_SESSION['form_toeic_msg'][]="スコア(=リスニング+リーディング)";
	//d($_SESSION['form_toeic_msg']);
}

//exit;


if(
	$_SESSION['form_toeic_error_year']==true    ||
	$_SESSION['form_toeic_error_month']==true   ||
	$_SESSION['form_toeic_error_day']==true     ||
	$_SESSION['form_error_score']==true   ||
	$_SESSION['form_toeic_error_reading_score']==true ||
	$_SESSION['form_toeic_error_listening_score']==true 
){
	$_SESSION['form_toeic_error']=true;
}else{
	$_SESSION['form_toeic_error']=false;
	$_SESSION['form_toeic_error_year']==false;
	$_SESSION['form_toeic_error_month']==false;
	$_SESSION['form_toeic_error_day']==false;
	$_SESSION['form_error_score']==false;
	$_SESSION['form_toeic_error_reading_score']==false;
	$_SESSION['form_toeic_error_listening_score']==false; 


	
	
}

//エラーがあればView画面に戻す
//var_dump($_SESSION['form_toeic_error']);
if ($_SESSION['form_toeic_error']==true){
	$url_post_back = "http://".get_url("form_toeic.php");
	header("Location: $url_post_back");
	//exit;

}else{
	//エラーがなければ、確認画面へ
	$url_confirm   = "http://".get_url("confirm_toeic.php");
	header("Location: $url_confirm");
	//exit;

}
