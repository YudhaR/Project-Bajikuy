<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
 
    if($old_pass != $empty_pass){
       if($old_pass != $prev_pass){
          $message[] = 'old password not matched!';
       }elseif($new_pass != $confirm_pass){
          $message[] = 'confirm password not matched!';
       }else{
          if($new_pass != $empty_pass){
             $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
             $update_pass->execute([$confirm_pass, $user_id]);
             $message[] = 'password updated successfully!';
          }else{
             $message[] = 'please enter a new password!';
          }
       }
    }  
 
 }
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
                <a href="./index.php" class="nav__logo">
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
                    <span class="section_title profile_title1">Ubah Password</span> 
                </div>

                <div class="profile-box">
                    <h3 class="profile_title3">Membuat kata sandi membantu anda menjaga keamanan akun dan <br> transaksi di bajikuyyy.</h3> 
                </div>

                <div class="updt_pass">
                    <form action="" method="post">
                        <div class="passeb">
                            <div class="pass_content">
                                <input type="text" required placeholder=" " class="pass_input" name="old_pass">
                                <label for="" class="pass_label">Masukkan Kata Sandi Lama</label>  
                            </div>

                            <div class="pass_content">
                                <input type="text" required placeholder=" " class="pass_input" name="new_pass">
                                <label for="" class="pass_label">Masukkan Kata Sandi Baru</label>  
                            </div>

                            <div class="pass_content">
                                <input type="text" required placeholder=" " class="pass_input" name="confirm_pass">
                                <label for="" class="pass_label">Masukkan Ulang Kata Sandi Baru</label>  
                            </div>
                        </div>
                        <div class="btn_pass">
                            <input type="submit" value="Simpan" class="button pass_button" id="nbutton" name="submit">
                        </div>
                    </form>
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