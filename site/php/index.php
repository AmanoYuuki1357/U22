<?php
require('common.php');
error_reporting(E_ALL & ~E_NOTICE);
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id"])) {
    $users = $db->prepare('SELECT * FROM t_users WHERE f_user_id=?');
    $users->execute(array($_SESSION["id"]));
    $user = $users->fetch();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link rel="stylesheet" href="../css/reset.css">
<!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">

    <title>ミールフレンド</title>
</head>

<body>

<!-- ヘッダー部分 -->
<?php
require('header.php');
?>



    <main>


        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">ミールフレンド、忙しい方のための配食サービス</h1>
                <p class="col-md-8 fs-4">
                    ミールフレンドは、忙しい方のための配食サービスです。温かく美味しいお弁当を、ご自宅までお届けします。また、栄養士が監修した献立なので、安心してお召し上がりいただけます。また、お弁当の配達の際には、安否確認も行いますので、安心してご利用いただけます。ご興味のある方は、ぜひお問い合わせください。
                </p>
                <!-- <button class="btn btn-primary btn-lg" type="button">Example button</button> -->
            </div>
        </div>

        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-white bg-light rounded-3">
                    <h2>食事を作るのが苦手な方のための配食サービス</h2>
                    <p>ミールフレンドは、食事を作るのが苦手な方のための配食サービスです。温かく美味しいお弁当を、ご自宅までお届けします。また、栄養士が監修した献立なので、安心してお召し上がりいただけます。また、お弁当の配達の際には、お買い物や掃除などのお手伝いも行いますので、ご自宅で安心して生活することができます。ご興味のある方は、ぜひお問い合わせください。
                    </p>
                    <!-- <button class="btn btn-outline-light" type="button">Example button</button> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-light rounded-3">
                    <h2>健康的な食事をしたい方のための配食サービス</h2>
                    <p>ミールフレンドは、健康的な食事をしたい方のための配食サービスです。温かく美味しいお弁当を、ご自宅までお届けします。また、栄養士が監修した献立なので、安心してお召し上がりいただけます。また、お弁当の配達の際には、安否確認も行いますので、安心してご利用いただけます。ご興味のある方は、ぜひお問い合わせください。
                    </p>
                    <!-- <button class="btn btn-outline-secondary" type="button">Example button</button> -->
                </div>
            </div>
        </div>


        <!-- 商品全体紹介文 -->
        <h1 class="visually-hidden">Heroes examples</h1>

        <div class="px-4 py-5 my-5 text-center">
            <h1 class="display-5 fw-bold">安心安全で豊富な食品</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4">
                    当店では、豊富な食品を取り揃えております。野菜、果物、肉、魚、加工食品、飲料など、幅広い商品を取り揃えておりますので、お探しのものがきっと見つかります。また、送料無料の商品も多数ございますので、お得にお買い物をお楽しみいただけます。

                    当店では、お客様に安心してご利用いただけるよう、品質管理に万全を期しております。また、お客様の個人情報は厳重に保護しておりますので、安心してご利用いただけます。</p>

            </div>
        </div>




        <!-- 商品をいくつか -->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                
                <div class="carousel-item active">
                    <img src="../images/what1.jpg" class="d-block w-90" alt="...">
                </div>

                <div class="carousel-item">
                    <img src="../images/what2.jpg" class="d-block w-90" alt="...">
                </div>

                <div class="carousel-item">
                    <img src="../images/what3.jpg" class="d-block w-90" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


        <h1 class="visually-hidden">Heroes examples</h1>

        <div class="px-4 py-5 my-5 text-center">
            <h2 class="display-5 fw-bold">ぜひご登録ください！</h1>

            <a class="text-end px-4 py-5 my-5 text-center" href="../php/login.php">
                        <button type="button" class="btn btn-outline-primary btn-lg">Login/Sign-up</button>
                    </a>
        </div>


    </main>



    <!-- フッター -->

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
          <span class="text-muted">&copy; 2023 ミールフレンド all right reserved</span>
        </div>
      </footer>


<!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>


</html>