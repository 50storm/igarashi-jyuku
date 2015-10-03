<?php
session_start();
session_regenerate_id(true);//セッション作り直す
//session_regenerate_id();//セッション作り直す
//mb_language('ja');
//mb_internal_encoding('UTF-8'); //PHP内部の日本語をユニコードでエンコード
require_once "./module/utility.php";
require_once "./module/db_setting.php";
require_once "./module/toeic_class.php";
require_once "./module/user.php";
require_once "./config/config.php";

//いらないセッションを破棄する

if( $debug === "on" ){var_dump($_SESSION);}



//if(!isset($_SESSION['user_id'])){
	//$login_url="http://".get_url("login.php");
	//header("Location: $login_url");
	//header("Location: " . $_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/login.php" );
	
//}

try{
	//define('PER_PAGE', 10);
	//toeic_scoresテーブルから持ってくる
	$TOEIC = new Toeic($dsn,$user,$password);
	//$TOEIC->getScoreDesc();
	
	$USER = new User($dsn,$user,$password);
	$users = $USER->getToeicers();
	var_dump($users);
}catch(PDOException $e){
		echo "PDOException occured";
		var_dump($e);
		exit;
}


?>
<!DOCTYPE HTML>
<html lang="ja" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="./Css/com/Wrapper.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/Menu.css" type="text/css">
<link rel="stylesheet" href="./Css/mypage/main.css" type="text/css">

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
  
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>



<script>
try{
	$(document).ready(function() 
		{  
			$("#toeic_table").DataTable();
		} 
	); 
}catch(e) {
//document.write(e);

}
   
</script>

<title>マイページ</title>
</head>
<body>
<div id="wrapper">

	<header id="header">
		<div style="">
			<h1>We are TOEICers</h1>
		</div>
	</header>
	
	<!---TODO:途中---->
	<!--
	<table>
	<caption>客観的な視点で分析！(努力は裏切らない！Keep it up!)</caption>
	<tr>
	<th>初受験</th><th>ラスト受験日</th><th>受験回数</th><th>最高点</br>(Total)</th><th>最高点</br>(Listeing)</th><th>最高点</br>(Reading)</th><th>平均点</br>(Total)</th><th>平均点</br>(Listeing)</th><th>平均点</br>(Reading)</th><th>伸び率(対初回)</br>(Total)</th><th>伸び率(対初回)</br>(Listeing)</th><th>伸び率(対初回)</br>(Reading)</th>
	</tr>
	<tr>
	<td><?php echo $first_date['first_date']; ?></td>
	<td><?php echo $last_date['last_date'];   ?></td>
	<td><?php echo $times['times'];   ?></td>
	
	<td><?php echo $MaxScores["max_score"] ;   ?></td>
	<td><?php echo $MaxScores["max_score_L"]; ?></td>	
	<td><?php echo $MaxScores["max_score_R"]; ?></td>
	
	<td><?php echo $AvgScores["avg_score"] ;   ?></td>
	<td><?php echo $AvgScores["avg_score_L"]; ?></td>	
	<td><?php echo $AvgScores["avg_score_R"]; ?></td>
	
	<td><?php echo $rate["rate_score"] ;   ?></td>
	<td><?php echo $rate["rate_score_L"]; ?></td>	
	<td><?php echo $rate["rate_score_R"]; ?></td>
	
	</tr>
	</table>
	-->

	<?php // include"toeic_menu.php"; ?>
	<?php if(empty($_SESSION['email'])): //SESSIONにemailがなければログインしてないとする ?>
				<p><a href="./login.php"  target=""  >ログインしてください</a></p>
				<p><a href="./form_user.php"  target=""  >新規登録はこちら</a></p>
				<div class="ad"  style="width:400px;height:400px; border: 1px solid #FF0000;">
					<p>広告募集</p>
				</div>
		
	<?php else: ?>
			<div id="menu" >
				<div id="profile" >
		
					<?php echo "TOEICer No.".$_SESSION["user_id"]."</br>" .$_SESSION["user_name"]; ?>
					<!--
					<div><?php echo  $first_date['first_date'] . "からTOEICer!"; ?> </div>
					<div><?php echo  $last_date['last_date'] . "が最後のTOEIC戦"; ?> </div>
					-->
					<!--
					<table>
					<tr>
					<td>TOEICer になった日:</td><td><?php echo $first_date['first_date']; ?></td>
					</tr>
					</table>
					-->
				</div>
				<div id="">
					<nav>
						<ul id="dropMenu" class="dropMenu" style="list-style:none;">
							<!--<li><a href="index.html">Home</a></li>-->
							<li><a href="./mypage.php"  target=""  >マイページ</a></li>
							<?php if( !empty($_SESSION['blog_url']) ) : ?>
							<li><a href="<?php echo $_SESSION['blog_url'] ;?>"  target="_blank"  >TOEICerブログ</a></li>
							<?php endif ; ?>
							<li><a href="./form_toeic.php" target="" >TOEIC戦歴入力</a></li>
							<!--<li><a href="./link.php"  target=""  >ブックマーク一覧</a></li>-->
							<li><a href="./form_user.php?mode=<?php echo h(urlencode("update")); ?>"  target="">ユーザ情報変更</a></li>
							<li><a href="./form_user_pass.php"  target="">パスワード変更</a></li>
							
						</ul>
					</nav>
				</div>
				
			
			</div>
			
			
			<div  id="main">
				<article>
				<section>
					<?php echo $html_analysis_table; ?>
				</section>
				<section>
					<?php echo $html_toeic; ?>
				</section>
				</article>
			</div>
	<?php endif; ?>
	<footer id="footer" style="clear:left;">
	<?php include"footer.html"; ?>
	</footer>
</div>
</body>
</html>
