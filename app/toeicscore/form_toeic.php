<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/toeic_class.php";
require_once "./config/config.php";

//とりあえず日本語のみ対応にしょう
//session expiration check and login-in check
if(!isset($_SESSION['user_id'])){
	$login_url="http://".get_url("login.php");
	header("Location: $login_url");
}

if( $debug === "on" ){var_dump($_SESSION);}
mb_language('ja');
mb_internal_encoding('UTF-8'); //PHP内部の日本語をユニコードでエンコード

define('year',0);
define('month',1);
define('day',2);

$title="TOEIC";
$width_item = "100px";
$error_color ="red";

//使うセッションを定義
if(!isset($_SESSION['form_toeic_error'])){
	$_SESSION['form_toeic_error']=null;
}
if(!isset($_SESSION['form_toeic_error_year'])){
	$_SESSION['form_toeic_error_year']=null;
}
if(!isset($_SESSION['form_toeic_error_month'])){
	$_SESSION['form_toeic_error_month']=null;
}
if(!isset($_SESSION['form_toeic_error_day'])){
	$_SESSION['form_toeic_error_day']=null;
}
if(!isset($_SESSION['form_toeic_error_score'])){
	$_SESSION['form_toeic_error_score']=null;
}
if(!isset($_SESSION['form_toeic_error_reading_score'])){
	$_SESSION['form_toeic_error_reading_score']=null;
}
if(!isset($_SESSION['form_toeic_error_listening_score'])){
	$_SESSION['form_toeic_error_listening_score']=null;
}
if(!isset($_SESSION['form_toeic_msg'])){
	$_SESSION['form_toeic_msg']=null;
}


if(isset($_GET['mode'])){
	switch(trim($_GET['mode'])){
		case "update":
		$_SESSION['form_toeic_mode']="update";
		break;
		
		case "insert":
		$_SESSION['form_toeic_mode']="insert";	
		break;
		
		default:
		$_SESSION['form_toeic_mode']="insert";	
	}
}else{
	$_SESSION['form_toeic_mode']="insert";
}

if(isset($_GET['toeic_id'])){
	$_SESSION["toeic_id"]=$_GET['toeic_id'];
}else{
	$_SESSION["toeic_id"]=null;
}
//var_dump($_SESSION['form_toeic_mode']);
 if($_SESSION['form_toeic_mode']=="update"){
	$TOEIC = new Toeic($dsn,$user,$password);
	$row=$TOEIC->getRowById($_SESSION["toeic_id"]);
	unset($TOEIC);
	//セッションに突っ込む
	//そうすれば、フォームひとつでＯＫではないか？
	if ($row['date'] == ""){
		$date[year]="";
		$date[month]="";
		$date[day]="";
		
	}else{
		$date=explode("-",$row['date']);
	}
	
	$_SESSION["year"]   =  $date[year];
	$_SESSION["month"]  =  $date[month];
	$_SESSION["day"]    =  $date[day];
	$_SESSION["score"]  =  $row["score"];
	$_SESSION["reading_score"]    =  $row["reading_score"];
	$_SESSION["listening_score"]  =  $row["listening_score"];
	$_SESSION["comment"]          =  $row["comment"];
}elseif($_SESSION['form_toeic_mode']=="insert" && $_SESSION['form_toeic_error']==false ){
	$_SESSION["year"]   =  null;
	$_SESSION["month"]  =  null;
	$_SESSION["day"]    =  null;
	$_SESSION["score"]  =  null;
	$_SESSION["reading_score"]    =  null;
	$_SESSION["listening_score"]  =  null;
	$_SESSION["comment"]          =  null;
}
//if( $debug === "on" ){var_dump($_SESSION);}

if($_SESSION['form_toeic_mode'] === "insert"){

	$title= "TOEIC戦歴入力";

	
}elseif($_SESSION['form_toeic_mode'] === "update"){
	$title= "TOEIC戦歴修正";
}

