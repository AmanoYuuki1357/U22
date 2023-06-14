<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $userId = $_POST['val1'];
    $itemId = $_POST['val2'];


    // $sql1 = 'SELECT * FROM t_carts WHERE f_user_id=? AND f_item_id=?';
    // $stmt = $db->prepare($sql1);
    // $stmt->execute(array($userId,$itemId));
    // $cart = $stmt->fetch();

    // if()
    $sql2 = 'INSERT INTO t_carts(f_user_id,f_item_id,f_item_num) VALUES(?,?,1)';
    $stmt = $db->prepare($sql2);
    $stmt->execute(array($userId,$itemId));
    print_r($cart);

    // print("ajax");


?>