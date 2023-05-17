<?php
    require('common.php');
    error_reporting(E_ALL & ~E_NOTICE);
    if(!isset($_SESSION)){
        session_start();
    }

    // // セッションにユーザー情報があり、ログイン後に行動してから60分以内であるとき
    // if(isset($_SESSION['id']) && $_SESSION['time'] + 3600>time()){
    //     // ログインした時間を現在の時間に更新
    //     $_SESSION['time']=time();
    //     // セッション変数のidを使って、ユーザーの情報を呼び出す
    //     $members=$db->prepare('SELECT * FROM user_info WHERE id=?');
    //     $members->execute(array($_SESSION['id']));
    //     $member=$members->fetch();
    //     // ログインしていないとき
    // }else{
    //     // 即時にログイン画面に転送する
    //     header('Location: login.php');
    //     exit();
    // }

    // ヘッダーのアイコン
    // $icons=$db->prepare('SELECT userIcon FROM user_info WHERE userID=?');
    // $icons->execute(array($_SESSION['id']));
    // $icon=$icons->fetch();

    // ジャンルを取り出す
    $sql='SELECT f_item_genre_name FROM t_item_genre';
    $genres=$db->query($sql);
    $genre=$genres->fetchAll();

    // 商品情報を取り出す
    // 本当は販売履歴と結合してランキングにする
    // 画像も取り出す
    $sql2='SELECT f_item_id,f_item_name,f_item_price FROM t_items';
    $items=$db->query($sql2);
    $item=$items->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>商品一覧</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css">
        <!-- <link rel="stylesheet" type="text/css" href="css/main.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="css/home.css"> -->

    </head>

    <body>
        <div id="wrap">
            <header>

                <h2>
                    ミールフレンド
                </h2>
                <div>
                    <a href="index.php"><img src="../images/logo.jpg" alt="ロゴ"></a>
                </div>

                <!-- ログインしていない時 -->
                <a href="login.php">ログイン</a>
                <a href="regist.php">会員登録</a>

                <!-- ログインしている時 -->
                <!-- ユーザーメニュー -->
                <div id="user">
                    <label>
                        <img src="../images/icon.jpg" alt="アイコン">
                        <!-- <img src=icon_images/<?php print(h($icon["userIcon"])) ?> alt="アイコン"> -->
                    </label>
                    <div>
                        <a href="my_page.html">ニックネーム</a>
                        <!-- <a href="my_page.php"><?php print(h($user["userNickName"])) ?></a> -->
                    </div>
                </div>

            </header>

            <main>

                <div>

                    <h3>メニュー選択</h3>

                    <select name='genre'>
                    <option value='all'>すべて</option>
                    <?php
                    for($i=0; $i!=count($genre); $i++){
                        print('<option value={$i}>'.$genre[$i]['f_item_genre_name'].'</option>');
                    }
                    ?>
                    </select>

                    <select name='allergen'>
                    <option value='filter'>食材フィルタ</option>
                    <?php
                    for($i=0; $i!=count($allergens); $i++){
                        print('<option value={$i}>'.$allergens[$i].'</option>');
                    }
                    ?>
                    </select>

                    <select name='allergen'>
                    <option value='filter'>ソート</option>
                    <?php
                    for($i=0; $i!=count($sorts); $i++){
                        print('<option value={$i}>'.$sorts[$i].'</option>');
                    }
                    ?>
                    </select>

                    <div>
                        <table>

                            <?php
                                for($i=0; $i!=count($item); $i++){
                                    if($i%4==0){
                                        print('<tr>');
                                    }
                                    print('<td>');
                                    print('<a href="item_piece.php?id='.$item[$i][0].'">');
                                    print('<img src="../images/menu'.$i.'.jpg" alt='.$item[$i][1].'>');
                                    print('<p>'.$item[$i][1].'</p>');
                                    print('<p>'.$item[$i][2].'円</p>');
                                    print('<button>カートに入れる</button>');
                                    print('</a>');
                                    print('</td>');
                                    if($i%4==3){
                                        print('</tr>');
                                    }
                                }
                            ?>

                        </table>

                    </div>

                </div>

            </main>

            <footer>
                <!-- コピーライト -->
                <small>&copy; 2023 ミールフレンド all right reserved</small>
            </footer>

        </div>


    <!-- jQuery -->
    <!-- <script src="js/jQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

    </body>

</html>