<?php

if(isset($_POST['tambah_cart'])){

   if($user_id == ''){
      header('location:./login.php');
   }else{
      $select_addres = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_addres->execute([$user_id]);
      $user_addres = $select_addres->fetch(PDO::FETCH_ASSOC);
      if($user_addres['address'] != 'Belum Update'){
         $pid = $_POST['pid'];
         $name = $_POST['name'];
         $price = $_POST['price'];
         $image = $_POST['image'];
         $qty = 1;
   
         $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
         $check_cart_numbers->execute([$name, $user_id]);
   
         if($check_cart_numbers->rowCount() > 0){
   
            $message[] = 'Makanan atau Minuman sudah ada dikeranjang!';
            
         }else{
            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
   
            $message[] = 'Berhasil Ditambahkan!';
   
         }
      }else{
         header('location:./update_addres1.php');
      }



   }

}

?>