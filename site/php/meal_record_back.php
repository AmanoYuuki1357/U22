<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);

    if (isset($_POST['val1'])) {
        $food_name = $_POST['val1'];
        $searchs = $db->prepare('SELECT f_item_name FROM t_items WHERE f_item_name LIKE "%"?"%"');
        $searchs->execute(array($food_name));
        $search = $searchs->fetchAll();
        echo json_encode($search, JSON_UNESCAPED_UNICODE);
    }

    if (isset($_POST['val2'])) {

        for($i = 0; $i < count($_POST['val2']); $i++) {
            $anser .= $i;

            $food_name = $_POST['val2'][$i];
            $searchs = $db->prepare('SELECT * FROM t_items WHERE f_item_name=?');
            $searchs->execute(array($food_name));
            $search = $searchs->fetch();
            $anser .= $search['f_item_name'];
            $adds = $db->prepare('INSERT INTO t_intakes( f_user_id, f_intake_date,f_intake_name, f_intake_calorie, f_intake_protein_vol, f_intake_suger_vol, f_intake_lipid_vol, f_intake_dietary_fiber_vol, f_intake_salt_vol, f_intake_image ) VALUES(?,NOW(),?,?,?,?,?,?,?,?)');
            $adds->execute(array(
                $_POST['val3'],
                $search['f_item_name'],
                $search['f_item_calorie'],
                $search['f_item_protein_vol'],
                $search['f_item_sugar_vol'],
                $search['f_item_lipid_vol'],
                $search['f_item_dietary_fiber_vol'],
                $search['f_item_salt_vol'],
                $search['f_item_image']
            ));


        }
        echo json_encode($anser, JSON_UNESCAPED_UNICODE);
    }
?>