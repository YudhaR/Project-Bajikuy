<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   $select = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select->execute([$user_id]);
   $row = $select->fetch(PDO::FETCH_ASSOC);
   if($row['role'] != 'admin'){
        header('location:../index.php');
   }

}else{
   $user_id = '';
   header('location:../index.php');
}

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== FAVICON ===============-->
        <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">

        <!--=============== ICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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
                <a href="../admin/index.php" class="nav__logo">
                    <img src="../img/bajikuyyy.png" alt="logo">
                </a>
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="../admin/index.php" class="nav__link">Beranda</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/lokasi.php"about class="nav__link active-link">Lokasi</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/menu.php" class="nav__link">Menu</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/pesanan.php" class="nav__link">Pesanan</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/bantuan.php" class="nav__link">Bantuan</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/acc.php" class="nav__link">Akun</a>
                        </li>
                    </ul>
                    <!-- Close button -->
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
                    <a href="../admin/profile.php" class="btn">Profile</a>
                    <a href="../components/user_logout.php" onclick="return confirm('Apakah anda yakin keluar?');" class="delete-btn">logout</a>
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

        <section class="pbox container grid">
            <div class="profile_container">
                <div class="profile-box">
                    <a href="../admin/lokasi.php"><i class="ri-arrow-left-line icon_panah"></i></a>
                    <span class="section_title profile_title1">Riwayat Lokasi</span> 
                </div>

                <div class="profile-box">
                    <h3 class="profile_title3">Riwayat Penambahan Lokasi Warung Atau Outlet Yang Telah Diinput Oleh Seller Maupun Admin!</h3> 
                </div>


                <div class="records table-responsive">
                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>USERNAME</th>
                                    <th>ROLE</th>
                                    <th>JUDUL</th>
                                    <th>STATUS</th>
                                    <th>WAKTU</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $select_update = $conn->prepare("SELECT * FROM `tabel_lokasi`");
                                $select_update->execute();
                                if(($select_update->rowCount() > 0)){
                                    while($fetch_update = $select_update->fetch(PDO::FETCH_ASSOC)){
                            ?>
                                <tr>
                                    <td><?= $fetch_update['user_id']; ?></td>
                                    <td>
                                        <div class="client">
                                            <div class="client-info">
                                                <h4><?= $fetch_update['name']; ?></h4>
                                                <small><?= $fetch_update['email']; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $fetch_update['role']; ?>
                                    </td>
                                    <td>
                                        <?= $fetch_update['judul']; ?>
                                    </td>
                                <?php
                                    if($fetch_update['status'] == "Menambahkan"){
                                ?>
                                    <td class="tambah">
                                        <?= $fetch_update['status']; ?>
                                    </td>
                                <?php
                                    }else if($fetch_update['status'] == "Mengedit"){
                                ?>
                                    <td class="edit">
                                        <?= $fetch_update['status']; ?>
                                    </td>
                                <?php
                                    }else if($fetch_update['status'] == "Menghapus"){
                                ?>
                                    <td class="hapus">
                                        <?= $fetch_update['status']; ?>
                                    </td>
                                <?php
                                    }
                                ?>
                                    <td>
                                        <?= $fetch_update['waktu']; ?>
                                    </td>
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
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