<?php

    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlUser = '
        SELECT
            f_user_id,
            f_user_name,
            f_user_nick_name
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
    if (isset($_SESSION['id'])) {
        // ログインユーザーのIDを取得
        $userId = $_SESSION['id'];

        // ===================================================================================
        // DB検索
        // ===================================================================================
        // ユーザー情報取得
        $contents = $db->prepare($sqlUser);
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
    <title>購入完了</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">

</head>

<body>

    <!-- TODO: アカウント・カートを非表示にするならば個別実装が必要になるかもしれない -->
    <!-- <header>
        <h1>ミールフレンド</h1>
        <nav>
            <div>
                <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>
            <div id="header-right">
                <div id="user">
                    <label>
                        <img src="../images/icon.jpg" alt="アイコン">
                    </label>
                    <div>
                        <a href="my_page.php"><?php //print(h($user["nick_name"])) ?></a>
                    </div>
                </div>
            </div>
            <div id="gomypage">
                <a href="my_page.php">＜マイページ</a>
            </div>
        </nav>
    </header> -->

    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>

    <main>

        <!-- 進行度バー -->
        <div class="stepbar-row">
            <ol class="stepbar">
                <li class="done"><span></span><br />お届け先</li>
                <li class="done"><span></span><br />お支払方法</li>
                <li class="done"><span></span><br />完了</li>
            </ol>
        </div>

        <div class="container">
        <div class="row">
            <h2>お支払内容確認</h2>
        </div>

        <hr>

        <p>登録完了しました</p>
        <p>ありがとうございました</p>

        <div class="back"><a href="my_page.php">マイページへ</a></div>
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
