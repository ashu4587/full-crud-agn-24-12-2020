<?php
  $selectedInterestField = '';
  include '../connection/connection.php';
  $massage= "";
  $msg = "";
  $gender = "";
  // debug($data);
  if (isset($_POST['update'])){
    
    $username         = $_POST['username'];
    $email            = $_POST['email'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender           = $_POST['gender'];
    $interest         = $_POST['interest'];
    $int              = implode(',',$interest); // convert array to string
    
    // match password to confirm Password
    if ($password===$confirm_password){
      $update = "UPDATE  
      `".TABLE."` 
    SET 
      `username`='".$username."' ,
      `email`   ='".$email."' ,
      `password`='".$password."',
      `gender`  ='".$gender."',
      `interest`='".$int."'
    WHERE 
      `id`=".$_GET['id'];

      $updateheck = mysqli_query($conn, $update);
      if($updateheck== true){
        header('location:http://localhost/test-main/Test.project/crud/listing.php');
      }else{
        echo "There is an error to update data";
      }
    }else{
      $massage = "Password did not Match*";
    }
  }
  $fetch = "SELECT * FROM `".TABLE."` WHERE `id`=".$_GET['id'];
  $query = mysqli_query($conn, $fetch);
  $data  = mysqli_fetch_assoc($query);

  include '../html/header.php';
?>

<div class="container contact-form">
  <div class="contact-image">
    <img src="../images/img.png" alt="rocket_contact"/>
  </div>
  <form method="post">
    <h3>UPDATE HERE</h3>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="User Name *" value="<?php echo $data['username'];?>" />
          <?php echo $msg; ?>
        </div>
        <div class="form-group">
          <input type="text" name="email" class="form-control" placeholder="Your Email *" value="<?php echo $data['email'];?>" />
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Your Password*" value="<?php echo $data['password'];?>" />
        </div>
         <?php echo $massage ?>
        <div class="form-group">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password*" value="<?php echo $data['password'];?>" />
        </div>
        <div class="radio-button">
        <label for = "gender"><b>Gender:</b></label>

          <?php
            foreach($genderFields as $value => $label){
              $checked = ($value == $data['gender']) ? 'checked' : '';
            ?>
              <label class="form-check-label" for="male"> <?php echo $label; ?></label> &nbsp; &nbsp;
              <input class="form-check-input" type="radio" name="gender"  value = "<?php echo $value; ?>" <?php  echo $checked; ?> id="flexRadioDefault1"/>
            <?php } ?>
        </div>

        <div class="checkbox">
        <label for="interest"><b>Interest:</b></label>
        <?php
            // $selectedInterestField = !empty($data['interest']) ? $data['interest'] : [];
            foreach($interestFields as $field){
              $explode= explode(',',$data['interest']);

              // debug($explode);
              $check = in_array($field,$explode) ? 'checked' : '';
              // debug($check);
        ?>
            <label>
              <?php echo $field;?> <input type="checkbox" name ="interest[]"     value="<?php echo $field; ?>" <?php echo$check ; ?> >
            </label>
          <?php } ?>
        </div>
        <div class="form-group">
          <input type="submit" name= "update"  class="btnContact" value="SUBMIT" />
        </div>
      </div>
    </div>
  </form>
</div>
<?php
  include '../html/footer.php';
?>