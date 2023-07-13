<?php
require('common.php');
require('test.php');
error_reporting(E_ALL & ~E_NOTICE);

// ===================================================================================
// SQL
// ===================================================================================
$sqlUser = '
    SELECT
        f_user_id,
        f_user_name,
        f_user_nick_name,
        f_user_address      AS address
    FROM
        t_users
    WHERE
        f_user_id = ? ;';

// ===================================================================================
// セッション開始
// ===================================================================================
if (!isset($_SESSION)) {
    session_start();
}

// REVIEW: オブジェクト生成
$test = new test();

// ユーザーID取得
if (isset($_SESSION['id'])) {

    $userId = $_SESSION['id'];          // ログインユーザーのIDを取得
    // $_SESSION['buy']['address'] = "";   // お届け先初期化

    // ===================================================================================
    // DB検索
    // ===================================================================================
    // ユーザー情報取得
    $contents = $db->prepare($sqlUser);
    $contents->bindparam(1, $userId, PDO::PARAM_INT);
    $contents->execute();
    $user = $contents->fetch();

    if (!isset($_SESSION['buy']['address']) || empty($_SESSION['buy']['address'])) {
        $_SESSION['buy']['address'] = $user['address'];

        // REVIEW: 確認ログ
        $test->info("[OK]DB:address取得");
    }
} else {
    // ログインページへ
    header('Location: login.php');
}

