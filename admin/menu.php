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


if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_image= $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_image->execute([$delete_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
    unlink('../update_img/'.$fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);


    $judul = $fetch_delete_image['name'];

    $select_uid = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_uid->execute([$user_id]);
    $data1 = $select_uid->fetch(PDO::FETCH_ASSOC);

    $uid = $data1['id'];
    $uname = $data1['name'];
    $uemail = $data1['email'];
    $status = "Menghapus";
    $waktu1 = date('Y-m-d H:i:s');

    $insert_update = $conn->prepare("INSERT INTO `tabel_products`(user_id, name, email, judul, status, waktu) VALUES(?,?,?,?,?,?)");
    $insert_update->execute([$uid, $uname, $uemail, $judul, $status, $waktu1]);
    header('location:../admin/menu.php');
 
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
                            <a href="../admin/lokasi.php"about class="nav__link ">Lokasi</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/menu.php" class="nav__link active-link">Menu</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/pesanan.php" class="nav__link">Pesanan</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/bantuan.php" class="nav__link ">Bantuan</a>
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

        <section class="lokasi section" id="lokasi1">
            <div class="bloks1 container">
                    <div class="blok1">
                        <div class="icon_lokasi">
                             <i class="ri-upload-cloud-2-fill"></i>
                        </div>
                        <div class="content">
                            <h3>penambahan menu!</h3>
                            <p>Tambahkan menu warungmu untuk memudahkan pelanggan untuk mencoba produkmu!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                            <div class="tombol container" >
                                <a href="../admin/add_menu.php" class="btn" id="lokabtn"> Tambahkan </a>
                            </div>
                        </div>
                    </div>

                    <div class="blok1">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-windy-line"></i>
                        </div>
                        <div class="content">
                            <h3>riwayat penambahan!</h3>
                            <p>Riwayat penambahan menu warung atau outlet yang telah diinput oleh admin!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                            <div class="tombol container" >
                                <a href="../admin/his_menu.php" class="btn" id="lokabtn"> Riwayat </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $select_menu = $conn->prepare("SELECT * FROM `products`");
                    $select_menu->execute();
                    if($select_menu->rowCount() > 0){
                        while($fetch_menu = $select_menu->fetch(PDO::FETCH_ASSOC)){
                ?>
                        <div class="blok1">
                            <div class="image">
                                <img src="../update_img/<?= $fetch_menu['image']; ?>" alt="">
                            </div>
                            <div class="content">
                                <h3><?= $fetch_menu['name']; ?></h3>
                                <p><?= $fetch_menu['category']; ?></p>
                                <h4 class="menu1"> <i class="ri-money-dollar-circle-line"></i> <?= "Rp " . number_format($fetch_menu['price'], 0, ',', '.'); ?> </h4>
                                <div class="tombol-container">
                                    <a href="../admin/update_menu.php?update=<?= $fetch_menu['id']; ?>" class="btn" id="lokabtn">update</a>
                                    <a href="../admin/menu.php?delete=<?= $fetch_menu['id']; ?>" class="delete-btn" id="lokabtn" onclick="return confirm('Hapus menu ini??');">delete</a>
                                </div>
                            </div>
                        </div>
                <?php
                            }
                        }
                ?>
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