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
    if(isset($_POST["update"])){
        // REVIEW: 
        $test->debug("入力チェック開始");
        $test->debug($_POST);

        // -------------------------------------------------------------------------------
        // 入力チェック
        // -------------------------------------------------------------------------------
        // TODO: 入力チェック作る
        // ニックネーム
        // 性別
        // 年齢
        // 住所
        // 職業
        // 身長
        // 体重

        if(empty($error)){
            // -------------------------------------------------------------------------------
            // ユーザー情報の更新
            // -------------------------------------------------------------------------------
            $test->debug("登録処理開始");
            $address = '〒' . $_POST['postal-code'] . ' ' . $_POST['region'] . $_POST['locality'] . $_POST['street-address'] . $_POST['others'];

            $contents = $db->prepare($sqlupdate);
            $contents->bindparam(1, $_POST["nick_name"], PDO::PARAM_STR);
            $contents->bindparam(2, $_POST["gender"],    PDO::PARAM_INT);
            $contents->bindparam(3, $_POST["age"],       PDO::PARAM_INT);
            $contents->bindparam(4, $address,            PDO::PARAM_STR);
            $contents->bindparam(5, $_POST["job"],       PDO::PARAM_STR);
            $contents->bindparam(6, $_POST["height"],    PDO::PARAM_STR);
            $contents->bindparam(7, $_POST["weight"],    PDO::PARAM_STR);
            $contents->bindparam(8, $_SESSION["id"],     PDO::PARAM_INT);
            $updateUser = $contents->execute();

            // 更新失敗した場合
            if($updateUser != 1){
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">

</head>

<body>
    <!-- ヘッダー部分 -->
    <?php require('header.php'); ?>

    <main>

        <div style="padding: 30px; padding-top: 0;">
            <h1 class="h3 mb-3 fw-normal">ユーザー情報の閲覧・変更</h1>

            <hr>

            <form class="h-adr" action="" method="post">
            <div class="row g-3">

                <div class="col-md-4">
                    <p>お客様名</p>
                    <p><?php print $user["f_user_name"] ?>様</p>
                </div>

                <div class="col-md-4">
                    <label for="nick_name" class="form-label">ニックネーム</label>
                    <p><input
                        type="text"
                        id="nick_name"
                        name="nick_name"
                        value="<?php print $user["f_user_nick_name"] ?>"
                        placeholder="ニックネームを入力してください"
                        require />様</p>
                </div>

                <div class="col-12">
                    <p>メールアドレス</p>
                    <p><?php print $user["email"] ?></p>
                </div>

                <div class="col-12">
                    <p>パスワード</p>
                    <p>[表示しません]</p>
                </div>

                <p>住所</p>
                <!-- <input type="text" name="address" value="<?php // print $user["address"]?>" placeholder="住所を入力してください" /> -->
                <p><?php print $user["address"] ?></p>

                <!-- 郵便番号による住所の自動入力 -->
                <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

                <span class="p-country-name" style="display:none;">Japan</span>
                <table>
                    <tr>
                        <th>郵便番号</th>
                        <td>
                            〒<input
                                type="text"
                                name="postal-code"
                                class="p-postal-code"
                                size="8"
                                maxlength="8"
                                placeholder="郵便番号" />
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

                <p>性別</p>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input
                        type="radio"
                        class="btn-check"
                        name="gender"
                        id="other"
                        value="9"
                        autocomplete="off"
                        checked>
                    <label class="btn btn-outline-primary" for="other">そのほか</label>

                    <input type="radio" class="btn-check" name="gender" id="male" value="0" autocomplete="off">
                    <label class="btn btn-outline-primary" for="male">男性</label>

                    <input type="radio" class="btn-check" name="gender" id="female" value="1" autocomplete="off">
                    <label class="btn btn-outline-primary" for="female">女性</label>
                </div>

                <p>年齢</p>
                <input type="text" name="age" value="<?php print $user["age"]?>" placeholder="年齢を入力してください" />
                
                <!-- TODO: ポイント付与機能がないのでコメントアウト化 -->
                <!-- <p>ポイント</p> -->
                <!-- <p><?php // print $user["f_user_point"] ?>点</p> -->

                <p>職業</p>
                <input type="text" name="job" value="<?php print $user["job"]?>" placeholder="職業を入力してください" />

                <p>身長</p>
                <p><input type="text" name="height" value="<?php print $user["height"]?>" placeholder="身長を入力してください" />cm</p>

                <p>体重</p>
                <p><input type="text" name="weight" value="<?php print $user["weight"]?>" placeholder="体重を入力してください" />kg</p>

            </div>

            <div>
                <input type="submit" class="btn btn-secondary" name="reset" value="登録の内容に戻す" />
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

    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>