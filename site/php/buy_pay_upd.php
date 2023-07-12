<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);

    // ===================================================================================
    // SQL
    // ===================================================================================
    $sqluser = '
    SELECT
        f_user_id,
        f_user_name,
        f_user_nick_name
    FROM
        t_users
    WHERE
        f_user_id = ? ;';

    $sqlupdate = '
        UPDATE
            t_users
        SET
            f_user_credit_number    = ?,
            f_user_credit_name      = ?,
            f_user_credit_expiry    = ?,
            f_user_credit_code      = ?
        WHERE
            f_user_id = ? ;';

    // ===================================================================================
    // セッション開始
    // ===================================================================================
    if(!isset($_SESSION)){
        session_start();
    }

    // ユーザーID取得
    if(isset($_SESSION['id'])){
        // ログインユーザーのIDを取得
        $userId = $_SESSION['id'];

        // -------------------------------------------------------------------------------
        // DB検索
        // -------------------------------------------------------------------------------
        // ユーザー情報取得
        $contents = $db->prepare($sqluser);
        $contents->bindparam(1, $userId, PDO::PARAM_INT);
        $contents->execute();
        $user = $contents->fetch();
    }
    else{
        // ログインページへ
        header('Location: login.php');
    }

    // ===================================================================================
    // 更新するボタン押下時のイベント
    // ===================================================================================
    if(isset($_POST) && count($_POST) != 0){

        // REVIEW: 取得地の確認
        // print_r($_POST);
        // print_r($error);

        // -------------------------------------------------------------------------------
        // ユーザー情報更新
        // -------------------------------------------------------------------------------
        $contents = $db->prepare($sqlupdate);
        $contents->bindparam(1, $_POST["number"], PDO::PARAM_INT);
        $contents->bindparam(2, $_POST["name"], PDO::PARAM_STR);
        $contents->bindparam(3, str_replace('-', '', $_POST["expiry"]), PDO::PARAM_INT);
        $contents->bindparam(4, sha1($_POST["code"]), PDO::PARAM_STR);
        $contents->bindparam(5, $userId, PDO::PARAM_INT);
        $updateUser = $contents->execute();

        // 更新失敗した場合
        if($updateUser != 1){
            // TODO: 更新失敗時の動作を考える
        }

        // 更新成功
        header('Location: buy_pay.php');
    }

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入カード情報登録</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">

</head>

<body>

    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>

    <main>
        <!-- 進行度バー -->
        <div class="stepbar-row">
            <ol class="stepbar">
                <li class="done"><span></span><br />お届け先</li>
                <li class="done"><span></span><br />お支払方法</li>
                <li><span></span><br />完了</li>
            </ol>
        </div>

        <div class="container">
            <div class="row">
                <h2>クレジットカード情報の登録</h2>
            </div>

            <hr>

            <form id="myForm" action="" method="post">

            <div class="row">
                <div class="col-md-2">
                    <label for="number" class="form-label">
                        <p><span class="attention">*</span>カード番号</p>
                    </label>
                </div>
                <div class="col has-validation">
                    <input
                        type="text"
                        id="number"
                        name="number"
                        class="form-control"
                        maxlength="16"
                        value="<?php isset($_POST["update"]) && print $_POST["number"]; ?>"
                        placeholder="カード番号(16桁)を入力してください"
                        onblur="validateCardNum()" />
                    <div id="error_number" class="invalid-feedback">
                            必須項目です。カード番号を入力してください
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="name" class="form-label">
                        <p><span class="attention">*</span>カード名義人</p>
                    </label>
                </div>
                <div class="col has-validation">
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?php isset($_POST["update"]) && print $_POST["name"]; ?>"
                        placeholder="カード名義人を入力してください"
                        onblur="validateName()" />
                    <div id="error_name" class="invalid-feedback">
                        必須項目です。カード名義人を入力してください
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="expiry" class="form-label">
                        <p><span class="attention">*</span>有効期限(月/年)</p>
                    </label>
                </div>
                <div class="col has-validation">
                    <input
                        type="month"
                        id="expiry"
                        name="expiry"
                        class="form-control"
                        value="<?php if(isset($_POST["update"])){ print $_POST["expiry"]; } ?>"
                        placeholder="有効期限(yyyy-mm)を入力してください"
                        onblur="validateExpiry()" />
                    <div id="error_expiry" class="invalid-feedback">
                        必須項目です。有効期限を入力してください
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="code" class="form-label">
                        <p><span class="attention">*</span>セキュリティコード</p>
                    </label>
                </div>
                <div class="col has-validation">
                    <input
                        type="password"
                        id="code"
                        name="code"
                        class="form-control"
                        value=""
                        maxlength="4"
                        minlength="3"
                        placeholder="セキュリティコード(3~4桁)を入力してください"
                        onblur="validateCode()" />
                    <div id="error_code" class="invalid-feedback">
                        必須項目です。セキュリティコードを入力してください
                    </div>
                </div>
            </div>

            <div class="d-md-flex justify-content-center">
                <a href="buy_pay.php" class="btn btn-secondary me-md-2">戻る</a>
                <input type="submit" name="update" class="btn btn-primary" value="クレジットカード情報を更新する" />
            </div>

            </form>

        </div>

    </main>

    <!-- フッター部分 -->
    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

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

    <!-- jQuery -->
    <!-- <script src="js/JQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

    <!-- バリデーション -->
    <script src="../js/validation.js"></script>
    <script src="../js/buy_pay_upd.js"></script>

</body>

<style>
    .stepbar-row {
        position: relative;
        top: 20px;
    }
</style>

</html>