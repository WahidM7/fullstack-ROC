<?php

include '../components/connect.php';

//if(isset($_COOKIE['admin_id'])){
//   $admin_id = $_COOKIE['admin_id'];
//}else{
//   $admin_id = '';
//   header('location:register.php');
//}

if(isset($_POST['submit'])){

   $id = create_unique_id();
   $user = $_POST['user'];
   $user = filter_var($user, FILTER_SANITIZE_STRING); 
   $password = sha1($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING); 
   $c_pass = sha1($_POST['c_pass']);
   $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   

   $select_admins = $conn->prepare("SELECT * FROM `admins` WHERE user = ?");
   $select_admins->execute([$user]);

   if($select_admins->rowCount() > 0){
      $warning_msg[] = 'Username wordt al gebruikt!';
   }else{
      if($password != $c_pass){
         $warning_msg[] = 'Wachtwoord matched niet!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admins`(id, user, password) VALUES(?,?,?)");
         $insert_admin->execute([$id, $user, $c_pass]);
         $success_msg[] = 'Registratie succesvol!';
         header("Location: dashboard.php");
         exit();
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
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- register section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>register new</h3>
      <input type="text" name="user" placeholder="enter username" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="password" placeholder="enter password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="c_pass" placeholder="confirm password" maxlength="20" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" name="submit" class="btn">
      <br>
      <br>
      <a style="font-size: 15px" href="../admin/login.php">Heb je al een account? Log hier in!</a>
      <br>
      <br>
      <a href="../index.php">Terug naar Home</a>
   </form>

</section>

<!-- register section ends -->
</body>
</html>

















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>