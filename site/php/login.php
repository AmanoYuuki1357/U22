<?php


require('common.php');
error_reporting(E_ALL & ~E_NOTICE);
if (!isset($_SESSION)) {
    session_start();
}

if (!empty($_POST)) {
    //会員登録の処理
    if ($_POST['type'] == 'regist') {
        if ($_POST['name'] == '') {
            $error['name'] = 'blank';
        }
        if ($_POST['nickname'] == '') {
            $error['nickname'] = 'blank';
        }
        if ($_POST['email'] == '') {
            $error['email'] = 'blank';
        }
        if ($_POST['password'] == '') {
            $error['password'] = 'blank';
        } elseif (strlen($_POST['password']) < 4) {
            $error['password'] = 'length';
        }
        if ($_POST['password_re'] == '') {
            $error['password_re'] = 'blank';
        } elseif ($_POST['password'] != $_POST['password_re']) {
            $error['password_re'] = 'notequal';
        }
        //アカウントの重複をチェック
        if (empty($error)) {
            $member = $db->prepare('SELECT COUNT(*) AS cnt FROM t_users WHERE f_user_email=?');
            $member->execute(array($_POST['email']));
            $record = $member->fetch();
            if ($record['cnt'] > 0) {
                $error['email'] = 'duplicate';
            } else {
                $statement = $db->prepare('INSERT INTO t_users SET f_user_name=?,f_user_nick_name=?,f_user_email=?,f_user_password=?');
                $statement->execute(array($_POST['name'], $_POST['nickname'], $_POST['email'], sha1($_POST['password'])));
                $login = $db->prepare('SELECT * FROM t_users WHERE f_user_email=?');
                $login->execute(array($_POST['email']));
                $member = $login->fetch();

                $_SESSION['id'] = $member['f_user_id'];
                header('Location: menu.php');
                exit();
            }
        }
    } else if ($_POST['email'] != '' && $_POST['password'] != '') {
        if (empty($error)) {
            $login = $db->prepare('SELECT * FROM t_users WHERE f_user_email=? AND f_user_password=?');
            $login->execute(array($_POST['email'], sha1($_POST['password'])));
            $member = $login->fetch();

            if ($member) {
                $_SESSION['id'] = $member['f_user_id'];
                header('Location: menu.php');
                exit();
            } else {
                $error['login'] = 'failed';
            }
        } else {
            $error['login'] = 'blank';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <!-- <link rel="stylesheet" type="text/css" href="../css/reset.css"> -->
    <link rel="stylesheet" href="../css/common.css">
    <!-- <link rel="stylesheet" href="../css/login.css"> -->
</head>

<body>
    <div id="wrap">
        <header>
            <h1>ロゴ入れたいねぇ</h1>
            <nav>
                <div>
                    <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
                </div>

                <!-- ログインしていない時 -->
                <!-- <a href="login.php">ログイン/会員登録</a> -->
                <!-- ログインしている時 -->
            </nav>
        </header>

        <main>
            <p>ログイン</p>
            <div id="login">
                <form action="" method="post">
                    <div>
                        <p>メールアドレス</p>
                        <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($_POST['email']); ?>" />
                        <?php if ($error['login'] == 'blank') : ?>
                            <p class="error">*メールアドレスとパスワードをご記入ください</p>
                        <?php endif; ?>
                        <?php if ($error['login'] == 'failed') : ?>
                            <p class="error">*ログインに失敗しました。正しくご記入ください</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p>パスワード</p>
                        <input type="password" name="password" size="35" maxlength="255" value="<?php echo h($_POST['password']); ?>" />
                    </div>
                    <input type='submit' value="ログイン">
                    <div>
                    </div>
                </form>
                <div>
                    <p>
                        <a href="/site/php/pass_reset.php">パスワードをお忘れの方はこちら</a>
                    </p>
                </div>
            </div>


            <p>初めてご利用の方はこちら</p>
            <div id="regist">
                <form action="" method="post">
                    <div>
                        <p>必須</p>
                        <p>お名前</p>
                        <input type="text" name="name" size="35" maxlength="255" value="<?php echo h($_POST['name']); ?>" />
                        <?php if ($error['name'] == 'blank') : ?>
                            <p class="error">*ニックネームを入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p>必須</p>
                        <p>ニックネーム</p>
                        <input type="text" name="nickname" size="35" maxlength="255" value="<?php echo h($_POST['nickname']); ?>" />
                        <?php if ($error['nickname'] == 'blank') : ?>
                            <p class="error">*ニックネームを入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p>メールアドレス</p>
                        <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($_POST['email']); ?>" />
                        <?php if ($error['email'] == 'blank') : ?>
                            <p class="error">*メールアドレスを入力してください</p>
                        <?php endif; ?>
                        <?php if ($error['email'] == 'duplicate') : ?>
                            <p class="error">*指定されたメールアドレスはすでに登録されています</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p>パスワード</p>
                        <input type="password" name="password" size="10" maxlength="20" value="<?php echo h($_POST['password']); ?>" />
                        <?php if ($error['password'] == 'blank') : ?>
                            <p class="error">*パスワードを入力してください</p>
                        <?php endif; ?>
                        <?php if ($error['password'] == 'length') : ?>
                            <p class="error">*パスワードは4文字以上で入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p>パスワード(確認用)</p>
                        <input type="password" name="password_re" size="10" maxlength="20" value="<?php echo h($_POST['password_re']); ?>" />
                        <?php if ($error['password_re'] == 'blank') : ?>
                            <p class="error">*パスワード(確認用)を入力してください</p>
                        <?php endif; ?>
                        <?php if ($error['password_re'] == 'notequal') : ?>
                            <p class="error">*パスワードが一致していません</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type='hidden' name="type" value="regist">
                        <input type='submit' value="この内容でアカウントを作る">
                    </div>
                </form>
            </div>
            <div>
                <a href="">元の画面へ</a>
                <a href="my_page.php">マイページへ</a>
            </div>
        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
    </div>
</body>
<style>
</style>

</html>