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
                            <a href="../admin/lokasi.php"about class="nav__link ">Lokasi</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/menu.php" class="nav__link ">Menu</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/pesanan.php" class="nav__link active-link">Pesanan</a>
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


        <section class="transaksi section">
            <div class="pesanan_boxs container transbox7">
                <div class="pesanan4_box1">
                    <a href="../admin/pesanan.php">
                        <i class="ri-arrow-left-line pesanan2-icon"></i>
                    </a>
                    <span>Menunggu Pembayaran</span>
                </div>


                <?php
                $pstatus1 = "Menunggu Pembayaran";
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ORDER BY `id` ASC");
                $select_orders->execute([$pstatus1]);
                    if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="pesanan_box2">
                    <i class="ri-shopping-bag-2-line pesanan-icon1"></i>
                    <span class="pesanan-text">Belanja</span>
                    <span class="pesanan-text3"><?= $fetch_orders['placed_on']; ?></span>
                    <?php
                    if($fetch_orders['payment_status']  == "Menunggu Pembayaran"){
                    ?>
                    <span class="hapus1"><?= $fetch_orders['payment_status']; ?></span>
                    <?php
                    }else if($fetch_orders['payment_status']  == "Menunggu Verifikasi"){
                    ?>
                    <span class="edit1"><?= $fetch_orders['payment_status']; ?></span>
                    <?php
                    }else if($fetch_orders['payment_status']  == "Sedang Diperjalanan"){
                    ?>
                    <span class="edit1"><?= $fetch_orders['payment_status']; ?></span>
                    <?php
                    }else if($fetch_orders['payment_status']  == "Selesai"){
                    ?>
                    <span class="tambah1"><?= $fetch_orders['payment_status']; ?></span>
                    <?php
                    }
                    $oid = $fetch_orders['id'];
                    $select_order_products1 = $conn->prepare("SELECT * FROM `order_products` WHERE oid = ?");
                    $select_order_products1->execute([$oid]);
                    $select_order_products = $conn->prepare("SELECT * FROM `order_products` WHERE oid = ? LIMIT 1");
                    $select_order_products->execute([$oid]);
                        if($select_order_products->rowCount() > 0){
                            while($fetch_order_products = $select_order_products->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="pesanan_box3">
                        <div class="pesanan_box4">
                            <div class="pesanan_box6">
                                <img src="../update_img/<?= $fetch_order_products['image']; ?>" alt="Menu Image">
                            </div>
                            <div class="pesanan_box7">
                                <h5><b><?= $fetch_order_products['name']; ?></b></h5>
                                <span><?= $fetch_order_products['quantity']; ?> Barang x </span>
                                <span><?= "Rp " . number_format($fetch_order_products['price']) ?></span>
                                <h4>+<?= $select_order_products1->rowCount() - 1 ?> Produk Lainnya</h4>
                            </div>
                        </div>
                        <div class="pesanan_box5">
                            <h4 class="pesanan_box5-text">Total Belanja</h4>
                            <h4 class="pesanan_box5-text1"><?= "Rp " . number_format($fetch_orders['total_price']) ?></h4>
                            <a href="../admin/pesanan1.php?pesanan1=<?= $fetch_orders['id']; ?>" class="pesanan1-link">Lihat Detail Pesanan</a>
                        </div>
                    </div>
                    <?php
                            }
                        }
                    ?>
                </div>

                <?php
                        }
                    }else{
                ?>
                    <div class="cart-empty">
                        <i class="ri-emotion-sad-line"></i>
                        <h4 class="h4-text1"> <b> Belum ada transasksi </b></h4>
                        <h5 class="h5-text1"> Yuk, Tambahkan Menu Warungmu Untuk Memudahkan Pelanggan Untuk Mencoba Produkmu! </h5>
                        <a href="../admin/menu.php" class="btn cart-btn1">Tambahkan Menu</a>
                    </div>
                <?php
                    }
                ?>
            </div>







        </section>





        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line"></i>
        </a>

        <!--=============== Header JS ===============-->
        <script src="../js/header.js"></script>