<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:./login.php');
};

$check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$check_cart->execute([$user_id]);

if($check_cart->rowCount() == 0){
    header('location:./cart.php');
}

if(isset($_SESSION['total'])){
    $grand_total = $_SESSION['total'];
}else{
    header('location:./cart.php');
}

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address = $_POST['address'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
    $placed_on = date('Y-m-d');
    $payment_status = "Menunggu Pembayaran";
    $waktu = date('H:i:s');
 
    $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status, waktu) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on, $payment_status, $waktu]);
 
    $order_id = $conn->lastInsertId();

    $select_cart1 = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart1->execute([$user_id]);
    if($select_cart1->rowCount() > 0){
        while($data1 = $select_cart1->fetch(PDO::FETCH_ASSOC)){
            $name = $data1['name'];
            $price = $data1['price'];
            $qty = $data1['quantity'];
            $image = $data1['image'];

            $insert_order_products = $conn->prepare("INSERT INTO `order_products`(oid, name, price, quantity, image) VALUES(?,?,?,?,?)");
            $insert_order_products->execute([$order_id, $name, $price, $qty, $image]);
        }
    }

    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);

    unset($_SESSION['grand_total']);

    header('location:./pesanan.php');
 


 
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
                    <a href="cart.php" class="barang active-link"><i class="fas fa-shopping-cart active-link"></i><span>(<?= $total_keranjang; ?>)</span></a>
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
            <span class="menu_subtitle">Cek Kembali Belanjaanmu</span>
            <h4 class="menu_title">Checkout</h4>

            <div class="cartboxs container grid">
                <div class="cartboxs1">
                    <?php
                        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                        $select_profile->execute([$user_id]);
                        if($select_profile->rowCount() > 0){
                            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="cart_box">
                        <?php
                        if($grand_total > 20000){
                            $ongkir = 0;
                        ?>
                        <div class="cart_info">
                            <i class="ri-information-line"></i>
                            <h4>Yay, ongkir untuk pesanan dalam transaksi ini ditanggung Bajikuyyy!</h4>
                        </div>
                        <?php
                        }else{
                            $ongkir = 5000;
                        ?>
                        <div class="cart_info">
                            <i class="ri-information-line"></i>
                            <h4>Kamu dapat <b>Bebas Ongkir</b> min. belanja RP20 rb, ya. Hari ini terakhir.</h4>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="cart_box">
                        <div class="cart_info3">
                            <h4><b>Alamat Pengiriman</b></h4>
                        </div>
                        <div class="cart_info2">
                            <h4><?= $fetch_profile['name']; ?> (<?= $fetch_profile['number']; ?>)</h4>
                            <h4><?= $fetch_profile['address']; ?></h4>
                        </div>
                    </div>

                    <?php
                        }
                        $grand_total = 0;
                        $grand_total_barang = 0;
                        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $select_cart->execute([$user_id]);
                        if($select_cart->rowCount() > 0){
                            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <form action="" method="post" class="cart_box1 grid">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <input type="hidden" name="cart_qty" value="<?= $fetch_cart['quantity']; ?>">
                        <input type="hidden" name="cart_price" value="<?= $fetch_cart['price']; ?>">
                        <div class="cart_img">
                            <img src="./update_img/<?= $fetch_cart['image']; ?>" alt="">
                        </div>

                        <div class="cart_menu">
                            <div class="cart_menu-info">
                                <h4><?= $fetch_cart['name']; ?></h4>
                                <h6>( <?= $fetch_cart['quantity']; ?> Barang )</h4>
                                <h4><?= "Rp " . number_format($sub_total = ($fetch_cart['price'] * $fetch_cart['quantity'])); ?></h4>
                            </div>
                        </div>


                    </form>
                    <?php
                            $grand_total += $sub_total;
                            $grand_total_barang +=  $fetch_cart['quantity'];
                            }
                    ?>
                </div>



                <div class="cartboxs2">
                    <div class="cart-totals">
                        <h4 class="cart-text1"> <b>Ringkasan Belanja</b> </h4>
                        <div class="cart-text1">
                            <span>Total Harga( <?= $grand_total_barang ?> Barang )</span>
                            <span><?="Rp " . number_format($grand_total)?></span>
                        </div>
                        <div class="cart-total cart-text1">
                            <span>Ongkir</span>
                            <span><?="Rp " . number_format($ongkir)?></span>
                        </div>
                        <div class="cart-text1">
                            <span><b>Total Harga</b></span>
                            <span> <b> <?="Rp " . number_format($grand_total + $ongkir)?> </b></span>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <h4 class="cart-text1"> <b>Pilih Pembayaran</b> </h4>
                            <select name="method" class="cart-payment" required>
                                <option value="" disabled selected>Pilih Metode Pembayaran --</option>
                                <option value="1">COD (Bayar di Tempat)</option>
                                <option value="2">BCA (Bank Central Asia)</option>
                                <option value="3">BRI (Bank Rakyat Indonesia)</option>
                                <option value="4">BTN (Bank Tabungan Negara)</option>
                                <option value="5">Mandiri</option>
                            </select>
                            <input type="hidden" name="total_products" value="<?= $grand_total_barang; ?>">
                            <input type="hidden" name="total_price" value="<?= $grand_total + $ongkir; ?>" >
                            <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
                            <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
                            <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
                            <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
                            <input type="submit" value="Beli" class="btn" id="lokabtn" name="submit">
                        </form>
                    </div>
                </div>

                    <?php
                        }
                    ?>
            </div>


















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