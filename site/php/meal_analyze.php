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
    <title>食事分析</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_analize.css">

</head>

<body>
    <div id="wrap">
        <?php
            require('header.php');
        ?>

        <div id="gomypage">
            <!-- パンクズ -->
            <a href="my_page.php">＜マイページ</a>
        </div>
        <main class="mt-5">
            <div>
                <div id="advice">



                    <?php
                    $advices = $db->prepare("SELECT * FROM t_intakes WHERE f_intake_date LIKE ? AND f_user_id = ?");
                    $searchDate = '%' . date("Y-m-d") . '%';
                    $advices->execute(array($searchDate, $_SESSION["id"]));
                    $advice = $advices->fetch();

                    // if(!isset($user["f_user_gender"],$user["f_user_age"],$user["f_user_height"],$user["f_user_weight"])){
                        // print("<a href='user_upd.php'>プロフィールを登録してください</a>");
                    // }else


                    if ($advice == null) {
                        print("<p>食事記録がありません</p>");
                        print("<a href='meal_record.php'>食事記録を取る</a>");
                    }else{
                        while ($advice = $advices->fetch()){
                            $calorie = $calorie + (int)$advice["f_intake_calorie"];
                            $protein += (int)$advice["f_intake_protein_vol"];
                            $sugar += (int)$advice["f_intake_augar_vol"];
                            $lipid += (int)$advice["f_intake_lipid_vol"];
                            $fiber += (int)$advice["f_intake_dietary_fiber_vol"];
                            $salt += (int)$advice["f_intake_salt_vol"];
                        }
                        print("<div class='coutainer'><div class='row'><div class='col p-5 box'>
                        <h2>アドバイス</h2><p>カロリーは" . $calorie . "kcalです</p>");
                        print("<p>タンパク質は" . $protein . "gです</p>");
                        print("<p>糖質は" . $sugar . "gです</p>");
                        print("<p>脂質は" . $lipid . "gです</p>");
                        print("<p>食物繊維は" . $fiber . "gです</p>");
                        print("<p>塩分は" . $salt . "gです</p></div>");
                        print("<div class='col p-5 box'><h2>※1日の目標量には残り</h2>");
                        $calorie = 2400-$calorie;
                        $protein = 60-$protein;
                        $sugar = 300-$sugar;
                        $lipid = 60-$lipid;
                        $fiber = 20-$fiber;
                        $salt = 10-$salt;
                        print("<p>カロリーは" . $calorie. "kcalです</p>");
                        print("<p>タンパク質は" . $protein. "gです</p>");
                        print("<p>糖質は" . $sugar. "gです</p>");
                        print("<p>脂質は" . $lipid. "gです</p>");
                        print("<p>食物繊維は" . $fiber. "gです</p>");
                        print("<p>塩分は" . $salt. "gです</p></div></div></div>");
                    }

                    ?>
                </div>
            </div>

            <!-- <div id="recommend">
                <p>おすすめ商品</p>
            </div> -->
        </main>

        <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>
    </div>

        <!-- コンテンツが短い時にfooterをwindow最下部に固定する -->
        <script>
        // mainタグの高さを取得する
        var mainHeight = document.querySelector('main').clientHeight;
        console.log(mainHeight);
        // mainタグの高さが1000px未満だったら、footerを画面最下部に固定する
        if (mainHeight < 800) {
            document.querySelector('footer').style.position = 'fixed';
            document.querySelector('footer').style.bottom = '0';
        }
    </script>


    <!-- bootstrap CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>