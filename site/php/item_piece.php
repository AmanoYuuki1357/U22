<!DOCTYPE html>

<?php
require "common.php";
require "test.php";
error_reporting(E_ALL & ~E_NOTICE);

// ===================================================================================
// SQL
// ===================================================================================
// ユーザー検索SQL
$sqlUser = '
    SELECT
        f_user_id,
        f_user_name,
        f_user_nick_name
    FROM
        t_users
    WHERE
        f_user_id = ? ;';

// 食品検索SQL
$sqlItems = '
        SELECT
            f_item_id                   AS id,
            f_item_name                 AS name,
            f_item_price                AS price,
            f_item_explain              AS ex,
            f_item_calorie              AS calorie,
            f_item_protein_vol          AS protein_vol,
            f_item_sugar_vol            AS sugar_vol,
            f_item_lipid_vol            AS lipid_vol,
            f_item_dietary_fiber_vol    AS dietary_fiber_vol,
            f_item_salt_vol             AS salt_vol,
            f_item_materials            AS materials,
            f_item_save_way             AS save_way,
            f_item_use_by_date          AS use_by_date,
            f_item_image                AS image
        FROM
            t_items
        WHERE
            f_item_id = ? ;';

// ジャンル検索SQL
$sqlGenres = '
        SELECT
            type.f_item_genre_id        AS id,
            genre.f_item_genre_name     AS name
        FROM
            t_item_types    as type
        JOIN
            t_item_genre    as genre
        ON
            type.f_item_genre_id = genre.f_item_genre_id
        WHERE
            type.f_item_id = ? ;';

// アレルギー検索SQL
$sqlAllergens = '
        SELECT
            f_item_allergen_wheat       AS "小麦",
            f_item_allergen_egg         AS "卵",
            f_item_allergen_milk        AS "乳",
            f_item_allergen_soba        AS "そば",
            f_item_allergen_shrimp      AS "えび",
            f_item_allergen_crab        AS "かに",
            f_item_allergen_peanut      AS "落花生",
            f_item_allergen_pork        AS "豚肉",
            f_item_allergen_chicken     AS "鶏肉",
            f_item_allergen_beef        AS "牛肉",
            f_item_allergen_salmon      AS "さけ",
            f_item_allergen_mackerel    AS "さば",
            f_item_allergen_soy         AS "大豆",
            f_item_allergen_squid       AS "いか",
            f_item_allergen_yamaimo     AS "やまいも",
            f_item_allergen_orange      AS "オレンジ",
            f_item_allergen_sesame      AS "ごま",
            f_item_allergen_cashew_nuts AS "カシューナッツ",
            f_item_allergen_abalone     AS "あわび",
            f_item_allergen_ikura       AS "いくら",
            f_item_allergen_kiwi        AS "キウイフルーツ",
            f_item_allergen_banana      AS "バナナ",
            f_item_allergen_peaches     AS "もも",
            f_item_allergen_apple       AS "りんご",
            f_item_allergen_walnut      AS "くるみ",
            f_item_allergen_matsutake   AS "まつたけ",
            f_item_allergen_gelatin     AS "ゼラチン",
            f_item_allergen_almond      AS "アーモンド"
        FROM
            t_item_allergens
        WHERE
            f_item_id = ? ;';

// レビュー検索SQL
$sqlReviews = '
        SELECT
            review.f_review_date    AS date,
            user.f_user_nick_name   AS nick_name,
            review.f_review_point   AS point,
            review.f_review         AS review
        FROM
            t_item_review           AS review
        JOIN
            t_users                 AS user
        ON
            review.f_user_id = user.f_user_id
        where
            review.f_item_id = ?
        ORDER BY
            f_review_date DESC';

// カート検索SQL
$sqlCarts = '
        SELECT
            f_item_num      AS num
        FROM
            t_carts
        WHERE
            f_item_id = ?
        AND
            f_user_id = ?;';

// ===================================================================================
// 関数
// ===================================================================================
// IDによる検索(汎用)
function showById($db, $sql, $id)
{
    $contents = $db->prepare($sql);
    $contents->bindparam(1, $id, PDO::PARAM_INT);
    $contents->execute();

    return $contents->fetchAll(PDO::FETCH_ASSOC);
}

// カート検索
function showCart($db, $sql, $itemId, $userId)
{
    $contents = $db->prepare($sql);
    $contents->bindparam(1, $itemId, PDO::PARAM_INT);
    $contents->bindparam(2, $userId, PDO::PARAM_INT);
    $contents->execute();

    return $contents->fetch(PDO::FETCH_ASSOC);
}

// 画像URLのテキストを返す
function imageUrl($str)
{
    return "../images/items/" . $str . ".jpg";
}