?>
<!DOCTYPE HTML>
<html lang="ja" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/Menu.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/main.css" type="text/css">
<script src="./js/jquery-1.11.2.min.js" type="text/javascript"></script>
<style>
/*必須チェック*/
.blur { color: black; background-color:white; } 
.focus { color: black;  background-color:LightPink; } 
</style>
<script>
$(function () {
	//必須チェック
	$('#btnSubmit').click(function(){
	
		var year = $('#year').val();
		if(year==''){
			$('#year').removeClass('blur');
			$('#year').addClass('focus');
			$('#year').focus();
			return false;

		}else{
			$('#year').removeClass('focus');
			$('#year').addClass('blur');
		}
		
		var month = $('#month').val();
		if(month==''){
			$('#month').removeClass('blur');
			$('#month').addClass('focus');
			$('#month').focus();
			return false;
		
		}else{
			$('#month').removeClass('focus');
			$('#month').addClass('blur');
		}
		
		
		var day = $('#day').val();
		if(day==''){
			$('#day').removeClass('blur');
			$('#day').addClass('focus');
			$('#day').focus();
			return false;
		
		}else{
			$('#day').removeClass('focus');
			$('#day').addClass('blur');	
		}
		
		var score = $('#score').val();
		if(score==''){
			$('#score').removeClass('blur');
			$('#score').addClass('focus');
			$('#score').focus();
			return false;
		
		}else{
			$('#score').removeClass('focus');
			$('#score').addClass('blur');

		}
		
		
		var reading_score = $('#reading_score').val();
		if(reading_score==''){
			$('#reading_score').removeClass('blur');
			$('#reading_score').addClass('focus');
			$('#reading_score').focus();
			return false;
			
		}else{
			$('#reading_score').removeClass('focus');
			$('#reading_score').addClass('blur');

		}
		
		
		var listening_score = $('#listening_score').val();
		if(listening_score==''){
			$('#listening_score').removeClass('blur');
			$('#listening_score').addClass('focus');
			$('#listening_score').focus();
			return false;
		
		}else{
			$('#listening_score').removeClass('focus');
			$('#listening_score').addClass('blur');
		}
		
		
		
	})

	$('#year').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
		
	})
	
	$('#year').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
		
	})

	$('#month').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#month').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#day').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#day').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#score').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#score').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})

	$('#reading_score').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
		//スコア計算
		var r_score = $(this).val();
		//if(!is_score(r_score)){
		//	$(this).focus();
		//	return false;
		//}
		
		var l_score = $('#listening_score').val();
		$('#score').val(cal_total(l_score, r_score));
		
	})
	
	$('#reading_score').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
		
		
	})
	
	$('#listening_score').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
		//スコア計算
		var l_score = $(this).val();
		//if(!is_score(l_score)){
		//	$(this).focus();
		//	return false;
		//}
		var r_score = $('#reading_score').val();
		$('#score').val(cal_total(l_score, r_score));
	})
	
	$('#listening_score').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})
	
	$('#comment').blur(function(){
		$(this).removeClass('focus');
		$(this).addClass('blur');
	})
	
	$('#comment').focus(function(){
		$(this).removeClass('blur');
		$(this).addClass('focus');
	})
	
	
	function cal_total(l_score,  r_score){
		t_score = r_score*1 + l_score*1;
		return t_score;
		
	}
	
	function is_score(score){
		score = score * 1;
		
		if( 5 <= score && score <= 495){
			//OK
		}else{
			return false;
		}
		
		var x = score % 5;
		if(x === 0){
			return true;
		}else{
			return false;
			
		}
	}
	
});

