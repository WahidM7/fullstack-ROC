<?php

include 'components/connect.php';


if(isset($_POST['cancel'])){

   $id_bungalow = $_POST['id_bungalow'];
   $id_bungalow = filter_var($id_bungalow, FILTER_SANITIZE_STRING);

   $verify_booking = $conn->prepare("SELECT * FROM `bungalow` WHERE id_bungalow = ?");
   $verify_booking->execute([$id_bungalow]);

   if($verify_booking->rowCount() > 0){
      $delete_booking = $conn->prepare("DELETE FROM `bungalow` WHERE id_bungalow = ?");
      $delete_booking->execute([$id_bungalow]);
      $success_msg[] = 'booking cancelled successfully!';
   }else{
      $warning_msg[] = 'booking cancelled already!';
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bookings</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- booking section starts  -->

<section class="bookings">

   <h1 class="heading">Bungalows</h1>

   <div class="box-container">

   <?php
      $select_bungalows = $conn->prepare("SELECT * FROM `bungalow`");
      $select_bungalows->execute();
      print($select_bungalows->rowCount());
      if($select_bungalows->rowCount() > 0){
         while($fetch_bungalows = $select_bungalows->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Type : <span><?= $fetch_bungalows['type']; ?></span></p>
      <p>Huisnummer : <span><?= $fetch_bungalows['nummer']; ?></span></p>
      <p>Prijs : <span><?= $fetch_bungalows['prijs']; ?></span></p>
      <p>Voorzieningen : <span><?= $fetch_bungalows['voorzieningen']; ?></span></p>
   </div>
   <?php
    }
   }else{
   ?>   
   <div class="box" style="text-align: center;">
      <p style="padding-bottom: .5rem; text-transform:capitalize;">Geen bungalows beschikbaar</p>
   </div>
   <?php
   }
   ?>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>
</html>