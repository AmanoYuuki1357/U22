
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
        f_user_nick_name        AS nick_name
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
            f_item_allergen_wheat       AS wheat,
            f_item_allergen_egg         AS egg,
            f_item_allergen_milk        AS milk,
            f_item_allergen_soba        AS soba,
            f_item_allergen_shrimp      AS shrimp,
            f_item_allergen_crab        AS crab,
            f_item_allergen_peanut      AS peanut,
            f_item_allergen_pork        AS pork,
            f_item_allergen_chicken     AS chicken,
            f_item_allergen_beef        AS beef,
            f_item_allergen_salmon      AS salmon,
            f_item_allergen_mackerel    AS mackerel,
            f_item_allergen_soy         AS soy,
            f_item_allergen_squid       AS squid,
            f_item_allergen_yamaimo     AS yamaimo,
            f_item_allergen_orange      AS orange,
            f_item_allergen_sesame      AS sesame,
            f_item_allergen_cashew_nuts AS cashew_nuts,
            f_item_allergen_abalone     AS abalone,
            f_item_allergen_ikura       AS ikura,
            f_item_allergen_kiwi        AS kiwi,
            f_item_allergen_banana      AS banana,
            f_item_allergen_peaches     AS peaches,
            f_item_allergen_apple       AS apple,
            f_item_allergen_walnut      AS walnut,
            f_item_allergen_matsutake   AS matsutake,
            f_item_allergen_gelatin     AS gelatin,
            f_item_allergen_almond      AS almond
        FROM
            t_item_allergens
        WHERE
            f_item_id = ? ;';

// レビュー検索SQL
$sqlReviews = '
        SELECT
            f_review_date               AS date,
            f_review_point              AS point,
            f_review                    AS review
        FROM
            t_item_review    AS review
        where
            review.f_item_id = ?
        ORDER BY
            f_review_date DESC
        LIMIT 0, 2';

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

// カート登録SQL
$insertCarts = 'INSERT INTO t_carts VALUES( ?, ?, ? );';

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
}
else{
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/item_piece.css">

    <!-- 商品個別画面 -->
    <title><?php print $item['name']; ?> | ミールフレンド</title>

</head>

<body>
    <div id="wrap">
        <header>
            <h1>ミールフレンド</h1>
            <nav>
                <div>
                    <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
                </div>

                <div id="header-right">
                    <!-- マイページ/ログイン -->
                    <?php
                    if (isset($_SESSION['id'])) {
                        print '
                            <div id="user">
                                <label>
                                    <img class="headerimg"  src="../images/icon.jpg" alt="アイコン">
                                </label>
                                <div>
                                    <a href="my_page.php">' . h($user['nick_name']) . '</a>
                                </div>
                            </div>
                            <div>
                                <a href="cart.php"><img style="width: 50px;" src="../images/cart.jpg" alt="カート"></a>
                            </div>';
                    } else {
                        print "<a href='login.php'>ログイン/会員登録</a>";
                    }
                    ?>
                </div>
            </nav>

        </header>
        <div id="gomenu">
            <a href="./menu.php">＜メニュー一覧</a>
        </div>


        <main>

            <div>
                <div id="meal_genre">
                    <p>食品ジャンル:</p>
                    <ul>
                        <?php
                        if (!empty($genres)) {
                            // ジャンル情報が取得できた場合
                            foreach ($genres as $genre) {
                                print "<li>" . h($genre['name']) . "|</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div id="itemimg">
                    <!-- 画像表示 -->
                    <img id="piece_img" src=<?php print imageUrl($item['image']); ?> alt="商品画像">

                    <div id="review">
                        <h2>レビュー</h2>

                        <div>
                            <?php
                            if (empty($reviews)) {
                                // レビュー情報が取得できない場合
                                print "<p>まだレビューはありません</p>";
                            } else {
                                // レビュー情報が取得できた場合
                                foreach ($reviews as $review) {

                                    print "
                                <div>
                                    <dl>
                                        <dt>日付</dt>
                                            <dd>" . h($review['date']) . "</dd>
                                        <dt>評価</dt>
                                            <dd>" . strNumToStar($review['point']) . "</dd>
                                        <dt>コメント</dt>
                                            <dd>" . h($review['review']) . "</dd>
                                    </dl>
                                </div>";
                                }

                                print "<a id='go_review' href='review.php?id={$itemId}&page=1'>レビューを見る</a>";
                            }
                            ?>
                        </div>

                    </div>
                </div>

                <div id="iteminfo">
                    <!-- 商品名 -->
                    <h2><?php print h($item['name']); ?></h2>

                    <dl>
                        <dt>値段</dt>
                        <dd><?php print h($item['price']); ?>円</dd>
                    </dl>

                    <dl>
                        <dt>商品説明</dt>
                        <dd><?php print h($item['ex']); ?></dd>
                    </dl>

                    <p>アレルゲン</p>
                    <ul>
                        <?php
                        // TODO:該当食品だけ表示
                        print $allergens['wheat'] ? "<li>小麦</li>" : "";
                        print $allergens['egg'] ? "<li>卵</li>" : "";
                        print $allergens['milk'] ? "<li>乳</li>" : "";
                        print $allergens['soba'] ? "<li>そば</li>" : "";
                        print $allergens['shrimp'] ? "<li>えび</li>" : "";
                        print $allergens['crab'] ? "<li>かに</li>" : "";
                        print $allergens['peanut'] ? "<li>落花生</li>" : "";
                        print $allergens['pork'] ? "<li>豚肉</li>" : "";
                        print $allergens['chicken'] ? "<li>鶏肉</li>" : "";
                        print $allergens['beef'] ? "<li>牛肉</li>" : "";
                        print $allergens['salmon'] ? "<li>さけ</li>" : "";
                        print $allergens['mackerel'] ? "<li>さば</li>" : "";
                        print $allergens['soy'] ? "<li>大豆</li>" : "";
                        print $allergens['squid'] ? "<li>いか</li>" : "";
                        print $allergens['yamaimo'] ? "<li>やまいも</li>" : "";
                        print $allergens['orange'] ? "<li>オレンジ</li>" : "";
                        print $allergens['sesame'] ? "<li>ごま</li>" : "";
                        print $allergens['cashew_nuts'] ? "<li>カシューナッツ</li>" : "";
                        print $allergens['abalone'] ? "<li>あわび</li>" : "";
                        print $allergens['ikura'] ? "<li>いくら</li>" : "";
                        print $allergens['kiwi'] ? "<li>キウイフルーツ</li>" : "";
                        print $allergens['banana'] ? "<li>バナナ</li>" : "";
                        print $allergens['peaches'] ? "<li>もも</li>" : "";
                        print $allergens['apple'] ? "<li>りんご</li>" : "";
                        print $allergens['walnut'] ? "<li>くるみ</li>" : "";
                        print $allergens['matsutake'] ? "<li>まつたけ</li>" : "";
                        print $allergens['gelatin'] ? "<li>ゼラチン</li>" : "";
                        print $allergens['almond'] ? "<li>アーモンド</li>" : "";
                        ?>
                    </ul>

                    <table>
                        <tr>
                            <th>カロリー</th>
                            <th>たんぱく質</th>
                            <th>糖質</th>
                            <th>脂質</th>
                            <th>食物繊維</th>
                            <th>塩分</th>
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
                        <div>
                            <button>
                                お気に入り
                            </button>
                        </div>

                        <div>
                            <p>カートに入れる</p>
                            <button>
                                +
                            </button>
                            <?php print isset($cart['num'])? h($cart['num']): 0; ?>
                            <button>
                                -
                            </button>
                        </div>
                    </div>

                </div>
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