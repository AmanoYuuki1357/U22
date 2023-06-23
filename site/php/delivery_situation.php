<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id"])) {
    $users = $db->prepare('SELECT * FROM t_users WHERE f_user_id=?');
    $users->execute(array($_SESSION["id"]));
    $user = $users->fetch();
}

$sql = 'SELECT b.f_buy_history_date, b.f_buy_history_delivery_situation, f_buy_history_delivery_place, i.f_item_name FROM t_buy_history as b JOIN t_items as i ON b.f_item_id = i.f_item_id WHERE b.f_user_id=?';
$items = $db->prepare($sql);
$items->execute(array($user["f_user_id"]));
$item = $items->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>配送状況</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/delivery_situation.css">

</head>

<body>
<!-- ヘッダー部分 -->
<?php
require('header.php');
?>

    <main>
        <!-- <p><?php print_r($item); ?></p> -->
        <h2>配送状況</h2>

        <?php
            $cccOld = "";
            $cccNew = "";
            for($i=0; $i<count($item); $i++){
                $cccNew = $item[$i]['f_buy_history_date'];
                if($cccOld != $item[$i]['f_buy_history_date']){
                    print("<div class='situation'>");
                    print("<p>購入履歴：".$item[$i]['f_buy_history_date']."</p>");
                    print("<div class='info'>");
                    print("<p>商品：</p>");
                    print("<ul>");
                    print("<li>".$item[$i]['f_item_name']."</li>");
                }

                for($j=$i; $j<count($item); $j++){
                    if($j != $i){
                        if($cccNew == $item[$j]['f_buy_history_date']){
                            print("<li>".$item[$j]['f_item_name']."</li>");
                        }
                    }
                }

                if($cccOld != $item[$i]['f_buy_history_date']){
                print("</ul>");
                print("<p>配送予定：".$item[$i]['f_buy_history_delivery_situation']."</p>");
                print("<p>配達場所：".$item[$i]['f_buy_history_delivery_place']."</p>");
                print("</div>");
                print("</div>");
                }
                $cccOld = $item[$i]['f_buy_history_date'];
            }
        ?>

    </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>



    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>