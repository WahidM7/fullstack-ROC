<?php

include '../components/connect.php';

if(isset($_COOKIE['id'])){
   $id = $_COOKIE['id'];
}else{
   $id = '';
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- dashboard section starts  -->

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <?php
         $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ? LIMIT 1");
         $select_profile->execute([$id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <h3>Welkom!</h3>
      <p><?= $fetch_profile['user']; ?></p>
   </div>

   <div class="box">
      <h3>quick select</h3>
      <p>login or register</p>
      <a href="login.php" class="btn" style="margin-right: 1rem;">login</a>
      <a href="register.php" class="btn" style="margin-left: 1rem;">register</a>
   </div>

</div>
</section>


<section class="dashboard"> 
   <div class="box-container">
      <div class="box">
         <a href="../admin/bungalow.php" class="btn" style="margin-left: 1rem;">Nieuw lot toevoegen</a>
      </div>
   </div>
</section>


<!-- dashboard section ends -->




















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>


</body>
</html>