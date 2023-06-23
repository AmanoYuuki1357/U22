<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);
    // ===================================================================================
    // SQL
    // ===================================================================================
    $sql = 'SELECT * FROM t_users WHERE f_user_id=?;';

    // ===================================================================================
    // セッション開始
    // ===================================================================================
    if (!isset($_SESSION)) {
        session_start();
    }

    // ユーザーID取得
    if (isset($_SESSION["id"])) {
        $users = $db->prepare($sql);
        $users->execute(array($_SESSION["id"]));
        $user = $users->fetch();
    } else {
        header('Location: login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">

</head>

<body>
    <!-- ヘッダー部分 -->
    <?php
    require('header.php');
    ?>

    <main>

        <div>

            <div id="box">
                <div>
                    <a href="meal_record.php">
                        <img alt="食事記録pic">
                        <p>食事記録</p>
                    </a>
                </div>
                <div>
                    <a href="meal_manage.php">
                        <img alt="食事管理pic">
                        <p>食事管理</p>
                    </a>
                </div>
                <div>
                    <a href="meal_analyze.php">
                        <img alt="食事分析pic">
                        <p>食事分析</p>
                    </a>
                </div>
            </div>

            <div class="outline">
                <a href="buy_history.php">あなたの購入履歴></a>
            </div>

            <div class="outline">
                <a href="delivery_situation.php">あなたの配送状況></a>
            </div>

            <div class="outline">
                <a href="user_upd.php">ユーザー情報></a>
            </div>


            <!-- <?php
                    $cs = $db->prepare("SELECT count(*) FROM works_info WHERE worksCreatedID=?");
                    $cs->execute(array($_SESSION['id']));
                    $c = $cs->fetch();
                    if ($c[0] != 0) {
                        print('<p class="sl">あなたの投稿はこちら</p>');
                    ?> -->

            <!-- <table> -->
            <!-- <?php

                        $posts = $db->prepare('SELECT * FROM works_info WHERE worksCreatedID=? ORDER BY worksCreated DESC');
                        $posts->execute(array($_SESSION['id']));

                        for ($i = 0; $post = $posts->fetch(); $i++) {
                            if ($i == 0) {
                                print("<tr>");
                            }
                            if ($i == 5) {
                                print("</tr>");
                                $i = 0;
                            }
                    ?> -->

            <!-- <td><a href="works.php?id=<?php print($post["worksID"]) ?>"><img class="works" src="post_images/<?php print(h($post["worksImage"])) ?>" alt="新着"></a></td> -->

            <!-- <?php
                        }
                    } else {
                        print('<p class="sl">あなたの投稿作品はまだありません</p>
                        <div class="sltr"><a href="post.php">投稿してみましょう</a></div>');
                    }
                    ?> -->
            <!-- </table> -->
        </div>
    </main>

    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    <!-- jQuery -->
    <!-- <script src="js/jQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>