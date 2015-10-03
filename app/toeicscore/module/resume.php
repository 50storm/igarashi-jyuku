<?php
/**********
TOEIC　クラス
***********/
class Resume{
	private $perPage;
	private $dsn;
	private $user;
	private $password;
	
	
	function __construct($dsn,$user,$password){
		if(isset($dsn)|| isset($user)|| isset($password)){
			$this->dsn=$dsn;
			$this->user=$user;
			$this->password=$password;
			
			
		}else{
			////var_dump($user);
			////var_dump($password);
			////var_dump($dsn);
			throw new Exception("Dsn is invalid");
		
		}
		
	}
	
	public function setPerPage($i){
		if(is_numeric($i)){
			$this->perPage = (int)$i;
		}else{
			throw new Exception("invalid Argument in setPerPage()");
		}
	}
	

	public function setUser($user){
		$this->user=$user;
	}
	
	public function setPassword($password){
		$this->password=$password;
	}
	
	
	public function getRows(){
		
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		//exit;
		//$sql = "select * from toeicengineer_db.resumes order by from_year desc limit ". $from .", ".$this->perPage;
		$sql = "select * from resumes order by from_year desc";
		////var_dump($sql );
		$ret = $dbh->query($sql);
		$rows=array();
		foreach($ret as $row){
			array_push($rows,$row);
		}
		////var_dump($rows);
		
		//コネクションクローズ
		$dbh = null;
		//toeicテーブルの行数分リターン
		////var_dump($rows);
		return $rows;
	}
	
	public function getTotalPage(){
		
		//テーブル総数をカウント
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		
		//$sql="select count(*) from toeicengineer_db.resumes ";
		$total= $dbh->query("select count(*) from resumes ")->fetchColumn();
		//コネクションクローズ
		$dbh = null;
		
		$totalPage = ceil($total/$this->perPage);
		
		//必要なページ数をリターン
		
		return $totalPage;
	
	}
	
	
	public function showTable($date,$from){
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		//exit;
		if ($date==0){
			$sql = "select * from toeicengineer_db.resumes order by date desc limit ". $from .", ".$this->perPage;
			$date=1;
		}
		else
		{
			$sql = "select * from toeicengineer_db.resumes order by date asc limit ". $from .", ".$this->perPage;
			$date=0;
		}
		
		//var_dump($sql );
		$rows=array();
		foreach($dbh->query($sql) as $row){
			array_push($rows,$row);
		}
		//$str ="";
		//連想配列で
		$str =array(
			"date" => "",
			"score" => "",
		
		);
		foreach($rows as $toeic_row){
			//$str  =" <tr class=\"> "         ;
			//$str .=" <td class=\"center\"> " ;
			//$str .=$toeic_row['date']         ;
			//$str .="  </td>"                  ;
			//$str .="</tr>"                    ;
			
			$str["date"] .="<p>"         ;
			$str["date"] .=$toeic_row['date']         ;
			$str["date"] .="  </p>"                  ;
			
			
			$str["score"] .="<p>"         ;
			$str["score"] .=$toeic_row['score']         ;
			$str["score"] .="  </p>"                  ;
			
			////var_dump($str);
		}
		
		
		
		
		//コネクションクローズ
		$dbh = null;
		//toeicテーブルの行数分リターン
		////var_dump($rows);
		
		return $str;
	}
	
	
}
