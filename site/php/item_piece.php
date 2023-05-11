<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商品個別画面 | ミールフレンド</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/works.css">
    </head>

    <body>
        <div id="wrap">
            <header>

                <h2>
                    ミールフレンド
                </h2>

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
                        <img src=icon_images/<?php //print(h($icon["userIcon"])) ?> alt="アイコン">
                    </label>
                    <div>
                        <a href="my_page.html">ニックネーム</a>
                        <a href="my_page.php"><?php //print(h($user["userNickName"])) ?></a>
                    </div>
                </div>

            </header>

            <main>
                <div>
                    <a href="index.html">＜メニュー一覧</a>
                </div>

                <div>
                    <img src="images/salmon.jpg" alt="鮭">
                </div>

                <div>

                    <?php
                        require "db_access.php";

                        $db = new Db();
                        if($db->connect()){ $dbCon = $db->db; }
                        $records = $dbCon->query('select * from t_items where f_item_id = 1;');
                        $record = $records->fetch( PDO::FETCH_ASSOC )
                    ?>

                    <h2>
                        <?php print $record['f_item_name']; ?>
                    </h2>

                    <p>
                        値段
                    </p>

                    <p>
                        <?php print "{$record['f_item_price']}円"; ?>
                    </p>

                    <p>
                        商品説明
                    </p>

                    <p>
                        アレルゲン
                    </p>

                    <p>
                        |カロリー｜タンパク質｜脂質｜食物繊維｜塩分｜
                    </p>

                    <p>
                        原材料
                    </p>

                    <p>
                        保存方法
                    </p>

                    <p>
                        賞味期限
                    </p>
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
                    <p>
                        レビュー
                    </p>
                    <img src="images/icon.jpg" alt="nakaotoshiki">
                    <p>
                        ユーザー名｜評価｜コメント｜
                    </p>

                    <img src="images/icon.jpg" alt="nakaotoshiki">
                    <p>
                        ユーザー名｜評価｜コメント｜
                    </p>
                    <a href="review.html">レビューを見る</a>
                </div>
            </main>

            <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

        </div>

    </body>

</html>