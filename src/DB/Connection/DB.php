<?php

namespace RGarman\DB\Connection;

use PDO;


class DB {
	//test comment
    public $Host, $DB, $Credentials, $charset, $PDOInstance;

    public function __construct($DB, $Credentials = [], $host = "localhost", $charset = "utf8mb4"){
        $this->Host = $host;
        $this->DB = $DB;
        $this->Credentials = (sizeof($Credentials) > 0) ? array_values($Credentials) : ["", ""];
        $this->charset = $charset;		
	
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
	
	public function run($CMD, $Params = []){
		$stmt = $this->PDOInstance->prepare($CMD);
	
		$stmt->execute($Params);
	
		if($CMD[0] == "S" || $CMD[0] == "I" || $CMD[1] == "E"){
			$row = $stmt->fetchAll();
			return $row;
		}elseif($CMD[0] =="D"){
			return $stmt->rowCount();
        }
	}
}