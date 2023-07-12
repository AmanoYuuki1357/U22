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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">

</head>

<body>

<!-- ヘッダー部分 -->
<?php
require('header.php');
?>




    <main>

        <div id="box">

            <h3>メニュー選択</h3>

            <select onChange="sort(this)" name='genre'>
                <option value="all">ジャンル</option>
                <?php
                for ($i = 0; $genre = $genres->fetch(); $i++) {
                    print('<option value='.$genre['f_item_genre_name'].'>' . $genre['f_item_genre_name'] . '</option>');
                }
                ?>
            </select>

            <!-- <select onChange="sort2(this)" name='allergen'>
                <option value='all'>食材フィルタ</option>
                <?php
                // for ($i = 0; $i != count($allergens); $i++) {
                //     print('<option value='.$allergensEng[$i].'>' . $allergens[$i] . '</option>');
                // }
                ?>
            </select> -->
            <button type="button" class="review-btn" data-bs-toggle="modal" data-bs-target="#reviewModal" data-bs-whatever="@getbootstrap">食材フィルタ</button>

            <!-- <select onChange="sort3(this)" name='allergen'>
                <option value='def'>ソート(多い順)</option>
                <?php
                // for ($i = 0; $i != count($sorts); $i++) {
                //     print('<option value='.$sortsEng[$i].'>' . $sorts[$i] . '</option>');
                // }
                ?>
            </select> -->

            <div>
                <div class="container">

                    <p id="userId" style="display: none;"><?php print($user["f_user_id"]); ?></p>

                    <div class="row" id="listNum">
                        <?php
                        // print("<h1>");
                        // print_r($cartItemId);
                        // print("<h1>");
                        for ($i = 0; $item = $items->fetch(); $i++) {

                            // print('<div class="row">');

                            // print('<div class="col-sm-6 col-md-3 col-lg-2 item-box" id="'.$i+1.'">');
                            ?>
                            <div class="col-sm-6 col-md-3 col-lg-2 item-box" id="<?php print($item["f_item_id"]); ?>">
                            <?php
                            print('<a href="item_piece.php?id=' . $item['f_item_id'] . '" id="itemId' . $item['f_item_id'] . '">');
                            print('<img id="menu_img" src="../images/items/' . $item['f_item_image'] . '.jpg" alt=' . $item['f_item_name'] . '>');
                            print('<h4 class="item-info">' . $item['f_item_name'] . '</h4>');
                            print('<p class="item-info">' . $item['f_item_price'] . '円</p>');
                            print('</a>');
                            if (isset($user["f_user_id"])) {
                                if (in_array($i + 1, $cartItemId)) {
                                    print('<a class="go-cart" href="./cart.php">カートに移動する</a>');
                                } else {
                                    print('<button class="into-cart" onClick="inCart(this)">カートに入れる</button>');
                                }
                            }
                            print('</div>');
                        }
                        ?>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <footer>
        <!-- コピーライト -->
        <small>&copy; 2023 ミールフレンド all right reserved</small>
    </footer>

    <!-- 食材フィルタ記入ウィンドウ -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <!-- ヘッダー -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">避けたい食材を選択してください</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>

                <form action="" method="post">
                    <div class="modal-body" id="filter">
                        <?php
                        for ($i = 0; $i != count($allergens); $i++) {
                            print('<label><input type="checkbox" value='.$allergensEng[$i].' />' . $allergens[$i] . '</label>');
                        }
                        ?>
                    </div>

                    <div class="modal-footer">
                        <p>食事の好みを設定することで、苦手食材以外からメニューを選択できます。</p>
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">やめる</button> -->
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="filter()">反映<button>
                        <!-- <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="post_review" onclick="filter()" value="閉じる" /> -->
                    </div>
                </form>

        </div>
    </div>


    <!-- jQuery -->
    <script src="../js/jQuery.js"></script>
    <script src="../js/menu.js"></script>


    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>