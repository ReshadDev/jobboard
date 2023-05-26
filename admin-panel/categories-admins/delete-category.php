<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php" ?>

<?php
if(!isset($_SESSION['adminname'])){
  echo "<script>window.location.href = '" . ADMINURL . "/admins/login-admins.php'</script>";
}


   if(isset($_GET['id'])){
     $id = $_GET['id'];
     $delete = $conn->prepare("DELETE FROM categories WHERE id = $id");
     $delete->execute([
     ]);
     header("Location: ".ADMINURL."/categories-admins/show-categories.php");
   }else{
        header("Location: http://localhost/jobboard/404.php ");
   }

?>


<?php require "../layouts/footer.php"; ?>