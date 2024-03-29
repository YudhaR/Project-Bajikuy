<?php

include './components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    $role = $_POST['role'];
 
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
    $select_user->execute([$email, $number]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $message[] = 'Email atau Nomor Sudah Terdaftar!';
    }else{
       if($pass != $cpass){
          $message[] = 'Konfirmasi Password Salah!';
       }else{
          $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password, role) VALUES(?,?,?,?,?)");
          $insert_user->execute([$name, $email, $number, $cpass, $role]);
          $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
          $select_user->execute([$email, $pass]);
          $row = $select_user->fetch(PDO::FETCH_ASSOC);
          if($select_user->rowCount() > 0){
 
                if($row['role'] == 'admin'){
        
                $_SESSION['user_id'] = $row['id'];
                header('location:./admin/index.php');
        
                }elseif($row['role'] == 'user'){
        
                $_SESSION['user_id'] = $row['id'];
                header('location:./index.php');
        
                }elseif($row['role'] == 'seller'){
        
                $_SESSION['user_id'] = $row['id'];
                header('location:./seller/index.php');
                }
            }
        }
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

<section class="rbox container grid">

   <form action="" method="post" enctype="multipart/form-data" class="regis_form">
        <h3 class="section_title regis_title">Masuk Sekarang</h3>
        <div class="regis_inputs">
            <div class="regis_content">
                <input type="text" required placeholder=" " class="regis_input" name="name" maxlength="200">
                <label for="" class="regis_label">Name</label>  
            </div>

            <div class="regis_content">
                <input type="email" required placeholder=" " class="regis_input" name="email" maxlength="50">
                <label for="" class="regis_label">Email</label>  
            </div>

            <div class="regis_content">
                <input type="number" required placeholder=" " class="regis_input" name="number" minlength="0" maxlength="15">
                <label for="" class="regis_label">Number</label>
            </div>

            <div class="regis_content">
                <input type="password" required placeholder=" " class="regis_input" name="pass" minlength="8" maxlength="50">
                <label for="" class="regis_label">Password</label>
            </div>

            <div class="regis_content">
                <input type="password" required placeholder=" " class="regis_input" name="cpass" minlength="8" maxlength="50">
                <label for="" class="regis_label">Confirm Password</label>
            </div>

            <select class="regis_role" name="role">
                <option value="" disabled selected>Pilih Role Akun --</option>
                <option value="user">User</option>
                <option value="seller">Seller</option>
            </select>
        </div>
        <p class="regis">Sudah mempunyai akun? <a href="./login.php">Masuk Sekarang</a></p>
        <input type="submit" value="Daftar" class="btn" id="lokabtn" name="submit">
   </form>

</section>
 