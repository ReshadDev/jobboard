<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php" ?>

<?php

if(!isset($_SESSION['adminname'])){
    echo "<script>window.location.href = '" . ADMINURL . "/admins/login-admins.php'</script>";
  }
  

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    if ($status == 1) {
        $update = $conn->prepare("UPDATE jobs SET status = 0 WHERE id = :id");
    } else {
        $update = $conn->prepare("UPDATE jobs SET status = 1 WHERE id = :id");
    }

    $update->bindParam(':id', $id);
    $update->execute();

    header("Location: " . ADMINURL . "/jobs-admins/show-jobs.php");
} else {
    header("Location: http://localhost/jobboard/404.php");
}

?>

<?php require "../layouts/footer.php"; ?>
