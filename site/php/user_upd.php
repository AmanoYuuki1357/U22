<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sql = 'SELECT * FROM t_users WHERE f_delete_flag = 0 AND f_user_id=?;';

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
    <title>ユーザー情報の閲覧・変更</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">

</head>

<body>
    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>

    <main>

        <div>
            <h2>ユーザー情報の閲覧・変更</h2>

            <hr>

            <form action="" method="post">
            <div>
                <p>ユーザー名</p>
                <p><?php print $user["f_user_name"] ?>様</p>

                <p>ニックネーム</p>
                <p><input type="text" name="address" value="<?php print $user["f_user_nick_name"] ?>" placeholder="ニックネームを入力してください" require />様</p>

                <p>メールアドレス</p>
                <p><?php print $user["f_user_email"] ?></p>

                <p>パスワード</p>
                <p>[表示しません]</p>

                <p>住所</p>
                <input type="text" name="address" value="<?php print $user["f_user_address"]?>" placeholder="住所を入力してください" />

                <p>年齢</p>
                <input type="text" name="age" value="<?php print $user["f_user_age"]?>" placeholder="年齢を入力してください" />
                
                <!-- TODO: ポイント付与機能がないのでコメントアウト化 -->
                <!-- <p>ポイント</p> -->
                <!-- <p><?php // print $user["f_user_point"] ?>点</p> -->

                <p>身長</p>
                <p><input type="text" name="height" value="<?php print $user["f_user_hight"]?>" placeholder="身長を入力してください" />cm</p>

                <p>体重</p>
                <input type="text" name="weight" value="<?php print $user["f_user_weight"]?>" placeholder="体重を入力してください" />

            </div>

            <div>
                <input type="submit" class="btn btn-secondary" name="reset" value="クリア" />
                <input type="submit" class="btn btn-primary" name="update" value="更新する" />
            </div>
            </form>

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