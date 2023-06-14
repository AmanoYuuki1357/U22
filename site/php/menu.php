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

// ジャンルを取り出す
$sql = 'SELECT f_item_genre_name FROM t_item_genre';
$genres = $db->query($sql);

// 商品情報を取り出す
// 本当は販売履歴と結合してランキングにする
$sql2 = 'SELECT f_item_id,f_item_name,f_item_price,f_item_image FROM t_items';
$items = $db->query($sql2);

// カートのitem_idを取り出す
$sql3 = 'SELECT f_item_id FROM t_carts WHERE f_user_id=?';
$carts = $db->prepare($sql3);
$carts->execute(array($user["f_user_id"]));
$cartItemId = [];
while ($cart = $carts->fetch()) {
    array_push($cartItemId, $cart["f_item_id"]);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">

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
                if (!isset($_SESSION["id"])) {
                ?>
                    <a href="login.php">ログイン/会員登録</a>
                    <!-- ログインしている時 -->
                <?php
                } else {
                ?>
                    <div>
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
                        <a href="my_page.php"><?php print($user["f_user_nick_name"]); ?></a>
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

            <div id="box">

                <h3>メニュー選択</h3>

                <select name='genre'>
                    <option value='all'>すべて</option>
                    <?php
                    for ($i = 0; $genre = $genres->fetch(); $i++) {
                        print('<option value={$i}>' . $genre['f_item_genre_name'] . '</option>');
                    }
                    ?>
                </select>

                <select name='allergen'>
                    <option value='filter'>食材フィルタ</option>
                    <?php
                    for ($i = 0; $i != count($allergens); $i++) {
                        print('<option value={$i}>' . $allergens[$i] . '</option>');
                    }
                    ?>
                </select>

                <select name='allergen'>
                    <option value='filter'>ソート</option>
                    <?php
                    for ($i = 0; $i != count($sorts); $i++) {
                        print('<option value={$i}>' . $sorts[$i] . '</option>');
                    }
                    ?>
                </select>

                <div>
                    <table>

                        <p id="userId" style="display: none;"><?php print($user["f_user_id"]); ?></p>

                        <?php
                        // print("<h1>");
                        // print_r($cartItemId);
                        // print("<h1>");
                        for ($i = 0; $item = $items->fetch(); $i++) {
                            if ($i % 4 == 0) {
                                print('<tr>');
                            }
                            print('<td>');
                            print('<a href="item_piece.php?id=' . $item['f_item_id'] . '" id="itemId' . $item['f_item_id'] . '">');
                            print('<img id="menu_img" src="../images/items/' . $item['f_item_image'] . '.jpg" alt=' . $item['f_item_name'] . '>');
                            print('<p>' . $item['f_item_name'] . '</p>');
                            print('<p>' . $item['f_item_price'] . '円</p>');
                            print('</a>');
                            if(isset($user["f_user_id"])){
                                if(in_array($i+1,$cartItemId)){
                                    print('<a href="./cart.php">カートに移動する</a>');
                                }else{
                                    print('<button onClick="inCart(this)">カートに入れる</button>');
                                }
                            }
                            print('</td>');
                            if ($i % 4 == 3) {
                                print('</tr>');
                            }
                        }
                        ?>

                    </table>

                </div>

            </div>

        </main>

        <footer>
            <!-- コピーライト -->
            <small>&copy; 2023 ミールフレンド all right reserved</small>
        </footer>

    </div>


    <!-- jQuery -->
    <script src="../js/jQuery.js"></script>
    <script src="../js/menu.js"></script>


    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>