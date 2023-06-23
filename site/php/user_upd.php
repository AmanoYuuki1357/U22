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

            <form class="h-adr" action="" method="post">
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
                                if ( isset($error['region']) && $error['region'] == 'blank') {
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