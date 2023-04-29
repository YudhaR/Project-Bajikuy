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

if(isset($_POST['submit'])){
    $uid = $_POST['uid'];
    $urole = $_POST['urole'];

    if($urole == "user"){
        $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
        $delete_user->execute([$uid]);

        $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
        $delete_orders->execute([$uid]);
        
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$uid]);

        $delete_order_products = $conn->prepare("DELETE FROM `order_products` WHERE user_id = ?");
        $delete_order_products->execute([$uid]);

        $message[] = 'Akun berhasil dihapus!';
    }else if($urole == "seller"){
        $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
        $delete_user->execute([$uid]);

        $delete_lokasi = $conn->prepare("DELETE FROM `lokasi` WHERE user_id = ?");
        $delete_lokasi->execute([$uid]);

        $message[] = 'Akun berhasil dihapus!';
    }

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
                            <a href="../admin/index.php" class="nav__link ">Beranda</a>
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
                            <a href="../admin/acc.php" class="nav__link active-link">Akun</a>
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

        <section class="acc section">
            <div class="transboxs container grid">
            <?php
                $role1 = "user";
                $role2 = "seller";
                $select_users = $conn->prepare("SELECT * FROM `users` WHERE role = ? OR role = ?");
                $select_users->execute([$role1, $role2]);
                if($select_users->rowCount() > 0){
                    while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="transbox13">
                    <div class="tran-icon4">
                        <i class="ri-team-line"></i>
                    </div>
                    <h5><b><?= $fetch_users['name']; ?></b></h5>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4><?= $fetch_users['email']; ?></h4>
                        </div>
                        <div class="transbox4">
                            <h4>#<?= $fetch_users['id']; ?> </h4>
                        </div>
                    </div>
                    <div class="transbox2">
                        <div class="transbox3">
                            <h4><?= $fetch_users['role']; ?></h4>
                        </div>
                        <div class="transbox4">
                            <h4><?= $fetch_users['number']; ?> </h4>
                        </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" class="transdlt">
                        <input type="hidden" name="uid" value="<?= $fetch_users['id']; ?>">
                        <input type="hidden" name="urole" value="<?= $fetch_users['role']; ?>">
                        <input type="submit" value="Hapus" class="delete-btn" id="transbtn" name="submit" onclick="return confirm('Hapus Lokasi ini?')">
                    </form>
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


        <!--=============== Header JS ===============-->
        <script src="../js/header.js"></script>