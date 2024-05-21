<?php

include '../components/connect.php';
//
if(isset($_COOKIE['id'])){
    $id = $_COOKIE['id'];
 }else{
    $id = '';
    header('location:login.php');
 }

try {
   $b_lijst = $conn->prepare("SELECT * FROM b_type");
   $b_lijst->execute();
   $b_results=$b_lijst->fetchAll();
}
   catch(Exception $ex){
      
      echo($ex -> getMessage());
   };



 if(isset($_POST['submitbungalow'])){


   $bungalow = $_POST['bungalow'];
   $slaapkamers = $_POST['slaapkamers'];
   $maxpersoon = $_POST['maxpersoon'];

   $select_bungalow = $conn->prepare("INSERT INTO `b_type`(type, slaapkamers, maxpersoon) VALUES(?,?,?)");
   $select_bungalow->execute([$bungalow, $slaapkamers, $maxpersoon]);
   $success_msg[] = 'Actie succesvol uitgevoerd!';
   header("Location: bungalow.php");
   exit();
 }



 if(isset($_POST['submitvoorziening'])){
   $voorziening = $_POST['voorziening'];
   $voorzieningprijs = $_POST['voorzieningprijs'];

   $select_voorziening = $conn->prepare("INSERT INTO `voorzieningen`(voorziening, prijs_extra) VALUES(?,?)");
   $select_voorziening->execute([$voorziening, $voorzieningprijs]);
   $success_msg[] = 'Actie succesvol uitgevoerd!';
   header("Location: bungalow.php");
   exit();
 }

 if(isset($_POST['submit'])){
   $voorzieningID = $_POST['voorzieningID'];

   $b_naam = $_POST['bungalownaam'];
   $bigtype = $_POST['id_type'];
   $prijs = $_POST['prijs'];

   $type_query = $conn->query("SELECT * FROM b_type");
   $typeid = $type_query->fetch(PDO::FETCH_ASSOC);

   $insert_bungalows = $conn->prepare("INSERT INTO `bungalow`(b_naam, id_type, prijs) VALUES(?,?,?)");
   $insert_bungalows->execute([$b_naam, $bigtype, $prijs]);

   for($x = 0; $x <= count($voorzieningID); $x++){
   $insert_tussentabel = $conn->prepare("INSERT INTO `bungalow_has_voorzieningen`(b_naam, id_voorziening) VALUES(?,?)");
   $insert_tussentabel->execute([$b_naam, $voorzieningID]);
}

   $success_msg[] = 'Actie succesvol uitgevoerd!';
   header("Location: dashboard.php");
   exit();
 
 }

 $show = $conn->prepare("SELECT * FROM bungalow 
   LEFT JOIN b_type ON b_type.id_type = bungalow.id_type ");
 $show->execute();

 $showvoorzieningen = $conn->prepare("SELECT * FROM voorzieningen");
 $showvoorzieningen->execute();

 try {
   $v_lijst = $conn->prepare("SELECT * FROM voorzieningen");
   $v_lijst->execute();
   $v_results=$v_lijst->fetchAll();
}
   catch(Exception $ex){
      echo("er ging iets fout: " . $ex -> getMessage());
   };   
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

<section class="dashboard">
<div class="box-container">
    <div class="box">
      <form action="" method="POST">
         <h3>Voeg bungalow type toe</h3>
         <p>Type <span>*</span></p>
         <input name="bungalow" placeholder="Type" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <p>Aantal slaapkamers <span>*</span></p>
         <input name="slaapkamers" placeholder="Slaapkamers" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <p>Maximaal aantal personen <span>*</span></p>
         <input name="maxpersoon" placeholder="Max aantal personen" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Submit" name="submitbungalow" class="btn">
      </form>
   </div>
      <div class="box">
      <form action="" method="POST">
         <h3>Voeg voorzieningen toe </h3>
         <p>Voorziening <span>*</span></p>
         <input name="voorziening" placeholder="naam voorziening" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <p>Prijs <span>*</span></p>
         <input name="voorzieningprijs" placeholder="voeg een prijs toe" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Submit" name="submitvoorziening" class="btn">
      </form>
      </div>
   </div>
</section>

<section class="dashboard">
<div class="box-container">
    <div class="box">
      <form action="" method="POST">
         <h3>Voeg een huis optie toe aan de site</h3>
         <p>Naam bungalow</p>
         <input name="bungalownaam" placeholder="Bungalow naam" maxlength="32" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <p>Type bungalow <span>*</span></p>
         <select name="id_type" placeholder="kies een type" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <?php foreach ($b_results as $output) {?>
         <option value="<?php echo $output['id_type'];?>"><?php echo $output['type']; ?></option>
         <?php }; ?>
         </select>
         <p>Prijs <span>*</span></p>
         <input name="prijs" placeholder="€" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
         <p>Voorzieningen </p>
         <?php foreach ($v_results as $output2) {?>
         <input type="checkbox" name="voorzieningID[]" value="<?php echo $output2['id'];?>"><?php echo $output2['voorziening']; ?></input>
         <?php }; ?>
         <br>
         <input type="submit" value="Submit" name="submit" class="btn">
      </form>
   </div>
</div>
</section>

<section class="bookings">

   <h1 class="heading">Bungalows</h1>

   <div class="box-container">

   <?php
      if($show->rowCount() > 0 or $showvoorzieningen->rowCount() > 1){
         while($fetch_bungalows = $show->fetch(PDO::FETCH_ASSOC) ){
   ?>
   <div class="box">
      <p>Naam : <span><?= $fetch_bungalows['b_naam']; ?></span></p>
      <p>Type : <span><?= $fetch_bungalows['type']; ?></span></p>
      <p>Prijs : €<span><?= $fetch_bungalows['prijs']; ?></span></p>
      <p>Slaapkamers : <span><?= $fetch_bungalows['slaapkamers']; ?></span></p>
      <p>Max aantal personen : <span><?= $fetch_bungalows['maxpersoon']; ?></span></p>
      <p>Bungalow ID : <span><?= $fetch_bungalows['id_bungalow']; ?></span></p>
      <!--<p>Voorzieningen : <span><?//= $fetch_voorzieningen['voorziening']; ?></span></p>-->
   </div> 
   <?php }  } else{?>
   <div class="boxadmin" style="text-align: center;">
      <p style="padding-bottom: .5rem; text-transform:capitalize;">Geen bungalows in de database</p>
   </div>
   <?php
   };
   ?>
   </div>

</section>