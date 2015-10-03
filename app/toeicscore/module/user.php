<?php
/**********
User　クラス
***********/
class User{
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
	
	
	//TODO:User一覧
	public function getToeicers(){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			//$sql = "SELECT * FROM　users ";
			//$sql .= " INNER JOIN  toeic_scores　ON toeic_scores.user_id = users.id "; 
			
			//$sql .= " WHERE date = :date " ;
			//$sql .= " ORDER BY users.id ";
			//$sql = " SELECT * from users  left outer join toeic_scores  on users.id = toeic_scores.user_id ORDER BY users.id " ;
			$sql = " SELECT users.id, users.user_name from users, toeic_scores.score  left outer join toeic_scores  on users.id = toeic_scores.user_id ORDER BY users.id " ;
		
			//var_dump($sql);
			//$users=array()
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$stmt = $dbh->query($sql);
			
			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo '<p>' . $data['users.id'] . ':' . $data['users.user_name'] . "</p>\n";
					//echo '<p>' . $data['id'] . ':' . $data['user_name'] .  ':' . $data['score'] ."</p>\n";

					}
			
			//$pdo = null;

			
			//$rows =$stmt->fetch(PDO::FETCH_ASSOC);
			unset($dbh);
			//return $users;
			return $stmt;
			
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		} 

	}



	public function getRowByEmailAndPassword($email, $password){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from users where email = :email and password = :password" ;
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":email",$email);
			$stmt->bindParam(":password",$password);
			
			$stmt->execute();
			$row =$stmt->fetch();
			$dbh = null;//コネクションクローズ
			if($row == null || empty($row)){
				return false;
			}else{
				return $row;
			}
			
	}

	/*
	*秘密の質問を取得
	*/
	public function getQuestion($email){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from users where email = :email ";
			
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":email",    $email);
			
			$stmt->execute();
			$row =$stmt->fetch();
			$dbh = null;//コネクションクローズ
			return $row ;
	}


	
	/*
	*秘密の答えがあってるか確認
	*/
	public function confirmUserAnswer($email, $question , $answer ){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from users where email = :email ";
			$sql .= " and question = :question " ;
			$sql .= " and answer   = :answer " ;
			
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":email",    $email);
			$stmt->bindParam(":question", $question);
			$stmt->bindParam(":answer",   $answer);
			
			$stmt->execute();
			$row =$stmt->fetch();
			$dbh = null;//コネクションクローズ
			return $row ;
	}


	public function getRowById($id){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from users where id = :id" ;
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id",$id);
			$stmt->execute();
			$row =$stmt->fetch();//When pdo coldn't fetch date, return false.
			$dbh = null;//コネクションクローズ
			return $row;
			
	}
	
	public function getRowByEmail($email){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from users where email = :email" ;
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			$row =$stmt->fetch();//When pdo coldn't fetch date, return false.
			$dbh = null;//コネクションクローズ
			return $row;
			
	}

	public function deleteRowById($id){
		//try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "delete from users where id = :id " ;
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
	
	public function insert($email, $password, $user_name, $last_name, $first_name,  $blog_url,  $question,  $answer){
		//try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "INSERT INTO users(
						email,
						password,
						user_name,
						last_name,
						first_name,
						blog_url,
						question,
						answer
					)VALUES(
						:email,
						:password,
						:user_name,
						:last_name,
						:first_name,
						:blog_url,
						:question,
						:answer
						
					)";

			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":email",$email);
			$stmt->bindParam(":password",$password);
			$stmt->bindParam(":user_name",$user_name);
			$stmt->bindParam(":last_name",$last_name);
			$stmt->bindParam(":first_name",$first_name);
			$stmt->bindParam(":blog_url",$blog_url);
			$stmt->bindParam(":question",$question);
			$stmt->bindParam(":answer",$answer);

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


	public function updateRowById($id, $email, $user_name, $last_name, $first_name){
	//try{
			
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "update users set " 
					." email   = :email, "
					." user_name  = :user_name, "
					." last_name  = :last_name, "
					." first_name = :first_name "
					." where id = :id " ;
			//var_dump($sql);
			
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":user_name", $user_name);
			$stmt->bindParam(":last_name", $last_name);
			$stmt->bindParam(":first_name", $first_name);
			
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
	
	public function updatePasswordById($id, $password){
	//try{
			
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "update users set " 
					." password = :password "
					." where id = :id " ;
			var_dump($sql);
			
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":password", $password);
			
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


	public function getTotalPage(){
		
		//テーブル総数をカウント
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		////var_dump($dbh);
		//$sql="select count(*) from toeicengineer_db.users ";
		//$total= $dbh->query($sql)->fetchColumn();
		$sql="select count(*) from users ";
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
	/*
	public function showTable($date,$from){
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		//exit;
		if ($date==0){
			$sql = "select * from toeicengineer_db.users order by date desc limit ". $from .", ".$this->perPage;
			$date=1;
		}
		else
		{
			$sql = "select * from toeicengineer_db.users order by date asc limit ". $from .", ".$this->perPage;
			$date=0;
		}
		
		//var_dump($sql );
		$toeic_rows=array();
		foreach($dbh->query($sql) as $row){
			array_push($toeic_rows,$row);
		}
		//$str ="";
		//連想配列で
		$str =array(
			"date" => "",
			"score" => "",
		
		);
		foreach($toeic_rows as $toeic_row){
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
		////var_dump($toeic_rows);
		
		return $str;
	}
	*/
	
}
