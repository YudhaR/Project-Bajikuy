<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:./login.php');
};

if(isset($_POST['hapus_cart'])){
    $cart_id = $_POST['cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$cart_id]);
    $message[] = 'Menu Telah Dihapus!';
}
 
if(isset($_POST['hapusall_cart'])){
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_item->execute([$user_id]);
    $message[] = 'Semua Menu Telah Dihapus!';
}

if(isset($_POST['edit_cart'])){
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
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
            <span class="menu_subtitle">Cek Kembali Keranjangmu</span>
            <h4 class="menu_title">Keranjang</h4>

            <div class="cartboxs container grid">
                <div class="cartboxs1">
                    <?php
                        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                        $select_profile->execute([$user_id]);
                        if($select_profile->rowCount() > 0){
                            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="cart_box">
                        <div class="cart_info">
                            <i class="ri-information-line"></i>
                            <h4>Kamu dapat <b>Bebas Ongkir</b> min. belanja RP20 rb, ya. Hari ini terakhir.</h4>
                        </div>
                        <div class="cart_info1">
                            <i class="ri-map-pin-line"></i>
                            <h4>Dikirim ke <b><?= $fetch_profile['address']; ?></b></h4>
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
                        <div class="cart_img">
                            <img src="./update_img/<?= $fetch_cart['image']; ?>" alt="">
                        </div>

                        <div class="cart_menu">
                            <div class="cart_menu-info">
                                <h4><?= $fetch_cart['name']; ?></h4>
                                <h4><?= "Rp " . number_format($fetch_cart['price']); ?></h4>
                            </div>
                            <div class="cart_menu-info1 grid">
                                <div class="sub-total">
                                    <h4> <b> Sub total : <?= "Rp " . number_format($sub_total = ($fetch_cart['price'] * $fetch_cart['quantity'])); ?>/- </b></h4>
                                </div>
                                <div class="cart-qty">
                                    <button class="cart-btn" type="submit" name="hapus_cart" onclick="return confirm('Hapus keranjang untuk menu ini?')";>
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                    <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                                    <button class="cart-btn" type="submit" name="edit_cart">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                </div>
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
                        <form action="" method="post" class="cart_hapus-btn">
                            <button class="cart_hapus-btn1" type="submit" name="hapusall_cart" onclick="return confirm('Hapus semua keranjang?')";>
                                Hapus Semua
                            </button>
                        </form>
                        <h4 class="cart-text1"> <b>Ringkasan Belanja</b> </h4>
                        <div class="cart-total cart-text1">
                            <span>Total Harga(<?= $grand_total_barang ?> Barang)</span>
                            <span><?="Rp " . number_format($grand_total)?></span>
                        </div>
                        <div class="cart-text1">
                            <span><b>Total Harga</b></span>
                            <span> <b> <?="Rp " . number_format($grand_total)?> </b></span>
                        </div>
                        <a href="./checkout.php" class="btn cart-btn1">Beli</a>
                    </div>
                </div>

                    <?php
                        }else{
                    ?>
                    <div class="cart-empty">
                        <i class="ri-emotion-sad-line"></i>
                        <h4 class="h4-text1"> <b> Wah, keranjang belanjamu kosong </b></h4>
                        <h5 class="h5-text1"> Yuk, isi dengan Minuman dan Makanan Favoritmu! </h5>
                        <a href="./index.php#menu" class="btn cart-btn1">Mulai Belanja</a>
                    </div>
                </div> 

                <div class="cartboxs2">
                    <div class="cart-totals">
                        <form action="" method="post" class="cart_hapus-btn">
                            <button class="cart_hapus-btn1" type="submit" name="-" disabled>
                                Hapus Semua
                            </button>
                        </form>
                        <h4 class="cart-text1"> <b>Ringkasan Belanja</b> </h4>
                        <div class="cart-total cart-text1">
                            <span>Total Harga( - Barang)</span>
                            <span>Rp -</span>
                        </div>
                        <div class="cart-text1">
                            <span><b>Total Harga</b></span>
                            <span> <b> Rp - </b></span>
                        </div>
                        <a href="./checkout.php" class="btn cart-btn1" id="lokbtn">Beli</a>
                    </div>
                </div>

                    <?php
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