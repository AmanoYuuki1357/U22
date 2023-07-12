<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require('./common.php');

    $selected = $_POST['selected'];
    $filter = "";
    for($i=0; $i<count($selected); $i++){
        $filter .= "f_item_allergen_".$selected[$i]." = 0";
        if($i!=count($selected)-1){
            $filter .= " and ";
        }
    }
    // print($filter);

    $sql = 'SELECT f_item_id FROM t_item_allergens WHERE '.$filter.' ;';
    $items = $db->query($sql);

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