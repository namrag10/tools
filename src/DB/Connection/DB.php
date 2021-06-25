<?php

namespace RGarman\DB\Connection;

use PDO;


class DB {
	
    public $Host, $DB, $Credentials, $charset, $PDOInstance, $Command, $Params;

    public function __construct($DB, $Credentials = [], $host = "localhost", $charset = "utf8mb4"){
        $this->Host = $host;
        $this->DB = $DB;
        $this->Credentials = (sizeof($Credentials) > 0) ? array_values($Credentials) : ["", ""];
		$this->charset = $charset;
		
		$this->Command = "";
		$this->Params = [];
	
		$dsn = "mysql:host=$this->Host;dbname=$this->DB;charset=$this->charset";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
	
		try {
			$this->PDOInstance = new PDO($dsn, $this->Credentials[0], $this->Credentials[1], $opt);
		} catch (\PDOException $e) {
		    throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
		
	}
	
	public function run($CMD = null, $Params = []){
		$this->setCMD($CMD, $Params);
		$stmt = $this->PDOInstance->prepare($this->Command);
	
		$stmt->execute($this->Params);
	
		switch($this->Command[0]){
				// Only valid response is the Select statement
			case "S":
				return $stmt->fetchAll();
				break;
			case "I":
				// Only valid response is the Insert statement
				return $this->PDOInstance->lastInsertId();
				break;
			case "D":
				// Only valid response is the Delete statement
				return $stmt->rowCount();
				break;
		}
	}

	public function setCMD($CMD, $Params = []){
		if(!$CMD == null){
			$this->Command = $CMD;
			$this->Params = $Params;
		}
		return $this;
	}

	public function getCMD(){
		return [$this->Command, $this->Params];
	}
}