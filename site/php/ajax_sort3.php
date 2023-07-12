<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $sorts = $_POST['def'];
    if($sorts=="def"){
        $sort = "f_item_".$_POST['val']."_vol";
        // print($sort);

        // $sql1 = 'SELECT * FROM t_carts WHERE f_user_id=? AND f_item_id=?';
        // $stmt = $db->prepare($sql1);
        // $stmt->execute(array($userId,$itemId));
        // $cart = $stmt->fetch();

        $sql = 'SELECT f_item_id FROM t_items ORDER BY '.$sort.' DESC;';
        $items = $db->query($sql);

    }else{
        $sql = 'SELECT f_item_id FROM t_items;';
        $items = $db->query($sql);
    }
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