<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:./login.php');
};

$oid = $_GET['pembayaran1'];
$select_users = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
$select_users->execute([$oid]);

$fetch_users = $select_users->fetch(PDO::FETCH_ASSOC);

if($fetch_users['user_id'] != $user_id){
    header('location:./index.php');
}

if(isset($_POST['submit'])){

    $status = "Menunggu Verifikasi";
    $oid = $_GET['pembayaran1'];
 
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './payment_img/' .$image;

    $select_img = $conn->prepare("SELECT * FROM `orders` WHERE image = ?");
    $select_img->execute([$image]);

    if($select_img->rowCount() > 0){
        $message[] = 'Ganti Nama File Foto Anda!';
     }else{
        if($image_size > 2000000){
           $message[] = 'Ukuran Gambar Terlalu Besar!';
        }else{
           move_uploaded_file($image_tmp_name, $image_folder);
  
           $insert_img = $conn->prepare("UPDATE `orders` SET payment_status = ?, image = ? WHERE id = ?");
           $insert_img->execute([$status, $image, $oid]);
  
           $message[] = 'Bukti Berhasil Dikirim!';
        }
  
    }
  
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
            <div class="pesanan_boxs3 container">
                <div class="pesanan_boxs4">
                    <div class="pesanan5_box1">
                        <a href="./pembayaran.php">
                            <i class="ri-arrow-left-line pesanan3-icon"></i>
                        </a>
                        <span>Detail Pembayaran</span>
                    </div>

                    <div class="pesanan5_box2">
                        <i class="ri-shopping-basket-2-line"></i>
                    </div>


                    <?php
                    $oid = $_GET['pembayaran1'];
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
                    $select_orders->execute([$oid]);
                        if($select_orders->rowCount() > 0){
                            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                                $payment_id = $fetch_orders['method'];
                                $select_payment = $conn->prepare("SELECT * FROM `payment_method` WHERE id = ?");
                                $select_payment->execute([$payment_id]);
                                $fetch_payment = $select_payment->fetch(PDO::FETCH_ASSOC);
                                if($fetch_orders['total_price'] > 20000){
                                    $ongkir = 0;
                                }else{
                                    $ongkir = 5000;
                                }
                    ?>
                    <div class="pesanan5_box3">
                        <div class="pesanan5_box4">
                            <h4>Status</h4>
                        </div>
                        <div class="pesanan5_box5">
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
                    <div class="pesanan5_box3">
                        <div class="pesanan5_box4">
                            <h4>No. Pesanan</h4>
                        </div>
                        <div class="pesanan5_box5">
                            <h5><?= $fetch_orders['id']; ?></h5>
                        </div>
                    </div>
                    <div class="pesanan6_box1">
                        <div class="pesanan5_box4">
                            <h4>Tanggal Pembelian</h4>
                        </div>
                        <div class="pesanan5_box5">
                            <h5><?= $fetch_orders['placed_on']; ?>, <?= $fetch_orders['waktu']; ?></h5>
                        </div>
                    </div>

                    <div class="pesanan5_box6">
                        <div class="pesanan5_box8">
                            <div class="pesanan5_box9">
                                <h4>Total Harga ( <?= $fetch_orders['total_products']; ?> Barang )</h4>
                                <h4>Total Ongkos Kirim</h4>
                                <h4>Biaya Admin</h4>
                                <h4><b>Total Belanja</b></h4>
                            </div>
                            <div class="pesanan5_box10">
                                <h6><?= "Rp " . number_format($fetch_orders['total_price']  - $ongkir) ?></h6>
                                <h6><?= "Rp " . number_format($ongkir) ?></h6>
                                <h6>Rp 0</h6>
                                <h6><b><?= "Rp " . number_format($fetch_orders['total_price']) ?></b></h6>
                            </div>
                        </div>
                    </div>

                    <div class="pesanan5_box11">
                        <h4>Tranfer Ke</h4>
                        <div class="pesanan5_box12">
                            <img src="./bank_img/<?= $fetch_payment['image']; ?>" alt="">
                            <h4>Bank : <b><?= $fetch_payment['method']; ?></b></h4>
                            <h4>Nomor Rekening :</h4>
                            <h4><b><?= $fetch_payment['no_rek']; ?></b></h4>
                            <h4>Atas Nama : <b><?= $fetch_payment['atasnama']; ?></b></h4>
                        </div>
                    </div>

                    <?php
                    $pstatus = "Menunggu Pembayaran";
                    $select_orders1 = $conn->prepare("SELECT * FROM `orders` WHERE id = ? AND payment_status = ?");
                    $select_orders1->execute([$oid, $pstatus]);
                    if($select_orders1->rowCount() > 0){
                        while($fetch_orders1 = $select_orders1->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <div class="pesanan5_box13">
                        <h6>HARAP BACA PENTING!!!</h6>
                        <h4>*Mohon transfer sesuai jumlah yang tertera(tidak lebih atau kurang). Diharapkan atas nama bank anda sesuai dengan nama yang ada di profile anda. simpan bukti transfer kemudian upload foto tersebut dibawah ini!!!</h4>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="pesanan_content">
                            <input type="file" name="image" class="pesanan_input" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                            <label for="" class="pesanan_label">Image</label>  
                        </div>
                        <div class="pesanan5_box14">
                            <input type="submit" value="Kirim" class="btn" id="pesananbtn" name="submit">
                        </div>
                    </form>
                </div>

                <?php
                        }
                    }
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

        <!--=============== Header JS ===============-->
        <script src="./js/header.js"></script>
    </body>