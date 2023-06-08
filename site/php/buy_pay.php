<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);

// ===================================================================================
// セッション開始
// ===================================================================================
if (!isset($_SESSION)) {
    session_start();
}


// ユーザーID取得
if (isset($_SESSION['id'])) {
    // ログインユーザーのIDを取得
    $userId = $_SESSION['id'];
}

// if(!empty($_POST)){
//     $statement=$db->prepare('UPDATE user_info SET CardNumber=?,CardName=?,CardEMonth=?,CardEYear=?,CardCode=? WHERE userID=?');
//     //echo $ret=$statement->execute(array(
//     $cnt = $statement->execute(array(
//         sha1($_SESSION['join']['c_number']),
//         sha1($_SESSION['join']['c_name']),
//         sha1($_SESSION['join']['c_e_month']),
//         sha1($_SESSION['join']['c_e_year']),
//         sha1($_SESSION['join']['c_code']),
//         $_SESSION['id']
//     ));
//     header('Location: c_complete.php');
//     exit();
// }

// // ヘッダーのアイコン
// $icons=$db->prepare('SELECT userIcon FROM user_info WHERE userID=?');
// $icons->execute(array($_SESSION['id']));
// $icon=$icons->fetch();

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
                <!-- ログインしていない時 -->

                <!-- ログインしている時 -->
                <!-- ユーザーメニュー -->
                <div id="user">
                    <div>
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
                    </div>
                    <div>
                        <a href="my_page.php">ニックネーム</a>
                        <!-- <a href="my_page.php"><?php print(h($user["userNickName"])) ?></a> -->
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
                        <!-- <?php echo h($_SESSION['join']['c_number']); ?> -->
                        xxxx
                    </p>
                    <p>カード名義人</p>
                    <p>
                        <!-- <?php echo h($_SESSION['join']['c_name']); ?> -->
                        xxxx
                    </p>
                    <p>有効期限(月/年)</p>
                    <p>
                        <!-- <?php echo h($_SESSION['join']['c_e_month']) . '/' . h($_SESSION['join']['c_e_year']); ?> -->
                        xxxx
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
                <a href="buy_complete.html">次へ</a>
            </div>
            <div class="back">
                <a href="buy_address.html">戻る</a>
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