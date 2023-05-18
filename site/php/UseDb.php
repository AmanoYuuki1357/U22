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

    private $sqlReveiwAll = '
        SELECT
            f_reveiw_date,
            f_item_name,
            f_user_nick_name,
            f_reveiw_point,
            f_reveiw
        FROM
            t_item_reveiw    AS reveiw
        JOIN
            t_items        AS item
        ON
            item.f_item_id = reveiw.f_item_id
        JOIN
            t_users        AS user
        ON
            user.f_user_id = reveiw.f_user_id
        where
            reveiw.f_item_id = ?;';

    private $sqlReveiwLimitByItemId = '
        SELECT
            f_reveiw_date,
            f_user_nick_name,
            f_reveiw_point,
            f_reveiw
        FROM
            t_item_reveiw    AS reveiw
        JOIN
            t_users        AS user
        ON
            user.f_user_id = reveiw.f_user_id
        WHERE
            reveiw.f_item_id = ?
        ORDER BY
            f_reveiw_date DESC
        limit 0,';

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
    // 食品詳細情報取得(返り値:商品情報)
    // ===================================================================================
    function showItemByItemId($itemId){
        $contents = $this->showByItemId($this->sqlItemByItemId, $itemId);
        return $contents->fetch(PDO::FETCH_ASSOC);
    }

    // ===================================================================================
    // 食品ジャンル情報取得(返り値:ジャンル情報)
    // ===================================================================================
    function showGenresByItemId($itemId){
        $contents = $this->showByItemId($this->sqlGenreByItemId, $itemId);
        return  $contents->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===================================================================================
    // 食品アレルギー情報取得(返り値:アレルギー情報)
    // ===================================================================================
    function showAllergensByItemId($itemId){
        $contents = $this->showByItemId($this->sqlAllergensByItemId, $itemId);
        return $contents->fetch(PDO::FETCH_ASSOC);
    }
    
    // ===================================================================================
    // 食品レビュー情報取得(返り値:商品詳細画面用レビュー情報)
    // ===================================================================================
    function showReveiwLimitByItemId($itemId, $num){
        $contents =  $this->showByItemId($this->sqlReveiwLimitByItemId . $num .';', $itemId);
        return  $contents->fetchAll(PDO::FETCH_ASSOC);
    }


}

?>
