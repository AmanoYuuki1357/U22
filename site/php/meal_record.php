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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_record.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/meal_record.js"></script>

</head>

<body>
    <!-- ヘッダー部分 -->
    <?php
    require('header.php');
    ?>

    <div id="gomypage">
        <a href="my_page.php">＜マイページ</a>
    </div>
    <main>

            <!-- 検索する場所 -->
            <div id="meal" class="row content">
                <div id="tab_breakfast" class="col col-lg-6">
                    <h2>献立</h2>
                    <p>ミールフレンドの商品から食事登録する</p>
                    <input type="text" name="search" size="15" id="search" placeholder="料理名を検索">
                    <button onclick="search()">検索</button>
                    <div id="food_list">
                        <!-- 検索結果の生成スペース -->
                    </div>


                    <h2>AI登録</h2>
                    <p>画像から食事登録する</p>
                    <!-- AI用のスペース -->
                    <input type="file">



                </div>

                <!-- 結果を表示する場所 -->
                <div id="table" class="col col-lg-6">
                    <label for="datetime">日時を選択してください:</label>
                    <input type="datetime-local" id="datetime" name="datetime">
                    <!-- table作成 -->
                    <table id="menu">
                        <tr>
                            <th>メニュー名</th>
                            <th>削除ボタン</th>
                        </tr>
                    </table>
                    <button>
                        <a onclick="regist(<?php print $user['f_user_id'] ?>)">登録</a>
                    </button>
                </div>

            </div>

    </main>

    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    <!-- コンテンツが短い時にfooterをwindow最下部に固定する -->
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

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>