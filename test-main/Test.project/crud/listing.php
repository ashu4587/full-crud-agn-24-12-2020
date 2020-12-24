<?php 
  include '../connection/connection.php';
  $sort    = "";
  $search  = !empty($_GET['search'])  ? $_GET['search'] : '';
  $orderBy = !empty($_GET['orderBy']) ? $_GET['orderBy'] : '';  
  $order   = !empty($_GET['order'])   ? $_GET['order'] : '';
  $page    = !empty($_GET['page'])   ? $_GET['page'] : 1;
  
  $perPage = 2;

  # single row delete
  if( isset( $_GET['action'] ) && $_GET['action'] == 'delete' ){
    $query  = "DELETE FROM `".TABLE."` WHERE `id` = '{$_GET['id']}'";
    $delete = mysqli_query($conn, $query);
    if( $delete == false ){
      echo "Error : delete";
    }else{
      header('location:http://localhost/test-main/Test.project/crud/listing.php');
    }
  }

  # Multi Delete Records
  if( isset( $_POST['multiDelete'] ) && $_POST['multiDelete'] == 'allDelete' ){
    $user = $_POST['user'];
    foreach( $user as $id ){
      $query  = "DELETE FROM `".TABLE."` WHERE `id` = '$id'";
      $delete = mysqli_query($conn, $query);
      if( $delete == false ){
      echo "Error : delete";
      }else{
        header('location:http://localhost/test-main/Test.project/crud/listing.php');
      }
    }
  }





  // if(isset($_GET['task'] )&& $_GET['task'] == 'delete'){
  //   $delete = 'DELETE FROM `'.TABLE.'` WHERE `id` ='.$_GET['id'] ;
  //   $records  = mysqli_query($conn, $delete);

  //   //print_r($records);
  //   //die();
  //   if($records){
  //     echo "Record Delete successfully";
  //   }else{
  //     echo "Delete Error";
  //   }
  // }
  // if(isset($_POST['bulkAction'] )&& $_POST['bulkAction'] == 'deleted'){

  //   if( empty( $_POST['users'] ) ){
  //     return;
  //   }

  //   $users = $_POST['users'];
  //   foreach ($users as $ids) {
  //     $records  = mysqli_query($mysqli, 'DELETE FROM `'.TABLE.'` WHERE `id` ='.$ids );
  //     if($records === false){
  //       return "Multi delete Error";
  //     }      
  //   }
  //   echo "records deleted";
  // }

  if(!empty($search)){
  $search = "WHERE `username` LIKE '{$search}%' || `id` LIKE '{$search}%' || `email` LIKE '{$search}%' || `gender` LIKE '{$search}%'";
  }

  if(!empty($orderBy) && !empty($order)){
    $sort = " ORDER BY `{$orderBy}` {$order}";
  }

  $fetch = "SELECT SQL_CALC_FOUND_ROWS * FROM `".TABLE."`  {$search} {$sort} LIMIT {$page},{$perPage} ";
  $query   = mysqli_query($conn, $fetch);
  $listing = mysqli_fetch_all($query, MYSQLI_ASSOC);
  // debug($listing); 

  if(!empty($order)){
    $order = ($order == 'asc') ? 'desc' : 'asc';
  }

  $statement  =  mysqli_query($conn,'SELECT FOUND_ROWS() as total');
  $response   = mysqli_fetch_all($statement, MYSQLI_ASSOC);
  $totalpages = ceil( $response[0]['total'] / $perPage );  

  include '../html/header.php';
?>

<div class="form-group" style="float: right; margin-right:50px;">
<button class="btn btn-warning"><a href= "index.php">Click Here to Register</a></button>
</div>
<div class ="form-group has-search">
<form method="get">
<input placeholder="Search..." name="search">
</form>
</div>
<form method="post">
<div class ="select">
<select name="multiDelete">
<option value="">SELECT</option>
<option value="allDelete">Delete</option>
</select>

<button class= "btn-danger"type="submit" name="all">Action</button>
</div>

<table class="table table-bordered" style="text-align:center">
<thead thead class="thead-dark">
<tr>
<th> Select</th>
<th>
  <a href="listing.php?orderBy=id&order=<?php echo $order; ?>">ID</a>
</th>
<th>
  <a href="listing.php?orderBy=username&order=<?php echo $order; ?>">UserName</a> 
</th>
<th>EMAIL</th>
<th>PASSWORD</th>
<th>GENDER</th>
<th>INTEREST</th>
<th>ACTION</th>
</tr>
</thead>
<?php foreach($listing as $values){?>
<tbody>
<tr>
<td> <input type="checkbox" name="user[]" value="<?php echo $values['id']; ?>"> </td>
<td><?php echo $values['id'];?></td>
<td><?php echo $values['username'];?></td>
<td><?php echo $values['email'];?></td>
<td><?php echo $values['password'];?></td>  
<td><?php echo $values['gender'];?></td>
<td><?php echo $values['interest'];?></td>
<td><a href="./edit.php?id=<?php echo $values['id']; ?>">EDIT </a>
<a href="listing.php?id=<?php echo $values['id']; ?>&action=delete">DELETE</a></td>
</tr> 
<?php } ?>     
</tbody>

</table>
</form>
<!-- Pagination -->
<div class="pagination" style="margin: 0 auto;width: 20%;">
<?php
  for($i=1;$i<=$totalpages;$i++){
    echo "<a href='listing.php?page={$i}' style='color:#fff;margin-left: 9px;padding: 1px 11px;'>".$i."</a>";
  } 
?>
</div>

<?php include '../html/footer.php'?>