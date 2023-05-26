<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php

if (!isset($_SESSION['username'])) {
  echo "<script>window.location.href = '" . APPURL . "'</script>";
}

// print_r($_SESSION);




if (isset($_SESSION['id'])) {

  $id = $_SESSION['id'];

  if ($_SESSION['id'] !== $id) {
    echo "<script>window.location.href = '" . APPURL . "'</script>";
  }


  $select = $conn->query("SELECT * FROM users WHERE id = '$id'");
  $select->execute();

  $row = $select->fetch(PDO::FETCH_OBJ);

  if (isset($_POST['submit'])) {
    if (empty($_POST['username']) or empty($_POST['email'])) {
      echo "<script>alert('Username or Email are empty')</script>";
    } else {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $bio = $_POST['bio'];
      $title = $_POST['title'];
      $facebook = $_POST['facebook'];
      $twitter = $_POST['twitter'];
      $linkedin = $_POST['linkedin'];
      $img = $_FILES['img']['name'];
      // $cv = $_FILES['cv']['name'];

      $row->type == 'Worker' ? $cv = $_FILES['cv']['name'] : $cv = 'NULL';

      $dir_img = 'user-images/' . basename($img);
      $dir_cv = 'user-cvs/' . basename($cv);



      $update = $conn->prepare("UPDATE users SET username = :username, email = :email, bio = :bio, title = :title, facebook = :facebook, twitter = :twitter, linkedin = :linkedin, img = :img, cv = :cv WHERE id = '$id'");

      if ($row->type == "Worker") {
        if ($img !== '' && $cv !== "") {
          if ($row->img !== 'person_2.jpg') {
            unlink('user-images/' . $row->img);
          }
          if ($row->cv !== NULL) {
            unlink('user-cvs/' . $row->cv);
          }
          $update->execute([
            ':username' => $username,
            ':email' => $email,
            ':bio' => $bio,
            ':title' => $title,
            ':facebook' => $facebook,
            ':twitter' => $twitter,
            ':linkedin' => $linkedin,
            ':img' => $img,
            ':cv' => $cv,
          ]);
          if (move_uploaded_file($_FILES['img']['tmp_name'], $dir_img) and move_uploaded_file($_FILES['cv']['tmp_name'], $dir_cv)) {
            header("Location: " . APPURL . "");
          }
        } else {
          $update->execute([
            ':username' => $username,
            ':email' => $email,
            ':bio' => $bio,
            ':title' => $title,
            ':facebook' => $facebook,
            ':twitter' => $twitter,
            ':linkedin' => $linkedin,
            ':img' => $row->img, // Corrected syntax
            ':cv' => $row->cv, // Corrected syntax
          ]);
          header("Location: " . APPURL . "");
        }
      } else {
        if ($img !== '') {
          unlink('user-images/' . $row->img);
          $update->execute([
            ':username' => $username,
            ':email' => $email,
            ':bio' => $bio,
            ':title' => $title,
            ':facebook' => $facebook,
            ':twitter' => $twitter,
            ':linkedin' => $linkedin,
            ':img' => $img,
            ':cv' => NULL
          ]);
        } else {
          $update->execute([
            ':username' => $username,
            ':email' => $email,
            ':bio' => $bio,
            ':title' => $title,
            ':facebook' => $facebook,
            ':twitter' => $twitter,
            ':linkedin' => $linkedin,
            ':img' => $row->img, // Corrected syntax
            ':cv' => NULL
          ]);
        }
        if (move_uploaded_file($_FILES['img']['tmp_name'], $dir_img)) {
          echo "<script>window.location.href = '" . APPURL . "'</script>";
        }
      }
    }
  }
} else {
  echo "HELLO";
}




?>

<section class="section-hero overlay inner-page bg-image" style="background-image: url('../images/hero_1.jpg');" id="home-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h1 class="text-white font-weight-bold">Update Profile</h1>
        <div class="custom-breadcrumbs">
          <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Update Profile</strong></span>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="site-section" id="next-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <form action="update-profile.php?upd_id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="">

          <div class="row form-group">
            <div class="col-md-6 mb-3 mb-md-0">
              <label class="text-black" for="fname">Username</label>
              <input type="text" id="fname" value="<?php echo $row->username; ?>" name="username" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="text-black" for="lname">Email</label>
              <input type="email" id="lname" value="<?php echo $row->email; ?>" name="email" class="form-control">
            </div>
          </div>

          <?php if (isset($_SESSION['type']) and $_SESSION['type'] == 'Worker') : ?>

            <div class="row form-group">

              <div class="col-md-12">
                <label class="text-black" for="email">Title</label>
                <input type="text" id="" value="<?php echo $row->title; ?>" name="title" class="form-control">
              </div>
            </div>

          <?php else : ?>

            <div class="row form-group">

              <div class="col-md-12">
                <input type="hidden" id="" value="NULL" name="title" class="form-control">
              </div>
            </div>
          <?php endif; ?>


          <div class="row form-group">
            <div class="col-md-12">
              <label class="text-black text-start" for="message">Bio</label>
              <textarea name="bio" id="message" cols="5" rows="5" class="form-control"><?php echo trim($row->bio,); ?></textarea>
            </div>
          </div>

          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Facebook</label>
              <input type="subject" value="<?php echo $row->facebook; ?>" name="facebook" id="subject" class="form-control">
            </div>
          </div>

          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Twitter</label>
              <input type="subject" value="<?php echo $row->twitter; ?>" name="twitter" id="subject" class="form-control">
            </div>
          </div>

          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Linkedin</label>
              <input type="subject" value="<?php echo $row->linkedin; ?>" name="linkedin" id="subject" class="form-control">
            </div>
          </div>

          <div class="row form-group">

            <div class="col-md-12">
              <label class="text-black" for="subject">Image</label>
              <input type="file" name="img" id="" class="form-control">
            </div>
          </div>

          <?php if (isset($_SESSION['type']) and $_SESSION['type'] == 'Worker') : ?>
            <div class="row form-group">

              <div class="col-md-12">
                <label class="text-black" for="subject">CV</label>
                <input type="file" name="cv" id="" class="form-control">
              </div>
            </div>

          <?php else : ?>

            <div class="row form-group">

              <div class="col-md-12">
                <input type="hidden" value="NULL" name="cv" id="" class="form-control">
              </div>
            </div>

          <?php endif; ?>






          <div class="row form-group">
            <div class="col-md-12">
              <input type="submit" name="submit" value="Update " class="btn btn-primary btn-md text-white">
            </div>
          </div>


        </form>
      </div>
      <!-- <div class="col-lg-5 ml-auto">
            <div class="p-4 mb-3 bg-white">
              <p class="mb-0 font-weight-bold">Address</p>
              <p class="mb-4">203 Fake St. Mountain View, San Francisco, California, USA</p>

              <p class="mb-0 font-weight-bold">Phone</p>
              <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

              <p class="mb-0 font-weight-bold">Email Address</p>
              <p class="mb-0"><a href="#">youremail@domain.com</a></p>

            </div>
          </div> -->
    </div>
  </div>
</section>

<?php require "../includes/footer.php"; ?>