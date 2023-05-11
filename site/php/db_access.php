<?php
class DbMagic{

	// 変数宣言も不要になる(db変数はマジックメソッドで生成)
	// 外部からアクセスさせたくない変数だけはprivate宣言
	private $userid;
	private $pass, $host, $dbname, $port, $dsn;

	function __construct(
					$dbname = "mealfriend",
					$id		= "root",
					$pass	= "",
					$host	= "127.0.0.1",
					$port	= 3306){

		$this->userid	= $id;
		$this->pass	= $pass;
		$this->host	= $host;
		$this->dbname = $dbname;
		$this->port	= $port;
		$this->dsn	= "mysql:host={$this->host};dbname={$this->dbname};charset=utf8;port={$this->port}";
	}

	function __get($name){
  		return $this->name;
	}
	function __set( $name, $val ){
  		$this->{$name} = $val;
	}

	// DB接続用の関数
	function conn(){
		$flg = true;

		try{
	   		$this->db = new PDO($this->dsn, $this->userid, $this->pass);
		}
		catch( PDOException $e ){
			$flg = false;
			print "接続エラー：".$e->getMessage();
		}

		return $flg;
	}
}

?>