</script>
<title><?php echo $title; ?></title>
</head>
<body>
<div id="wrapper">
	<!--header-->
	<header id="header">
		<h1>TOEICスコア管理サイト</h1>
	</header>
	<!--Menu-->
	<?php // include"toeic_menu.php"; ?>
	<div id="main">
		<?php if($_SESSION['form_toeic_error']==true && $_SESSION['form_toeic_msg'] !==null ):?>
				<p>*入力エラーがあります</p>
				<ul>
					<?php foreach($_SESSION['form_toeic_msg'] as $message): ?>
					<li><?php echo  h("$message"); ?></li>
					<?php endforeach; ?>
				</ul>
		<?php endif ;?>
		<form id="frmInput" name="frmInput" action="./validate_toeic.php" method="post" >
			<table>
			<caption><?php echo $title; ?></caption>
					<tr>
						<th>
						</th>
						<th>
						</th>
						<th>
						</th>
					</tr>
					<tr>
						<td>
							<label for="year" class="input" >年</label>
						</td>
						<td >
							<input name="year" type="text" id="year"  size="4" value="<?php echo empty($_SESSION['year']) ? date('o') : $_SESSION['year'] ; ?>"  style="width:<?php echo "$width_item"; ?>" />
						</td>
						<td>
							<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_toeic_error_year']==false) ? "" : "*" ; ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<label for="month" class="input" >月</label>
						</td>
						<td>
							<input name="month" type="text" id="month"  size="2" value="<?php echo empty($_SESSION["month"]) ? date ('n') : $_SESSION["month"] ; ?>" style="width:<?php echo "$width_item"; ?>" />
						</td>
						<td>
							<span style="color:<?php echo $error_color;?>;"><?php echo ($_SESSION['form_toeic_error_month']==false) ? "" : "*" ; ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<label for="day" class="input" >日</label>
						</td>
						<td>
							<input name="day" type="text" id="day"  size="2" value="<?php echo empty($_SESSION["day"]) ? date ('j') : $_SESSION["day"] ; ?> " style="width:<?php echo "$width_item"; ?>" />
						</td>
						<td>
							<span style="color:<?php echo $error_color;?>;"><?php  echo ($_SESSION['form_toeic_error_day']==false) ? "" : "*" ;  ?></span>
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="listening_score" class="input" >リスニング スコア</label>
						</td>
						<td>
							<input name="listening_score" type="text" id="listening_score" size="3" value="<?php echo empty($_SESSION["listening_score"]) ? "" : $_SESSION["listening_score"] ; ?>"  style="width:<?php echo "$width_item"; ?>" />
						</td>
						<td>
							<span style="color:<?php echo $error_color;?>;"><?php echo $_SESSION['form_toeic_error_listening_score']==false ? "" : "*" ; ?></span>
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="reading_score" class="input" >リーディング スコア</label>
						</td>
						<td>
							<input name="reading_score" type="text" id="reading_score" size="3" value="<?php echo empty($_SESSION["reading_score"]) ? "" : $_SESSION["reading_score"] ; ?>"  style="width:<?php echo "$width_item"; ?>"/>
						</td>
						<td>
							<span style="color:<?php echo $error_color;?>;"><?php echo $_SESSION['form_toeic_error_reading_score']==false ? "" : "*" ; ?></span>
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="score" class="input" >スコア</label>
						</td>
						<td>
							<input name="score" type="text" id="score" size="3" value="<?php echo empty($_SESSION["score"]) ? "" : $_SESSION["score"] ; ?>" style="width:<?php echo "$width_item"; ?>" />
						</td>
						<td>
							<span style="color:<?php echo $error_color;?>;"><?php  echo ($_SESSION['form_toeic_error_score']==false) ? "" : "*" ;  ?></span>
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="comment" class="input" >一言</label>
						</td>
						<td>
							<input name="comment" type="text" id="comment" size="" value="<?php echo empty($_SESSION["comment"]) ? "" : $_SESSION["comment"] ; ?>"  style="width:<?php echo "$width_item"; ?>"/>
							
						</td>
						<td>
							<span></span>
						</td>
					</tr>
				</table>
				<input id="btnSubmit" type="submit" value="送信確認画面へ" />
		</form>
		</div>
		<footer id="footer" style="clear:left;">
		<?php include"footer.html"; ?>
		</footer>

</div>
</body>
</html>
