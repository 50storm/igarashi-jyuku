<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";

$_POST["email"]    = trim($_POST["email"]);
//$_POST["question"] = trim($_POST["question"]);
$_POST["answer"]   = trim($_POST["answer"]);


$_SESSION["email"]    = trim($_POST["email"]);
//$_SESSION["question"] = trim($_POST["question"]);
$_SESSION["answer"]   = trim($_POST["answer"]);
$_SESSION["error"]=false;


$_SESSION["msg"]=array();
$USER = new user($dsn,$user,$password);
$result = $USER->confirmUserAnswer(
					trim($_POST["email"]),
					trim($_SESSION["question"]),
					trim($_POST["answer"])
					);
if($result){
	$_SESSION["error"]=false;
	$pwd = "パスワード=>".$result['password'];
	//$back_url ="http://".get_url("form_pass_answer.php");
	//header("Location: $back_url");
//	echo $result['password'];
	
	
	
	//emaiでパスワード送付
	
	//初期化
	//header('Content-Type: text/html; charset=UTF-8');
	//header('Content_Language: ja');
//	mb_language('ja');
//	mb_internal_encoding('UTF-8');
//	
//	$sTo          = '';
//	$sFromMail    = '';
//	$sSubject     = '';
//	$sMessage     = '';
//	$sHeaders     = '';
//	
//	//送信先
//	$sTo          = trim($_POST["email"]);
//	//送信元
//	$sFromMail    = 'hiroshi-igarashi@hiroshi-igarashi.sakura.ne.jp';
//	//題
//	$sSubject     = 'Password reminder';
//	//ヘッダー
//	$sHeaders     = "From: {$sFromMail}\r\n";
//	//本文
//	$sMessage .= "\n"."Password：  ". $result['password'] ."\n"
//	;
//	
//	//送信処理
//	
//	//mb_language('uni');
//	if(mb_send_mail($sTo, $sSubject, $sMessage, $sHeaders)){
//		echo 'メール送信に成功致しました。<br/>';
//	}else{
//		echo 'メール送信に失敗致しました。<br/>';
//	}
//
//	// 言語と文字エンコーディングを正しくセット
//	mb_language("Japanese");
//	mb_internal_encoding("UTF-8");
//	// 宛先情報をエンコード
//	$to_name = "宛先太郎";
//	$to_addr = "taro@example.com";
//	$to_name_enc = mb_encode_mimeheader($to_name,"ISO-2022-JP");
//	$to = "$to_name_enc<$to_addr>";
//	// 送信元情報をエンコード
//	$from_name = "送信元次郎";
//	$from_addr = "jiro@example.com";
//	$from_name_enc = mb_encode_mimeheader($from_name, "ISO-2022-JP");
//	$from = "$from_name_enc<$from_addr>";
//	// メールヘッダを作成
//	$header  = "From: $from\n";
//	$header .= "Reply-To: $from";
//	// 件名や本文をセット(ここは自動的にエンコードされる)
//	$subject = "メールのテスト";
//	$body = " こんにちは、$to_name さん。元気ですか？";
//	// 日本語メールの送信
//	$result = mb_send_mail($to, $subject, $body, $header);
//	if ($result) {
//	echo "Success!";
//	} else {
//	echo "Failed...";
//	}
	
	//うまくいかない
	mb_language('Japanese'); //'ISO-2022-jp/Base64'のメールを作成
	mb_internal_encoding('UTF-8'); //変換元の文字コードを指定
	
	$to = trim($_POST["email"]);
	$from = mb_encode_mimeheader('管理者より').' <toeic.igarashi@gmail.com>';  //,mb_language('Japanese')で設定済みなので'ISO-2022-jp'の指定は不要
	$subject = "日本語の件名";
	$body = $pwd;
	
	$header = "From:".$from; 
	
	mb_send_mail($to, $subject, $body, $header );
	$_SESSION["msg"][]="パスワードをメールで送信しました。";
	
}else{
	$_SESSION["error"]=true;
	$_SESSION["msg"][]="合言葉が間違っています。";

}
	$back_url ="http://".get_url("form_pass_answer.php");
	header("Location: $back_url");

