<?php
include '../connection/connection.php';
$massage= $warn =$warn1 =$warn2 =$warn3 =$warn4 = $gender =$flag ="";

if (isset($_POST['submit'])){

$username         = $_POST['username'];
$email            = $_POST['email'];
$password         = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$gender           = !empty($_POST['gender'])?$_POST['gender']:'';
$interest         = !empty($_POST['interest'])?$_POST['interest']:[];
$int              = implode(',',$interest); 
$flag             = false;                

if(empty($username)){
$flag = true;
$warn = "Username is required*";
}
if(empty($email)){
$flag = true;
$warn1 = "Email is required*";
}
if(empty($password)){
$flag = true;
$warn2 = "Password is required*";
}
if(empty($gender)){
$flag = true;
$warn3 = "Please select a Gender*";
}
if(empty($interest)){
$flag = true;
$warn4 = "Please select any interest*";
}
if ($password===$confirm_password){

if($flag==false){ $insert = "INSERT INTO `".TABLE."`(`username`, `email`,`password`,`gender`,`interest`) VALUES ('".$username."', '".$email."','".$password."','".$gender."','".$int."')";
$query = mysqli_query($conn, $insert);
if($query== true){
$username = "";
$email = "";
$password = "";
$confirm_password = "";
$gender = "";
$interest  = [];
$success = "alert alert-success";
header('Location: http://localhost/test-main/Test.project/crud/listing.php');

$massage= "Data inserted sucessfully";
}else{
$massage= "There is an error to insert data";
$success = "alert alert-danger";
}
}
}else{
$massage = "Password did not Match*";
$success = "alert alert-danger";
}
}
include '../html/header.php';
?>
<style>
p{
    color:red;
   }
   </style>
<div class="container contact-form">
  <div class="contact-image">
    <img src="../images/img.png" alt="rocket_contact"/>
  </div>
  <form method="post">
    <h3>REGISTER HERE</h3>
    <div class="<?php echo $success;?>">
      <?php echo $massage ?>
    </div>
    <div class="row">

      <div class="col-md-6">
        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="User Name *" value="<?php echo(!empty($username)? $username:'');?>"/>
        <p><?php echo $warn; ?> </p>
        </div>
        <div class="form-group">
          <input type="text" name="email" class="form-control" placeholder="Your Email *" value="<?php echo(!empty($email)? $email:'');?>" />
          <p><?php echo $warn1; ?></p> 
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Your Password*" value="<?php echo(!empty($password)? $password:'');?>" />
          <p><?php echo $warn2; ?></p>
        </div>

        <div class="form-group">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password*" value="<?php echo(!empty($confirm_password)? $confirm_password:'');?>" />
        </div>
        <div class="radio-button">
          <label for = "gender"><b>Gender:</b></label>

          <?php
            foreach($genderFields as $value => $label){
            $checked = ($value == $gender) ? 'checked' : '';
          ?>
            <label class="form-check-label" for="male">
              <?php echo $label; ?>
            </label> &nbsp; &nbsp;
            <input class="form-check-input" type="radio" name="gender"  value = "<?php echo $value; ?>" <?php  echo $checked; ?> id="flexRadioDefault1"/>
          <?php } ?>
        </div>
        <p><?php echo $warn3; ?></p>
        <div class="checkbox">
          <label for="interest">
            <b>Interest:</b>
          </label>
          <?php
            $selectedInterestField = !empty($_POST['interest']) ? $_POST['interest'] : [];
            foreach($interestFields as $field){
              $check = in_array($field,$selectedInterestField ) ? 'checked' : '';
          ?>
            <label>
              <?php echo $field; ?>  <input type="checkbox" name ="interest[]"     value="<?php echo $field; ?>" <?php echo $check; ?> >
            </label>
          <?php } ?>
        </div>
        <p><?php echo $warn4; ?></p>
        <div class="form-group">
          <input type="submit" name= "submit"  class="btnContact" value="SUBMIT" />
        </div>
        <div class="form-group" style="margin-left:90px; margin-top:90px;">
          <u><b><a href= "listing.php">Already Signed Up<b></a></u>
        </div>
      </div>
    </div>
  </form>
</div>
<?php
  include '../html/footer.php';
?>