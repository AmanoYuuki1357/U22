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

    private $sqlreviewCntByItemId = '
        SELECT
            count(*)    AS cnt
        FROM
            t_item_review
        where
            f_item_id = ?;';

    private $sqlreviewByItemId = '
        SELECT
            f_review_date,
            f_review_point,
            f_review
        FROM
            t_item_review    AS review
        where
            review.f_item_id = ?
        ORDER BY
            f_review_date DESC
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
    function countreviewByItemId($itemId){
        $contents =  $this->showByItemId($this->sqlreviewCntByItemId, $itemId);
        return  $contents->fetch(PDO::FETCH_ASSOC);

    }

    // 商品IDで抽出(件数指定)
    function showReviewByItemId($itemId, $first, $last){
        $contents =  $this->showByItemId($this->sqlreviewByItemId . $first . "," . $last .';', $itemId);
        return  $contents->fetchAll(PDO::FETCH_ASSOC);
    }

    // 商品IDで抽出(件数指定)
    function limitReviewByItemId($itemId, $num){
        return $this->showreviewByItemId($itemId, 0, $num);
    }




}

?>
