<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlcredit = '
        SELECT
            f_user_nick_name        AS nick_name,
            f_user_credit_number    AS number,
            f_user_credit_name      AS name,
            f_user_credit_expiry    AS expiry
        FROM
            t_users
        WHERE
            f_user_id = ? ;';

    // ===================================================================================
    // 初期値
    // ===================================================================================
    // $userId     = 0;        // ユーザーID(ゲストユーザー)
    $userId     = 1;        // REVIEW: ユーザーID(テスト用)

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
    }
    else{
        // ログインページへ
        // header('Location: login.php');
    }    

    // ===================================================================================
    // DB検索
    // ===================================================================================
    // ユーザー情報取得
    $contents = $db->prepare($sqlcredit);
    $contents->bindparam(1, $userId, PDO::PARAM_INT);
    $contents->execute();
    $credit = $contents->fetch();

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入カード情報</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
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

                <!-- ログインしている時 -->
                <!-- ユーザーメニュー -->
                <div id="user">
                    <div>
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
                    </div>
                    <div>
                        <a href="my_page.php"><?php print(h($credit["nick_name"])) ?></a>
                    </div>
                </div>

                <!-- どちらの場合でもカートは出す -->
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

                <div>
                    <p>カード番号</p>
                    <p>
                        <?php echo h( '**** **** **** ' . substr($credit['number'], 12, 4) ); ?>
                    </p>
                    <p>カード名義人</p>
                    <p>
                        <?php echo h($credit['name']); ?>
                    </p>
                    <p>有効期限(月/年)</p>
                    <p>
                        <?php echo h(substr($credit['expiry'], 0, 2) . "/". substr($credit['expiry'], 2)); ?>
                    </p>
                    <p>セキュリティコード</p>
                    <p>
                        【表示されません】
                    </p>
                </div>
                <div>
                    <a href="">クレジットカード情報を編集する</a>
                </div>

            </div>

            <div>
                <a href="buy_complete.php">次へ</a>
            </div>
            <div class="back">
                <a href="buy_address.php">戻る</a>
            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

    <!-- jQuery -->
    <!-- <script src="js/JQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

</body>
<style>
    .stepbar-row {
        position: relative;
        top: 20px;
    }
</style>

</html>