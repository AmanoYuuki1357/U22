<!-- <?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    if(!isset($_SESSION)){
        session_start();
    }

    // セッションにユーザー情報があり、ログイン後に行動してから60分以内であるとき
    if(isset($_SESSION['id']) && $_SESSION['time'] + 3600>time()){
        // ログインした時間を現在の時間に更新
        $_SESSION['time']=time();
        // セッション変数のidを使って、ユーザーの情報を呼び出す
        $members=$db->prepare('SELECT * FROM user_info WHERE userID=?');
        $members->execute(array($_SESSION['id']));
        $member=$members->fetch();
        // ログインしていないとき
    }else{
        // 即時にログイン画面に転送する
        header('Location: login.php');
        exit();
    }

    $posts=$db->query('SELECT * FROM works_info ORDER BY worksCreated DESC;');
    // for($i=0; $post=$posts->fetch(PDO::FETCH_ASSOC); $i++){}
    $post=$posts->fetch(PDO::FETCH_ASSOC);
    for($i=0; $i>5; $i++){
        if($i==0){
            print("<tr>");
        }
        if($i==5){
            print("</tr>");
        }
    }

    // ヘッダーのアイコン
    $icons=$db->prepare('SELECT userIcon FROM user_info WHERE userID=?');
    $icons->execute(array($_SESSION['id']));
    $icon=$icons->fetch();

?> -->

<!DOCTYPE html>
<html lang="ja">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>カート</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css">

    </head>

    <body>
        <div id="wrap">
            <header>

                <div>
                    <a href="menu.php">商品一覧</a>
                </div>

                <div>
                    <a href="index.php"><img src="../images/logo.jpg" alt="ロゴ"></a>
                </div>

                <!-- ログインしていない時 -->
                <div>
                    <a href="login.html">ログイン/会員登録</a>
                </div>

                <!-- ログインしている時 -->
                <!-- ユーザーメニュー -->
                <div id="user">
                    <div>
                        <img src="../images/icon.jpg" alt="アイコン">
                    </div>
                    <div>
                        <a href="my_page.html">ニックネーム</a>
                        <!-- <a href="my_page.php"><?php print(h($user["userNickName"])) ?></a> -->
                    </div>
                </div>

                <!-- どちらの場合でもカートは出す -->
                <div>
                    <a href="cart.html"><img src="../images/cart.jpg" alt="カート"></a>
                </div>

            </header>

            <main>

                <div>

                    <h3>ショッピングカート</h3>

                    <div>
                        <button>pic</button>
                        <p>商品名</p>
                        <p>何円</p>
                        <p>-</p>
                        <p>個数</p>
                        <p>+</p>
                    </div>
                    <hr>

                    <div>
                        <button>pic</button>
                        <p>商品名</p>
                        <p>何円</p>
                        <p>-</p>
                        <p>個数</p>
                        <p>+</p>
                    </div>
                    <hr>

                </div>

                <div>
                    <div>
                        <p>合計</p>
                        <p>何円</p>
                    </div>
                    <div>
                        <a href="buy_pay.html">購入する</a>
                        <!-- ここはformのinputのbutton -->
                    </div>

                </div>

            </main>

            <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

        </div>

    <!-- jQuery -->
    <!-- <script src="js/jQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    </body>

</html>