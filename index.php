<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $pesan = $_POST['pesan'];

    $insert_bantuan = $conn->prepare("INSERT INTO `messages`(email, subject, message) VALUES(?,?,?)");
    $insert_bantuan->execute([$email, $subject, $pesan]);

    $message[] = 'Pesan berhasil dikirim!';
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
                            <a href="#home" class="nav__link active-link">Beranda</a>
                        </li>
                        <li class="nav__item">
                            <a href="#cerita"about class="nav__link">Cerita</a>
                        </li>
                        <li class="nav__item">
                            <a href="#lokasi" class="nav__link">Lokasi</a>
                        </li>
                        <li class="nav__item">
                            <a href="#menu" class="nav__link">Menu</a>
                        </li>
                        <li class="nav__item">
                            <a href="./pesanan.php" class="nav__link">Pesanan</a>
                        </li>
                        <li class="nav__item">
                            <a href="#bantuan" class="nav__link">Bantuan</a>
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
                    <a href="cart.php" class="barang"><i class="fas fa-shopping-cart"></i><span>(<?= $total_keranjang; ?>)</span></a>
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

        <!--==================== MAIN ====================-->

        <!--==================== Home ====================-->
        <section class="home section" id="home">
            <div class="home_container container grid">
                <div class="home_data">
                    <span class="home_subtitle">Temukan secangkir gelasmu hanya di</span>
                    <h4 class="home_title">BAJIKUYYY STORE</h4>
                    <div class="home_list">
                        <h4 class="dropdown">KUNJUNGI</h4>
                        <ul class="home_items">
                            <li class="home_item"><a href="https://www.facebook.com/watch/Masterchef/"target="_blank" class="home_link">Facebook</a></li>
                            <li class="home_item"><a href="https://www.instagram.com/ydhrizqi._/"target="_blank" class="home_link">Instagram</a></li>
                            <li class="home_item"><a href="https://twitter.com/ydhrizqi_"target="_blank" class="home_link">Twitter</a></li>
                        </ul>
                    </div>
                </div>
                <div class="home_description">
                    <p class="desc">Bajikuyyy adalah platform yang bertujuan melestarikan minuman hangat tradisional Indonesia dengan merekomendasikan minuman dan tempat terdekat untuk mendapatkannya, yang memiliki banyak khasiat dan nilai manfaat yang terkandung dalam setiap gelas atau cangkir minuman tersebut.</p>
                    <div class="box">
                        <a href="#cerita">
                            <div class="boxp">
                                <h2 class="box_title">Cerita</h2>
                                <img src="./img/1.png" alt="">
                            </div>
                        </a>
                        <a href="#menu">
                            <div class="boxp">
                                <h2 class="box_title">Toko</h2>
                                <img src="./img/3.png" alt="">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!--==================== Cerita ====================-->
        <section class="cerita section" id="cerita">
            <span class="cerita_subtitle">Cerita dibalik kehangatan</span>
            <h4 class="cerita_title">Cerita</h4>

            <div class="cerita_container container grid">
                <div class="cerita_data">
                    <h4 class="cerita_title">
                        Minuman Tradisional <br>
                        Wedang Ronde
                    </h4>

                    <p class="cerita_description">
                    Wedang ronde merupakan salah satu bentuk akulturasi budaya di Indonesia. Minuman hangat tradisional ini berasal dari dataran Tiongkok dengan sebutan Dongzhi atau Tangyuan. Pada zaman dahulu ketika Indonesia belum terbentuk dan wilayah-wilayah masih disebut Nusantara, banyak pedagang yang datang ke Indonesia. Sebagian pedagang memperkenalkan minuman hangat ini. Masyarakat Nusantara mulai berinovasi membuat minuman tradisional dari bahan khas masyarakat Jawa yaitu, jahe.
                    </p>
                </div>
                <div class="cerita_box">
                    <img src="./img/ronde.png" alt="Wedang Ronde" class="cerita_img">
                </div>
            </div>

           <div class="cerita1_container container grid">
                <div class="cerita1_data">
                    <h4 class="cerita1_title">
                        Minuman Tradisional <br>
                        Wedang Sekoteng
                    </h4>

                    <p class="cerita_description">Sukothung atau shiguoteng ini dibawa oleh orang-orang Tiongkok ke Indonesia dan namanya dilafalkan menjadi Sekoteng. Isiannya juga berbeda karena disesuaikan dengan buah dan biji yang tumbuh di Indonesia. Sekoteng sendiri dalam budaya Jawa merupakan singkatan dari nyokot weteng yang artinya menggigit perut. Orang Jawa membuat sekoteng dari rebusan gula merah dan jahe yang diisi kacang tanah, kacang hijau, potongan roti tawar, dan pacar cina atau biji mutiara yang berwana merah muda.</p>
                </div>
                <img src="./img/sekoteng.png" alt="Wedang Sekoteng" class="cerita1_img">
           </div>

            <div class="cerita_container container grid">
                <div class="cerita_data">
                    <h4 class="cerita_title">
                        Minuman Tradisional <br>
                        Wedang Bajigur
                    </h4>

                    <p class="cerita_description">
                    Minuman tradisional ini pertama kali dikenalkan oleh para petani Sunda pada zaman dahulu. Mulanya, para petani terbiasa menikmati air rebusan gula aren selepas bekerja, tujuannya adalah untuk meningkatkan stamina dan menambah tenaga. Sampai pada suatu hari, mereka mulai menambahkan beberapa rempah ke dalam air rebusan tersebut, yang salah satunya adalah perasan santan. Sejak saat itu, bajigur menjadi populer di kalangan petani dan menjadi minuman favorit yang kemudian diperjual belikan.
                    </p>
                </div>
                <div class="cerita_box">
                    <img src="./img/bajigur.png" alt="Wedang Bajigur" class="cerita_img">
                </div>
            </div>

            <div class="cerita1_container container grid">
                <div class="cerita1_data">
                    <h4 class="cerita1_title">
                        Minuman Tradisional <br>
                        Wedang Jahe
                    </h4>

                    <p class="cerita_description">Wedang jahe merupakan minuman tradisional yang diwariskan oleh nenek moyang secara turun temurun. Minuman tradisional yang diolah dengan cara sederhana. Umum disajikan panas atau hangat. Wedang berasal dari bahasa jawa yang berarti “minuman jahe”. Jahe segar dipukul atau digeprek dipadukan dengan gula jawa, gula pasir, madu atau gula batu dalam sebuah gelas bercampur air panas. Jahe juga bisa ditambah rempah lain seperti cengkih, kayu manis dan daun pandan. Aroma menjadi khas nan menawan.</p>

                    <a href="#menu" class="button">
                        Beli Sekarang <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
                <img src="./img/jahe.png" alt="Wedang Jahe" class="cerita1_img">
           </div>

        </section>

        <!--==================== Lokasi ====================-->
        <section class="lokasi section" id="lokasi">
            <span class="lokasi_subtitle">Secangkir Gelasmu</span>
            <h4 class="lokasi_title">Lokasi</h4>

            <div class="bloks container">

                <?php
                    $select_lokasi = $conn->prepare("SELECT * FROM `lokasi`");
                    $select_lokasi->execute();
                    // $select_nama = "SELECT users.role FROM users JOIN lokasi ON users.id = lokasi.user_id";
                    // $result = $conn->query($select_nama);
                    // $fetch_name = $result->fetch(PDO::FETCH_ASSOC);
                    if(($select_lokasi->rowCount() > 2)&&($select_lokasi->rowCount() < 4)){
                        while($fetch_lokasi = $select_lokasi->fetch(PDO::FETCH_ASSOC)){
                            $select_nama = $conn->prepare("SELECT users.role FROM users JOIN lokasi ON users.id = lokasi.user_id WHERE lokasi.user_id = ?");
                            $select_nama->execute([$fetch_lokasi['user_id']]);
                            $fetch_name = $select_nama->fetch();
                ?>
                    <a href="<?= $fetch_lokasi['link']; ?>" class="blok" target="_blank">
                        <div class="image">
                            <img src="update_img/<?= $fetch_lokasi['image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <h3><?= $fetch_lokasi['judul']; ?></h3>
                            <p><?= $fetch_lokasi['deskripsi']; ?></p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> <?= $fetch_lokasi['waktu']; ?> </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> <?= $fetch_name['role']; ?> </h4>
                        </div>
                    </a>
                <?php
                        }
                    }else if($select_lokasi->rowCount() > 3){
                        while($fetch_lokasi = $select_lokasi->fetch(PDO::FETCH_ASSOC)){
                            $select_nama = $conn->prepare("SELECT users.role FROM users JOIN lokasi ON users.id = lokasi.user_id WHERE lokasi.user_id = ?");
                            $select_nama->execute([$fetch_lokasi['user_id']]);
                            $fetch_name = $select_nama->fetch();
                ?>
                    <a href="<?= $fetch_lokasi['link']; ?>" class="blok" target="_blank">
                        <div class="image">
                            <img src="update_img/<?= $fetch_lokasi['image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <h3><?= $fetch_lokasi['judul']; ?></h3>
                            <p><?= $fetch_lokasi['deskripsi']; ?></p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> <?= $fetch_lokasi['waktu']; ?> </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> <?= $fetch_name['role']; ?> </h4>
                        </div>
                    </a>
                <?php
                        }
                ?>
            </div>
            <div class="tombol container">
                <div id="load" class="btn"> Lebih Banyak </div>
            </div>
            <div class="tombol container">
                <a href="./lokasi.php" id="load1" class="btn"> Lebih Banyak </a>
            </div>
            <div class="bloks container">
                <?php
                    }else if(($select_lokasi->rowCount() > 0)&&($select_lokasi->rowCount() < 2)){
                        while($fetch_lokasi = $select_lokasi->fetch(PDO::FETCH_ASSOC)){
                            $select_nama = $conn->prepare("SELECT users.role FROM users JOIN lokasi ON users.id = lokasi.user_id WHERE lokasi.user_id = ?");
                            $select_nama->execute([$fetch_lokasi['user_id']]);
                            $fetch_name = $select_nama->fetch();
                ?>
                    <a href="<?= $fetch_lokasi['link']; ?>" class="blok" target="_blank">
                        <div class="image">
                            <img src="update_img/<?= $fetch_lokasi['image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <h3><?= $fetch_lokasi['judul']; ?></h3>
                            <p><?= $fetch_lokasi['deskripsi']; ?></p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> <?= $fetch_lokasi['waktu']; ?> </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> <?= $fetch_name['role']; ?> </h4>
                        </div>
                    </a>

                    <a href="#lokasi" class="blok">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-off-fill"></i>
                        </div>
                        <div class="content">
                            <h3>Segera Tersedia!</h3>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                        </div>
                    </a>

                    <a href="#lokasi" class="blok">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-off-fill"></i>
                        </div>
                        <div class="content">
                            <h3>Segera Tersedia!</h3>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                        </div>
                    </a>

                <?php
                        }
                    }else if(($select_lokasi->rowCount() > 1)&&($select_lokasi->rowCount() < 3)){
                        while($fetch_lokasi = $select_lokasi->fetch(PDO::FETCH_ASSOC)){
                            $select_nama = $conn->prepare("SELECT users.role FROM users JOIN lokasi ON users.id = lokasi.user_id WHERE lokasi.user_id = ?");
                            $select_nama->execute([$fetch_lokasi['user_id']]);
                            $fetch_name = $select_nama->fetch();
                ?>
                    <a href="<?= $fetch_lokasi['link']; ?>" class="blok" target="_blank">
                        <div class="image">
                            <img src="update_img/<?= $fetch_lokasi['image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <h3><?= $fetch_lokasi['judul']; ?></h3>
                            <p><?= $fetch_lokasi['deskripsi']; ?></p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> <?= $fetch_lokasi['waktu']; ?> </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> <?= $fetch_name['role']; ?> </h4>
                        </div>
                    </a>

                <?php
                        }
                ?>
                    <a href="#lokasi" class="blok">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-off-fill"></i>
                        </div>
                        <div class="content">
                            <h3>Segera Tersedia!</h3>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                        </div>
                    </a>
                <?php
                    }else{
                ?>
                    <a href="#lokasi" class="blok">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-off-fill"></i>
                        </div>
                        <div class="content">
                            <h3>Segera Tersedia!</h3>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                        </div>
                    </a>

                    <a href="#lokasi" class="blok">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-off-fill"></i>
                        </div>
                        <div class="content">
                            <h3>Segera Tersedia!</h3>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                        </div>
                    </a>

                    <a href="#lokasi" class="blok">
                        <div class="icon_lokasi">
                            <i class="ri-cloud-off-fill"></i>
                        </div>
                        <div class="content">
                            <h3>Segera Tersedia!</h3>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                            <h4 class="lokasic"> <i class="fas fa-calendar"></i> - </h4>
                            <h4 class="lokasic1"> <i class="fas fa-user"></i> - </h4>
                        </div>
                    </a>
                <?php
                    }
                ?>
            </div>
    
        </section>

        <!--==================== Menu ====================-->
        <section class="menu section" id="menu">
            <span class="menu_subtitle">Pilih Minuman Favoritmu</span>
            <h4 class="menu_title">Menu</h4>

            <div class="bmens container">
                <?php
                    $select_menu = $conn->prepare("SELECT * FROM `products`");
                    $select_menu->execute();
                    if($select_menu->rowCount() > 3){
                        while($fetch_products = $select_menu->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="bmen">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <img src="./img/<?= $fetch_products['image']; ?>" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name"><?= $fetch_products['name']; ?></h3>
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="menu_description"><?= $fetch_products['category']; ?></a>

                    <span class="menu_price"><?= "Rp " . number_format($fetch_products['price'], 0, ',', '.'); ?></span>

                    <button class="menu_button" type="submit" name="tambah_cart">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </form>
                <?php
                        }
                ?>
            </div>
            <div class="tombol container">
                <div id="loadmenu" class="btn"> Lebih Banyak </div>
            </div>
            <div class="tombol container">
                <a href="./menu.php" id="loadmenu1" class="btn"> Lebih Banyak </a>
            </div>
            <div class="bmens container">
                <?php
                    }else if(($select_menu->rowCount() > 2)&&($select_menu->rowCount() < 4)){
                        while($fetch_products = $select_menu->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="bmen">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <img src="./img/<?= $fetch_products['image']; ?>" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name"><?= $fetch_products['name']; ?></h3>
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="menu_description"><?= $fetch_products['category']; ?></a>

                    <span class="menu_price"><?= "Rp " . number_format($fetch_products['price'], 0, ',', '.'); ?></span>

                    <button class="menu_button" type="submit" name="tambah_cart">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </form>
                <?php
                    }
                }else if(($select_menu->rowCount() > 1)&&($select_menu->rowCount() < 3)){
                    while($fetch_products = $select_menu->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="bmen">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <img src="./img/<?= $fetch_products['image']; ?>" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name"><?= $fetch_products['name']; ?></h3>
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="menu_description"><?= $fetch_products['category']; ?></a>

                    <span class="menu_price"><?= "Rp " . number_format($fetch_products['price'], 0, ',', '.'); ?></span>

                    <button class="menu_button" type="submit" name="tambah_cart">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </form>
                <?php
                    }
                ?>
                <div class="bmen">
                    <i class="ri-cloud-off-fill menu_cloud"></i> 

                    <h3 class="menu_name">Segera Tersedia!</h3>
                    <a href="#menu" class="menu_description">-</a>

                    <span class="menu_price">Rp. -</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>
                <?php
                }else if(($select_menu->rowCount() > 0)&&($select_menu->rowCount() < 2)){
                    while($fetch_products = $select_menu->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="bmen">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <img src="./img/<?= $fetch_products['image']; ?>" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name"><?= $fetch_products['name']; ?></h3>
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="menu_description"><?= $fetch_products['category']; ?></a>

                    <span class="menu_price"><?= "Rp " . number_format($fetch_products['price'], 0, ',', '.'); ?></span>

                    <button class="menu_button" type="submit" name="tambah_cart">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </form>
                <?php
                    }
                ?>
                <div class="bmen">
                    <i class="ri-cloud-off-fill menu_cloud"></i> 

                    <h3 class="menu_name">Segera Tersedia!</h3>
                    <a href="#menu" class="menu_description">-</a>

                    <span class="menu_price">Rp. -</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <i class="ri-cloud-off-fill menu_cloud"></i> 

                    <h3 class="menu_name">Segera Tersedia!</h3>
                    <a href="#menu" class="menu_description">-</a>

                    <span class="menu_price">Rp. -</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div> 
                <?php
                }else{
                ?>                             
                <div class="bmen">
                    <i class="ri-cloud-off-fill menu_cloud"></i> 

                    <h3 class="menu_name">Segera Tersedia!</h3>
                    <a href="#menu" class="menu_description">-</a>

                    <span class="menu_price">Rp. -</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div> 
                <div class="bmen">
                    <i class="ri-cloud-off-fill menu_cloud"></i> 

                    <h3 class="menu_name">Segera Tersedia!</h3>
                    <a href="#menu" class="menu_description">-</a>

                    <span class="menu_price">Rp. -</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div> 
                <div class="bmen">
                    <i class="ri-cloud-off-fill menu_cloud"></i> 

                    <h3 class="menu_name">Segera Tersedia!</h3>
                    <a href="#menu" class="menu_description">-</a>

                    <span class="menu_price">Rp. -</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div> 
                <?php
                }
                ?>               
            </div>








        </section>

        <!--==================== CONTACT ====================-->
        <section class="bantuan section container" id="bantuan">                
            <div class="bantuan_container grid">
                <div class="bantuan_box">
                    <h2 class="bantuan_title">
                        Hubungi kami sekarang <br> melalui informasi yang <br> tersedia.
                    </h2>

                    <div class="bantuan_data">
                        <div class="bantuan_information">
                            <h3 class="bantuan_subtitle">Hubungi kami untuk bantuan langsung</h3>
                            <span class="bantuan_description">
                                <i class="ri-phone-line bantuan_icon"></i>
                                +62 823 2878 4895
                            </span>
                        </div>

                        <div class="bantuan_information">
                            <h3 class="bantuan_subtitle">Kirimkan pesan lewat mail</h3>
                            <span class="bantuan_description">
                                <i class="ri-mail-line bantuan_icon"></i>
                                Yudharizqia182@email.com
                            </span>
                        </div>
                    </div>
                </div>

                <form action="" method="post" class="bantuan_form">
                    <div class="bantuan_inputs">
                        <div class="bantuan_content">
                            <input type="email" required placeholder=" " class="bantuan_input" name="email">
                            <label for="" class="bantuan_label">Email</label>
                        </div>

                        <div class="bantuan_content">
                            <input type="text" required placeholder=" " class="bantuan_input" name="subject">
                            <label for="" class="bantuan_label">Subject</label>
                        </div>

                        <div class="bantuan_content bantuan_area">
                            <textarea name="pesan" required placeholder=" " class="bantuan_input"></textarea>                              
                            <label for="" class="bantuan_label">Message</label>
                        </div>
                    </div>

                    <button type="submit" class="button" id="bantuan_button" name="submit">
                        Kirim Pesan
                        <i class="ri-arrow-right-up-line button_icon"></i>
                    </button>
                </form>
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

        <!--=============== LOAD MORE LOKASI ===============-->
        <script src="./js/load.js"></script>

        <!--=============== LOAD MORE MENU ===============-->
        <script src="./js/loadmenu.js"></script>

    </body>