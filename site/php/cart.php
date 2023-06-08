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
}

// // セッションにユーザー情報があり、ログイン後に行動してから60分以内であるとき
// if(isset($_SESSION['id']) && $_SESSION['time'] + 3600>time()){
//     // ログインした時間を現在の時間に更新
//     $_SESSION['time']=time();
//     // セッション変数のidを使って、ユーザーの情報を呼び出す
//     $members=$db->prepare('SELECT * FROM user_info WHERE userID=?');
//     $members->execute(array($_SESSION['id']));
//     $member=$members->fetch();
//     // ログインしていないとき
// }else{
//     // 即時にログイン画面に転送する
//     header('Location: login.php');
//     exit();
// }

if (!empty($_POST)) {
    $delCart = $db->prepare('DELETE FROM t_carts WHERE f_user_id=? and f_item_id=?');
    $delCart->execute(array($user['f_user_id'], $_POST['delete']));

    header('Location: cart.php');
    exit();
}

$sql = 'SELECT c.f_item_id,c.f_item_num,i.f_item_name,i.f_item_price FROM t_carts c INNER JOIN t_items i ON c.f_item_id = i.f_item_id WHERE f_user_id=?';
$carts = $db->prepare($sql);
$carts->execute(array($user['f_user_id']));

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/cart.css"> <!-- cart.htmlで検証　こっちでもCSS適用されているかは未確認 -->


</head>

<body>
    <div id="wrap">
        <header>

            <div>
                <a href="menu.php">商品一覧</a>
            </div>

            <div>
                <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>

            <div id="header-right">
                <!-- ログインしていない時 -->
                <?php
                if (!empty($session["id"])) {
                ?>
                    <a href="login.php">ログイン/会員登録</a>
                    <!-- ログインしている時 -->
                <?php
                } else {
                ?>
                    <div>
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
                        <form action="my_page.php">
                            <input type="hidden" name="user_id" value="<?php $_SESSION["id"] ?>">
                            <a href="my_page.php"><?php print($user["f_user_name"]); ?></a>
                        </form>
                    </div>
                <?php
                }
                ?>

                <!-- どちらの場合でもカートは出す -->
                <div>
                    <a href="cart.php"><img class="headerimg" src="../images/cart.jpg" alt="カート"></a>
                </div>
            </div>

        </header>

        <main>

            <div id="cart">

                <h3>ショッピングカート</h3>


                <?php
                $sum = 0;
                for ($i = 0; $cart = $carts->fetch(); $i++) {

                    print('<div>');
                    // print('<button>pic</button>');
                    print('<p>' . $cart['f_item_name'] . '</p>');
                    print('<p>' . $cart['f_item_price'] . '円</p>');
                    print('<div id=plus_minus>'); //+-ボタン横並びにするためのid指定
                    print('<button onClick="down(this)">-</button>');
                    print('<p>' . $cart['f_item_num'] . '</p>');
                    print('<button onClick="up(this)">+</button>');
                    print('</div>'); //div id="plus_minus"閉じタグ
                    // print('<p class="smallSum">小計:' . $cart['f_item_price'] * $cart['f_item_num'] . '円</p>');
                    print('<form action="" method="post" enctype="multipart/form-data">');
                ?><input type="hidden" name="delete" value="<?php print($cart['f_item_id']); ?>">
                <?php
                    print('<input type="submit" value="削除" />');
                    print('</form>');
                    print('</div>');
                    $sum += $cart['f_item_price'] * $cart['f_item_num'];
                }
                ?>

            </div>

            <div id="pay">
                <div>
                    <p>合計</p>
                    <?php print('<p id="buySum">' . $sum . '円</p>'); ?>
                </div>
                <div id="button">
                    <a href="buy_address.php">レジに進む</a>
                    <!-- ここはformのinputのbutton -->
                </div>

            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

    <!-- jQuery -->
    <!-- <script src="js/jQuery.js"></script> -->
    <script src="../js/cart.js"></script>

</body>

</html>