// ===================================================================================
// セッション開始
// ===================================================================================
if (!isset($_SESSION)) {
    session_start();
}

// ===================================================================================
// getの取得
// ===================================================================================
// 商品ID取得
if (isset($_GET['id'])) {
    // 前ページから渡された商品IDの取得
    $itemId = $_GET['id'];
} else {
    // 商品のIDが取得できないときは商品一覧へ遷移する
    header('Location: ./menu.php');
}

// REVIEW: オブジェクト生成
$test = new test();

// ===================================================================================
// レビュー登録
// ===================================================================================
if (isset($_POST['post_review'])) {
    // POST送信された情報を取得
    $itemId     = $_POST['review_itemid'];     // 食品ID
    $userId     = $_POST['review_userid'];     // ユーザーID
    $point      = $_POST['review_point'];      // ポイント
    $comment    = $_POST['review_comment'];    // コメント

    $sql = '
        INSERT INTO
            t_item_review
        VALUES
            (
                NOW(),
                ?,
                ?,
                ?,
                ?
            )';

    // レビュー登録処理
    $contents = $db->prepare($sql);
    $contents->bindparam(1, $itemId, PDO::PARAM_INT);
    $contents->bindparam(2, $userId, PDO::PARAM_INT);
    $contents->bindparam(3, $point, PDO::PARAM_INT);
    $contents->bindparam(4, $comment, PDO::PARAM_STR);
    $updateUser = $contents->execute();

    // TODO: 入力処理の成功失敗の制御をする

    // 二重送信防止のためリダイレクト
    header("Location:./item_piece.php?id=" . $itemId);
    exit;
}

// ===================================================================================
// DB検索
// ===================================================================================
$item       = showById($db, $sqlItems, $itemId)[0];         // 食品詳細検索
$genres     = showById($db, $sqlGenres, $itemId);           // 食品ジャンル検索
$allergens  = showById($db, $sqlAllergens, $itemId)[0];     // 食品アレルゲン検索
$reviews    = showById($db, $sqlReviews, $itemId);          // 食品レビュー検索

if (empty($item)) {
    // 商品情報が取得できないときは商品一覧へ遷移する
    header('Location: ./menu.php');
}

// ログインしている場合、カートTBLから情報を取得する
if (isset($_SESSION['id'])) {
    // ログインユーザーのIDを取得
    $userId = $_SESSION['id'];

    // カート内情報検索
    $cart = showCart($db, $sqlCarts, $itemId, $userId);
    $user = showById($db, $sqlUser, $userId)[0];
} else {
    // REVIEW: 確認ログ
    $test->warn("[NG]ユーザーなし");
}

// REVIEW: 確認ログ
$test->get(empty($item), "食品TBL");
$test->get(empty($genres), "ジャンルTBL");
$test->get(empty($allergens), "アレルゲンTBL");
$test->get(empty($reviews), "レビューTBL");
$test->get(empty($cart), "カートTBL");
$test->get(empty($user), "ユーザーTBL");
?>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/item_piece.css">

    <!-- 商品個別画面 -->
    <title><?php print $item['name']; ?> | ミールフレンド</title>

</head>

