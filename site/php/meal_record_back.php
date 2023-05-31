<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    // $i=1;

    $food_name = $_POST['val1'];

    $searchs = $db->prepare('SELECT f_item_name FROM t_items WHERE f_item_name LIKE "%"?"%"');
    $searchs->execute(array($food_name));
    $search = $searchs->fetchAll();

    echo json_encode($search, JSON_UNESCAPED_UNICODE);
?>