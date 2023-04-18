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

    $address = $_POST['jalan'] .', '.$_POST['desa'].', '.$_POST['kecamatan'].', '.$_POST['kabupaten'] .' - '. $_POST['kode_pos'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
 
    $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
    $update_address->execute([$address, $user_id]);
 
    $message[] = 'Alamat Berhasil Diubah!';

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
                    <a href="../seller/update_addres.php"><i class="ri-arrow-left-line icon_panah"></i></a>
                    <span class="section_title profile_title1">Detail Alamat</span> 
                </div>

                <div class="profile-box">
                    <h3 class="profile_title3">Tambahkan alamatmu untuk pengiriman belanja anda.</h3> 
                </div>

                <div class="updt_alm">
                    <form action="" method="post">
                        <div class="almeb">
                            <div class="alm_content">
                                <input type="text" required placeholder=" " class="alm_input" name="jalan">
                                <label for="" class="alm_label">Jalan</label>  
                            </div>

                            <div class="alm_content">
                                <input type="text" required placeholder=" " class="alm_input" name="desa">
                                <label for="" class="alm_label">Desa</label>  
                            </div>

                            <div class="alm_content">
                                <input type="text" required placeholder=" " class="alm_input" name="kecamatan">
                                <label for="" class="alm_label">Kecamatan</label>  
                            </div>

                            <div class="alm_content">
                                <input type="text" required placeholder=" " class="alm_input" name="kabupaten">
                                <label for="" class="alm_label">Kabupaten</label>  
                            </div>

                            <div class="alm_content">
                                <input type="number" required placeholder=" " class="alm_input" name="kode_pos">
                                <label for="" class="alm_label">Kode Pos</label>  
                            </div>
                        </div>
                        <input type="submit" value="Simpan" class="button" id="nbutton" name="submit">
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