<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!--==================== HEADER ====================-->
<header class="header" id="header">
    <nav class="nav container">
        <a href="#" class="nav__logo">
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