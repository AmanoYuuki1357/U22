<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $itemId     = $_POST['itemId'];
    $userId     = $_POST['userId'];
    $point      = $_POST['point'];
    $comment    = $_POST['comment'];

    // レビュー登録処理
    $sql = '
        INSERT INTO
            t_item_review
        VALUES
            (
                NOW(),
                ?,
                ?,
                ?,
                ?
            )';

    $contents = $db->prepare($sql);
    $contents->bindparam(1, $itemId, PDO::PARAM_INT);
    $contents->bindparam(2, $userId, PDO::PARAM_INT);
    $contents->bindparam(3, $point, PDO::PARAM_INT);
    $contents->bindparam(4, $comment, PDO::PARAM_STR);
    $updateUser = $contents->execute();

?>