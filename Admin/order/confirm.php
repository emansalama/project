<?php 
// require '../helpers/checkLogin.php';
require '../helpers/dbConnection.php';


# Fetch Id .... 
$id = $_GET['id'];

$sql = "select * from orders where id = $id";
$op  = mysqli_query($con,$sql);

# Check If Count == 1 
if(mysqli_num_rows($op) == 1){

    // delete code ..... 
   $sql = "update orders set status=1 where id=$id";
   $op  = mysqli_query($con,$sql);

   if($op){
       $Message = ["Message" => "Raw Confirmed"];
   }else{
       $Message = ["Message" => "Error try Again"];
   }


}else{
    $Message = ["Message" => "Invalid Id "];
}

   #   Set Session 
   $_SESSION['Message'] = $Message;

   header("location: index.php");

?>