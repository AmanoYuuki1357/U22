<header>


    <div class="container">
        <div class="row header">

            <?php
            if (!isset($_SESSION["id"])) {
            ?>
                <a class="text-end" href="../php/login.php">
                    <button type="button" class="btn btn-outline-primary">ログイン/サインアップ</button>
                </a>
            <?php


            } else {
            ?>


                <!-- rogo画像 -->
                <div class="col-6">
                    <a class="logoImg" href="../php/menu.php" class="col">
                        <img class="logoImg" src="../images/logo.png">
                    </a>
                </div>

                <!-- マイページ -->
                <a class="col-2 hover-underline" href="my_page.php"><?php print ($user['f_user_nick_name']) . "様のマイページ"; ?></a>




                <!-- メニュー一覧 -->
                <a class="col-2 hover-underline" href="./menu.php">メニュー一覧</a>


            <?php
            }
            ?>

            <div class="col-1"></div>

            <div class="col-1">
                <?php
                if (isset($_SESSION["id"])) {
                ?>
                    
                        <a class="text-end" href="cart.php"><img class="headerimg" src="../images/cart.jpg" alt="カート"></a>
                
                <?php } ?>

            </div>



        </div>
    </div>



    <!-- サインアウトはマイページへ移動 -->

</header>