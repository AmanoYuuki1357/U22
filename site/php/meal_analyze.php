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
} else {
    header('Location: login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食事分析</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_analize.css">

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
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
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
                    <?php
                    $advices = $db->prepare("SELECT * FROM t_intakes WHERE f_intake_date LIKE '%'?'%' AND f_user_id=?");
                    $advices->execute(array(date("Y-m-d"),$_SESSION["id"]));
                    // print(date("Y-m-d"));

                    if(!isset($user["f_user_gender"],$user["f_user_age"],$user["f_user_height"],$user["f_user_weight"])){
                        print("プロフィールを登録してください");
                    }else if (isset($advices) ){
                        while($advice= $advices->fetch()){
                        }
                    }else{
                        print("アドバイスはありません");
                    }
                    ?>
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


    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>