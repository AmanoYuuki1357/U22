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
    }else{
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
        <title>食事記録</title>
        <link rel="stylesheet" type="text/css" href="css/reset.css">

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

                <!-- ログインしていない時 -->

                <?php
                    if(!isset($_SESSION["id"])){
                ?>
                <a href="login.php">ログイン/会員登録</a>
                <?php
                    }else{
                ?>
                <div>
                    <img src="../images/icon.jpg" alt="アイコン">
                    <a href="my_page.php"><?php print($user["f_user_name"]); ?></a>
                </div>
                <?php
                    }
                ?>

            </header>

            <main>
                <div>
                    <a href="my_page.html">＜マイページ</a>
                </div>
                <div>
                    <h2>朝食</h2>
                    <input type="text" name="search" size="15" placeholder="料理名を検索">
                    <input type="image" src="images/meal.jpg" alt="飯">
                    <p>飯1</p>
                    <p>飯2</p>
                    <p>飯3</p>
                    <p>飯4</p>
                    <p>飯5</p>
                </div>

                <div>
                    <h2>昼食</h2>
                    <input type="text" name="search" size="15" placeholder="料理名を検索">
                    <input type="image" src="images/meal.jpg" alt="飯">
                    <p>飯1</p>
                    <p>飯2</p>
                    <p>飯3</p>
                    <p>飯4</p>
                    <p>飯5</p>
                </div>

                <div>
                    <h2>夕食</h2>
                    <input type="text" name="search" size="15" placeholder="料理名を検索">
                    <input type="image" src="images/meal.jpg" alt="飯">
                    <p>飯1</p>
                    <p>飯2</p>
                    <p>飯3</p>
                    <p>飯4</p>
                    <p>飯5</p>
                </div>

                <div>
                    <p>日付</p>
                    <!-- table作成 -->
                    <table border="1">
                        <tr>
                            <th>メニュー</th>
                            <th>削除</th>
                        </tr>
                        <tr>
                            <td>朝食</td>
                            <td><button>佐久間</button></td>
                        </tr>
                        <tr>
                            <td>朝食</td>
                            <td><button>佐久間</button></td>
                        </tr>
                        <tr>
                            <td>朝食</td>
                            <td><button>佐久間</button></td>
                        </tr>
                        <tr>
                            <td>朝食</td>
                            <td><button>佐久間</button></td>
                        </tr>
                        <tr>
                            <td>朝食</td>
                            <td><button>佐久間</button></td>
                        </tr>
                        <tr>
                            <td>朝食</td>
                            <td><button>佐久間</button></td>
                        </tr>
                    </table>
                    <button>
                        <a>登録</a>
                    </button>
                </div>



            </main>

            <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
        </div>

    </body>

</html>