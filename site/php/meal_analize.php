<?php
// require('common.php');
// error_reporting(E_ALL & ~E_NOTICE);
// if (!isset($_SESSION)) {
//     session_start();
// }


// if (isset($_SESSION["id"])) {
//     $users = $db->prepare('SELECT * FROM t_users WHERE f_user_id=?');
//     $users->execute(array($_SESSION["id"]));
//     $user = $users->fetch();
// } else {
//     header('Location: login.php');
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食事分析</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_analize.css">

</head>

<body>
    <div id="wrap">
        <header>

            <h2>
                ミールフレンド
            </h2>
            <div>
                <a href="index.php"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>

            <div id="header-right">
                <?php
                if (!isset($_SESSION["id"])) {
                ?>
                    <a href="login.php">ログイン/会員登録</a>
                <?php
                } else {
                ?>
                    <div>
                        <img src="../images/icon.jpg" alt="アイコン">
                        <a href="my_page.php"><?php print($user["f_user_name"]); ?></a>
                    </div>
                <?php
                }
                ?>
            </div>

        </header>

        <div id="gomypage">
            <!-- パンクズ -->
            <a href="my_page.php">＜マイページ</a>
        </div>
        <main>
            <div>
                <h2>アドバイス</h2>
                <div id="advice">
                    <p>食事の記録がありません</p>
                </div>
            </div>

            <div id="recommend">
                <p>おすすめ商品</p>
                <a href="item_piece.html">鮭の塩焼き</a>
                <a href="item_piece.html">鮭の塩焼き</a>
                <a href="item_piece.html">鮭の塩焼き</a>
            </div>
        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
    </div>

</body>

</html>