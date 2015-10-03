<?php
//require_once "table.php";
require_once "db_interface.php";


/**********
Resume　クラス
***********/
class Resume implements DataBase {
	public function getRows($date,$from){
		//$dbh = new PDO($this->dsn, $this->user, $this->password);
		//$sql = "select * from toeicengineer_db.resumes order by from_year desc";
		//$rows=array();
		//foreach($dbh->query($sql) as $row){
		//	array_push($rows,$row);
		//}
		////コネクションクローズ
		//$dbh = null;
		////toeicテーブルの行数分リターン
		//return $rows;
	}
	
	public function setPerPage(){
	
	}
	
	public function getTotalPage(){
	
	}
	
	
}

//class Resume extends Table {
//
//	public function getRows($date,$from){
//		$dbh = new PDO($this->dsn, $this->user, $this->password);
//		$sql = "select * from toeicengineer_db.resumes order by from_year desc";
//		$rows=array();
//		foreach($dbh->query($sql) as $row){
//			array_push($rows,$row);
//		}
//		//コネクションクローズ
//		$dbh = null;
//		//toeicテーブルの行数分リターン
//		return $rows;
//	}
//	
//	//テーブルの総数から
//	//必要なﾍﾟｰｼﾞ数を計算してリターンする
//	public function getTotalPage(){
//		
//		//テーブル総数をカウント
//		$dbh = new PDO($this->dsn, $this->user, $this->password);
//		$total= $dbh->query("select count(*) from toeicengineer_db.resumes ")->fetchColumn();
//		//コネクションクローズ
//		$dbh = null;
//		//必要なページ数を計算
//		$totalPage = ceil($total/$this->perPage);
//		//必要なページ数をリターン
//		return $totalPage;
//	}
//
//}
//