<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $filter = "f_item_allergen_".$_POST['val'];


    // $sql1 = 'SELECT * FROM t_carts WHERE f_user_id=? AND f_item_id=?';
    // $stmt = $db->prepare($sql1);
    // $stmt->execute(array($userId,$itemId));
    // $cart = $stmt->fetch();

    // if()
    $sql = 'SELECT f_item_id FROM t_item_allergens WHERE ? = 0;';
    $items = $db->prepare($sql);
    $items->execute(array($filter));
    // $items = $items->fetchAll();
    // print_r($items);


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