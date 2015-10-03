<?php
session_start();
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/user.php";
require_once "./config/config.php";
if( $debug === "on" ){var_dump($_SESSION);}


//セッション優先
//GETで飛んできた場合は、そちらを使う
//削除などGETで飛ばす予定
$question=null;
$title= "パスワード確認";

$list_question = array(
				"0" => "母の旧姓は？",
				"1" => "初恋の人は？",
				"2" => "出身小学校は？",
				"3" => "出身中学校は？",
				"4" => "好きなスポーツは？",
				"5" => "好きな俳優は？",
				"6" => "好きな女優は？",
				"7" => "食べれない食べ物は？"
				);
foreach($list_question as $k => $v){
	if((int)$k == (int)$_SESSION['question']){
		$question="<label>" .  h($v) . "</label>";
	}
}


//exit;

				
				
				
				
				
				
//$question="<label>秘密の質問</label>" ;
//$question.="</br>"                    ;
//$question.='<select name="question">' ;
//for( $i=0 ; $i<=7 ; $i++ ){
//	if($i == $_SESSION['question']){
//		$question.='<option value="' . $i . '  selected  ">' ;
//	
//	}else{
//		$question.='<option value="' . $i . '">' ;
//	
//	}
//	$question.=$list_question[$i];
//	$question.='</option>';
//}
//$question.='</select>';
//

if(!isset($_SESSION["error"])){
	$_SESSION["error"]=null;
	
}
if(!isset($_SESSION["msg"])){
	$_SESSION["msg"]=null;
}
if(!isset($_SESSION["mode"])){
	$_SESSION["mode"]=null;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' type='text/css' href='../css/com.css' />  
<style>
.water { color: #ccc; } 
.focus { color: black; } 
</style>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
	google.load("jquery", "1.6.1");
</script>
<script>
/*
$(function () {
	//必須チェック
	$('#login').click(function(){
		var email　=　$('#TextEmail').val();
		if(email==''){
			alert("mail");
			$('#TextEmail').css('background-color', 'Lime');
			return false;
		}else{
		
			$('#TextEmail').css('background-color', 'wite');
		}
		
		var pass= $('#TextPass').val();
		if(pass==''){
			alert("pass");
			$('#TextEmail').css('background-color', 'Lime');
			return false;
		}else{
			$('#TextEmail').css('background-color', 'wite');
		}
	})

	$('#TextEmail').blur(function(){
			$(this).addClass('water');
	})

	$('#TextEmail').focus(function(){
		$(this).removeClass('water');
	})
 
	$('#TextPass').blur(function(){
		$(this).addClass('water');
		
	})
	
	$('#TextPass').focus(function(){
		$(this).removeClass('water');
		
	  })

});
*/
</script>
<title><?php echo $title; ?></title>
</head>
<body>
<div id="wrap">
	<div id="head">
		<h1><?php echo $title; ?></h1>
	</div>
	<div id="content">
		<div>
			<?php// if($_SESSION["error"] == true) :?>
				<ul>
					<?php foreach($_SESSION["msg"] as $msg) :?>
							<li><?php  echo $msg; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php// endif; ?>
		</div>
		<form id="frmInput" name="frmInput" method="post" action="./do_user_pass_question.php">
			<table  style="" >
				<tr>
					<td>
					<label for="TextEmail" >メールアドレス</label>
					</td>
					<td>
						<input id="TextEmail"  class="input" name="email" type="text" id="email" value="<?php echo empty($_SESSION["email"]) ? "" : $_SESSION["email"] ; ?>" readonly />
					</td>
				</tr>

				<tr>           
					<td>
						<?php  echo $question; ?>
					</td>
					<td>
						<input class="input" name="answer" type="text" value=""/>
					</td>
				</tr>
			</table>
			<input id="login"  type="submit" value="確認" />
		</form>

	</div>
</div>
</body>
</html>
