<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $userId = $_POST['val1'];
    $itemName = $_POST['val2'];
    $itemImage = $_POST['val3'];

    $sql = 'SELECT f_item_calorie, f_item_protein_vol, f_item_sugar_vol, f_item_lipid_vol, f_item_dietary_fiber_vol FROM t_items WHERE f_item_name = ?;';
    $items = $db->prepare($sql);
    $items->execute(array($itemName));
    $item = $items->fetch();
    print_r($item);



    $sql = 'INSERT INTO t_intakes(f_user_id, f_intake_date, f_intake_name, f_item_calorie, f_item_protein_vol, f_item_sugar_vol, f_item_lipid_vol, f_item_dietary_fiber_vol, f_intake_salt_vol,f_intake_image) VALUES(?, date("Y/m/d H:i:s"), ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($userId,$itemName,$itemCalorie,$itemProtein,$itemSugar,$itemLipid,$itemDietaryFiber,$itemSalt,$itemImage));

    // print("ajax");

?>