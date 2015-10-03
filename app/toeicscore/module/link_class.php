<?php
require_once "./module/utility.php";
/**********
Link　クラス
***********/
class Link{
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
			//var_dump($user);
			//var_dump($password);
			//var_dump($dsn);
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
	

			
			
	public function getTags($email){
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select distinct tag from links where email = :email " ;
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":email",   $email);
			$stmt->execute();
			$rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
			$dbh = null;//コネクションクローズ
			return $rows;//if nothing,return false
	}
	
	public function getlinks($email, $from){
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		$sql = "select * from links where email = :email limit ". $from .", ".$this->perPage;
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(":email",   $email);
		$stmt->execute();
		$rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbh = null;
		return $rows;
		
	}
	public function getlinksByTag($email, $tag , $from){
		$dbh  =  new PDO($this->dsn, $this->user, $this->password);
		$sql  =  "SELECT * FROM links WHERE email = :email AND tag = :tag limit ". $from .", ".$this->perPage;
		$stmt =  $dbh->prepare($sql);
		$stmt->bindParam(":email",   trim($email));
		$stmt->bindParam(":tag",     trim($tag));
		$stmt->execute();
		$rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);
		$dbh  =  null;
		//d($email);d($tag);d($sql);exit;
		
		return $rows;
		
	}


	public function getRowById($id){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from links where id = :id " ;
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id",$id);
			$stmt->execute();
			$row =$stmt->fetch();
			$dbh = null;//コネクションクローズ
			//var_dump($row);

			
			return $row;
	}
	
	public function deleteRowById($id){
		//try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "delete from links where id = :id " ;
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id",$id);
			$stmt->execute();
			$dbh = null;//コネクションクローズ
			return true;
		//}catch(PDOException $e){
		//	$dbh = null;//コネクションクローズ
		//	echo "PDOException occured";
		//	var_dump($e);
		//	exit;
		//}
	}
	
	public function insert($date, $score, $reading_score, $listening_score, $comment, $email){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "INSERT INTO links( "
					." date, "
					." score,"
					." reading_score,"
					." listening_score,"
					." comment, "
					." email "
					." )VALUES( "
					." :date,  "
					." :score, "
					." :reading_score, "
					." :listening_score, "
					." :comment, "
					." :email "
					." )"
					;
			
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":date", $date);
			$stmt->bindParam(":score", $score);
			$stmt->bindParam(":reading_score", $reading_score);
			$stmt->bindParam(":listening_score", $listening_score);
			$stmt->bindParam(":comment", $comment);
			$stmt->bindParam(":email", $email);
			//msg("link_class start");
			//msg("start inserting");
			//
			//d($sql);
			//d($date);
			//d($score);
			//d($reading_score);
			//d($listening_score);
			//d($comment);
			
			$stmt->execute();
			$dbh = null;//コネクションクローズ
			//exit;
			
		}catch(PDOException $e){
			$dbh = null;//コネクションクローズ
			echo "PDOException occured";
			var_dump($e);
			return false;
			//exit;
		}
	}


	public function updateRowById($id, $date, $score, $reading_score, $listening_score, $comment ){
	//try{
			
			d($id);
			d($date);
			d($score);
			d($reading_score);
			d($listening_score);
			d($comment);
			
			//exit;
			
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "update links set " 
					." date   = :date, "
					." score  = :score, "
					." reading_score   = :reading_score,"
					." listening_score = :listening_score,"
					." comment  = :comment, "
					." email  = :email "
					." where id = :id " ;

			$stmt = $dbh->prepare($sql);
			
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":date", $date);
			$stmt->bindParam(":score", $score);
			$stmt->bindParam(":reading_score", $reading_score);
			$stmt->bindParam(":listening_score", $listening_score);
			$stmt->bindParam(":comment", $comment);
			$stmt->bindParam(":email", $email);
			//d($stmt);
			
			//exit;
			
			$stmt->execute();
			d($stmt->execute());
			//exit;
			
			$dbh = null;//コネクションクローズ
			return true;
		//}catch(PDOException $e){
		//	$dbh = null;//コネクションクローズ
		//	echo "PDOException occured";
		//	var_dump($e);
		//	exit;
		//}
	}


	public function getTotalPage(){
		
		//テーブル総数をカウント
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		////var_dump($dbh);
		//$sql="select count(*) from toeicengineer_db.links ";
		//$total= $dbh->query($sql)->fetchColumn();
		
		$sql="select count(*) from links ";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$total= $stmt->fetchColumn();
		
		//コネクションクローズ
		$dbh = null;
		
		$totalPage = (int)ceil($total/$this->perPage);
		////var_dump($totalPage);
		//必要なページ数をリターン
		return $totalPage;
		//return $ceil($total/$this->perPage);
	
	}
	
}
