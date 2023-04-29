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
                            <a href="" class="nav__link active-link">Beranda</a>
                        </li>
                        <li class="nav__item">
                            <a href="../admin/lokasi.php"about class="nav__link">Lokasi</a>
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

        <section class="transaksi section">
            <span class="transaksi_subtitle">Dashboard Admin Panel</span>
            <h4 class="transaksi_title">Beranda</h4>

            <?php
                $pstatus1 = "Menunggu Pembayaran";
                $pstatus2 = "Menunggu Verifikasi";
                $pstatus3 = "Sedang Diperjalanan";
                $pstatus4 = "Selesai";
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total_uang = 0;
                $total_pesanan = 0;

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

                $total_uang = $total1 + $total2 + $total3 + $total4;
                $total_pesanan = $select_pembayaran1->rowCount() + $select_pembayaran2->rowCount() + $select_pembayaran3->rowCount() + $select_pembayaran4->rowCount();

                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();

                $select_order_products = $conn->prepare("SELECT * FROM `order_products`");
                $select_order_products->execute();

                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();

                $role1 = "user";
                $role2 = "seller";
                $role3 = "admin";

                $select_lokasi = $conn->prepare("SELECT * FROM `lokasi`");
                $select_lokasi->execute();

                
                $select_role2 = $conn->prepare("SELECT COUNT(*) as total_role2 FROM lokasi WHERE user_id IN (SELECT id FROM users WHERE role = ?)");
                $select_role2->execute([$role2]);
                $fetch_role2 = $select_role2->fetch(PDO::FETCH_ASSOC);
                $total_role2 = $fetch_role2['total_role2'];

                $select_role3 = $conn->prepare("SELECT COUNT(*) as total_role3 FROM lokasi WHERE user_id IN (SELECT id FROM users WHERE role = ?)");
                $select_role3->execute([$role3]);
                $fetch_role3 = $select_role3->fetch(PDO::FETCH_ASSOC);
                $total_role3 = $fetch_role3['total_role3'];

                $select_bantuan = $conn->prepare("SELECT * FROM `messages`");
                $select_bantuan->execute();

                $select_users1 = $conn->prepare("SELECT * FROM `users` WHERE role = ?");
                $select_users1->execute([$role1]);

                $select_users2 = $conn->prepare("SELECT * FROM `users` WHERE role = ?");
                $select_users2->execute([$role2]);

                $select_users3 = $conn->prepare("SELECT * FROM `users` WHERE role = ?");
                $select_users3->execute([$role3]);

                





                
            ?>

            <div class="transboxs container grid">
                <div class="transbox13">
                    <div class="tran-icon4">
                        <i class="ri-team-line"></i>
                    </div>
                    <h5><b>-</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Users</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?=  $select_users->rowCount()?> Users</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox13">
                    <div class="tran-icon4">
                        <i class="ri-group-line"></i>
                    </div>
                    <h5><b>-</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Role User</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?=  $select_users1->rowCount()?> User</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox13">
                    <div class="tran-icon4">
                        <i class="ri-user-add-line"></i>
                    </div>
                    <h5><b>-</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Role Seller</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?=  $select_users2->rowCount()?> Seller</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox13">
                    <div class="tran-icon4">
                        <i class="ri-admin-line"></i>
                    </div>
                    <h5><b>-</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Role Admin</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?=  $select_users3->rowCount()?> Admin</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox1">
                    <div class="tran-icon1">
                        <i class="ri-mail-unread-line"></i>
                    </div>
                    <h5><b>-</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Pesan Bantuan</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $select_bantuan->rowCount()?> Pesan</h4>
                        </div>
                    </div>
                </div>
            
                <div class="transbox5">
                    <div class="tran-icon2">
                        <i class="ri-map-pin-line"></i>
                    </div>
                    <h5><b><?=$select_lokasi->rowCount()?> Lokasi</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Lokasi Tersedia</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $total_role2 ?> Seller dan <?= $total_role3?> Admin</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox5">
                    <div class="tran-icon2">
                        <i class="ri-shopping-cart-2-line"></i>
                    </div>
                    <h5><b><?=$select_order_products->rowCount()?> Terjual</b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Menu</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $select_products->rowCount()?> Menu</h4>
                        </div>
                    </div>
                </div>

                <div class="transbox6">
                    <div class="tran-icon3">
                        <i class="ri-wallet-2-line"></i>
                    </div>
                    <h5><b><?="Rp " . number_format($total_uang)?></b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4>Total Pesanan</h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $total_pesanan ?> Pesanan</h4>
                        </div>
                    </div>
                </div>

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









        </section>



        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line"></i>
        </a>


        <!--=============== Header JS ===============-->
        <script src="../js/header.js"></script>