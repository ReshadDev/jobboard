<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php" ?>


<?php

if(isset($_SESSION['adminname'])){
    echo "<script>window.location.href = '" . ADMINURL . "'</script>";
  }

  
if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Please fill all the fields')</script>";
    } else {

        // chekced for form submission
        // we need to grab the data
        // do the query with the email only
        // we are going to execute and then fetch the data
        // check for the row count
        // check for the password

        

        $email = $_POST['email'];
        $password = $_POST['password'];

        $login = $conn->query("SELECT * FROM admins WHERE email = '$email' ");
        $login->execute();

        $select = $login->fetch(PDO::FETCH_ASSOC);

        if ($login->rowCount() > 0) {
            if (password_verify($password, $select['mypassword'])) {

                  $_SESSION['adminname'] = $select['adminname'];  
               
                  $_SESSION['email'] = $select['email'];
                

                header("Location: " . ADMINURL . "");

                // echo "<script>alert('Logged IN')</script>";

            } else {
                echo "<script>alert('Password does not match')</script>";
            }
        } else {
            echo "<script>alert('Email does not exist')</script>";
        }
    }
}


?>
     
<div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mt-5">Login</h5>
              <form method="POST" class="p-auto" action="login-admins.php">
                  <!-- Email input -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email" />
                   
                  </div>

                  
                  <!-- Password input -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control" />
                    
                  </div>



                  <!-- Submit button -->
                  <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">Login</button>

                 
                </form>

            </div>
       </div>
     </div>


<?php require "../layouts/header.php"; ?>