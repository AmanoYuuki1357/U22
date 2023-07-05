<?php
require('common.php');
require "test.php";
error_reporting(E_ALL & ~E_NOTICE);

// ===================================================================================
// SQL
// ===================================================================================
$sql = '
        SELECT
            f_user_name,
            f_user_nick_name,
            f_user_gender,
            f_user_gender   AS gender,
            f_user_age      AS age,
            f_user_address  AS address,
            f_user_job      AS job,
            f_user_email    AS email,
            f_user_point    AS point,
            f_user_height   AS height,
            f_user_weight   AS weight
        FROM
            t_users
        WHERE
            f_delete_flag = 0
        AND f_user_id=?;';

$sqlupdate = '
        UPDATE
            t_users
        SET
            f_user_name         = ?,
            f_user_nick_name    = ?,
            f_user_gender       = ?,
            f_user_age          = ?,
            f_user_address      = ?,
            f_user_job          = ?,
            f_user_height       = ?,
            f_user_weight       = ?
        WHERE
            f_user_id = ? ;';

$test = new test();
// ===================================================================================
// 更新するボタン押下時のイベント
// ===================================================================================
if (isset($_POST["update"])) {
    // REVIEW: 
    $test->debug("入力チェック開始");
    $test->debug($_POST);

    // -------------------------------------------------------------------------------
    // 入力チェック
    // -------------------------------------------------------------------------------
    // TODO: 入力チェック作る
    $exist["age"]       = false;
    $exist["address"]   = false;
    $exist["job"]       = false;
    $exist["height"]    = false;
    $exist["weight"]    = false;

    // 名前
    // TODO: 必須チェック

    // ニックネーム
    // TODO: 必須チェック

    // 性別

    // 年齢
    if ($_POST["age"] !== "") {
        $exist["age"] = true;
    }

    // 住所
    if ($_POST["postal-code"] !== "") {
        $exist["address"] = true;
        $address = '〒' . $_POST['postal-code'] . ' ' . $_POST['address'];
    }

    // 職業
    if ($_POST["job"] !== "") {
        $exist["job"] = true;
    }

    // 身長
    if ($_POST["height"] !== "") {
        $exist["height"] = true;
    }

    // 体重
    if ($_POST["weight"] !== "") {
        $exist["weight"] = true;
    }

    if (empty($error)) {
        // -------------------------------------------------------------------------------
        // ユーザー情報の更新
        // -------------------------------------------------------------------------------
        $test->debug("登録処理開始");

        $contents = $db->prepare($sqlupdate);
        $contents->bindparam(1, $_POST["name"],      PDO::PARAM_STR);
        $contents->bindparam(2, $_POST["nick_name"], PDO::PARAM_STR);
        $contents->bindparam(3, $_POST["gender"],    PDO::PARAM_INT);
        $contents->bindparam(4, $_POST["age"],       $exist["age"]      ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $contents->bindparam(5, $address,            $exist["address"]  ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $contents->bindparam(6, $_POST["job"],       $exist["job"]      ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $contents->bindparam(7, $_POST["height"],    $exist["height"]   ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $contents->bindparam(8, $_POST["weight"],    $exist["weight"]   ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $contents->bindparam(9, $_SESSION["id"],     PDO::PARAM_INT);
        $updateUser = $contents->execute();

        // 更新失敗した場合
        if ($updateUser != 1) {
            // TODO: 更新失敗時の動作を考える
            $test->error("登録処理失敗");
        }

        // 更新成功
        header('Location: user_upd.php');
        exit;
    }
}
// ===================================================================================
// セッション開始
// ===================================================================================
if (!isset($_SESSION)) {
    session_start();
}

// ユーザー情報取得   
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/mypage.css"> -->

</head>

<body>
    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>
    <main>
        <div class="container">

            <div class="row">
                <h1 style="padding-bottom: 30px;">ユーザー情報の閲覧・変更</h1>
            </div>

            <!-- <hr> -->

            <form class="h-adr" action="" method="post">

                <!-- 名前 -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="name" class="form-label">
                            <p><span class="attention">*</span>お客様名</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_name">
                        <input type="text" id="name" name="name" value="<?php print $user["f_user_name"] ?>" placeholder="お名前を入力してください" require />様
                    </div>
                    <div id="caption_name" class="col form-text">
                        お客様のお名前です。配達先の宛名に使用されます。
                    </div>
                </div>

                <!-- メールアドレス -->
                <div class="row">
                    <div class="col-md-2">
                        <p><span class="attention">*</span>メールアドレス</p>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_email">
                        <p><?php print $user["email"] ?></p>
                    </div>
                    <div id="caption_email" class="col form-text">
                        お客様のメールアドレスです。ログインや配達のご連絡に使用されます。
                    </div>
                </div>

                <!-- パスワード -->
                <div class="row">
                    <div class="col-md-2">
                        <p><span class="attention">*</span>パスワード</p>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_password">
                        <p>[表示しません]</p>
                    </div>
                    <div id="caption_password" class="col form-text">
                        お客様のパスワードです。ログインの際に使用されます。
                    </div>
                </div>

                <!-- ニックネーム -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="nick_name" class="form-label">
                            <p><span class="attention">*</span>ニックネーム</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_nick_name">
                        <input type="text" id="nick_name" name="nick_name" value="<?php print $user["f_user_nick_name"] ?>" placeholder="ニックネームを入力してください" require />様
                    </div>
                    <div id="caption_nick_name" class="col form-text">
                        お客様のニックネームです。マイページやレビュー投稿の際に使用されます。
                    </div>
                </div>

                <!-- 郵便番号による住所の自動入力 -->
                <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
                <span class="p-country-name" style="display:none;">Japan</span>

                <!-- 住所 -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="address" class="form-label">
                            <p>住所</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_address">
                        <div class="row">
                            <!-- 郵便番号 -->
                            <p>〒<input
                                type="text"
                                id="address"
                                name="postal-code"
                                class="p-postal-code"
                                size="8"
                                maxlength="8"
                                value="<?php print mb_substr($user["address"], 1, 8); ?>"
                                placeholder="郵便番号" /></p>
                        </div>
                        <div class="row">
                            <!-- 住所 -->
                            <p><input
                                type="text"
                                name="address"
                                class="p-region p-locality p-street-address p-extended-address"
                                value="<?php print mb_substr($user["address"], 10); ?>"
                                placeholder="住所を入力してください"
                                style="width: 90%" /></p>
                        </div>
                    </div>
                    <div id="caption_address" class="col form-text">
                        お客様の住所です。デフォルトのお届け先として使用されます。
                    </div>

                </div>

                <!-- 性別 -->
                <div class="row">
                    <div class="col-md-2">
                        <p>性別</p>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_gender">
                        <?php
                        $checked_male   = false;    // 男性
                        $checked_female = false;    // 女性
                        $checked_other  = false;    // そのほか

                        // 初期チェック状態の取得
                        switch ($user["gender"]) {
                            case 0:
                                // 男性
                                $checked_male = true;
                                break;
                            case 1:
                                // 女性
                                $checked_female = true;
                                break;
                            default:
                                // そのほか
                                $checked_other = true;
                                break;
                        }
                        ?>
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input - type="radio" class="btn-check" name="gender" id="other" value="9" autocomplete="off" <?php $checked_other && print "checked"; ?>>
                            <label class="btn btn-outline-primary" for="other">そのほか</label>

                            <input type="radio" class="btn-check" name="gender" id="male" value="0" autocomplete="off" <?php $checked_male && print "checked"; ?>>
                            <label class="btn btn-outline-primary" for="male">男性</label>

                            <input type="radio" class="btn-check" name="gender" id="female" value="1" autocomplete="off" <?php $checked_female && print "checked"; ?>>
                            <label class="btn btn-outline-primary" for="female">女性</label>
                        </div>
                    </div>
                    <div id="caption_gender" class="col form-text">
                        お客様の性別です。
                    </div>
                </div>

                <!-- 年齢 -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="age" class="form-label">
                            <p>年齢</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_age">
                        <input type="text" id="age" name="age" value="<?php print $user["age"] ?>" placeholder="年齢を入力してください" />歳
                    </div>
                    <div id="caption_age" class="col form-text">
                        お客様の年齢です。
                    </div>
                </div>

                <!-- TODO: ポイント付与機能がないのでコメントアウト化 -->
                <!-- <p>ポイント</p> -->
                <!-- <p><?php // print $user["f_user_point"] 
                        ?>点</p> -->

                <!-- 職業 -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="job" class="form-label">
                            <p>職業</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_job">
                        <input type="text" id="job" name="job" value="<?php print $user["job"] ?>" placeholder="職業を入力してください" />
                    </div>
                    <div id="caption_job" class="col form-text">
                        お客様の職業です。
                    </div>
                </div>

                <!-- 身長 -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="height" class="form-label">
                            <p>身長</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_height">
                        <input type="text" id="height" name="height" value="<?php print $user["height"] ?>" placeholder="身長を入力してください" />cm
                    </div>
                    <div id="caption_height" class="col form-text">
                        お客様の身長です。
                    </div>
                </div>

                <!-- 身長 -->
                <div class="row">
                    <div class="col-md-2">
                        <label for="weight" class="form-label">
                            <p>体重</p>
                        </label>
                    </div>
                    <div class="col-md-6" aria-describedby="caption_weight">
                        <input type="text" id="weight" name="weight" value="<?php print $user["weight"] ?>" placeholder="体重を入力してください" />kg
                    </div>
                    <div id="caption_weight" class="col form-text">
                        お客様の体重です。
                    </div>
                </div>

                <div>
                    <input type="submit" class="btn btn-secondary" name="reset" value="現在の情報に戻す" />
                    <input type="submit" class="btn btn-primary" name="update" value="更新する" />
                </div>
            </form>
        </div>
    </main>

    <footer>
        <!-- コピーライト -->
        <small>&copy; 2023 ミールフレンド all right reserved</small>
    </footer>

    <!-- jQuery -->
    <!-- <script src="js/jQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    <!-- コンテンツが短い時にfooterをwindow最下部に固定する -->
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

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

<style>
    main {
        padding-bottom: 30px;
    }

    footer {
        position: fixed;
    }

    div+div {
        padding-bottom: 10px;
    }
</style>

</html>