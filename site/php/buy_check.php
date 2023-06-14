<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlcredit = '
        SELECT
            f_user_name             AS name,
            f_user_nick_name        AS nick_name
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
    <div id="wrap">
        <header>

            <div>
                <a href="menu.php">商品一覧</a>
            </div>

            <div>
                <a href="index.php"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>

            <div id="header-right">

                <!-- ログイン時のみ遷移可能なため、常にユーザー情報が表示されている -->
                <div id="user">
                    <div>
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
                    </div>
                    <div>
                        <a href="my_page.php"><?php print(h($user["nick_name"])) ?></a>
                    </div>
                </div>
                <a href="cart.php"><img class="headerimg" src="../images/cart.jpg" alt="カート"></a>

            </div>

        </header>

        <main>
            <!-- 進行度バー -->
            <div class="stepbar-row">
                <ol class="stepbar">
                    <li class="done"><span></span><br />お届け先</li>
                    <li class="done"><span></span><br />お支払方法</li>
                    <li><span></span><br />完了</li>
                </ol>
            </div>

            <div>
                <h3>お支払内容確認</h3>
                <div>

                    <p>お受取情報</p>

                    <p>お名前</p>
                    <p><?php print(h($user["name"] . " 様")) ?></p>
                    <p>宛先</p>
                    <p><?php print(h($_SESSION['buy']['address'])) ?></p>

                    <p>購入商品</p>
                    <table>
                        <tr>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>個数</th>
                            <th>小計</th>
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
                            <th>合計</th>
                            <td colspan="2"><?php print h($sum) . "円" ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div>
                <a href="buy_complete.php">次へ</a>
            </div>

            <div class="back">
                <a href="buy_pay.php">戻る</a>
            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

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