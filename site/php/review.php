<?php
    require "common.php";
    error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqlItems = '
        SELECT
            f_item_name                 AS name,
            f_item_explain              AS ex,
            f_item_calorie              AS calorie,
            f_item_protein_vol          AS protein_vol,
            f_item_suger_vol            AS suger_vol,
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
    // 食品IDによる検索(汎用)
    function showByItemId($db, $sql, $itemId){
        $contents = $db->prepare($sql);
        $contents->bindparam(1, $itemId, PDO::PARAM_INT);
        $contents->execute();

        return $contents;
    }

    // ページ内表示アイテムの検索
    function showPage($db, $sql, $itemId, $start, $amount ){
        $contents = $db->prepare($sql);
        $contents->bindparam(1, $itemId, PDO::PARAM_INT);
        $contents->bindparam(2, $start, PDO::PARAM_INT);
        $contents->bindparam(3, $amount, PDO::PARAM_INT);
        $contents->execute();

        return $contents;
    }

    // 点数を☆に変換
    function strNumToStar($point){
        $strStars =  "☆☆☆☆☆";
        for($i=0; $i<$point; $i++){ $strStars = "★" . $strStars; }

        return mb_substr($strStars , 0, 5);
    }

    // ページURLのテキストを返す
    function pageUrl($check, $itemId, $page, $str){
        return $check? "<a href='review.php?id={$itemId}&page={$page}'>{$str}</a>": "<p>{$str}</p>"; 
    }

    // 画像URLのテキストを返す
    function imageUrl($str){
        return "../images/items/" . $str . ".jpg";
    }

    // ===================================================================================
    // セッション開始
    // ===================================================================================
    if(!isset($_SESSION)){ session_start(); }

    // ===================================================================================
    // get取得
    // ===================================================================================
    // 食品ID
    if( isset($_GET['id']) || is_numeric($_GET['id']) ){ $searchItemId = $_GET['id']; }
    else{ header('Location: ./menu.php');}

    // ページ
    if( isset($_GET['page']) || is_numeric($_GET['page']) ){ $page = $_GET['page']; }
    else{ $page = 1; }

    // ===================================================================================
    // ページ内のレビューアイテム
    // ===================================================================================
    $pageRevs   = 3;                        // 表示対象数
    $revStart   = $pageRevs * ($page - 1);  // 表示対象開始の数

    // ===================================================================================
    // DB検索
    // ===================================================================================
    $item       = showByItemId($db, $sqlItems, $searchItemId)->fetch(PDO::FETCH_ASSOC);         // 食品詳細情報
    $revCnt     = showByItemId($db, $sqlReviewCnt, $searchItemId)->fetch(PDO::FETCH_ASSOC);     // 総レビュー件数
    $reviews    = showPage($db, $sqlReviews, $searchItemId, $revStart, $pageRevs)
                    ->fetchAll(PDO::FETCH_ASSOC);                                               // 表示対象のレビュー情報

    // 検索失敗時
    if(empty($item)){
        // 取得できないときは商品一覧へ遷移する
        header('Location: ./menu.php');
    }

    // ===================================================================================
    // ページ処理
    // ===================================================================================
    $pageEnd = $revCnt['cnt'] / $pageRevs;
    if($revCnt['cnt'] % $pageRevs != 0){ $pageEnd += 1; }
?>

<!DOCTYPE html>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print $item['name']; ?>のレビュー | ミールフレンド</title>
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
                    <!-- <img src=icon_images/<?php // print(h($icon["userIcon"])) ?> alt="アイコン"> -->
                </label>
                <div>
                    <a href="my_page.html">ニックネーム</a>
                    <!-- <a href="my_page.php"><?php // print(h($user["userNickName"])) ?></a> -->
                </div>
            </div>

        </header>

        <main>

            <div>
                <!-- 商品個別画面に戻る -->
                <?php print "<a href='item_piece.php?id={$searchItemId}'>＜{$item['name']}</a>" ?>
            </div>

            <div>
                <p>カスタマーレビュー</p>
            </div>

            <?php
                // レビュー全件数
                print "<p>全". h($revCnt['cnt']) . "件</p>";

                $start  = $revStart + 1;
                $end    = $revCnt['cnt'] < $revStart + $pageRevs? $revCnt['cnt']: $revStart + $pageRevs;
                print $start . "-" . $end;

                // レビュー
                foreach($reviews as $review){
                    print "
                        <div>
                            <p>" . h($review['date']) ."</p>
                            <p>" . strNumToStar($review['point']) . "</p>
                            <p>" . h($review['review']) . "</p>
                        </div>
                    ";
                }

                // ページ部
                print pageUrl( $page-1 > 0, $searchItemId, $page-1, "<" );          // 前へ
                for($i=0; $i<$pageEnd-1; $i++){
                    print pageUrl( $page != $i+1, $searchItemId, $i+1, $i+1 );      // ページ
                }
                print pageUrl( $page+1 < $pageEnd, $searchItemId, $page + 1, ">" ); // 次へ

            ?>

            <div>
                <!-- TODO:画像表示 -->
                <img src=<?php print imageUrl($item['image']); ?> alt="商品画像">
                <p>テスト出力:[画像]<?php print imageUrl($item['image']); ?></p>

                <h2><?php print $item['name']; ?></h2>
                <dl>
                    <dt>説明</dt>
                        <dd><?php print h($item['ex']); ?></dd>
                    <dt>カロリー</dt>
                        <dd><?php print h($item['calorie']); ?>kcal</dd>
                    <dt>たんぱく質</dt>
                        <dd><?php print h($item['protein_vol']); ?>g</dd>
                    <dt>糖質</dt>
                        <dd><?php print h($item['suger_vol']); ?>g</dd>
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
</body>
</html>