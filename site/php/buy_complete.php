<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlUser = '
    SELECT
        f_user_nick_name    AS nick_name
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
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">

</head>

<body>
    <div id="wrap">

        <header>
            <h1>ミールフレンド</h1>
            <nav>
                <div>
                    <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
                </div>

                <div id="header-right">
                    <!-- ログインしている時 -->
                    <!-- ユーザーメニュー -->
                    <div id="user">
                        <label>
                            <img src="../images/icon.jpg" alt="アイコン">
                        </label>
                        <div>
                            <a href="my_page.php"><?php print(h($user["nick_name"])) ?></a>
                        </div>
                    </div>
                </div>
                <div id="gomypage">
                    <a href="my_page.php">＜マイページ</a>
                </div>
            </nav>
        </header>

        <main>

            <!-- 進行度バー -->
            <div class="stepbar-row">
                <ol class="stepbar">
                    <li class="done"><span></span><br />お届け先</li>
                    <li class="done"><span></span><br />お支払方法</li>
                    <li class="done"><span></span><br />完了</li>
                </ol>
            </div>

            <p>登録完了しました</p>
            <p>ありがとうございました</p>

            <div class="back"><a href="my_page.php">マイページへ</a></div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

</body>

</html>