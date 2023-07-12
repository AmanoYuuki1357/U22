<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $genre = $_POST['val'];


    // $sql1 = 'SELECT * FROM t_carts WHERE f_user_id=? AND f_item_id=?';
    // $stmt = $db->prepare($sql1);
    // $stmt->execute(array($userId,$itemId));
    // $cart = $stmt->fetch();

    $sql = 'SELECT i.f_item_id FROM t_items as i join t_item_types as t on i.f_item_id = t.f_item_id join t_item_genre as g on t.f_item_genre_id = g.f_item_genre_id WHERE g.f_item_genre_name = ?;';
    $items = $db->prepare($sql);
    $items->execute(array($genre));
    // $item = $items->fetchAll();
    // print_r($item);


    $list[]=[];
    $i=0;
    while($item = $items->fetch()){
        $list[$i] = ($item["f_item_id"]);
        $i++;
    }

    $list_json = json_encode($list);
    print($list_json);

    // print("ajax");


?>