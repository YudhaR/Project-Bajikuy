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
            <span class="transaksi_subtitle">Dashboard Transaksi Penjualan</span>
            <h4 class="transaksi_title">Pesanan</h4>

            <?php
                $pstatus1 = "Menunggu Pembayaran";
                $pstatus2 = "Menunggu Verifikasi";
                $pstatus3 = "Sedang Diperjalanan";
                $pstatus4 = "Selesai";
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;

                $select_pembayaran1 = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_pembayaran1->execute([$pstatus1]);
                if($select_pembayaran1->rowCount() > 0){
                    while($fetch_pembayaran1 = $select_pembayaran1->fetch(PDO::FETCH_ASSOC)){
                        $total1 += $fetch_pembayaran1['total_price'];
                    }
                }


                $select_pembayaran2 = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_pembayaran2->execute([$pstatus2]);
                if($select_pembayaran2->rowCount() > 0){
                    while($fetch_pembayaran2 = $select_pembayaran2->fetch(PDO::FETCH_ASSOC)){
                        $total2 += $fetch_pembayaran2['total_price'];
                    }
                }

                $select_pembayaran3 = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_pembayaran3->execute([$pstatus3]);
                if($select_pembayaran3->rowCount() > 0){
                    while($fetch_pembayaran3 = $select_pembayaran3->fetch(PDO::FETCH_ASSOC)){
                        $total3 += $fetch_pembayaran3['total_price'];
                    }
                }

                $select_pembayaran4 = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                $select_pembayaran4->execute([$pstatus4]);
                if($select_pembayaran4->rowCount() > 0){
                    while($fetch_pembayaran4 = $select_pembayaran4->fetch(PDO::FETCH_ASSOC)){
                        $total4 += $fetch_pembayaran4['total_price'];
                    }
                }
            ?>


            <div class="transboxs container grid">
                <div class="transbox1">
                    <div class="tran-icon1">
                        <i class="ri-shopping-bag-line"></i>
                    </div>
                    <h5><b><?="Rp " . number_format($total1)?></b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Menunggu Pembayaran</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $select_pembayaran1->rowCount()?> Pesanan</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox5">
                    <div class="tran-icon2">
                        <i class="ri-customer-service-2-line"></i>
                    </div>
                    <h5><b><?="Rp " . number_format($total2)?></b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Menunggu Verifikasi</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $select_pembayaran2->rowCount()?> Pesanan</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox5">
                    <div class="tran-icon2">
                        <i class="ri-inbox-unarchive-line"></i>
                    </div>
                    <h5><b><?="Rp " . number_format($total3)?></b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Sedang Diperjalanan</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $select_pembayaran3->rowCount()?> Pesanan</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox6">
                    <div class="tran-icon3">
                        <i class="ri-dropbox-fill"></i>
                    </div>
                    <h5><b><?="Rp " . number_format($total4)?></b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Selesai</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $select_pembayaran4->rowCount()?> Pesanan</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pesanan_boxs container transbox7">
                <a href="../admin/menunggu_pembayaran.php" class="pesanan_box1">
                    <div class="pesanan-text1">
                        <span>Menunggu Pembayaran</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                    <i class="ri-shopping-bag-line pesanan-icon"></i>
                </a>
                
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ORDER BY `id` ASC LIMIT 2");
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

            <div class="pesanan_boxs container transbox7">
                <a href="../admin/menunggu_verifikasi.php" class="pesanan_box1">
                    <div class="pesanan-text1">
                        <span>Menunggu Verifikasi</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                    <i class="ri-customer-service-2-line pesanan-icon"></i>
                </a>
                
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ORDER BY `id` ASC LIMIT 2");
                $select_orders->execute([$pstatus2]);
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

            <div class="pesanan_boxs container transbox7">
                <a href="../admin/sedang_diperjalanan.php" class="pesanan_box1">
                    <div class="pesanan-text1">
                        <span>Sedang Diperjalanan</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                    <i class="ri-inbox-unarchive-line pesanan-icon"></i>
                </a>
                
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ORDER BY `id` ASC LIMIT 2");
                $select_orders->execute([$pstatus3]);
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

            <div class="pesanan_boxs container transbox7">
                <a href="../admin/selesai.php" class="pesanan_box1">
                    <div class="pesanan-text1">
                        <span>Selesai</span>
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                    <i class="ri-dropbox-fill pesanan-icon"></i>
                </a>
                
                <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? ORDER BY `id` ASC LIMIT 2");
                $select_orders->execute([$pstatus4]);
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