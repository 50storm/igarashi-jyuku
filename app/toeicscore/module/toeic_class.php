<?php
require_once "./module/utility.php";
/**********
TOEIC　クラス
***********/
class Toeic{
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
	
	
	//TODO:AVG実装
	/*
	*平均点
	*/
	public function getAvgScores($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "SELECT FORMAT(AVG(score),0) as avg_score , FORMAT(AVG(listening_score),0) as avg_score_L , FORMAT(AVG(reading_score),0) as avg_score_R";
			$sql .= " FROM toeic_scores " ;
			$sql .= " WHERE user_id = :user_id" ;
			//d($sql);
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$row =$stmt->fetch(PDO::FETCH_ASSOC);
			
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $row;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		} 

	}

	/*
	*最高点
	*/
	public function getMaxScores($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "SELECT MAX(score) as max_score , MAX(listening_score) as max_score_L , MAX(reading_score) as max_score_R";
			$sql .= " FROM toeic_scores " ;
			$sql .= " WHERE user_id = :user_id" ;
			//d($sql);
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$row =$stmt->fetch(PDO::FETCH_ASSOC);
			
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $row;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		}
	}

	/*
	*受験回数
	*/
	public function getTimes($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "SELECT COUNT(id) as times";
			$sql .= " FROM toeic_scores " ;
			$sql .= " WHERE user_id = :user_id" ;
			//d($sql);
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$row =$stmt->fetch(PDO::FETCH_ASSOC);
			
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $row;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		} 
	}
	
	/*
	*初めての受験日
	*
	*/
	public function getFristDate($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "SELECT MIN(date) as first_date ";
			$sql .= " FROM toeic_scores " ;
			$sql .= " WHERE user_id = :user_id" ;
			//d($sql);
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$row =$stmt->fetch(PDO::FETCH_ASSOC);
			
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $row;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		} 
	}
	/*
	*最新の受験日
	*
	*/
	public function getLastDate($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "SELECT MAX(date) as last_date ";
			$sql .= " FROM toeic_scores " ;
			$sql .= " WHERE user_id = :user_id" ;
			//d($sql);
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$row =$stmt->fetch(PDO::FETCH_ASSOC);
			
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $row;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		} 
	}

	/*
	*伸び率
	*
	*/
	public function getRate($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "SELECT MAX(score) - MIN(score) as rate_score ,MAX(listening_score) - MIN(listening_score) as rate_score_L,MAX(Reading_score) - MIN(Reading_score) as rate_score_R ";
			$sql .= " FROM toeic_scores " ;
			$sql .= " WHERE user_id = :user_id" ;
			//d($sql);
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$row =$stmt->fetch(PDO::FETCH_ASSOC);
			
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $row;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		}
	}

	
	
	
	
	
	public function getRows($user_id){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from toeic_scores where user_id = :user_id order by date desc ";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->execute();
			$rows =$stmt->fetchAll();
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $rows;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		}
	}

	//旧getRows jQueryのDataTablesでソートする事にしたから
	public function getRowsFromTo($user_id, $from, $per_page){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			//$sql = "select * from toeic_scores where user_id = :user_id order by date desc limit ". $from .", " . $per_page;
			$sql = "select * from toeic_scores where user_id = :user_id order by date desc limit :from , :per_page";

			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":user_id"      , $user_id      , PDO::PARAM_INT);
			$stmt->bindParam(":from"    , $from    , PDO::PARAM_INT);
			$stmt->bindParam(":per_page", $per_page, PDO::PARAM_INT);
			$stmt->execute();
			$rows =$stmt->fetchAll();
			unset($dbh);
			//msg("getRows");
			//var_dump($sql);
			//var_dump($from);
			//var_dump($per_page);
			//var_dump($rows);
			return $rows;
		}catch(PDOException $e){
			unset($dbh);
			echo "------getRows---------\n";
			echo $e->getMessage();
			echo "------getRows---------\n";
			//exit;
		}

	}
	
	public function getRowById($id){

			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "select * from toeic_scores where id = :id " ;
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
			$sql = "delete from toeic_scores where id = :id " ;
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
	
	//TODO: user_id
	/*
	*	INSERT
	*
	*/
	public function insert($date, $score, $reading_score, $listening_score, $comment, $user_id ){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "INSERT INTO toeic_scores( "
					." date, "
					." score,"
					." reading_score,"
					." listening_score,"
					." comment, "
					." user_id "
					." )VALUES( "
					." :date,  "
					." :score, "
					." :reading_score, "
					." :listening_score, "
					." :comment, "
					." :user_id"
					." )"
					;
			
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":date", $date);
			$stmt->bindParam(":score", $score);
			$stmt->bindParam(":reading_score", $reading_score);
			$stmt->bindParam(":listening_score", $listening_score);
			$stmt->bindParam(":comment", $comment);
			$stmt->bindParam(":user_id", $user_id);
			
			//msg("toeic_class start");
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

	/*
	* TOEIC戦歴の1行分をUPDATEする
	*/
	public function updateRowById($id, $date, $score, $reading_score, $listening_score, $comment ){
		try{
			$dbh = new PDO($this->dsn, $this->user, $this->password);
			$sql = "update toeic_scores set " 
					." date   = :date, "
					." score  = :score, "
					." reading_score   = :reading_score,"
					." listening_score = :listening_score,"
					." comment  = :comment "
					." where id = :id " ;

			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":date", $date);
			$stmt->bindParam(":score", $score);
			$stmt->bindParam(":reading_score", $reading_score);
			$stmt->bindParam(":listening_score", $listening_score);
			$stmt->bindParam(":comment", $comment);
			$stmt->execute();
			unset($dbh);
			return true;
		}catch(PDOException $e){
			unset($dbh);
			echo "PDOException occured";
			var_dump($e);
			exit;
		}
	}

	/*
	* usersテーブルでemail変更したときに、toeic_scoresのemailも変更する。
	*正規化の面では、不要だが、デバックで楽なので残す？
	*/
	//public function updateRowByEmail( $email , $new_email ){
	//	try{
	//		$dbh = new PDO($this->dsn, $this->user, $this->password);
	//		$sql = "update toeic_scores set " 
	//				." email  = :new_email "
	//				." where email = :email " ;
    //
	//		$stmt = $dbh->prepare($sql);
	//		$stmt->bindParam(":email", $email);
	//		$stmt->bindParam(":new_email", $new_email);
    //
	//		$stmt->execute();
	//		unset($dbh);
	//		return true;
	//	}catch(PDOException $e){
	//		unset($dbh);
	//		echo "PDOException occured";
	//		var_dump($e);
	//		exit;
	//	}
	//}
	
	public function getTotalPage($per_page){
		//全レコード数と一ページ当たりの表示数から、必要な総ページ数を計算する
		//テーブル総数をカウント
		$dbh = new PDO($this->dsn, $this->user, $this->password);
		$sql="select count(*) from toeic_scores ";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$total= $stmt->fetchColumn();
		
		
		//コネクションクローズ
		$dbh = null;
		$totalPage = (int)ceil($total/$per_page);
		////var_dump($totalPage);
		//必要なページ数をリターン
		return $totalPage;
		//return $ceil($total/$this->perPage);
	
	}

	//TOEICの表を作る
	//public function showTable($toeic_rows, $toeic_total_page, $page ){
	public function showTable($toeic_rows){
			//$html_toeic  = '<div><h1>TOEIC受験履歴</h1></div>'."\n";
			//$html_toeic .= '<div><p><a href="./form_toeic.php" >TOEIC結果入力</a></p></div>'."\n";
			//$html_toeic .= '<div>'."\n";
			$html_toeic = '<table id="toeic_table">'."\n";
			$html_toeic .= '<caption>TOEIC戦歴</caption>'         ."\n";
			//$html_toeic .= '<col width="160px" align="center" >          '."\n";
			//$html_toeic .= '<col width="150px" align="center" span="3" > '."\n";
			//$html_toeic .= '<col width="110px" align="center" >          '."\n";
			//$html_toeic .= '<col width="90px" align="center" >           '."\n";
			//$html_toeic .= '<col width="90px" align="center" >           '."\n";
			$html_toeic .= '<thead>'                                 ."\n";
			$html_toeic .= '	<tr > '                              ."\n";
			$html_toeic .= '		<th>受験日</th>   '."\n";
			$html_toeic .= '		<th>Total</th>     '."\n";
			$html_toeic .= '		<th>Listeing</th>  '."\n";
			$html_toeic .= '		<th>Reading</th> '."\n";
			$html_toeic .= '		<th>一言</th>     '."\n";
			$html_toeic .= '		<th>&nbsp</th>         '."\n";
			$html_toeic .= '		<th>&nbsp</th>         '."\n";
			$html_toeic .= '	</tr>                 '."\n";
			$html_toeic .= '</thead>                  '."\n";
			$html_toeic .= '<tbody>                   '."\n";
		if ( count($toeic_rows)==0 ){
			$html_toeic .= '	<tr>                  '."\n";
			//$html_toeic .= '		<td colspan="7"><a href="http://localhost:49200/toeicengineer/form_toeic.php" >TOEIC戦歴入力</a></td>'."\n";
			//さくらサーバーとローカル開発環境で挙動がことなる　（泣
			//$html_toeic .= '		<td><a href="./form_toeic.php" >TOEIC戦歴入力</a></td>'."\n"; //../form_toeic.phpだとさくらサーバー上でうまくいかん。なぞ。
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '		<td>&nbsp</td>'."\n";
			$html_toeic .= '	</tr>                  '."\n";
			
		}else{
			foreach ($toeic_rows as $toeic_row){
			$html_toeic .= '	<tr>  '."\n";
			$html_toeic .= '		<td>' . h($toeic_row['date']) . '</td>'."\n";
			$html_toeic .= '		<td>' . h($toeic_row['score'])           . '</td>'."\n";
			$html_toeic .= '		<td>' . h($toeic_row['listening_score']) . '</td>'."\n";
			$html_toeic .= '		<td>' . h($toeic_row['reading_score'])   . '</td>'."\n";
			
			$comment=h($toeic_row['comment']);//http://pk-brothers.com/839/
			if(empty($comment)){
				$html_toeic .= '		<td>&nbsp</td>'."\n";
			
			}else{
				$html_toeic .= '		<td><span style="font-size:10px;">' . h($toeic_row['comment'])         . '</span></td>'."\n";
			}
			$html_toeic .= '		<td><a href="./form_toeic.php?mode=update&toeic_id='    . h($toeic_row['id'])  . '">編集</a></td> '."\n";
			$html_toeic .= '		<td><a id="btn_del" href="./confirm_toeic.php?mode=delete&toeic_id=' . h($toeic_row['id'])  . '">削除</a></td> '."\n";
			$html_toeic .= '	</tr> '."\n";
			}
		}
			$html_toeic .= '</tbody> '."\n";
			// $html_toeic .= '<tfoot>                  '."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '		<td></td>'."\n";
			// $html_toeic .= '</tfoot>                  '."\n";
			 $html_toeic .= '</table> '."\n";
			//$html_toeic .= '</div>'."\n";
			
//		$html_toeic_footer=null;
//		if ( count($toeic_rows)==0 ){
//			$html_toeic_footer="";
//		}else{
//			if ($page > 1){
//				$pre = $page-1;
//				$html_toeic_footer .= '<a href=?page=' . (int)$pre . '>前</a>'."\n";
//				
//			}                                                 
//			for ($i=1; $i <= $toeic_total_page ; $i++){       
//				$html_toeic_footer .= '<a href="?page=' .$i . '">' . $i .'</a>'."\n";
//				
//			}
//			
//			if ($page < $toeic_total_page){
//				$next = $page+1;
//				$html_toeic_footer  .= '<a href="?page='  . (int)$next . '">次</a>'."\n";
//			}
//			//$html_toeic_footer  .= '</br><a href="./form_toeic.php" >TOEIC戦歴入力</a>'."\n";
//		}
		
//		return $html_toeic.$html_toeic_footer;
		return $html_toeic; 
	}

	
	//TODO:途中
	public function showAnalysisTable($first_date,  $last_date,  $times,  $MaxScores,  $AvgScores,  $rate){
	
	
	
		$html_table='<table>'."\n";
		$html_table.='<caption>客観的な視点で分析！(努力は裏切らない！Keep it up!)</caption>'."\n";
		$html_table.='<tr>'."\n";
//		$html_table.='<th>初受験</th><th>ラスト受験日</th><th>受験回数</th><th>最高点</br>(Total)</th><th>最高点</br>(Listeing)</th><th>最高点</br>(Reading)</th><th>平均点</br>(Total)</th><th>平均点</br>(Listeing)</th><th>平均点</br>(Reading)</th><th>伸び率(対初回)</br>(Total)</th><th>伸び率(対初回)</br>(Listeing)</th><th>伸び率(対初回)</br>(Reading)</th>'."\n";
		$html_table.='<th>最高点</br>(Total)</th><th>最高点</br>(Listeing)</th><th>最高点</br>(Reading)</th><th>平均点</br>(Total)</th><th>平均点</br>(Listeing)</th><th>平均点</br>(Reading)</th><th>伸び率</br>[対初回]</br>(Total)</th><th>伸び率</br>[対初回]</br>(Listeing)</th><th>伸び率</br>[対初回]</br>(Reading)</th>'."\n";
		$html_table.='</tr>'."\n";
		$html_table.='<tr>'."\n";
//		$html_table.='<td>' . $first_date['first_date'] .  '</td>' ."\n";
//		$html_table.='<td>' . $last_date['last_date']   .  '</td>' ."\n";
//		$html_table.='<td>' . $times['times']           .  '</td>' ."\n";
	
		$html_table.='<td>' . $MaxScores["max_score"]    .  '</td>' ."\n";
		$html_table.='<td>' . $MaxScores["max_score_L"]  .  '</td>' ."\n";
		$html_table.='<td>' . $MaxScores["max_score_R"]  .  '</td>' ."\n";
	
		$html_table.='<td>' . $AvgScores["avg_score"]    .  '</td>' ."\n";
		$html_table.='<td>' . $AvgScores["avg_score_L"]  .  '</td>' ."\n";
		$html_table.='<td>' . $AvgScores["avg_score_R"]  .  '</td>' ."\n";
	
		$html_table.='<td>' . $rate["rate_score"]      .  '</td>' ."\n";
		$html_table.='<td>' . $rate["rate_score_L"]    .  '</td>' ."\n";
		$html_table.='<td>' . $rate["rate_score_R"]    .  '</td>' ."\n";

		$html_table.='</tr>'."\n";
		$html_table.='</table>'."\n";
		return $html_table;
		
	}
	
	
	
	
	
	
	
}