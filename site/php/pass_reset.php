<!-- <?php
        require('common.php');
        error_reporting(E_ALL & ~E_NOTICE);
        if (!isset($_SESSION)) {
            session_start();
        }

        ?> -->


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワード再設定</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/pass_reset.css">
</head>

<body>
    <div id="wrap">
        <header>

            <h2>
                ミールフレンド
            </h2>
            <div>
                <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>

            <div id="header-right">
                <!-- ログインしていない時 -->
                <a href="login.php">ログイン/会員登録</a>

                <!-- ログインしている時 -->
                <!-- ユーザーメニュー -->
                <div id="user">
                    <label>
                        <img class="headerimg" src="../images/icon.jpg" alt="アイコン">
                        <!-- <img src=icon_images/<?php print(h($icon["userIcon"])) ?> alt="アイコン"> -->
                    </label>
                    <div>
                        <a href="my_page.php">ニックネーム</a>
                        <!-- <a href="my_page.php"><?php print(h($user["userNickName"])) ?></a> -->
                    </div>
                </div>
            </div>

        </header>

        <main>
            <p>パスワード再設定</p>
            <form action="" method="post">
                <div>
                    <p>メールアドレス</p>
                    <input type="text" />
                    <!-- <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($_POST['email']); ?>" />
                        <?php if ($error['login'] == 'blank') : ?>
                            <p class="error">*メールアドレスとパスワードをご記入ください</p>
                        <?php endif; ?>
                        <?php if ($error['login'] == 'failed') : ?>
                            <p class="error">*ログインに失敗しました。正しくご記入ください</p>
                        <?php endif; ?> -->
                </div>
                <div>
                    <p>新しいパスワード</p>
                    <input type="text" />
                    <!-- <input type="password" name="password" size="35" maxlength="255" value="<?php echo h($_POST['password']); ?>" /> -->
                </div>
                <div>
                    <p>新しいパスワード（確認）</p>
                    <input type="text" />
                    <!-- <input type="password" name="password" size="35" maxlength="255" value="<?php echo h($_POST['password']); ?>" /> -->
                </div>
                <div>
                    <button>再設定する</button>
                    <!-- <input class="wid" type='submit' value="ログイン"> -->
                </div>
            </form>
            <div>
                <a href="">元の画面へ</a>
                <a href="my_page.php">マイページへ</a>
            </div>
        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
    </div>


    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>