<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

// we are deleting jobs
<?php 

if(isset($_SESSION['type']) && $_SESSION['type'] !== 'Company') {
    header("Location: ".APPURL. "");
}

   if(isset($_GET['id'])) {

       $id = $_GET['id'];
    //    $delete = $conn->query("DELETE FROM jobs WHERE id = '$id'");
    $delete =$conn->prepare("DELETE FROM jobs WHERE id = '$id'");
       $delete->execute();

       echo "<script>window.location.href = '" . APPURL . "'</script>";

   } else {
    header("Location: " . APPURL . "/404.php");
   }
   



?>


<?php include '../includes/footer.php'; ?>