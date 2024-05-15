<?php

include '../components/connect.php';

session_start();

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:../user_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Admin Accounts</h1>

   <div class="box-container">

   <div class="box">
      <p>Add New Admin</p>
      <a href="register_admin.php" class="option-btn">Register Admin</a>
   </div>

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users` WHERE role ='admin'");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p hidden> Admin Id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p style="text-align:start;"> Name : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p style="text-align:start;"> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <p style="text-align:start;"> Role : <span><?= $fetch_accounts['role']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($fetch_accounts['id'] == $user_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>