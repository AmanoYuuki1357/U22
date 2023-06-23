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
    // ログインユーザーのIDを取得
    $userId = $_SESSION['id'];

    // ===================================================================================
    // DB検索
    // ===================================================================================
    // ユーザー情報取得
    $contents = $db->prepare($sqlUser);
    $contents->bindparam(1, $userId, PDO::PARAM_INT);
    $contents->execute();
    $user = $contents->fetch();

    if(!isset($_SESSION['buy']['address']) || empty($_SESSION['buy']['address'])){
        $_SESSION['buy']['address'] = $user['address'];

        // REVIEW: 確認ログ
        $test->info("[OK]DB:address取得");
    }
}
else{
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">
    <!-- <link rel="stylesheet" type="text/css" href="../css/buy_address.css"> -->

</head>

<body>

<!-- ヘッダー部分 -->
<?php
require('header.php');
?>

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


            <div class="step-bar">
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
</div>



            <div id="box">
                <h2>お届け情報</h2>

                <hr>

                <!-- デフォルトはユーザの住所 -->
                <h3>お届け先</h3>
                <?php
                if (empty($_SESSION['buy']['address'])) {
                    // 入力なし
                    print("<p class='address' style='color: red'>登録がありません</p>");
                } else {
                    // 入力あり
                    print("<p class='address'>" . $_SESSION['buy']['address'] . "</p>");
                }
                ?>

                <h3>新しいお届け先を登録する</h3>

                <form class="h-adr" action="" method="post">
                    <div>
                        <!-- 郵便番号による住所の自動入力 -->
                        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

                        <span class="p-country-name" style="display:none;">Japan</span>
                        <table>
                            <tr>
                                <th>郵便番号</th>
                                <td>
                                    〒<input type="text" name="postal-code" class="p-postal-code" size="8" maxlength="8" placeholder="郵便番号" />
                                </td>
                                <td>
                                    <?php
                                        if (isset($error['postal-code']) && $error['postal-code'] == 'blank') {
                                                print '<p style="color: red;">入力がありません</p>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>都道府県</th>
                                <td>
                                    <input type="text" name="region" class="p-region" placeholder="都道府県" readonly style="background-color: #eee;" />
                                </td>
                                <td>
                                    <?php
                                        if ( isset($error['region']) && $error['region'] == 'blank' ) {
                                            print '<p style="color: red;">正しい郵便番号を入力してください</p>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>市区町村</th>
                                <td>
                                    <input type="text" name="locality" class="p-locality" placeholder="市区町村" readonly style="background-color: #eee;" />
                                </td>
                                <td>
                                    <?php
                                        if ( isset($error['locality']) && $error['locality'] == 'blank' ) {
                                            print '<p style="color: red;">正しい郵便番号を入力してください</p>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>町名番地</th>
                                <td>
                                    <input type="text" name="street-address" class="p-street-address p-extended-address" placeholder="町名番地" />
                                </td>
                                <td>
                                    <?php
                                        if ( isset($error['street-address']) && $error['street-address'] == 'blank') {
                                            print '<p style="color: red;">入力がありません</p>';
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>マンション名ほか</th>
                                <td>
                                    <input type="text" name="others" placeholder="マンション名ほか" />
                                </td>
                            </tr>
                        </table>
                        <input id="fin" type='submit' value="変更する">
                    </div>
                </form>

                <?php
                if (!empty($_SESSION['buy']['address'])) {
                    // 住所が取得できた時だけ次のページへのリンクを表示
                    print('<div><a href="buy_pay.php">次へ:お支払方法</a></div>');
                }
                ?>
                <!-- <div class="back"><a href="my_page.php">マイページへ</a></div> -->

            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>


    <!-- jQuery -->
    <!-- <script src="js/JQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>