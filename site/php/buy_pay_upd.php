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
    if(isset($_POST["update"])){
        // -------------------------------------------------------------------------------
        // 入力チェック
         // -------------------------------------------------------------------------------
        // カード番号
        if($_POST["number"] == ""){
            // 必須チェック
            $error["number"] = "blank";
        }
        else if(mb_strlen($_POST["number"]) != 16){
            // 桁数チェック
            $error["number"] = "digits";
        }

        // カード名義人
        if($_POST["name"] == ""){
            // 必須チェック
            $error["name"] = "blank";
        }

        // 有効期限(mm/yyyy)
        if($_POST["expiry"] == ""){
            // 必須チェック
            $error["expiry"] = "blank";
        }
        elseif(strtotime(date("Ym")) > strtotime($_POST["expiry"])){
            // 整合性チェック
            $error["expiry"] = "expired";
        }

        // セキュリティコード
        if($_POST["code"] == ""){
            // 必須チェック
            $error["code"] = "blank";
        }
        else if(mb_strlen($_POST["code"]) != 3){
            if(mb_strlen($_POST["code"]) != 4){
                // 桁数チェック
                $error["code"] = "digits";
            }
        }

        // REVIEW: 取得地の確認
        // print_r($_POST);
        // print_r($error);

        if(empty($error)){
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

            <form action="" method="post">

            <div class="row">
                <div class="col-md-2">
                    <label for="number" class="form-label">
                        <p>カード番号</p>
                    </label>
                </div>
                <div class="col-md-4">
                    <input
                        type="text"
                        id="number"
                        name="number"
                        class="form-control"
                        maxlength="16"
                        value="<?php isset($_POST["update"]) && print $_POST["number"]; ?>"
                        placeholder="カード番号(16桁)を入力してください"
                        required />
                </div>
                <div class="col">
                <?php
                    // エラーメッセージ
                    if(isset($error["number"])){
                        print "<p style='color: red;'>";
                        switch($error["number"]){
                            case "blank":   print "入力がありません"; break;
                            case "digits":  print "16桁で入力してください"; break;
                            default: break;
                        }
                        print "</p>";
                    }
                ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="name" class="form-label">
                        <p>カード名義人</p>
                    </label>
                </div>
                <div class="col-md-4">
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?php isset($_POST["update"]) && print $_POST["name"]; ?>"
                        placeholder="カード名義人を入力してください" />
                </div>
                <div class="col">
                <?php
                    // エラーメッセージ
                    isset($error['name'])
                    && $error['name'] == 'blank'
                    && print '<p style="color: red;">入力がありません</p>';
                ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="expiry" class="form-label">
                        <p>有効期限(月/年)</p>
                    </label>
                </div>
                <div class="col-md-4">
                    <input
                        type="month"
                        id="expiry"
                        name="expiry"
                        class="form-control"
                        value="<?php if(isset($_POST["update"])){ print $_POST["expiry"]; } ?>"
                        placeholder="有効期限(yyyy-mm)を入力してください" />
                </div>
                <div class="col">
                <?php
                    // エラーメッセージ
                    if(isset($error["expiry"])){
                        print "<p style='color: red;'>";
                        switch($error["expiry"]){
                            case "blank":   print "入力がありません"; break;
                            case "expired": print "入力値が不正です"; break;
                            default: break;
                        }
                        print "</p>";
                    }
                ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <label for="code" class="form-label">
                        <p>セキュリティコード</p>
                    </label>
                </div>
                <div class="col-md-4">
                    <input
                        type="password"
                        id="code"
                        name="code"
                        class="form-control"
                        value=""
                        maxlength="4"
                        placeholder="セキュリティコード(3~4桁)を入力してください" />
                </div>
                <div class="col">
                <?php
                    // エラーメッセージ
                    if(isset($error['code'])){
                        print "<p style='color: red;'>";
                        switch($error['code']){
                            case "blank":   print "入力がありません"; break;
                            case "digits":  print "3または4桁で入力してください"; break;
                            default: break;
                        }
                        print "</p>";
                    }
                ?>
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
    <script src="../js/validation.js"></script>

</body>

<style>
    .stepbar-row {
        position: relative;
        top: 20px;
    }
</style>

</html>