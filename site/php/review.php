<?php
    require "common.php";
    // require "UseDb.php";
    error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlItems = '
        SELECT
            f_item_name,
            f_item_explain,
            f_item_calorie,
            f_item_protein_vol,
            f_item_suger_vol,
            f_item_lipid_vol,
            f_item_dietary_fiber_vol,
            f_item_salt_vol
        FROM
            t_items
        WHERE
            f_item_id = ? ;';

    $sqlReviewCnt = '
        SELECT
            count(*)    AS cnt
        FROM
            t_item_review
        where
            f_item_id = ?;';

    $sqlReviews = '
        SELECT
            f_review_date,
            f_review_point,
            f_review
        FROM
            t_item_review    AS review
        where
            review.f_item_id = ?
        ORDER BY
            f_review_date DESC
        LIMIT ';

    // ===================================================================================
    // セッション開始
    // ===================================================================================
    if(!isset($_SESSION)){ session_start(); }

    // ===================================================================================
    // get取得
    // ===================================================================================
    // 食品ID
    if(isset($_GET['id'])){ $searchItemId = $_GET['id']; }
    else{ header('Location: ./menu.php');}

    // ページ
    if(isset($_GET['page'])){ $page = $_GET['page']; }
    else{ $page = 1; }

    // ===================================================================================
    // ページ内のレビューアイテム
    // ===================================================================================
    $pageRevs   = 3;                        // 表示対象数
    $revStart   = $pageRevs * ($page - 1);  // 表示対象開始の数

    // ===================================================================================
    // DB検索
    // ===================================================================================
    // 食品IDによる検索(汎用)
    function showByItemId($db, $sql, $itemId){
        $contents = $db->prepare($sql);
        $contents->bindparam(1, $itemId, PDO::PARAM_INT);
        $contents->execute();

        return $contents;
    }

    $item       = showByItemId($db, $sqlItems, $searchItemId)->fetch(PDO::FETCH_ASSOC);         // 食品詳細情報
    $revCnt     = showByItemId($db, $sqlReviewCnt, $searchItemId)->fetch(PDO::FETCH_ASSOC);     // 総レビュー件数
    $reviews    = showByItemId($db, $sqlReviews . $revStart . "," . $pageRevs .';', $searchItemId)
                    ->fetchAll(PDO::FETCH_ASSOC);                                               // 表示対象のレビュー情報

    // 検索失敗時
    if(empty($item)){
        // 取得できないときは商品一覧へ遷移する
        header('Location: ./menu.php');
    }

    // ページ数
    $pageEnd = $revCnt['cnt'] / $pageRevs;
    if($revCnt['cnt'] % $pageRevs != 0){ $pageEnd += 1; }

    // ページURL
    function urlPage($check, $itemId, $page, $str){
        return $check? "<a href='review.php?id={$itemId}&page={$page}'>{$str}</a>": "<p>{$str}</p>"; 
    }
?>

<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $item['f_item_name']; ?>のレビュー | ミールフレンド</title>
</head>

<body>
    <div id="wrap">
        <header>

            <h2>ミールフレンド</h2>

            <div>
                <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>

            <!-- ログインしていない時 -->
                <a href="login.html">ログイン/会員登録</a>

            <!-- ログインしている時 -->

            <!-- ユーザーメニュー -->
            <div id="user">
                <label>
                    <img src="../images/icon.jpg" alt="アイコン">
                    <img src=icon_images/<?php // print(h($icon["userIcon"])) ?> alt="アイコン">
                </label>
                <div>
                    <a href="my_page.html">ニックネーム</a>
                    <a href="my_page.php"><?php // print(h($user["userNickName"])) ?></a>
                </div>
            </div>

        </header>

        <main>

            <div>
                <!-- 商品個別画面に戻る -->
                <?php print "<a href='item_piece.php?id={$searchItemId}'>＜{$item['f_item_name']}</a>" ?>
            </div>

            <div>
                <p>カスタマーレビュー</p>
            </div>

            <?php
                // レビュー全件数
                print "<p>全". $revCnt['cnt'] . "件</p>";

                // レビュー
                foreach($reviews as $review){
                    $strStars =  "☆☆☆☆☆";
                    for($i=0; $i<$review['f_review_point']; $i++){ $strStars = "★" . $strStars; }

                    print "
                        <div>
                            <p>{$review['f_review_date']}</p>
                            <p>" . mb_substr($strStars, 0, 5) . "</p>
                            <p>{$review['f_review']}</p>
                        </div>
                    ";
                }

                // ページ部
                print urlPage( $page-1 > 0, $searchItemId, $page-1, "<" );          // 前へ
                for($i=0; $i<$pageEnd-1; $i++){
                    print urlPage( $page != $i+1, $searchItemId, $i+1, $i+1 );      // ページ
                }
                print urlPage( $page+1 < $pageEnd, $searchItemId, $page + 1, ">" ); // 次へ

            ?>

            <div>
                <!-- 画像 -->
                <img src="images/salmon.jpg" alt="鮭">
                <h2><?php print $item['f_item_name']; ?></h2>
                <dl>
                    <dt>説明</dt>
                        <dd><?php print $item['f_item_explain']; ?></dd>
                    <dt>カロリー</dt>
                        <dd><?php print $item['f_item_calorie']; ?>kcal</dd>
                    <dt>たんぱく質</dt>
                        <dd><?php print $item['f_item_protein_vol']; ?>g</dd>
                    <dt>糖質</dt>
                        <dd><?php print $item['f_item_suger_vol']; ?>g</dd>
                    <dt>脂質</dt>
                        <dd><?php print $item['f_item_lipid_vol']; ?>g</dd>
                    <dt>食物繊維</dt>
                        <dd><?php print $item['f_item_dietary_fiber_vol']; ?>g</dd>
                    <dt>塩分</dt>
                        <dd><?php print $item['f_item_salt_vol']; ?>g</dd>
                </dl>
            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
    </div>
</body>
</html>