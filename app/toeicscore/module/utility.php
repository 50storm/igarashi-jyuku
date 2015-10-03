<?php
function h($str){
	return htmlspecialchars($str, ENT_QUOTES,'UTF-8');
}

function get_url($file){
	return $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/".$file ;
}

function msg($message){
//	echo "-------------------------\n";
	echo "</br>"."////".$message."////"."</br>";
//	echo "-------------------------\n";
}

function d($var){
//	echo "-------------------------\n";
	echo "</br>";
	var_dump($var);
	echo "</br>";
//	echo "-------------------------\n";
}


function isMonth($month){
	//d($month);
	
	if(!is_numeric($month)){
		return false;
	}
	
	//1 - 12
	if( $month >=1 && $month <= 12 ){
		//msg("1-12");
		return true;
	}else{
		//msg("Not 1-12");
		return false;
	}
}


function isDay($day){
	if(!is_numeric($day)){
		return false;
	}
	
	if(mb_strlen($day)>=1 && mb_strlen($day)<=2){
		if(1<=$day && $day<=31)
		{
			return true;
		}
		else
		{
			return false;
		}
	}else{
		return false;
	}
}

function isLeap($year){
	if ( $year%4 == 0 && $year%100 != 0 || $year%400 == 0 ) {
		return true;
	} else {
		return false;
	}
}

function is_score($score){
	if (!is_numeric($score)){
		return false;
	}else{
		//Digit check
		if(1 <=  mb_strlen($score) && mb_strlen($score)<=3 && (int) $score >= 10 && (int) $score <= 990 ){
		//OK
			return true;
		}else{
		//NG
			return false;
		}
	}
}

function is_listening_reading_score($score){
	if (!is_numeric($score)){
		return false;
	}else{
		if(1 <=  mb_strlen($score) && mb_strlen($score)<=3 && (int) $score >= 5 && (int) $score <= 495 ){
			// % 5 (Modules=0) increment by 5
			if((int)$score % 5 == 0){
				return true;
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
}


function is_password($pwd){
	
	$error;
	if( empty($pwd)) {
		//return "Password empty! ";
		return "パスワードが入力されていません。 ";
		
	
	}
	if( strlen($pwd) < 8 ) {
		//return "Password too short! ";
		return "パワスワードが短すぎます。";
	}
	
	//if( strlen($pwd) > 20 ) {
	//	return "Password too long! ";
	//}
	
	if( !preg_match("#[0-9]+#", $pwd) ) {
		//return "Password must include at least one number! ";
		return "パスワードには、少なくとも数字を1文字混ぜてください。";
		
	}
	
	//if( !preg_match("#[a-z]+#", $pwd) ) {
	//	return "Password must include at least one letter! ";
	//}
	

	if( !preg_match("#[A-Z]+#", $pwd) ) {
		//return "Password must include at least one CAPS! ";
		return "少なくとも英字大文字1文字を混ぜてください";
		
	}
	
	//if( !preg_match("#\W+#", $pwd) ) {
	//	return "Password must include at least one symbol! ";
	//}
	
	return true;
	
	//if(empty($error)){
	//	//echo "Password validation failure(your choise is weak): $error";
	//	return array(true, $error);
	//
	//} else {
	//	//echo "Your password is strong.";
	//	return array(false, $error); 
	//
	//}
}


function is_url($text) {
    if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $text)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
