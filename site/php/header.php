<script>
    function sign_out(){
        window.sessionStorage.clear();
        document.location.reload()
    }
</script>
<header class="py-3 mb-3 border-bottom flex-top">
        <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">

            <!-- ロゴ画像を置く -->
            <a href="./menu.php" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none" id="dropdownNavLink" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../images/logo.png" class="bi me-2" width="140" height="32">
            </a>

            <div class="d-flex justify-content-end">

                <!-- ログインしていないときに表示 -->
                <?php
                if (!isset($_SESSION["id"])) {
                ?>
                    <a class="text-end" href="../php/login.php">
                        <button type="button" class="btn btn-outline-primary">Login/Sign-up</button>
                    </a>
                <?php


                } else {
                ?>
                    <!-- ログインしているときに表示 -->
                    <div class="flex-shrink-0 dropdown icon">
                        <a class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- ログインした人の画像 -->
                            <img src="../images/icon.jpg" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a href="my_page.php"><?php print ($user["f_user_name"]) . "のマイページ"; ?></a></li>
                            <p id="userId" style="display: none;"><?php print($user["f_user_id"]); ?></p>

                            <!-- 一時的にここに置く -->
                            <li><a class="dropdown-item" href="./index.php">インデックス</a></li>
                            <li><a class="dropdown-item" href="./menu.php">メニュー一覧</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" onclick="sign_out()">Sign out</a></li>
                        </ul>
                    </div>

                <?php
                }
                ?>

                <div>
                    <a href="cart.php"><img class="headerimg" src="../images/cart.jpg" alt="カート"></a>
                </div>
            </div>
        </div>
    </header>