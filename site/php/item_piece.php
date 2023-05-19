<?php
    require "common.php";
    require "UseDb.php";
    error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // セッション開始
    // ===================================================================================
    if(!isset($_SESSION)){ session_start(); }

    // ===================================================================================
    // 食品IDの取得
    // ===================================================================================
    if(isset($_GET['id'])){
        $searchItemId = $_GET['id'];
    }
    else{
        // 商品のIDが取得できないときは商品一覧へ遷移する
        header('Location: ./menu.php');
    }

    // ===================================================================================
    // DB検索
    // ===================================================================================
    $db = new UseDb($db);                                           // オブジェクト生成
    $item       = $db->showItemByItemId($searchItemId);             // 食品詳細検索
    $genres     = $db->showGenresByItemId($searchItemId);           // 食品ジャンル検索
    $allergens  = $db->showAllergensByItemId($searchItemId);        // 食品アレルゲン検索
    $reviews    = $db->limitreviewByItemId($searchItemId, 2);       // 食品レビュー検索

    if(empty($item)){
        // 取得できないときは商品一覧へ遷移する
        header('Location: ./menu.php');
    }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <!-- <link rel="stylesheet" type="text/css" href="../css/reset.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="../css/common.css"> -->

    <!-- 商品個別画面 -->
    <title><?php print $item['f_item_name']; ?> | ミールフレンド</title>

</head>

<body>
    <div id="wrap">
        <header>
            <h1>ミールフレンド</h1>
            <nav>
                <div>
                    <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
                </div>

            <!-- マイページ/ログイン -->
            <?php 
                print isset($_SESSION['id'])? 
                    "<a href='mypage.html'>{$_SESSION['name']}様</a>":
                    "<a href='login.php'>ログイン/会員登録</a>";
            ?>
            </nav>

        </header>

        <main>
            <div>
                <a href="./menu.php">＜メニュー一覧</a>
            </div>

            <div>

                <p>食品ジャンル</p>
                <ul>
                <?php
                    if(!empty($genres)){
                        // ジャンル情報が取得できた場合
                        foreach ($genres as $genre){
                            print "<li>{$genre['f_item_genre_name']}</li>";
                        }
                    }
                ?>
                </ul>

                <!-- TODO:画像表示 -->

                <!-- 商品名 -->
                <h2><?php print $item['f_item_name']; ?></h2>

                <dl>
                    <dt>値段</dt>
                    <dd><?php print "{$item['f_item_price']}円"; ?></dd>
                </dl>

                <dl>
                    <dt>商品説明</dt>
                    <dd><?php print $item['f_item_explain']; ?></dd>
                </dl>

                <p>アレルゲン</p>
                <ul>
                <?php
                    // TODO:該当食品だけ表示
                    print $allergens['f_item_allergen_wheat']?"<li>小麦</li>": "";
                    print $allergens['f_item_allergen_egg']?"<li>卵</li>": "";
                    print $allergens['f_item_allergen_milk']?"<li>乳</li>": "";
                    print $allergens['f_item_allergen_soba']?"<li>そば</li>": "";
                    print $allergens['f_item_allergen_shrimp']?"<li>えび</li>": "";
                    print $allergens['f_item_allergen_clab']?"<li>かに</li>": "";
                    print $allergens['f_item_allergen_peanut']?"<li>落花生</li>": "";
                    print $allergens['f_item_allergen_pork']?"<li>豚肉</li>": "";
                    print $allergens['f_item_allergen_chicken']?"<li>鶏肉</li>": "";
                    print $allergens['f_item_allergen_beef']?"<li>牛肉</li>": "";
                    print $allergens['f_item_allergen_salmon']?"<li>さけ</li>": "";
                    print $allergens['f_item_allergen_mackerel']?"<li>さば</li>": "";
                    print $allergens['f_item_allergen_soy']?"<li>大豆</li>": "";
                    print $allergens['f_item_allergen_aquid']?"<li>いか</li>": "";
                    print $allergens['f_item_allergen_yamaimo']?"<li>やまいも</li>": "";
                    print $allergens['f_item_allergen_orange']?"<li>オレンジ</li>": "";
                    print $allergens['f_item_allergen_sesame']?"<li>ごま</li>": "";
                    print $allergens['f_item_allergen_cashew_nuts']?"<li>カシューナッツ</li>": "";
                    print $allergens['f_item_allergen_abalone']?"<li>あわび</li>": "";
                    print $allergens['f_item_allergen_ikura']?"<li>いくら</li>": "";
                    print $allergens['f_item_allergen_kiwi']?"<li>キウイフルーツ</li>": "";
                    print $allergens['f_item_allergen_banana']?"<li>バナナ</li>": "";
                    print $allergens['f_item_allergen_peaches']?"<li>もも</li>": "";
                    print $allergens['f_item_allergen_apple']?"<li>りんご</li>": "";
                    print $allergens['f_item_allergen_walnut']?"<li>くるみ</li>": "";
                    print $allergens['f_item_allergen_matsutake']?"<li>まつたけ</li>": "";
                    print $allergens['f_item_allergen_gelatin']?"<li>ゼラチン</li>": "";
                    print $allergens['f_item_allergen_almond']?"<li>アーモンド</li>": "";
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
                        <td><?php print $item['f_item_calorie']; ?>kcal</td>
                        <td><?php print $item['f_item_protein_vol']; ?>g</td>
                        <td><?php print $item['f_item_suger_vol']; ?>g</td>
                        <td><?php print $item['f_item_lipid_vol']; ?>g</td>
                        <td><?php print $item['f_item_dietary_fiber_vol']; ?>g</td>
                        <td><?php print $item['f_item_salt_vol']; ?>g</td>
                    </tr>
                </table>

                <dl>
                    <dt>原材料</dt>
                    <dd><?php print $item['f_item_materials']; ?></dd>
                </dl>

                <dl>
                    <dt>保存方法</dt>
                    <dd><?php print $item['f_item_save_way']; ?></dd>
                </dl>

                <dl>
                    <dt>賞味期限</dt>
                    <dd><?php print $item['f_item_use_by_date']; ?></dd>
                </dl>
            </div>

            <div>
                <button>
                    お気に入り
                </button>
                <button>
                    カートに入れる
                </button>
            </div>

            <div>
                <h2>レビュー</h2>

                <div>
                <?php
                    if(empty($reviews)){
                        // レビュー情報が取得できない場合
                        print "<p>まだレビューはありません</p>";
                    }
                    else{
                        // レビュー情報が取得できた場合
                        foreach ($reviews as $review){
                            print "
                                <div>
                                    <dl>
                                        <dt>日付</dt>
                                            <dd>{$review['f_review_date']}</dd>
                                        <dt>評価</dt>
                                            <dd>{$review['f_review_point']}</dd>
                                        <dt>コメント</dt>
                                            <dd>{$review['f_review']}</dd>
                                    </dl>
                                </div>";
                        }

                        print "<a href='review.php?id={$searchItemId}&page=1'>レビューを見る</a>";
                    }
                ?>
                </div>

            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

</body>

</html>