// ===================================================================================
// 入力チェック
// ===================================================================================
if (!empty($_POST)) {
    // -------------------------------------------------------------------------------
    // 郵便番号
    // -------------------------------------------------------------------------------
    // 必須チェック
    if ($_POST['postal-code'] == '') {
        $error['postal-code'] = 'blank';
    } else {
        // -------------------------------------------------------------------------------
        // 都道府県
        // -------------------------------------------------------------------------------
        // 必須チェック・不整合チェック
        if ($_POST['region'] == '') {
            $error['region'] = 'blank';
        }

        // -------------------------------------------------------------------------------
        // 市区町村
        // -------------------------------------------------------------------------------
        // 必須チェック・不整合チェック
        if ($_POST['locality'] == '') {
            $error['locality'] = 'blank';
        }
    }

    // -------------------------------------------------------------------------------
    // 町名番地
    // -------------------------------------------------------------------------------
    if ($_POST['street-address'] == '') {
        $error['street-address'] = 'blank';
    }

    // -------------------------------------------------------------------------------
    // マンション名ほか
    // -------------------------------------------------------------------------------
    // 必須チェックなし

    // エラーなしの場合
    if (empty($error)) {
        $_SESSION['buy']['address'] = '〒' . $_POST['postal-code'] . ' ' . $_POST['region'] . $_POST['locality'] . $_POST['street-address'] . $_POST['others'];
        $test->info("[OK]SESSION:address取得");
    }
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入お届け先情報</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/buy_address.css"> -->

</head>

<body>

    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>

    <main>
        <!-- 進行度バー -->
        <div class="stepbar-row">
            <ol class="stepbar">
                <li class="done"><span></span><br />お届け先</li>
                <li><span></span><br />お支払方法</li>
                <li><span></span><br />完了</li>
            </ol>
        </div>


        <!-- https://coliss.com/articles/build-websites/operation/css/pure-css-progress-bar.html
        ここ参考に進める予定 -->


        <!-- <div class="step-bar">
        <div class="step">
            ステップ1
        </div>
        <div class="step">
            ステップ2
        </div>
        <div class="step">
            ステップ3
        </div>
        </div>


        <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemax="3"></div>
        </div>

        <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 33.33%;" aria-valuenow="33.33" aria-valuemin="0" aria-valuemax="100">お届け先</div>

        </div>

        <div class="progress">

        <div class="progress-bar" role="progressbar" style="width: 66.66%;" aria-valuenow="66.66" aria-valuemin="0" aria-valuemax="100">お支払い</div>
        </div> -->

        <div class="container">
            <div class="row">
                <h2>お届け情報</h2>
            </div>

            <hr>

            <!-- 現在のお届け先 -->
            <!-- デフォルトはT_users.f_user_address -->
            <div class="row">
                <h4>現在のお届け先</h4>
            </div>
            <div class="row" style="margin-bottom: 30px;">
                <p class='address' <?php empty($_SESSION['buy']['address']) && print "style='color: red'" ?>>
                    <?php
                    print empty($_SESSION['buy']['address'])
                        ? "登録がありません"
                        : $_SESSION['buy']['address'];
                    ?>
                </p>
            </div>

            <details>
                <summary style="width: 300px; list-style:none;">
                    <div class="row">
                        <!-- クリックで編集フォームを展開 -->
                        <h5 style="border-bottom:1px solid;">お届け先を編集する</h5>
                    </div>
                </summary>

                <form class="h-adr" action="" method="post">
                    <!-- 郵便番号による住所の自動入力 -->
                    <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
                    <span class="p-country-name" style="display:none;">Japan</span>

                    <!-- 郵便番号 -->
                    <div class="row">
                        <div class="col-md-2">
                            <label for="postal-code" class="form-label">
                                <p><span class="attention">*</span>郵便番号</p>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-text">〒</div>
                                <input type="text" id="postal-code" name="postal-code" class="p-postal-code form-control" maxlength="8" value="<?php isset($_POST["postal-code"]) && print h($_POST["postal-code"]) ?>" placeholder="郵便番号" />
                            </div>
                        </div>
                        <div class="col">
                            <?php
                            // エラーメッセージ
                            isset($error['postal-code'])
                                && $error['postal-code'] == 'blank'
                                && print '<p style="color: red;">郵便番号の入力がありません</p>';
                            ?>
                        </div>
                    </div>

                    <!-- 都道府県 -->
                    <div class="row">
                        <div class="col-md-2">
                            <label for="region" class="form-label">
                                <p><span class="attention">*</span>都道府県</p>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="region" name="region" class="p-region form-control" value="<?php isset($_POST["region"]) && print h($_POST["region"]) ?>" placeholder="都道府県" readonly />
                        </div>
                        <div class="col">
                            <?php
                            // エラーメッセージ
                            isset($error['region'])
                                && $error['region'] == 'blank'
                                && print '<p style="color: red;">正しい郵便番号を入力してください</p>';
                            ?>
                        </div>
                    </div>

                    <!-- 市区町村 -->
                    <div class="row">
                        <div class="col-md-2">
                            <label for="locality" class="form-label">
                                <p><span class="attention">*</span>市区町村</p>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="locality" name="locality" class="p-locality form-control" value="<?php isset($_POST["locality"]) && print h($_POST["locality"]) ?>" placeholder="市区町村" readonly />
                        </div>
                        <div class="col">
                            <?php
                            // エラーメッセージ
                            isset($error['locality'])
                                && $error['locality'] == 'blank'
                                && print '<p style="color: red;">正しい郵便番号を入力してください</p>';
                            ?>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="street-address" class="form-label">
                                <p><span class="attention">*</span>町名番地</p>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="street-address" name="street-address" class="p-street-address p-extended-address form-control" value="<?php isset($_POST["street-address"]) && print h($_POST["street-address"]) ?>" placeholder="町名番地" />
                        </div>
                        <div class="col">
                            <?php
                            // エラーメッセージ
                            isset($error['street-address'])
                                && $error['street-address'] == 'blank'
                                && print '<p style="color: red;">入力がありません</p>';
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <label for="others" class="form-label">
                                <p>マンション名ほか</p>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="others" name="others" class="form-control" placeholder="マンション名ほか" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <input id="fin" type='submit' class="btn btn-primary" value="お届け先を変更する">
                    </div>
                </form>
            </details>

            <div class="d-md-flex justify-content-center">
                <a href="cart.php" class="btn btn-secondary me-md-2">戻る</a>
                <?php
                // 住所が取得できた時だけ次のページへのリンクを表示
                !empty($_SESSION['buy']['address'])
                    && print('<a href="buy_pay.php" class="btn btn-primary">お支払方法に進む</a>');
                ?>
            </div>
            <!-- <div class="back"><a href="my_page.php">マイページへ</a></div> -->

        </div>

    </main>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../js/validation.js"></script>

</body>

</html>