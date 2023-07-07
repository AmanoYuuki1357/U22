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
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/cart.css">
    <!-- cart.htmlで検証　こっちでもCSS適用されているかは未確認 -->


</head>

<body>

    <!-- ヘッダー部分 -->
    <?php
    require('header.php');
    ?>

    <main class="d-flex">


        <!-- ショッピングカート -->
        <div id="cart" class="container">
            <h3>ショッピングカート</h3>

            <p id="userId" style="display: none;"><?php print($user["f_user_id"]); ?></p>

            <div class="row">
                <?php
                $sum = 0;
                for ($i = 0; $cart = $carts->fetch(); $i++) {

                    print('<div class="col-sm-12 col-md-3 col-lg-2 item-box">');
                    // print('<button>pic</button>');
                    print('<p id="itemId' . $cart['f_item_id'] . '">' . $cart['f_item_name'] . '</p>');
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
                    print('<input class="delete-button" type="submit" value="削除" />');
                    print('</form>');
                    print('</div>');
                    $sum += $cart['f_item_price'] * $cart['f_item_num'];
                }
                ?>

            </div>
        </div>



        <!-- 購入 -->
        <div id="pay">
            <div>
                <h2>合計</h2>
                <?php print('<p id="buySum">' . number_format($sum) . '円</p>'); ?>
            </div>
            <div id="button" class="button">
                <?php
                // カートに商品が入っている場合のみ遷移可
                if ($sum > 0) {
                    print '<a href="buy_address.php">レジに進む</a>';
                } else {
                    print '<span>カートに商品を追加してください</span>';
                }
                ?>
                <!-- ここはformのinputのbutton -->
            </div>

        </div>

    </main>

    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>


    <!-- jQuery -->
    <script src="../js/jQuery.js"></script>
    <script src="../js/cart.js"></script>


    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>