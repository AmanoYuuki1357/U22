<?php
require "common.php";
error_reporting(E_ALL & ~E_NOTICE);

// ===================================================================================
// SQL
// ===================================================================================
$sqlUsers = '
    SELECT
        f_user_nick_name        AS nick_name
    FROM
        t_users
    WHERE
        f_user_id = ? ;';
$sqlItems = '
        SELECT
            f_item_name                 AS name,
            f_item_explain              AS ex,
            f_item_calorie              AS calorie,
            f_item_protein_vol          AS protein_vol,
            f_item_sugar_vol            AS sugar_vol,
            f_item_lipid_vol            AS lipid_vol,
            f_item_dietary_fiber_vol    AS dietary_fiber_vol,
            f_item_salt_vol             AS salt_vol,
            f_item_image                AS image
        FROM
            t_items
        WHERE
            f_item_id = ? ;';

$sqlReviewCnt = '
        SELECT
            count(*)            AS cnt
        FROM
            t_item_review
        where
            f_item_id = ?;';

$sqlReviews = '
        SELECT
            f_review_date       AS date,
            f_review_point      AS point,
            f_review            AS review
        FROM
            t_item_review    AS review
        where
            review.f_item_id = ?
        ORDER BY
            f_review_date DESC
        LIMIT ?, ?;';

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

// ページ内表示アイテムの検索
function showPage($db, $sql, $itemId, $start, $amount)
{
    $contents = $db->prepare($sql);
    $contents->bindparam(1, $itemId, PDO::PARAM_INT);
    $contents->bindparam(2, $start, PDO::PARAM_INT);
    $contents->bindparam(3, $amount, PDO::PARAM_INT);
    $contents->execute();

    return $contents;
}

// ページURLのテキストを返す
function pageUrl($check, $itemId, $page, $str)
{
    return $check ? "<a href='review.php?id={$itemId}&page={$page}'>{$str}</a>" : "<p>{$str}</p>";
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

// ログインしている場合、カートTBLから情報を取得する
if (isset($_SESSION['id'])) {
    // ログインユーザーのIDを取得
    $userId = $_SESSION['id'];

    // カート内情報検索
    $user = showById($db, $sqlUsers, $userId)[0];
}

// ===================================================================================
// get取得
// ===================================================================================
// 食品ID
if (isset($_GET['id']) || is_numeric($_GET['id'])) {
    $searchItemId = $_GET['id'];
} else {
    header('Location: ./menu.php');
}

// ページ
if (isset($_GET['page']) || is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// ===================================================================================
// ページ内のレビューアイテム
// ===================================================================================
$pageRevs   = 3;                        // 表示対象数
$revStart   = $pageRevs * ($page - 1);  // 表示対象開始の数

// ===================================================================================
// DB検索
// ===================================================================================
$item       = showById($db, $sqlItems, $searchItemId)[0];                       // 食品詳細情報
$revCnt     = showById($db, $sqlReviewCnt, $searchItemId)[0];                   // 総レビュー件数
$reviews    = showPage($db, $sqlReviews, $searchItemId, $revStart, $pageRevs);  // 表示対象のレビュー情報

// 検索失敗時
if (empty($item)) {
    // 取得できないときは商品一覧へ遷移する
    header('Location: ./menu.php');
}

// ===================================================================================
// ページ処理
// ===================================================================================
$pageEnd = $revCnt['cnt'] / $pageRevs;
if ($revCnt['cnt'] % $pageRevs != 0) {
    $pageEnd += 1;
}

?>

<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $item['name']; ?>のレビュー | ミールフレンド</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/review.css">
</head>

<body>
    <div id="wrap">
        <header>

            <h2>ミールフレンド</h2>

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
                                <a href="my_page.php">' . h($user["nick_name"]) . '</a>
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

        </header>

        <div id="gomenu">
            <!-- 商品個別画面に戻る -->
            <?php print "<a href='item_piece.php?id={$searchItemId}'>＜{$item['name']}</a>" ?>
        </div>
        <main>

            <div id="review">

                <div>
                    <p>カスタマーレビュー</p>
                </div>

                <?php
                // レビュー全件数
                print "<p>全" . h($revCnt['cnt']) . "件</p>";
                // 表示レビューの件数
                $start  = $revStart + 1;
                $end    = $revCnt['cnt'] < $revStart + $pageRevs ? $revCnt['cnt'] : $revStart + $pageRevs;
                print $start . "-" . $end;

                // レビュー
                foreach ($reviews as $review) {
                    print "
                        <div>
                            <p>" . h($review['date']) . "</p>
                            <p>" . strNumToStar($review['point']) . "</p>
                            <p>" . h($review['review']) . "</p>
                        </div>
                    ";
                }

                ?>
                <div id="page">
                    <!-- ページ部 -->
                    <?php
                    print pageUrl($page - 1 > 0, $searchItemId, $page - 1, "<");          // 前へ
                    for ($i = 0; $i < $pageEnd - 1; $i++) {
                        print pageUrl($page != $i + 1, $searchItemId, $i + 1, $i + 1);      // ページ
                    }
                    print pageUrl($page + 1 < $pageEnd, $searchItemId, $page + 1, ">"); // 次へ

                    ?>
                </div>

            </div>
            <div id="iteminfo">
                <!-- 画像表示 -->
                <img id="piece_img" src=<?php print imageUrl($item['image']); ?> alt="商品画像">

                <h2><?php print $item['name']; ?></h2>
                <dl>
                    <dt>説明</dt>
                    <dd><?php print h($item['ex']); ?></dd>
                    <dt>カロリー</dt>
                    <dd><?php print h($item['calorie']); ?>kcal</dd>
                    <dt>たんぱく質</dt>
                    <dd><?php print h($item['protein_vol']); ?>g</dd>
                    <dt>糖質</dt>
                    <dd><?php print h($item['sugar_vol']); ?>g</dd>
                    <dt>脂質</dt>
                    <dd><?php print h($item['lipid_vol']); ?>g</dd>
                    <dt>食物繊維</dt>
                    <dd><?php print h($item['dietary_fiber_vol']); ?>g</dd>
                    <dt>塩分</dt>
                    <dd><?php print h($item['salt_vol']); ?>g</dd>
                </dl>
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