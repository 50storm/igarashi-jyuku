<?php
session_start();
//header('Content-Type: text/html; charset=utf-8');
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/toeic_class.php";


//var_dump($_SESSION);
//exit;

try{
	if($_SESSION['form_toeic_mode']==="insert"){
		$date  = trim($_POST['year'])."-".trim($_POST['month'])."-".trim($_POST['day']);
		$TOEIC = new Toeic($dsn,$user,$password);
		$TOEIC->insert(
			$date,
			$_POST['score'] ,
			$_POST['reading_score'] ,  
			$_POST['listening_score'],
			$_POST['comment'],
			$_SESSION['user_id']
		);
		//msg("登録");
		//d($_SESSION);
		//exit;
	
	
	}elseif($_SESSION['form_toeic_mode']==="update"){
		$date  = trim($_POST['year'])."-".trim($_POST['month'])."-".trim($_POST['day']);
		$TOEIC = new Toeic($dsn,$user,$password);
		$TOEIC->updateRowById(
					trim($_SESSION["toeic_id"]),
					$date, 
					$_POST["score"], 
					$_POST["reading_score"], 
					$_POST["listening_score"], 
					$_POST["comment"]
				);
		//msg("変更");
		//d($_SESSION);
		//exit;
		
	}elseif($_SESSION['form_toeic_mode']==="delete"){
		$TOEIC = new Toeic($dsn,$user,$password);
		$TOEIC->deleteRowById($_SESSION["toeic_id"]);
		//msg("削除");
		
		//d($_SESSION);
		//exit;
	
	
	}
	
} catch(PDOException $e){
	echo $e->getMessage();
	
	
} catch (Exception $e) {
	echo "例外キャッチ：", $e->getMessage(), "\n";
	
}
 //finally {
//	//登録したのでクリア
//	unset($TOEIC);
//	unset($_SESSION['year']);
//	unset($_SESSION['month']);
//	unset($_SESSION['day']);
//	unset($_SESSION['score']);
//	unset($_SESSION['reading_score']);
//	unset($_SESSION['listening_score']);
//	unset($_SESSION['comment']);
//	unset($_SESSION['form_toeic_mode']);
//	unset($_SESSION['form_toeic_error']);
//	unset($_SESSION['form_toeic_error_year']);
//	unset($_SESSION['form_toeic_error_month']);
//	unset($_SESSION['form_toeic_error_day']);
//	unset($_SESSION['form_error_score']);
//	unset($_SESSION['form_toeic_error_reading_score']);
//	unset($_SESSION['form_toeic_error_listening_score']);
//	unset($_SESSION['form_toeic_msg']);
	
//}

	//登録したのでクリア
	unset($TOEIC);
	unset($_SESSION['year']);
	unset($_SESSION['month']);
	unset($_SESSION['day']);
	unset($_SESSION['score']);
	unset($_SESSION['reading_score']);
	unset($_SESSION['listening_score']);
	unset($_SESSION['comment']);
	unset($_SESSION['form_toeic_mode']);
	unset($_SESSION['form_toeic_error']);
	unset($_SESSION['form_toeic_error_year']);
	unset($_SESSION['form_toeic_error_month']);
	unset($_SESSION['form_toeic_error_day']);
	unset($_SESSION['form_error_score']);
	unset($_SESSION['form_toeic_error_reading_score']);
	unset($_SESSION['form_toeic_error_listening_score']);
	unset($_SESSION['form_toeic_msg']);
	
$redirect_url   = "http://".get_url("mypage.php");
header("Location: $redirect_url");

