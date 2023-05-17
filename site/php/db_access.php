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
	// SQL
	// ===================================================================================
	private $sqlItem = '
		select
			*
		from
			t_items
		where
			f_item_id = ? ;';
	
	private $sqlGenre = '
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
			type.f_item_id = ? ;';

	private $sqlAllergens = '
		select
			*
		from
			t_item_allergens
		where
			f_item_id = ? ;';

	// ===================================================================================
	// 指定商品IDによるDB検索
	// ===================================================================================
	function showByItemId($sql, $itemId){
		$contents = $this->db->prepare($sql);
		$contents->bindparam(1, $itemId, PDO::PARAM_INT);
		$contents->execute();

		return $contents;
	}

	// ===================================================================================
	// 食品詳細情報取得(返り値:指定食品IDの商品情報)
	// ===================================================================================
	function showItem($itemId){
		$contents = $this->showByItemId($this->sqlItem, $itemId);
		return $contents->fetch(PDO::FETCH_ASSOC);
	}

	// ===================================================================================
	// 食品ジャンル情報取得(返り値:指定食品IDのジャンル情報)
	// ===================================================================================
	function showGenres($itemId){
		return $this->showByItemId($this->sqlGenre, $itemId);
	}

	// ===================================================================================
	// 食品アレルギーgi情報取得(返り値:指定食品IDのアレルギー情報)
	// ===================================================================================
	function showAllergens($itemId){
		$contents = $this->showByItemId($this->sqlAllergens, $itemId);
		return $contents->fetch(PDO::FETCH_ASSOC);
	}
	
	

}

?>
