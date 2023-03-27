<?php

include './components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select->execute([$email, $pass]);
    $row = $select->fetch(PDO::FETCH_ASSOC);
 
    if($select->rowCount() > 0){
 
       if($row['role'] == 'admin'){
 
          $_SESSION['admin_id'] = $row['id'];
          header('location:./admin/admin_page.php');
 
       }elseif($row['role'] == 'user'){
 
          $_SESSION['role'] = $row['id'];
          header('location:./index.php');

       }elseif($row['role'] == 'seller'){
 
         $_SESSION['role'] = $row['id'];
         header('location:./seller.php');
   
 
       }else{
          $message[] = 'no user found!';
       }
       
    }else{
       $message[] = 'incorrect email or password!';
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
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
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
        <input type="submit" value="Masuk" class="button" id="fbutton" name="submit">
   </form>

</section>

</body>
</html>