<body>

    <!-- ヘッダー部分 -->
    <?php
    require('header.php');
    ?>

    <div id="gomenu">
        <a href="./menu.php">＜メニュー一覧</a>
    </div>

    <main>


        <div class="row col-sm-6 col-md-12">
            <div id="meal_genre">
                <p class="Subheading">食品ジャンル:</p>
                <ul class='genre'>
                    <?php
                    if (!empty($genres)) {
                        // ジャンル情報が取得できた場合
                        foreach ($genres as $genre) {
                            print "<li>" . h($genre['name']) . "　|　</li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <div id="itemimg" class="col">
                <!-- 画像表示 -->
                <img class="item-image" id="piece_img" src=<?php print imageUrl($item['image']); ?> alt="商品画像">

                <div id="review">
                    <h2>レビュー</h2>
                    <p>全<?php print count($reviews) ?>件</p>

                    <!-- <div class="overflow-scroll" style="height: 200px;"> -->
                    <div class="Review-column">
                        <?php
                        if (empty($reviews)) {
                            // レビュー情報が取得できない場合
                            print "<p>まだレビューはありません</p>";
                        } else {
                            // レビュー情報が取得できた場合
                            foreach ($reviews as $review) {
                                print "
                                    <div style='border-bottom: 1px #000 dotted'>
                                        <p>" . h($review['date']) . "</p>
                                        <dl>
                                            <dt>投稿者名</dt>
                                                <dd>" . h($review['nick_name']) . "</dd>
                                            <dt>評価</dt>
                                                <dd>" . strNumToStar($review['point']) . "</dd>
                                            <dt>コメント</dt>
                                                <dd>" . h($review['review']) . "</dd>
                                        </dl>
                                    </div>";
                            }
                        }
                        ?>
                    </div>

                    <!-- Todo: 購入履歴に応じてレビュー登録ボタンを表示する -->
                    <!-- <a id='go_review' href=''>レビューを書く</a> -->
                    <?php
                    if (isset($_SESSION["id"])) {
                        print '<button
                                        type="button"
                                        class="review-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#reviewModal"
                                        data-bs-whatever="@getbootstrap">レビューを書く</button>';
                    }
                    ?>

                </div>
            </div>

            <div id="iteminfo" class="col">
                <!-- 商品名 -->
                <h2><?php print h($item['name']); ?></h2>

                <dl>
                    <dt class="Subheading">値段</dt>
                    <dd><?php print h(number_format($item['price'])); ?>円</dd>
                </dl>

                <dl>
                    <dt class="Subheading">商品説明</dt>
                    <dd><?php print h($item['ex']); ?></dd>
                </dl>

                <p class="Subheading">アレルゲン</p>
                <ul>
                    <?php
                    // TODO:該当食品だけ表示
                    // print_r($allergens);
                    foreach ($allergens as $key => $allergen) {
                        if ($allergen == 1) {
                            print "<li>" . h($key) . "</li>";
                        }
                    }



                    ?>
                </ul>

                <table class="table">
                    <tr>
                        <th scope="col">カロリー</th>
                        <th scope="col">たんぱく質</th>
                        <th scope="col">糖質</th>
                        <th scope="col">脂質</th>
                        <th scope="col">食物繊維</th>
                        <th scope="col">塩分</th>
                    </tr>
                    <tr>
                        <td><?php print h($item['calorie']); ?>kcal</td>
                        <td><?php print h($item['protein_vol']); ?>g</td>
                        <td><?php print h($item['sugar_vol']); ?>g</td>
                        <td><?php print h($item['lipid_vol']); ?>g</td>
                        <td><?php print h($item['dietary_fiber_vol']); ?>g</td>
                        <td><?php print h($item['salt_vol']); ?>g</td>
                    </tr>
                </table>

                <dl>
                    <dt>原材料</dt>
                    <dd><?php print h($item['materials']); ?></dd>
                </dl>

                <dl>
                    <dt>保存方法</dt>
                    <dd><?php print h($item['save_way']); ?></dd>
                </dl>

                <dl>
                    <dt>賞味期限</dt>
                    <dd><?php print h($item['use_by_date']); ?></dd>
                </dl>

                <div>
                    <!-- <div><button>お気に入り</button></div> -->

                    <div id="itemId<?php print($itemId); ?>">
                        <p id="userId" style="display: none;"><?php print($userId); ?></p>
                        <?php
                        if (isset($userId)) {
                            if (isset($cart['num'])) {
                                print('<a class="go-cart" href="./cart.php">カートに移動する</a>');
                            } else {
                                print('<button class="into-cart" onClick="inCart(this)">カートに入れる</button>');
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    <!-- レビュー記入ウィンドウ -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <!-- ヘッダー -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php print $item['name'] ?>のレビューを書きましょう</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- 商品情報 -->
                    <div class="mb-3 row">
                        <figure class="col">
                            <img id="piece_img" src=<?php print imageUrl($item['image']); ?> alt="商品画像">
                        </figure>
                        <div class="col">
                            <h3><?php print $item['name'] ?></h3>
                            <p>価格</p>
                            <p><?php print $item['price'] ?>円</p>
                            <p>商品説明</p>
                            <p><?php print $item['ex'] ?></p>
                        </div>
                    </div>

                    <p>ニックネーム</p>
                    <p><?php print $user['f_user_nick_name'] ?>さん</p>

                    <!-- レビュー入力 -->
                    <form action="" method="post">
                        <input type="hidden" name="review_itemid" value="<?php print $item['id'] ?>">
                        <input type="hidden" name="review_userid" value="<?php print $user['f_user_id'] ?>">

                        <!-- レビュー点数 -->
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">点数</label>
                            <input type="number" class="form-control" name="review_point" maxlength="5">
                        </div>

                        <!-- レビュー内容 -->
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">コメント</label>
                            <textarea class="form-control" name="review_comment"></textarea>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">やめる</button>
                    <!-- <button type="button" class="btn btn-primary" id="button_review_post" data-bs-dismiss="modal">投稿する</button> -->
                    <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="post_review" value="投稿する" />
                </div>
                </form>
            </div>

        </div>
    </div>


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


    <script src="../js/jQuery.js"></script>
    <script src="../js/item_piece.js"></script>

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>