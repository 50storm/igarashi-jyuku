<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/toeic_class.php";
require_once "./config/config.php";

mb_language('ja');
mb_internal_encoding('UTF-8'); //PHP内部の日本語をユニコードでエンコード

//session expiration check and login-in check
//if( $debug === "on" ){var_dump($_SESSION);}

if(!isset($_SESSION['user_id'])){
	$login_url="http://".get_url("login.php");
	header("Location: $login_url");
}


define('year',0);
define('month',1);
define('day',2);


//define('INSERT',0);
//define('UPDATE',1);
//define('DELETE',2);


$title="TOEIC";
$width_item = "100px";
$error_color ="red";


//モード設定
if(isset($_GET['mode'])){
	$_SESSION['form_toeic_mode']=$_GET['mode'];
}

//d($_SESSION['mode']);

//When deleting, needs to access to the dababase.
if($_SESSION['form_toeic_mode']==="delete"){
		$_SESSION["toeic_id"]=trim($_GET['toeic_id']);//
		try{
			//get 1 record
			$toeicer = new Toeic($dsn,$user,$password);
			$row=$toeicer->getRowById($_SESSION["toeic_id"]);
			unset($toeicer);
			
			//var_dump($row);
			if ($row['date'] == ""){
				$date[year]="";
				$date[month]="";
				$date[day]="";
			}else{
				$date=explode("-",$row['date']);
			}
			//set values in SESSION to simplfy displaying data
			$_SESSION["year"]  = $date[year];
			$_SESSION["month"] = $date[month];
			$_SESSION["day"]   = $date[day];
			$_SESSION["score"]           = h($row["score"]);
			$_SESSION["reading_score"]   = h($row["reading_score"]);
			$_SESSION["listening_score"] = h($row["listening_score"]);
			$_SESSION["comment"]         = h($row["comment"]);
			
		}catch(PDOException $e){
			echo "PDOException occured";
			var_dump($e);
			exit;
		}
}

if($_SESSION['form_toeic_mode'] === "insert"){
	$title= "TOEIC戦歴入力";
	$submit = '<input type="submit" value="送信する" />';
	$submit.= '<a href="./form_toeic.php">やり直す</a>';
	

}elseif($_SESSION['form_toeic_mode'] === "update"){
	$title= "TOEIC戦歴修正";
	$submit= '<input type="submit" value="送信する" />';
	$submit.= '<a href="./mypage.php">やり直す</a>';
}elseif($_SESSION['form_toeic_mode'] === "delete"){
	$title= "TOEIC戦歴削除";
	$submit= '<input type="submit" value="送信する" onclick=\'return confirm("Are you sure？");\' />';
	$submit.= '<a href="./mypage.php">やり直す</a>';
}
if( $debug === "on" ){var_dump($_SESSION);}

?>
<!DOCTYPE HTML>
<html lang="ja" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/Menu.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/main.css" type="text/css">
<title><?php echo $title; ?></title>
</head>
<body>
<div id="wrapper">
	<!--header-->
	<header id="header">
		<h1>We are TOEICers</h1>
	</header>
	
	<?php // include"toeic_menu.php"; ?>
	
	<div id="main">
		<h1  style="font-size: medium;background-color:#FFB6C1;width:300px;" >TOEICデータ送信画面</h1>
		<form id="frmInput" name="frmInput" method="post" action="./do_toeic.php">
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
						<input name="year" type="text" id="year" value="<?php echo $_SESSION["year"] ; ?>"  style="width:<?php echo "$width_item"; ?>"   readonly  />
					</td>
					<td>
						<span></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="month" class="input" >月</label>
					</td>
					<td>
						<input name="month" type="text" id="month" value="<?php echo $_SESSION["month"] ; ?>" style="width:<?php echo "$width_item"; ?>"   readonly  />
					</td>
					<td>
						<span></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="day" class="input" >日</label>
					</td>
					<td>
						<input name="day" type="text" id="day" value="<?php echo $_SESSION["day"] ; ?> " style="width:<?php echo "$width_item"; ?>"   readonly />
					</td>
					<td>
						<span></span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="listening_score" class="input" >リスニング スコア</label
					</td>
					<td>
						<input name="listening_score" type="text" id="listening_score" size="3" value="<?php echo $_SESSION["listening_score"] ; ?>"  style="width:<?php echo "$width_item"; ?>"  readonly />
					</td>
					<td>
						<span></span>
					</td>
				</tr>
				<tr>
					<td>
							<label for="reading_score" class="input" >リーディング スコア</label>
					</td>
					<td>
						<input name="reading_score" type="text" id="reading_score" size="3" value="<?php echo $_SESSION["reading_score"] ; ?>"  style="width:<?php echo "$width_item"; ?>"  readonly />
					</td>
					<td>
						<span></span>
					</td>
				</tr>
				

				<tr>
					<td>
						<label for="score" class="input" >スコア</label>
					</td>
					<td>
						<input name="score" type="text" id="score" size="3" value="<?php echo $_SESSION["score"] ; ?>" style="width:<?php echo "$width_item"; ?>"  readonly  />
					</td>
					<td>
						<span></span>
					</td>
				</tr>

				<tr>
					<td>
							<label for="comment" class="input" >一言</label>
					</td>
					<td>
						<input name="comment" type="text" id="comment" size="" value="<?php echo  $_SESSION["comment"] ; ?>"  style="width:<?php echo "$width_item"; ?>"  readonly />
					</td>
					<td>
						<span></span>
					</td>
				</tr>
			</table>
			
			<?php echo $submit; ?>
			
		</form>
	</div>
</div>
</body>
</html>
