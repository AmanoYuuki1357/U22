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
    <title>食事記録</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_record.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/meal_record.js"></script>

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

            <!-- ログインしていない時 -->

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
            <a href="my_page.php">＜マイページ</a>
        </div>
        <main>

            <div id="meal">
                <div id="tab_breakfast">
                    <h2>献立</h2>
                    <input type="text" name="search" size="15" id="search" placeholder="料理名を検索">
                    <button onclick="search()">検索</button>
                    <div>
                        <input type="radio" name="time" value="朝食">朝食
                        <input type="radio" name="time" value="昼飯">昼食
                        <input type="radio" name="time" value="夕飯">夕食
                        <input type="radio" name="time" value="その他" checked>その他
                    </div>

                    <div id="food_list">

                    </div>
                </div>

            <div id="table">
                <p>日付</p>
                <!-- table作成 -->
                <table border="1" id="menu">
                    <tr>
                        <th>メニュー</th>
                        <th>削除</th>
                    </tr>
                </table>
                <button>
                    <a onclick="regist(<?php print $user['f_user_id'] ?>)">登録</a>
                </button>
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