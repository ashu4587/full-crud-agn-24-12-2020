<?php
  define('HOST','localhost');
  define('USER','root');
  define('PASSWORD','');
  define('DB','practice');
  define('TABLE','data');

  $conn = mysqli_connect(HOST, USER, PASSWORD, DB);

    if ($conn== false){
      echo "connection unsucessfull".mysqli_connect_error();
    }
      //else{
    //   echo "connected succesfully";
    // }
    function debug($args){
      echo "<pre>";
        print_r($args);
      echo "</pre>";

    }

    $genderFields = [
      'male' => 'Male',
      'female' => 'Female',
      'other' => 'Other',
    ];
    $interestFields = ['php','js','css','java'];  

?>