<?php

include './components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select->execute([$email, $pass]);
    $row = $select->fetch(PDO::FETCH_ASSOC);
 
    if($select->rowCount() > 0){
 
       if($row['role'] == 'admin'){
 
          $_SESSION['user_id'] = $row['id'];
          header('location:./admin/index.php');
 
       }elseif($row['role'] == 'user'){
 
          $_SESSION['user_id'] = $row['id'];
          header('location:./index.php');

       }elseif($row['role'] == 'seller'){
 
         $_SESSION['user_id'] = $row['id'];
         header('location:./seller/index.php');
   
 
       }else{
          $message[] = 'Email Tidak Diketahui!';
       }
       
    }else{
       $message[] = 'Email atau Password Salah!';
    }
 
 }
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="./img/icon.png" type="image/x-icon">
   <title>Bajikuyyy</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">

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
   
<section class="fbox container grid">

   <form action="" method="post" enctype="multipart/form-data" class="login_form">
        <h3 class="section_title login_title">Masuk Sekarang</h3>
        <div class="login_inputs">
            <div class="login_content">
                <input type="email" required placeholder=" " class="login_input" name="email">
                <label for="" class="login_label">Email</label>  
            </div>

            <div class="login_content">
                <input type="password" required placeholder=" " class="login_input" name="pass">
                <label for="" class="login_label">Password</label>
            </div>
        </div>
        <p class="login_regis">Tidak mempunyai akun? <a href="./register.php">Daftar Sekarang</a></p>
        <input type="submit" value="Masuk" class="btn" id="lokabtn" name="submit">
   </form>

</section>

</body>
</html>