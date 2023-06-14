<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入カード情報登録</title>
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/stepbar.css">

</head>

<body>
    <div id="wrap">
        <header>

            <div>
                <a href="index.html"><img src="../images/logo.jpg" alt="ロゴ"></a>
            </div>

            <div id="header-right">
                <!-- ログインしている時 -->
                <!-- ユーザーメニュー -->
                <div id="user">
                    <div>
                        <img src="../images/icon.jpg" alt="アイコン">
                    </div>
                    <div>
                        <a href="my_page.html">ニックネーム</a>
                    </div>
                </div>

                <!-- どちらの場合でもカートは出す -->
                <a href="cart.html"><img src="../images/cart.jpg" alt="カート"></a>
            </div>

        </header>

        <div id="gomypage">
            <a href="menu.html">&lt;商品一覧</a>
        </div>

        <main>
            <!-- 進行度バー -->
            <!-- <div class="stepbar-row">
                <ol class="stepbar">
                    <li class="done"><span></span><br />お届け先</li>
                    <li class="done"><span></span><br />お支払方法</li>
                    <li><span></span><br />完了</li>
                </ol>
            </div> -->

            <div>

                <div>
                    <p>カード番号</p>
                    <input type="text" value="xxxx" />
                    <p>カード名義人</p>
                    <input type="text" value="xxxx" />
                    <p>有効期限(月/年)</p>
                    <input type="month" value="xxxx/xx"/>
                    <p>セキュリティコード</p>
                    <input type="text" value=""/>
                </div>
                <div>
                    <a href="buy_pay.php">更新する</a>
                </div>

            </div>

            <div class="back">
                <a href="buy_pay.php">戻る</a>
            </div>

        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

    </div>

    <!-- jQuery -->
    <!-- <script src="js/JQuery.js"></script> -->
    <!-- <script src="js/main.js"></script> -->

</body>
<style>
    img {
        width: 50px;
    }

    .stepbar-row {
        position: relative;
        top: 20px;
    }
</style>

</html>