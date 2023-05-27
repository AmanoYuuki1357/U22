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

// $intakes = $db->prepare('SELECT * FROM t_intakes WHERE f_user_id=?');
// $intakes->execute(array($_SESSION["id"]));

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食事管理</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_manage.css">

</head>

<body>
    <div id="wrap">
        <header>

            <h2>
                ミールフレンド
            </h2>
            <div>
                <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
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
            <a href="my_page.php">＜マイページ</a>
        </div>
        <main>
            <div id="graph">
                <h2>グラフ</h2>
            </div>

            <div id="record">
                <h2>一覧</h2>
                <div>
                    <p>日付</p>
                    <p>・食べたもの</p>

                    <?php
                    while ($intake = $intakes->fetch()) {
                    ?>
                        <p><?php print($intake["f_intake_date"]); ?></p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
    </div>

</body>

</html>