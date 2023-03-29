<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// include 'components/add_cart.php';

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="./css/style.css">

        <title>Bajikuy</title>
    </head>
    <body>
    

        <?php include './components/user_header.php'; ?>

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
                        <a href="">
                            <div class="boxp">
                                <h2 class="box_title">Cerita</h2>
                                <img src="./img/1.png" alt="">
                            </div>
                        </a>
                        <a href="">
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

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                <a href="" class="blok">
                    <div class="image">
                        <img src="./img/11.png" alt="">
                    </div>
                    <div class="content">
                        <h3>blog title goes here</h3>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, adipisci!</p>
                        <div class="icons">
                            <span> <i class="fas fa-calendar"></i> 21st may, 2022 </span>
                            <span> <i class="fas fa-user"></i> by admin </span>
                        </div>
                    </div>
                </a>

                
            </div>

            <div class="tombol container">
                <div id="load" class="button"> Lebih Banyak </div>
            </div>
            
    
    
        </section>

        <!--==================== Menu ====================-->
        <section class="menu section" id="menu">
            <span class="menu_subtitle">Pilih Minuman Favoritmu</span>
            <h4 class="menu_title">Menu</h4>

            <div class="bmens container">
                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>

                <div class="bmen">
                    <img src="./img/bajigur.png" alt="Menu Image" class="menu_img">

                    <h3 class="menu_name">Onigiri</h3>
                    <a href="" class="menu_description">Japanese Dish</a>

                    <span class="menu_price">$10.99</span>

                    <button class="menu_button">
                        <i class="ri-shopping-bag-line"></i>
                    </button>

                </div>


            </div>

            <div class="tombol container">
                <div id="loadmenu" class="button"> Lebih Banyak </div>
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

                <form action="" class="bantuan_form">
                    <div class="bantuan_inputs">
                        <div class="bantuan_content">
                            <input type="email" placeholder=" " class="bantuan_input">
                            <label for="" class="bantuan_label">Email</label>
                        </div>

                        <div class="bantuan_content">
                            <input type="text" placeholder=" " class="bantuan_input">
                            <label for="" class="bantuan_label">Subject</label>
                        </div>

                        <div class="bantuan_content bantuan_area">
                            <textarea name="message" placeholder=" " class="bantuan_input"></textarea>                              
                            <label for="" class="bantuan_label">Message</label>
                        </div>
                    </div>

                    <button class="button" id="bantuan_button">
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