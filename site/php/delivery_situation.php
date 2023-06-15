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

$sql = 'SELECT * FROM t_buy_history WHERE f_user_id=?';
$items = $db->prepare($sql);
$items->execute(array($user["f_user_id"]));

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
        <!-- <p><?php print_r($buyHistory); ?></p> -->
        <h2>配送状況</h2>
        <div class="situation">
            <p>購入履歴:○○年○○月○○日</p>
            <div class="info">
                <p>商品：</p>
                <ul>
                    <li>商品名</li>
                    <li>商品名</li>
                </ul>
                <p>配送予定：○○年○○月○○日</p>
                <p>ステータス:配送済み</p>
                <p>配達場所:○○○-○○○○<br>○○県○○市○○町○丁目○番地○</p>
            </div>
        </div>

        <div class="situation">
            <p>購入履歴:○○年○○月○○日</p>
            <div class="info">
                <p>商品：</p>
                <ul>
                    <li>商品名</li>
                    <li>商品名</li>
                </ul>
                <p>配送予定：○○年○○月○○日</p>
                <p>ステータス:配送済み</p>
                <p>配達場所:○○○-○○○○<br>○○県○○市○○町○丁目○番地○</p>
            </div>
        </div>

        <div class="situation">
            <p>購入履歴:○○年○○月○○日</p>
            <div class="info">
                <p>商品：</p>
                <ul>
                    <li>商品名</li>
                    <li>商品名</li>
                </ul>
                <p>配送予定：○○年○○月○○日</p>
                <p>ステータス:配送済み</p>
                <p>配達場所:○○○-○○○○<br>○○県○○市○○町○丁目○番地○</p>
            </div>
        </div>
    </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>



    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>