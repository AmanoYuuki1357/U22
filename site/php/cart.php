<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION["id"])){
        $users=$db->prepare('SELECT * FROM t_users WHERE f_user_id=?');
        $users->execute(array($_SESSION["id"]));
        $user=$users->fetch();
    }
    // // セッションにユーザー情報があり、ログイン後に行動してから60分以内であるとき
    // if(isset($_SESSION['id']) && $_SESSION['time'] + 3600>time()){
    //     // ログインした時間を現在の時間に更新
    //     $_SESSION['time']=time();
    //     // セッション変数のidを使って、ユーザーの情報を呼び出す
    //     $members=$db->prepare('SELECT * FROM user_info WHERE userID=?');
    //     $members->execute(array($_SESSION['id']));
    //     $member=$members->fetch();
    //     // ログインしていないとき
    // }else{
    //     // 即時にログイン画面に転送する
    //     header('Location: login.php');
    //     exit();
    // }

    // $carts=$db->prepare('SELECT * FROM t_carts WHERE f_user_id=?');
    // $carts->execute(array($_SESSION["id"]));
    // $cart=$users->fetch();
    $sql='SELECT c.f_item_num,i.f_item_name,i.f_item_price FROM t_carts c INNER JOIN t_items i ON c.f_item_id = i.f_item_id WHERE f_user_id=1';
    $carts=$db->query($sql);
    $cart=$carts->fetch();

    // print_r($cart);
    print($cart['f_item_num']);

?>

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
                <?php
                    if(!empty($session["id"])){
                ?>
                <a href="login.php">ログイン/会員登録</a>
                <!-- ログインしている時 -->
                <?php
                    }else{
                ?>
                <div>
                    <img src="../images/icon.jpg" alt="アイコン">
                    <form action="my_page.php">
                        <input type="hidden"  name="user_id" value="<?php $_SESSION["id"] ?>">
                        <a href="my_page.php"><?php print($user["f_user_name"]); ?></a>
                    </form>
                </div>
                <?php
                    }
                ?>

                <!-- どちらの場合でもカートは出す -->
                <div>
                    <a href="cart.html"><img src="../images/cart.jpg" alt="カート"></a>
                </div>

            </header>

            <main>

                <div>

                    <h3>ショッピングカート</h3>

                    <div>
                        <?php
                            print('<button>pic</button>');
                            print('<p>'.$cart['f_item_name'].'</p>');
                            print('<p>'.$cart['f_item_price']*$cart['f_item_num'].'円</p>');
                            print('<p>-</p>');
                            print('<p>'.$cart['f_item_num'].'</p>');
                            print('<p>+</p>');
                        ?>
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