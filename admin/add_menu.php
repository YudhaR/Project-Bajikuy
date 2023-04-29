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

    $judul = $_POST['judul'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $uid = $_POST['uid'];
    $uname = $_POST['uname'];
    $uemail = $_POST['uemail'];
    $status = "Menambahkan";
 
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../update_img/' .$image;
    $waktu = date('Y-m-d');
    $waktu1 = date('Y-m-d H:i:s');
 
    $select_menu = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_menu->execute([$judul]);
 
    if($select_menu->rowCount() > 0){
       $message[] = 'Menu Sudah Tersedia!';
    }else{
       if($image_size > 2000000){
          $message[] = 'Ukuran Gambar Terlalu Besar!';
       }else{
          move_uploaded_file($image_tmp_name, $image_folder);
 
          $insert_menu = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
          $insert_menu->execute([$judul, $category, $price, $image]);

          $insert_update = $conn->prepare("INSERT INTO `tabel_products`(user_id, name, email, judul, status, waktu) VALUES(?,?,?,?,?,?)");
          $insert_update->execute([$uid, $uname, $uemail, $judul, $status, $waktu1]);
 
          $message[] = 'Menu Telah Ditambahkan!';
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
                    <a href="../admin/menu.php"><i class="ri-arrow-left-line icon_panah"></i></a>
                    <span class="section_title profile_title1">Tambah Menu</span> 
                </div>

                <div class="profile-box">
                    <h3 class="profile_title3">Tambahkan menu warungmu untuk memudahkan pelanggan untuk mencoba produkmu!</h3> 
                </div>

                <div class="updt_alm">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="almeb">
                            <div class="alm_content">
                                <input type="text" required placeholder=" " class="alm_input" name="judul">
                                <label for="" class="alm_label">Nama Product</label>  
                            </div>

                            <select class="category_select" name="category" >
                                <option value="" disabled selected>Pilih Kategori --</option>
                                <option value="minuman Tradisional">Minuman Tradisional</option>
                                <option value="makanan Tradisional">Makanan Tradisional</option>
                                <option value="jajanan Tradisional">Jajanan Tradisional</option>
                            </select>

                            <div class="alm_content">
                                <input type="number" required placeholder=" " class="alm_input" name="price">
                                <label for="" class="alm_label">Price</label>  
                            </div>

                            <div class="alm_content">
                                <input type="file" name="image" class="alm_input" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                                <label for="" class="alm_label">Image</label>  
                            </div>
                            <?php
                                $select_update = $conn->prepare("SELECT * FROM `users` WHERE id = \"$user_id\"");
                                $select_update->execute();
                                if($select_update->rowCount() >= 0){
                                    while($fetch_update = $select_update->fetch(PDO::FETCH_ASSOC)){  
                            ?>
                                <input type="hidden" name="uid" value="<?= $fetch_update['id']; ?>">
                                <input type="hidden" name="uname" value="<?= $fetch_update['name']; ?>">
                                <input type="hidden" name="uemail" value="<?= $fetch_update['email']; ?>">
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <input type="submit" value="Tambah" class="btn" id="lokabtn" name="submit">
                    </form>
                </div>

            </div>
        </section>


 











        <!--========== SCROLL UP ==========-->
        <a href="#" class="scrollup" id="scroll-up">
            <i class="ri-arrow-up-line"></i>
        </a>

        <!--=============== Header JS ===============-->
        <script src="../js/header.js"></script>