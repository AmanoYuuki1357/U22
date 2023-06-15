<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $userId = $_POST['val1'];
    $itemId = $_POST['val2'];
    $itemNum = $_POST['val3'];


    // $sql1 = 'SELECT * FROM t_carts WHERE f_user_id=? AND f_item_id=?';
    // $stmt = $db->prepare($sql1);
    // $stmt->execute(array($userId,$itemId));
    // $cart = $stmt->fetch();

    // if()
    $sql = 'UPDATE t_carts SET f_item_num=? WHERE f_user_id=? AND f_item_id=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($itemNum,$userId,$itemId));

    // print("ajax");


?>