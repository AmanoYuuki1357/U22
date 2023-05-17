<?php
class UseDb{

    private $db;

    function __construct($db){
        $this->db    = $db;
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
            t_item_types    as type
        join
            t_item_genre    as genre
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

    private $sqlReveiwLimit = '
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
    function showItem($itemId){
        $contents = $this->showByItemId($this->sqlItem, $itemId);
        return $contents->fetch(PDO::FETCH_ASSOC);
    }

    // ===================================================================================
    // 食品ジャンル情報取得(返り値:ジャンル情報)
    // ===================================================================================
    function showGenres($itemId){
        return $this->showByItemId($this->sqlGenre, $itemId);
    }

    // ===================================================================================
    // 食品アレルギー情報取得(返り値:アレルギー情報)
    // ===================================================================================
    function showAllergens($itemId){
        $contents = $this->showByItemId($this->sqlAllergens, $itemId);
        return $contents->fetch(PDO::FETCH_ASSOC);
    }
    
    // ===================================================================================
    // 食品レビュー情報取得(返り値:商品詳細画面用レビュー情報)
    // ===================================================================================
    function showReveiwLimit($itemId){
        return $this->showByItemId($this->sqlReveiwLimit . '3;', $itemId);
    }


}

?>
