<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $filter = "f_item_allergen_".$_POST['val'];
    // print($filter);

    // $sql = 'SELECT f_item_id FROM t_item_allergens WHERE ? = 0;';
    // $items = $db->prepare($sql);
    // $items->execute(array($filter));
    
    $sql = 'SELECT f_item_id FROM t_item_allergens WHERE '.$filter.' = 0;';
    $items = $db->query($sql);

    // print_r($items);
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