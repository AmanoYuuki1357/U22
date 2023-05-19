<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    if(!isset($_SESSION)){
        session_start();
    }

    // ヘッダーのアイコン
    $icons=$db->prepare('SELECT userIcon FROM user_info WHERE userID=?');
    $icons->execute(array($_SESSION['id']));
    $icon=$icons->fetch();

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/common.css">

</head>

<body>
    <div id="wrap">
        <header>
            <h1>ミールフレンド</h1>
            <nav>
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
                        <!-- <img src=icon_images/<?php print(h($icon["userIcon"])) ?> alt="アイコン"> -->
                    </label>
                    <div>
                        <a href="my_page.html">ニックネーム</a>
                        <!-- <a href="my_page.php"><?php print(h($user["userNickName"])) ?></a> -->
                    </div>
                </div>
            </nav>
        </header>

        <!-- ハンバーガーメニュー -->
        <!-- <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <nav class="globalMenuSp">
                    <ul>
                        <li><a href="home.php">ホーム</a></li>
                        <li><a href="ranking.php">ランキング</a></li>
                        <li><a href="recommendation.php">おすすめ</a></li>
                        <li><a href="new.php">新着</a></li>
                    </ul>
                </nav> -->

        <!-- <div id=icon>
                    <a href="home.php"><img src="images/pigsiv.jpg" alt="アイコン"></a>
                </div> -->

        <!-- 検索 -->
        <!-- <div id="search">
                    <form method="get" action="search.php">
                        <input type="text" name="search" size="15" placeholder="作品を検索">
                    </form>
                </div> -->

        <!-- 投稿ボタン -->
        <!-- <div id="contribute">
                    <a href="post.php">作品を投稿</a>
                </div> -->

        </header>

        <main>

            <div>

                <div id="box">
                    <div>
                        <a href="meal_record.html">
                            <img alt="食事記録pic">
                            <p>食事記録</p>
                        </a>
                    </div>
                    <div>
                        <a href="meal_manage.html">
                            <img alt="食事管理pic">
                            <p>食事管理</p>
                        </a>
                    </div>
                    <div>
                        <a href="meal_analize.php">
                            <img alt="食事分析pic">
                            <p>食事分析</p>
                        </a>
                    </div>
                </div>

                <div class="outline">
                    <a href="buy_history.html">あなたの購入履歴></a>
                </div>

                <div class="outline">
                    <a href="delivery_situation.html">あなたの配送状況></a>
                </div>

                <!-- <?php
                        $cs=$db->prepare("SELECT count(*) FROM works_info WHERE worksCreatedID=?");
                        $cs->execute(array($_SESSION['id']));
                        $c=$cs->fetch();
                        if($c[0]!=0){
                            print('<p class="sl">あなたの投稿はこちら</p>');
                    ?> -->

                <!-- <table> -->
                <!-- <?php

                            $posts=$db->prepare('SELECT * FROM works_info WHERE worksCreatedID=? ORDER BY worksCreated DESC');
                            $posts->execute(array($_SESSION['id']));

                            for($i=0; $post=$posts->fetch(); $i++){
                                if($i==0){
                                    print("<tr>");
                                }
                                if($i==5){
                                    print("</tr>");
                                    $i=0;
                                }
                        ?> -->

                <!-- <td><a href="works.php?id=<?php print($post["worksID"]) ?>"><img class="works" src="post_images/<?php print(h($post["worksImage"])) ?>" alt="新着"></a></td> -->

                <!-- <?php
                            }
                        }else{
                            print('<p class="sl">あなたの投稿作品はまだありません</p>
                            <div class="sltr"><a href="post.php">投稿してみましょう</a></div>');
                        }
                        ?> -->
                <!-- </table> -->
            </div>
        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

    <!-- jQuery -->
    <!-- <script src="js/jQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

</body>
<style>
    *{
        text-decoration: none;
        color: #000;
    }
    #box{
        display: flex;
        text-align: center;
    }
    #box div{
        margin: 15px;
        padding: 10px;
        background-color: #c8fac8;
    }
    .outline{
        border-bottom: solid;
        padding: 3px;
        margin: 5px;
    }

    
</style>

</html>