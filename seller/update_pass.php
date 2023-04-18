<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   $select = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select->execute([$user_id]);
   $row = $select->fetch(PDO::FETCH_ASSOC);
   if($row['role'] != 'seller'){
        header('location:../index.php');
   }

}else{
   $user_id = '';
   header('location:../index.php');
}

if(isset($_POST['submit'])){

    $empty_pass = '';
    $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = $_POST['old_pass'];
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = $_POST['new_pass'];
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = $_POST['confirm_pass'];
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
 
    if($old_pass != $empty_pass){
       if($old_pass != $prev_pass){
          $message[] = 'Password Lama Salah!';
       }elseif($new_pass != $confirm_pass){
          $message[] = 'Konfirmasi Password Salah!';
       }else{
          if($new_pass != $empty_pass){
             $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
             $update_pass->execute([$confirm_pass, $user_id]);
             $message[] = 'Password Berhasil Dirubah!';
          }else{
             $message[] = 'Masukkan Password Baru!';
          }
       }
    }  
 
 }
?>

!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== FAVICON ===============-->
        <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">

        <!--=============== ICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="../css/style.css">

        <title>Bajikuy</title>
    </head>
    <body>
    

        <?php
            if(isset($message)){
                foreach($message as $message){
                    echo '
                    <div class="message">
                        <div class="notif grid">
                            <i class="fas fa-times notif_ic1" onclick="this.parentElement.remove();"></i>
                            <i class="fa-solid fa-circle-exclamation notif_ic"></i>
                            <span>'.$message.'</span>
                        </div>
                    </div>
                    ';
                }
            }
        ?>

        <!--==================== HEADER ====================-->
        <header class="header" id="header">
            <nav class="nav container">
                <a href="../seller/index.php" class="nav__logo">
                    <img src="../img/bajikuyyy.png" alt="logo">
                </a>
                <div class="nav__menu nav_menu1" id="nav-menu">
                    <!-- <ul class="nav__list">
                        <li class="nav__item">
                            <a href="#" class="nav__link active-link">Lokasi</a>
                        </li>
                    </ul>
                    Close button -->
                    <div class="nav__close" id="nav-close">
                        <i class="ri-close-line"></i>
                    </div>
                </div>
                <div class="nav__buttons">
                    <div id="user-btn" class="fas fa-user"></div>
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
                    <a href="../seller/profile.php" class="btn">Profile</a>
                    <a href="../components/seller_logout.php" onclick="return confirm('Apakah anda yakin keluar?');" class="delete-btn">logout</a>
                </div>
                <p class="account">
                    <a href="../login.php">Login</a> or
                    <a href="../register.php">Register</a>
                </p> 
                <?php
                    }else{
                ?>
                    <p class="name">Anda Belum Login!</p>
                    <a href="../login.php" class="btn">login</a>
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
                    <a href="../seller/profile.php"><i class="ri-arrow-left-line icon_panah"></i></a>
                    <span class="section_title profile_title1">Ubah Password</span> 
                </div>

                <div class="profile-box">
                    <h3 class="profile_title3">Membuat kata sandi membantu anda menjaga keamanan akun dan <br> transaksi di bajikuyyy.</h3> 
                </div>

                <div class="updt_pass">
                    <form action="" method="post">
                        <div class="passeb">
                            <div class="pass_content">
                                <input type="password" required placeholder=" " class="pass_input" name="old_pass">
                                <label for="" class="pass_label">Masukkan Kata Sandi Lama</label>  
                            </div>

                            <div class="pass_content">
                                <input type="password" required placeholder=" " class="pass_input" name="new_pass">
                                <label for="" class="pass_label">Masukkan Kata Sandi Baru</label>  
                            </div>

                            <div class="pass_content">
                                <input type="password" required placeholder=" " class="pass_input" name="confirm_pass">
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


        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line"></i>
        </a>

        <!--=============== SCROLLREVEAL ===============-->
        <script src="../js/scrollreveal.min.js"></script>

        <!--=============== Header JS ===============-->
        <script src="../js/header.js"></script>
    </body>