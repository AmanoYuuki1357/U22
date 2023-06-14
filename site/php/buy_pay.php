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
            f_user_credit_number    AS number,
            f_user_credit_name      AS name,
            f_user_credit_expiry    AS expiry,
            f_user_credit_code      AS code
        FROM
            t_users
        WHERE
            f_user_id = ? ;';

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

        // ===================================================================================
        // DB検索
        // ===================================================================================
        // ユーザー情報取得
        $contents = $db->prepare($sqlcredit);
        $contents->bindparam(1, $userId, PDO::PARAM_INT);
        $contents->execute();
        $user = $contents->fetch();
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

        <div>
            <h2>クレジットカード情報</h2>

            <hr>

            <div>
                <p>カード番号</p>
                <?php
                    if(empty($user["number"])){
                        print "<p style='color: red;'>登録されていません</p>";
                    }
                    else{
                        print "<p>" . h( '**** **** **** ' . substr($user["number"], 12, 4) ) . "</p>";
                    }
                ?>
                <p>カード名義人</p>
                <?php
                    if(empty($user["name"])){
                        print "<p style='color: red;'>登録されていません</p>";
                    }
                    else{
                        print "<p>" . h($user["name"]) . "</p>";
                    }
                ?>
                <p>有効期限(月/年)</p>
                <p>
                <?php
                    if(empty($user["expiry"])){
                        print "<p style='color: red;'>登録されていません</p>";
                    }
                    else{
                        print "<p>" . h(substr($user["expiry"], 0, 2) . "/". substr($user["expiry"], 2)) ."</p>" ;
                    }
                ?>
                </p>
                <p>セキュリティコード</p>
                <p>
                    【表示されません】
                </p>
            </div>
            <div>
                <a href="buy_pay_upd.php">クレジットカード情報を編集する</a>
            </div>

        </div>

        <?php
            // カード情報に抜けがなければ
            if( !empty($user["number"])
                && !empty($user["name"])
                && !empty($user["expiry"])
                && !empty($user["code"])){
                print "<div><a href='buy_check.php'>次へ</a></div>";
            }
        ?>

        <div class="back">
            <a href="buy_address.php">戻る</a>
        </div>

    </main>

    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

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