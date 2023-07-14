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

$intakes = $db->prepare('SELECT * FROM t_intakes WHERE f_user_id=? ORDER BY f_intake_date DESC');
$intakes->execute(array($_SESSION["id"]));

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>食事管理</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/meal_manage.css">

</head>

<body>

    <?php require('header.php'); ?>

    <div id="gomypage">
        <a href="my_page.php">＜マイページ</a>
    </div>

    <main>









        <div id="record" class="container">
            <h1>一覧</h1>
            <div class="row">



<!-- ************************** -->
<?php
    $intake = $intakes->fetchAll();
    if(count($intake) == 0){
        echo '<p>まだ食事を登録していません</p>';
    }else{
        $now = substr($intake[0]['f_intake_date'], 0,9);
        for($i = 0; $i < count($intake); $i++){
            if($now != substr($intake[$i]['f_intake_date'], 0,10)){
            echo '</div><div class="row box"><p>' . $intake[$i]['f_intake_date'] . '</p>';
            echo '<h3>食べたもの</h3>';
            }
            echo '<p class="col-2">' . $intake[$i]['f_intake_name'] . '</p>';
            $now = substr($intake[$i]['f_intake_date'], 0,10);
        }
    }
?>

<!-- ************************** -->



            </div>
        </div>
    </main>

    <footer>Copyright 2023 mealfriend. All Rights Reserved.</footer>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>