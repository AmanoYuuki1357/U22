<?php
require('common.php');
require "test.php";
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

                <div class="row">
                    <div class="col-md-2">
                        <p>お客様名</p>
                    </div>
                    <div class="col" aria-describedby="user_name">
                        <p><?php print $user["f_user_name"] ?>様</p>
                    </div>
                    <div id="user_name" class="form-text">
                        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <p>メールアドレス</p>
                    </div>
                    <div class="col">
                        <p><?php print $user["email"] ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <p>パスワード</p>
                    </div>
                    <div class="col">
                        <p>[表示しません]</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="nick_name" class="form-label">
                            <p>ニックネーム</p>
                        </label>
                    </div>
                    <div class="col">
                        <input type="text" id="nick_name" name="nick_name" value="<?php print $user["f_user_nick_name"] ?>" placeholder="ニックネームを入力してください" require />様
                    </div>
                </div>

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
                        </td>
                    </tr>
                    <tr>
                        <th>都道府県</th>
                        <td>
                            <input type="text" name="region" class="p-region" placeholder="都道府県" readonly style="background-color: #eee;" />
                        </td>
                        <td>
                            <?php
                            if (isset($error['region']) && $error['region'] == 'blank') {
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
                            if (isset($error['locality']) && $error['locality'] == 'blank') {
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
                            if (isset($error['street-address']) && $error['street-address'] == 'blank') {
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

                <p>年齢</p>
                <input type="text" name="age" value="<?php print $user["f_user_age"] ?>" placeholder="年齢を入力してください" />

                <!-- TODO: ポイント付与機能がないのでコメントアウト化 -->
                <!-- <p>ポイント</p> -->
                <!-- <p><?php // print $user["f_user_point"] 
                        ?>点</p> -->

                <p>身長</p>
                <p><input type="text" name="height" value="<?php print $user["f_user_height"] ?>" placeholder="身長を入力してください" />cm</p>

                <p>体重</p>
                <input type="text" name="weight" value="<?php print $user["f_user_weight"] ?>" placeholder="体重を入力してください" />

        </div>

        <div>
            <input type="submit" class="btn btn-secondary" name="reset" value="クリア" />
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