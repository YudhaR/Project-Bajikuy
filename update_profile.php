<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== FAVICON ===============-->
        <link rel="shortcut icon" href="./img/icon.png" type="image/x-icon">

        <!--=============== ICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="./css/style.css">

        <title>Bajikuy</title>
    </head>
    <body>

        <?php
        if(isset($message)){
        foreach($message as $message){
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
        }
        ?>

        <!--==================== HEADER ====================-->
        <header class="header" id="header">
            <nav class="nav container">
                <a href="#" class="nav__logo">
                    <img src="./img/bajikuyyy.png" alt="logo">
                </a>
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="./index.php#home" class="nav__link">Beranda</a>
                        </li>
                        <li class="nav__item">
                            <a href="./index.php#cerita"about class="nav__link">Cerita</a>
                        </li>
                        <li class="nav__item">
                            <a href="./index.php#lokasi" class="nav__link">Lokasi</a>
                        </li>
                        <li class="nav__item">
                            <a href="./index.php#menu" class="nav__link">Menu</a>
                        </li>
                        <li class="nav__item">
                            <a href="./pesanan.php" class="nav__link">Pesanan</a>
                        </li>
                        <li class="nav__item">
                            <a href="./index.php#bantuan" class="nav__link">Bantuan</a>
                        </li>
                    </ul>
                    <!-- Close button -->
                    <div class="nav__close" id="nav-close">
                        <i class="ri-close-line"></i>
                    </div>
                </div>
                <div class="nav__buttons">
                    <?php
                        $hitung_keranjang = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $hitung_keranjang->execute([$user_id]);
                        $total_keranjang = $hitung_keranjang->rowCount();
                    ?>
                    <a href="cart.php" class="barang"><i class="fas fa-shopping-cart"></i><span>(<?= $total_keranjang; ?>)</span></a>
                    <div id="user-btn" class="fas fa-user active-link"></div>
                    <!-- Toggle button -->
                    <div class="nav__toggle" id="nav-toggle">
                        <i class="ri-apps-2-fill"></i>
                    </div>
                </div>

            <div class="profile">
                <?php
                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_profile->execute([$user_id]);
                    if($select_profile->rowCount() > 0){
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <p class="name"><?= $fetch_profile['name']; ?></p>
                <div class="flex">
                    <a href="./profile.php" class="btn">Profile</a>
                    <a href="./components/user_logout.php" onclick="return confirm('Apakah anda yakin keluar?');" class="delete-btn">logout</a>
                </div>
                <p class="account">
                    <a href="./login.php">Login</a> or
                    <a href="./register.php">Register</a>
                </p> 
                <?php
                    }else{
                ?>
                    <p class="name">Anda Belum Login!</p>
                    <a href="./login.php" class="btn">login</a>
                <?php
                }
                ?>
            </div>


                
            </nav>
            
        </header>

        <!--==================== PROFILE ====================-->
        <section class="pbox container grid">
            <div class="profile_container">
                <div class="profile-box">
                    <a href="./profile.php"><i class="ri-arrow-left-line icon_panah"></i></a>
                    <span class="section_title profile_title1">Ubah Profil</span> 
                </div>

                <div class="profile_box2">
                    <i class="ri-account-circle-line profile_icon4"></i>
                </div>
                <h3 class="profile_title2">Informasi Pribadi</h3>

                <div class="profile_box">
                    <span class="profile_acc2">nama</span>
                    <span class="profile_acc3"><?= $fetch_profile['name']; ?></span>
                </div>
                <a href="./update_nama.php"><i class="ri-arrow-right-s-line profile_icon5"></i></a>

                <div class="profile_box">
                    <span class="profile_acc4">User Id</span>
                    <span class="profile_acc3"><?= $fetch_profile['id']; ?></span>
                </div>

                <div class="profile_box">
                    <span class="profile_acc4">E-mail</span>
                    <span class="profile_acc3"><?= $fetch_profile['email']; ?></span>
                </div>
                <a href="./update_email.php"><i class="ri-arrow-right-s-line profile_icon5"></i></a>

                <div class="profile_box">
                    <span class="profile_acc5">Nomor HP</span>
                    <span class="profile_acc3"><?= $fetch_profile['number']; ?></span>
                </div>
                <a href="./update_number.php"><i class="ri-arrow-right-s-line profile_icon5"></i></a>

                <div class="profile_box">
                    <a href="./components/user_logout.php" onclick="return confirm('Apakah anda yakin keluar?');"><span class="profile_acc1">keluar akun</span></a>
                </div>

                <div class="profile_box1">
                    <a href="./components/user_logout.php" onclick="return confirm('Apakah anda yakin keluar?');"><i class="ri-logout-box-r-line profile_icon3"></i></a>
                    <a href="./components/user_logout.php" onclick="return confirm('Apakah anda yakin keluar?');"><span class="profile_desc1">keluar akun dan masuk kembali</span></a>
                </div>

            </div>
            



        </section>











        <?php include './components/user_footer.php'; ?>

        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line"></i>
        </a>

        <!--=============== SCROLLREVEAL ===============-->
        <script src="./js/scrollreveal.min.js"></script>

        <!--=============== Header JS ===============-->
        <script src="./js/header.js"></script>
    </body>