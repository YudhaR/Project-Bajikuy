<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:./login.php');
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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
                            <a href="./pesanan.php" class="nav__link active-link">Pesanan</a>
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
                    <a href="cart.php" class="barang "><i class="fas fa-shopping-cart "></i><span>(<?= $total_keranjang; ?>)</span></a>
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

        <section class="menu section">
            <div class="pesanan_boxs1 container">
                <div class="pesanan1_box2">
                    <a href="./pesanan.php">
                        <i class="ri-arrow-left-line pesanan1-icon"></i>
                    </a>
                    <span>Detail Pesanan</span>
                </div>

                <?php
                $oid = $_GET['pesanan1'];
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
                $select_orders->execute([$oid]);
                    if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="pesanan1_box1">
                    <div class="pesanan2_box1">
                        <h4>Status</h4>
                    </div>
                    <div class="pesanan2_box2">
                        <?php
                        if($fetch_orders['payment_status']  == "Menunggu Pembayaran"){
                        ?>
                        <h4 class="hapus1"><?= $fetch_orders['payment_status']; ?></h4>
                        <?php
                        }else if($fetch_orders['payment_status']  == "Menunggu Verifikasi"){
                        ?>
                        <h4 class="edit1"><?= $fetch_orders['payment_status']; ?></h4>
                        <?php
                        }else if($fetch_orders['payment_status']  == "Sedang Diperjalanan"){
                        ?>
                        <h4 class="edit1"><?= $fetch_orders['payment_status']; ?></h4>
                        <?php
                        }else if($fetch_orders['payment_status']  == "Selesai"){
                        ?>
                        <h4 class="tambah1"><?= $fetch_orders['payment_status']; ?></h4>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="pesanan1_box1">
                    <div class="pesanan2_box1">
                        <h4>No. Pesanan</h4>
                    </div>
                    <div class="pesanan2_box2">
                        <h5><?= $fetch_orders['id']; ?></h5>
                    </div>
                </div>
                <div class="pesanan3_box1">
                    <div class="pesanan2_box1">
                        <h4>Tanggal Pembelian</h4>
                    </div>
                    <div class="pesanan2_box2">
                        <h5><?= $fetch_orders['placed_on']; ?>, <?= $fetch_orders['waktu']; ?></h5>
                    </div>
                </div>

                <?php
                $paymentid = $fetch_orders['method'];
                $select_method = $conn->prepare("SELECT * FROM `payment_method` WHERE id = ?");
                $select_method->execute([$paymentid]);
                $fetch_method = $select_method->fetch(PDO::FETCH_ASSOC);
                $select_order_products = $conn->prepare("SELECT * FROM `order_products` WHERE oid = ?");
                $select_order_products->execute([$oid]);
                    if($select_order_products->rowCount() > 0){
                        while($fetch_order_products = $select_order_products->fetch(PDO::FETCH_ASSOC)){
                            if($fetch_orders['total_price'] > 20000){
                                $ongkir = 0;
                            }else{
                                $ongkir = 5000;
                            }
                ?>
                <div class="pesanan1_box3">
                    <div class="pesanan1_box4">
                        <div class="pesanan1_box6">
                            <img src="./update_img/<?= $fetch_order_products['image']; ?>" alt="Menu Image">
                        </div>
                        <div class="pesanan1_box7">
                            <h5><b><?= $fetch_order_products['name']; ?></b></h5>
                            <span><?= $fetch_order_products['quantity']; ?> Barang x </span>
                            <span><?= "Rp " . number_format($fetch_order_products['price']) ?></span>
                        </div>
                    </div>
                    <div class="pesanan1_box5">
                        <h4 class="pesanan1_box5-text">Total Belanja</h4>
                        <h4 class="pesanan1_box5-text1"><?= "Rp " . number_format($fetch_order_products['price'] * $fetch_order_products['quantity']) ?></h4>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
                <div class="pesanan1_box8">
                    <h4>Info Pengiriman</h4>
                    <h5><b><?= $fetch_orders['name']; ?> </b>( <?= $fetch_orders['number']; ?> )</h5>
                    <h6><?= $fetch_orders['address']; ?></h6>
                </div>

                <div class="pesanan1_box8">
                    <h4>Rincian Pembayaran</h4>
                </div>

                <div class="pesanan1_box1">
                    <div class="pesanan2_box1">
                        <h4>Metode Pembayaran</h4>
                    </div>
                    <div class="pesanan2_box2">
                        <h5><?= $fetch_method['method']; ?></h5>
                    </div>
                </div>
                <div class="pesanan1_box1">
                    <div class="pesanan2_box1">
                        <h4>Total Harga ( <?= $fetch_orders['total_products']; ?> Barang )</h4>
                    </div>
                    <div class="pesanan2_box2">
                        <h5><?= "Rp " . number_format($fetch_orders['total_price']  - $ongkir) ?></h5>
                    </div>
                </div>
                <div class="pesanan1_box1">
                    <div class="pesanan2_box1">
                        <h4>Total Ongkos Kirim</h4>
                    </div>
                    <div class="pesanan2_box2">
                        <h5><?= "Rp " . number_format($ongkir) ?></h5>
                    </div>
                </div>
                <div class="pesanan1_box1">
                    <div class="pesanan2_box1">
                        <h4><b>Total Belanja</b></h4>
                    </div>
                    <div class="pesanan2_box2">
                        <h5><b><?= "Rp " . number_format($fetch_orders['total_price']) ?></b></h5>
                    </div>
                </div>






                <?php
                        }
                    }
                ?>
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