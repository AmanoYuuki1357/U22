<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlcredit = '
        SELECT
            f_user_id,
            f_user_name,
            f_user_nick_name,
            SUBSTRING(f_user_credit_number, 13)    AS number
        FROM
            t_users
        WHERE
            f_user_id = ? ;';
    
    $sqlcart = '
        SELECT
            item.f_item_id      AS id,
            item.f_item_name    AS name,
            item.f_item_price   AS price,
            item.f_item_image   AS image,
            cart.f_item_num     AS num
        FROM
            t_carts	AS cart
        JOIN
            t_items	AS item
        ON
            cart.f_item_id = item.f_item_id
        WHERE
            f_user_id = ?;';
    
    $sqladd = '
        INSERT INTO
            t_buy_history
        VALUES
        (
            NOW(),
            ?,
            ?,
            ?,
            ?,
            "配送準備中"
        );';

    $sqldelete = '
        DELETE
        FROM
            t_carts
        WHERE
            f_user_id = ?;';

    // ===================================================================================
    // セッション開始
    // ===================================================================================
    if(!isset($_SESSION)){
        session_start();
    }

    // ユーザーID取得
    if(isset($_SESSION['id'])){
        // ログインユーザーのIDを取得
        $userId = $_SESSION['id'];

        // ===============================================================================
        // DB検索
        // ===============================================================================
        // ユーザー情報取得
        $contents = $db->prepare($sqlcredit);
        $contents->bindparam(1, $userId, PDO::PARAM_INT);
        $contents->execute();
        $user = $contents->fetch();

        // カート情報取得
        $contents = $db->prepare($sqlcart);
        $contents->bindparam(1, $userId, PDO::PARAM_INT);
        $contents->execute();
        $carts = $contents->fetchAll();
    }
    else{
        // ログインページへ
        header('Location: login.php');
    }

    // 購入確定ボタン押下イベント
    if(isset($_POST['settlement'])){

        // 購入履歴登録
        foreach($carts as $cart){

            // 購入履歴TBLへ登録
            $contents = $db->prepare($sqladd);
            $contents->bindParam(1, $userId, PDO::PARAM_INT);
            $contents->bindParam(2, $cart["id"], PDO::PARAM_INT);
            $contents->bindParam(3, $cart["num"], PDO::PARAM_INT);
            $contents->bindParam(4, $_SESSION["buy"]["address"], PDO::PARAM_STR);
            $insertHistory = $contents->execute();

            // 登録失敗した場合
            if($insertHistory != 1){
                // TODO: 登録失敗時の動作を考える
            }
        }

        // 登録成功
        // カート内情報の削除
        $contents = $db->prepare($sqldelete);
        $contents->bindParam(1, $userId, PDO::PARAM_INT);
        $deleteCarts = $contents->execute();

        // 削除失敗
        if($deleteCarts != 1){
            // TODO: 削除失敗時の処理を考える
        }

        // 削除成功
        header('Location: buy_complete.php');

    }

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入カード情報</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">

</head>

<body>
    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>

    <main>
        <!-- 進行度バー -->
        <div class="stepbar-row">
            <ol class="stepbar">
                <li class="done"><span></span><br />お届け先</li>
                <li class="done"><span></span><br />お支払方法</li>
                <li><span></span><br />完了</li>
            </ol>
        </div>

        <div class="container">
            <div class="row">
                <h2>お支払内容確認</h2>
            </div>

            <hr>

            <div class="row">
                <h3>お受取情報</h3>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>お名前</p>
                </div>
                <div class="col">
                    <p><?php print(h($user["f_user_name"] . " 様")) ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>宛先</p>
                </div>
                <div class="col">
                    <p><?php print(h($_SESSION['buy']['address'])) ?></p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-2">
                    <p>クレジットカード番号</p>
                </div>
                <div class="col">
                    <p><?php print(h( '**** **** **** ' . $user["number"] )); ?></p>
                </div>
            </div>

            <div class="row">
                <h3>購入商品</h3>
            </div>
                    
                <table class="table">
                    <tr>
                        <th scope="col">商品名</th>
                        <th scope="col">価格</th>
                        <th scope="col">個数</th>
                        <th scope="col">小計</th>
                    </tr>
                    <?php
                        $sum = 0;
                        foreach($carts as $cart){
                            $sum += $cart['price'] * $cart['num'];
                            print "<tr>";
                            print "<td>" . h($cart['name']) . "</td>";
                            print "<td>" . h($cart['price']) . "円</td>";
                            print "<td>" . h($cart['num']) . "個</td>";
                            print "<td>" . h($cart['price'] * $cart['num']) ."円</td>";
                            print "</tr>";
                        }
                    ?>
                    <tr>
                        <th colspan="3" scope="row">合計</th>
                        <td><?php print h($sum) . "円" ?></td>
                    </tr>
                </table>

        </div>

        <div class="d-md-flex justify-content-center">
            <a href="buy_pay.php" class="btn btn-secondary me-md-2">戻る</a>
            <form action="" method="post">
                <input type="hidden" name="settlement" value="settlement" />
                <input type="submit" class="btn btn-primary" value="以上の内容で購入する" />
            </form>
        </div>



    </main>

    <!-- フッター部分 -->
    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    <script>
        // mainタグの高さを取得する
        var mainHeight = document.querySelector('main').clientHeight;
        console.log(mainHeight);
        // mainタグの高さが1000px未満だったら、footerを画面最下部に固定する
        if (mainHeight < 800) {
            document.querySelector('footer').style.position = 'fixed';
            document.querySelector('footer').style.bottom = '0';
        }
    </script>

    <!-- jQuery -->
    <!-- <script src="js/JQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

<style>
    .stepbar-row {
        position: relative;
        top: 20px;
    }
</style>

</html>