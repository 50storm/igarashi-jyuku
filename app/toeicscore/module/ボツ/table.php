<?php

abstract class Table{
	protected $perPage; //1page当たり
	protected $dsn;
	protected $user;    
	protected $password;

	//abstract protected function  __construct();

	function __construct($dsn,$user,$password){
		if(isset($dsn)|| isset($user)|| isset($password)){
			$this->dsn=$dsn;
			$this->user=$user;
			$this->password=$password;
			
			
		}else{
			var_dump($user);
			var_dump($password);
			var_dump($dsn);
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
	
	
	//abstract
	// required to implement abstract functions
	//abstract protected function test();
	abstract public function getRows();
	abstract public function getRows($date,$from);
	abstract public function getTotalPage();
	
	
}
