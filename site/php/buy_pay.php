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
            SUBSTRING(f_user_credit_number, 13)    AS number,
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

        <div class="container">
            <div class="row">
                <h2>クレジットカード情報</h2>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-2">
                    <p>カード番号</p>
                </div>
                <div class="col">
                    <p <?php empty($user["number"]) && print"style='color: red'" ?> >
                    <?php 
                        print empty($user["number"])
                        ? "登録されていません"
                        : h( '**** **** **** ' . $user["number"] );
                    ?>
                    </p>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>カード名義人</p>
                </div>
                <div class="col">
                    <p <?php empty($user["name"]) && print"style='color: red'" ?> >
                    <?php 
                        print empty($user["name"])
                        ? "登録されていません"
                        : h( $user["name"] );
                    ?>
                    </p>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>有効期限</p>
                </div>
                <div class="col">
                    <p <?php empty($user["expiry"]) && print"style='color: red'" ?> >
                    <?php 
                        if (empty($user["expiry"])){
                            print "登録されていません";
                        }
                        else{
                            $dates = str_split($user["expiry"], 4);
                            print $dates[0] . "年" . $dates[1] . "月" ;
                        }
                    ?>
                    </p>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>セキュリティコード</p>
                </div>
                <div class="col">
                    <p>【表示されません】</p>
                </div> 
            </div>

            <div>
                <a href="buy_pay_upd.php" class="btn btn-primary">クレジットカード情報を編集する</a>
            </div>

        </div>

        <div class="d-md-flex justify-content-center">
            <a href="buy_address.php" class="btn btn-secondary me-md-2">お届け先確認へ戻る</a>
        <?php
            // カード情報に抜けがなければ
             !empty($user["number"])
            && !empty($user["name"])
            && !empty($user["expiry"])
            && !empty($user["code"])
            && print "<a href='buy_check.php' class='btn btn-primary px-4'>購入確認へ進む</a>";
        ?>
        </div>


    </main>

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