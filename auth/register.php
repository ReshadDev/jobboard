<?php require "../config/config.php"; ?>

<?php require "../includes/header.php"; ?>



<?php

if (isset($_SESSION['username'])) {
  echo "<script>window.location.href = '" . APPURL . "'</script>";
}

if (isset($_POST['submit'])) {
  if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['re-password'])) {
    echo "<script>alert('Please fill all the fields')</script>";
  } else {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];
    $img = 'person_2.jpg';
    $type = $_POST['type'];

    //checking password
    if ($password == $re_password) {

      if (strlen($email) > 25) {
        echo "<script>alert('Email is too long')</script>";
      }
      elseif (strlen($username) > 15) {
        echo "<script>alert('Username is too long')</script>";
      }
      elseif(strlen($password) > 16){
        echo "<script>alert('Password is too long')</script>";
      }
      elseif(strlen($password) < 5){
        echo "<script>alert('Password is too short')</script>";
      }
      else {



        // checking for username or password availability
        $validate = $conn->query("SELECT * FROM users WHERE email = '$email'");
        $validateu = $conn->query("SELECT * FROM users WHERE username = '$username'");
        $validate->execute();

        if($validate->rowCount() > 0){
          echo "<script>alert('Email already exists')</script>";
        }
        elseif($validateu->rowCount() > 0){
          echo "<script>alert('Username already exists')</script>";
        }
        else{
          $insert = $conn->prepare("INSERT INTO users (username, email, mypassword, img, type ) 
          VALUES (:username, :email, :mypassword , :img, :type)");

        $insert->execute([
          'username' => $username,
          'email' => $email,
          'mypassword' =>  password_hash($password, PASSWORD_DEFAULT),
          'img' => $img,
          'type' => $type
        ]);

        header("Location: login.php");
        }
        
       

        
      }
    } else {
      echo "<script>alert('Password does not match')</script";
    }
  }
}


?>

<!-- HOME -->
<section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1 class="text-white font-weight-bold">Register</h1>
        <div class="custom-breadcrumbs">
          <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Register</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-5">
        <form action="register.php" class="p-4 border rounded" method="POST">

          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="text-black" for="fname">Username</label>
              <input type="text" id="fname" class="form-control" placeholder="Username" name="username">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="text-black" for="fname">Email</label>
              <input type="email" max id="fname" class="form-control" placeholder="Email address" name="email">
            </div>
          </div>
          <div class="form-group">
            <label for="job-type">User Type</label>
            <select name="type" class="selectpicker border rounded" id="user-type" data-style="btn-black" data-width="100%" data-live-search="true" title="Select User Type">
              <option>Worker</option>
              <option>Company</option>
            </select>
          </div>
          <div class="row form-group">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="text-black" for="fname">Password</label>
              <input type="password" id="fname" class="form-control" placeholder="Password" name="password">
            </div>
          </div>
          <div class="row form-group mb-4">
            <div class="col-md-12 mb-3 mb-md-0">
              <label class="text-black" for="fname">Re-Type Password</label>
              <input type="password" id="fname" class="form-control" placeholder="Re-type Password" name="re-password">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Sign Up" class="btn px-4 btn-primary text-white">
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</section>

<?php require "../includes/footer.php"; ?>