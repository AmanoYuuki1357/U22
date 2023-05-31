<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    $i=1;

    $food_name = $_POST['food_name'];

    $searchs = $db->prepare('SELECT f_item_name FROM t_items WHERE LIKE ?');
    $searchs->execute(array($food_name));

    while($search = $searchs->fetch()){
        $array = $search['f_item_name'];
        $i++;
    }

    echo json_encode($search, JSON_UNESCAPED_UNICODE);
?>