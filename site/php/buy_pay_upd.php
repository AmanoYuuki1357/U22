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
        f_user_nick_name,
        f_user_credit_number    AS number,
        f_user_credit_name      AS name,
        f_user_credit_expiry    AS expiry,
        f_user_credit_code      AS code
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

        // ===================================================================================
        // DB検索
        // ===================================================================================
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

    // 更新するボタン押下時のイベント
    if(isset($_POST["update"])){
        // FIXME: 入力チェック未実装

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
        else{
            // 数字だけ取り出す
            $numExpiry = str_replace('/', '', $_POST["expiry"]);

            if(mb_strlen($numExpiry) != 6){
                // 形式(桁数)チェック
                $error["expiry"] = "digits";
            }
            else{
                // 形式(月の指定が1~12)チェック
                $month = substr($numExpiry, 0, 2);
                if($month < 1 || $month > 12){
                    $error["expiry"] = "digits";
                }
                // 整合性チェック
                if(date("Ym") > swappingExpiry($numExpiry)){
                    $error["expiry"] = "digits";
                }
            }
        }

        // セキュリティコード
        if($_POST["code"] == ""){
            // 必須チェック
            $error["code"] = "blank";
        }
        else if($_POST["code"]){
            // 桁数チェック
        }

        // REVIEW: 取得地の確認
        print_r($_POST);
        print_r($error);

        if(empty($error)){
            // ユーザー情報更新
            $contents = $db->prepare($sqlupdate);
            $contents->bindparam(1, $_POST["number"], PDO::PARAM_INT);
            $contents->bindparam(2, $_POST["name"], PDO::PARAM_STR);
            $contents->bindparam(3, $numExpiry, PDO::PARAM_INT);
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

    // ===================================================================================
    // 関数
    // ===================================================================================
    // 有効期限をmm/yyyyの形式にフォーマット
    function formatingExpiry($expiry):string{
        return substr($expiry, 0, 2) . "/". substr($expiry, 2);
    }

    function swappingExpiry($expiry):string{
        return substr($expiry, 2) . substr($expiry, 0, 2);
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

        <div>
            <h2>クレジットカード情報の登録</h2>

            <hr>

            <form action="" method="post">
            <div>
                <p>カード番号</p>
                <input
                    type="text"
                    name="number"
                    value="<?php print isset($_POST["update"])? $_POST["number"]: h($user["number"]) ?>"
                    placeholder="カード番号(16桁)を入力してください"
                    require />
                <?php
                    // エラーメッセージ
                    if(isset($_POST["number"])){
                        
                        switch($error["number"]){
                            case "blank":
                                print "<p style='color: red;'>入力がありません</p>";
                                break;
                            case "digits":
                                print "<p style='color: red;'>16桁で入力してください</p>";
                                break;
                            default:
                                break;
                        }
                    }
                ?>

                <p>カード名義人</p>
                <input
                    type="text"
                    name="name"
                    value="<?php print isset($_POST["update"])? $_POST["name"]: h($user["name"]) ?>"
                    placeholder="カード名義人を入力してください" />
                <?php
                    // エラーメッセージ
                    if(isset($_POST["name"])){
                        if ($error['name'] == 'blank') {
                            print '<p style="color: red;">入力がありません</p>';
                        }
                    }
                ?>

                <p>有効期限(月/年)</p>
                <input
                    type="month"
                    name="expiry"
                    value="<?php print isset($_POST["update"])? $_POST["expiry"]: h(formatingExpiry($user["expiry"])); ?>"
                    placeholder="有効期限(mm/yyyy)を入力してください" />
                <?php
                    // エラーメッセージ
                    if(isset($_POST["update"])){
                        switch($error["number"]){
                            case "expiry":
                                print "<p style='color: red;'>入力がありません</p>";
                                break;
                            case "digits":
                                print "<p style='color: red;'>16桁で入力してください</p>";
                                break;
                            case "digits":
                                print "<p style='color: red;'>16桁で入力してください</p>";
                                break;
                            default:
                                break;
                        }
                    }
                ?>

                <p>セキュリティコード</p>
                <input
                    type="text"
                    name="code"
                    value=""
                    placeholder="セキュリティコード(3~4桁)を入力してください"/>
                
                <?php
                    // エラーメッセージ
                    if(isset($_POST["update"])){
                        if ($error['code'] == 'blank') {
                            print '<p style="color: red;">入力がありません</p>';
                        }
                    }
                ?>

            </div>

            <div>
                <!-- <a href="buy_pay.php">更新する</a> -->
                <input type="submit" name="update" value="更新する" />
            </div>

            </form>

        </div>

        <div class="back">
            <a href="buy_pay.php">戻る</a>
        </div>

    </main>

    <!-- フッター部分 -->
    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    <!-- jQuery -->
    <!-- <script src="js/JQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</body>

<style>
    .stepbar-row {
        position: relative;
        top: 20px;
    }
</style>

</html>