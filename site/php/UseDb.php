<?php
class UseDb{

    private $db;

    function __construct($db){
        $this->db    = $db;
    }

    // ===================================================================================
    // SQL
    // ===================================================================================
    private $sqlItemByItemId = '
        SELECT
            *
        FROM
            t_items
        WHERE
            f_item_id = ? ;';
    
    private $sqlGenreByItemId = '
        SELECT
            type.f_item_genre_id,
            genre.f_item_genre_name
        FROM
            t_item_types    as type
        JOIN
            t_item_genre    as genre
        ON
            type.f_item_genre_id = genre.f_item_genre_id
        WHERE
            type.f_item_id = ? ;';

    private $sqlAllergensByItemId = '
        SELECT
            *
        FROM
            t_item_allergens
        WHERE
            f_item_id = ? ;';

    private $sqlReveiwCntByItemId = '
        SELECT
            count(*)    AS cnt
        FROM
            t_item_reveiw
        where
            f_item_id = ?;';

    private $sqlReveiwByItemId = '
        SELECT
            f_reveiw_date,
            f_reveiw_point,
            f_reveiw
        FROM
            t_item_reveiw    AS reveiw
        where
            reveiw.f_item_id = ?
        ORDER BY
            f_reveiw_date DESC
        LIMIT ';

    // ===================================================================================
    // 指定商品IDによるDB検索
    // ===================================================================================
    // 商品IDで抽出
    function showByItemId($sql, $itemId){
        $contents = $this->db->prepare($sql);
        $contents->bindparam(1, $itemId, PDO::PARAM_INT);
        $contents->execute();

        return $contents;
    }

    // ===================================================================================
    // 食品詳細情報取得(返り値:商品情報)
    // ===================================================================================
    // 商品IDで抽出
    function showItemByItemId($itemId){
        $contents = $this->showByItemId($this->sqlItemByItemId, $itemId);
        return $contents->fetch(PDO::FETCH_ASSOC);
    }

    // ===================================================================================
    // 食品ジャンル情報取得(返り値:ジャンル情報)
    // ===================================================================================
    // 商品IDで抽出
    function showGenresByItemId($itemId){
        $contents = $this->showByItemId($this->sqlGenreByItemId, $itemId);
        return  $contents->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===================================================================================
    // 食品アレルギー情報取得(返り値:アレルギー情報)
    // ===================================================================================
    // 商品IDで抽出
    function showAllergensByItemId($itemId){
        $contents = $this->showByItemId($this->sqlAllergensByItemId, $itemId);
        return $contents->fetch(PDO::FETCH_ASSOC);
    }
    
    // ===================================================================================
    // 食品レビュー情報取得(返り値:商品詳細画面用レビュー情報)
    // ===================================================================================
    // 商品IDで抽出
    function countReveiwByItemId($itemId){
        $contents =  $this->showByItemId($this->sqlReveiwCntByItemId, $itemId);
        return  $contents->fetch(PDO::FETCH_ASSOC);

    }

    // 商品IDで抽出(件数指定)
    function showReveiwByItemId($itemId, $first, $last){
        $contents =  $this->showByItemId($this->sqlReveiwByItemId . $first . "," . $last .';', $itemId);
        return  $contents->fetchAll(PDO::FETCH_ASSOC);
    }

    // 商品IDで抽出(件数指定)
    function limitReveiwByItemId($itemId, $num){
        return $this->showReveiwByItemId($itemId, 0, $num);
    }




}

?>
