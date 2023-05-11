<?php
class Db{

	private $userid;
	private $pass, $host, $dbname, $port, $dsn;

	function __construct(
					$dbname = "mealfriend",
					$id		= "root",
					$pass	= "",
					$host	= "127.0.0.1",
					$port	= 3306){

		$this->userid	= $id;
		$this->pass		= $pass;
		$this->host		= $host;
		$this->dbname 	= $dbname;
		$this->port		= $port;
		$this->dsn		= "mysql:host={$this->host};dbname={$this->dbname};charset=utf8;port={$this->port}";
	}

	function __get( $name ){
  		return $this->name;
	}
	function __set( $name, $val ){
  		$this->{$name} = $val;
	}

	// ===================================================================================
	// DB接続(返り値:true/false)
	// ===================================================================================
	function connect(){
		$flg = true;

		try{
	   		$this->db = new PDO($this->dsn, $this->userid, $this->pass);
		}
		catch( PDOException $e ){
			$flg = false;
			print "接続エラー：" . $e->getMessage();
		}

		return $flg;
	}

	// ===================================================================================
	// 食品詳細情報取得(返り値:指定食品IDの商品情報)
	// ===================================================================================
	function showItem($itemId){
		$contents = $this->db->prepare('
		select
			*
		from
			t_items
		where
			f_item_id = ? ;');
		$contents->bindparam(1, $itemId, PDO::PARAM_INT);
		$contents->execute();

		$count = $contents -> rowCount();
		if($count == 0){
			return false;
		}

		return $contents->fetch(PDO::FETCH_ASSOC);
	}

	// ===================================================================================
	// 食品詳細情報取得(返り値:指定食品IDのジャンル情報)
	// ===================================================================================
	function showGenre($itemId){
		$contents = $this->db->prepare('
		select
			type.f_item_genre_id,
			genre.f_item_genre_name
		from
			t_item_types	as type
		join
			t_item_genre	as genre
		on
			type.f_item_genre_id = genre.f_item_genre_id
		where
			type.f_item_id = ? ;');
		$contents->bindparam(1, $itemId, PDO::PARAM_INT);
		$contents->execute();

		return $contents;
	}

	// ===================================================================================
	// 食品詳細情報取得(返り値:指定食品IDのジャンル情報)
	// ===================================================================================
	function showAllergens($itemId){
		$contents = $this->db->prepare('
		select
			*
		from
			t_item_allergens
		where
			f_item_id = ? ;');
		$contents->bindparam(1, $itemId, PDO::PARAM_INT);
		$contents->execute();

		return $contents->fetch(PDO::FETCH_ASSOC);
	}
	
	

}

?>
