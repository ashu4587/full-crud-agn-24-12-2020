<?php 
  include '../connection/connection.php';
  if(isset($_GET['task'] )&& $_GET['task'] == 'delete'){
    $delete = 'DELETE FROM `'.TABLE.'` WHERE `id` ='.$_GET['id'] ;
    $records  = mysqli_query($conn, $delete);

    //print_r($records);
    //die();
    if($records){
      echo "Record Delete successfully";
    }else{
      echo "Delete Error";
    }
  }
?>