<?php
session_start();
//mb_language("Japanese");
//mb_internal_encoding("UTF-8");
//require_once('../Class/Utility.php');
//チェック
$flgErr=false;
$errMsg="";
if (empty($_POST['url'])) {
	$flgErr=true;
	$errMsg='URLが入力されていません。';
}

if (empty($_POST['name'])) {
	$flgErr=true;
	$errMsg='表示名が入力されていません。';
}

//エラーがあればView画面に戻す
if ($flgErr==true){
	$_SESSION['msg']=$errMsg;
	//$Uri=Utility::makeUrlController('view_controller.php?page=insertUrl');
	//header("Location: $Uri");
	header("Location: ./insertUrl.php");
	
	exit;
}else{
	$_SESSION['msg']="";
}


if ($_SERVER['HTTP_HOST'] == 'localhost'){
	$dsn      = 'mysql:dbname=toeicengineer_db;host=localhost';
	$user     = 'root';
	$password = '';
}else{
	$dsn      ='mysql:dbname=toeicengineer_db;host=mysql464.db.sakura.ne.jp';
	$user     ='toeicengineer';
	$password ='hiro1128';
}



try{
	$pdo = new PDO($dsn, $user, $password);
	//Step1
	//日本語文字化け対策
	//$stmt = $pdo->query("SET NAMES utf8;"); 
	//echo "属性を変更しますよ</br>";
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // 属性設定
	$stmt = $pdo->prepare(
			"INSERT INTO Link(email, url, name, tag) VALUES(:email, :url, :name, :tag)"
	);
	
	$SqlParam = array('url' => '','name' => '', 'tag' =>'');
	$SqlParam["url"]   = $_POST['url'];
	$SqlParam["name"]  = $_POST['name'];
	//タグがなければタグなしをセット
	if (empty($_POST['tag'])) {
		$SqlParam["tag"]   = "タグなし";
	}else{
		$SqlParam["tag"]   = $_POST['tag'];
	}

	
	
	//var_dump($SqlParam);
	//var_dump($email);
	$stmt->bindParam(":email" , $email);
	$stmt->bindParam(":url"   , $url);
	$stmt->bindParam(":name"  , $name);
	$stmt->bindParam(":tag"   , $tag);
	
	
	$email  =  $_SESSION['email'];
	$url    =  $SqlParam["url"];
	$name   =  $SqlParam["name"];
	$tag    =  $SqlParam["tag"];
	
	echo $email ;
	echo $url ;
	echo $name ;
	echo $tag ;
	
	
	echo "登録しますよ</br>";
	$stmt->execute();
	echo "登録しました</br>";
	
	
	$count=$stmt->rowCount();
	echo "$count</br>";
	echo $pdo->lastInsertId();
	
	
	
	//var_dump($stmt);
	//header("Location: ./menu.php");
	echo "<a href=" .  "./insertUrl.php". ">追加とうろく</a>";
	exit;
}catch(PDOException $e){
	echo $e->getMessage();
	exit;

}
//$Uri=Utility::makeUrlController('view_controller.php?page=link');
//var_dump($Uri);
//header("Location: $Uri");
exit;