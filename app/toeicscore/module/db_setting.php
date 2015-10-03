<?php 
//-------------------
//MySQL接続文字列
//-------------------
if ($_SERVER['HTTP_HOST'] == "localhost:49200"){
	$dsn      = 'mysql:dbname=toeicengineer_db;host=localhost;charset=utf8;';
	$user     = 'root';
	$password = '';
}elseif($_SERVER['HTTP_HOST'] == "www.toeicengineer.expressweb.jp"){
	$dsn      ='mysql:dbname=toeicengineer_db;host=mysql02.dataweb-ad.jp;charset=utf8';
	$user     ='toeicengineer';
	$password ='Hiro@1128';

}elseif($_SERVER['HTTP_HOST'] == "hiroshi-igarashi.sakura.ne.jp" || $_SERVER['HTTP_HOST'] == "igarashi-jyuku.com"){
	//$dsn      ='mysql:dbname=hiroshi-igarashi_db;host=mysql458.db.sakura.ne.jp;charset=utf8';
	$dsn      ='mysql:dbname=hiroshi-igarashi_toeicers;host=mysql458.db.sakura.ne.jp;charset=utf8';
	$user     ='hiroshi-igarashi';
	$password ='hiro1128';

}

//var_dump($_SERVER['HTTP_HOST']);


//Hiro@1128