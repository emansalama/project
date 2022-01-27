<?php
require './Admin/helpers/dbConnection.php';
require './Admin/helpers/functions.php';

$id = $_GET['id'];

# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = Clean($_POST['name']);
    $email       = Clean($_POST['email']);
    $address     = Clean($_POST['address']);
    $phone       = Clean($_POST['phone']);
    $date        = Clean($_POST['date']);
    $time        = Clean($_POST['time']);


    # Validate name ....
    $errors = [];

    if (!Validate($name, 1)) {
        $errors['Name'] = 'Required Field';
    } elseif (!Validate($name, 6)) {
        $errors['Name'] = 'Invalid String';
    }

    # Validate Email
    if (!Validate($email,1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email,2)) {
        $errors['Email'] = 'Invalid Email';
    }


   # Validate address ...  
    if(!Validate($address,1)){
      $errors['address'] = "Required Field";
   }elseif(!Validate($address,3,10)){
      $errors['address'] = "Length Must be  >= 10  CHARS"; 
   }

    # Validate phone .... 
     if (!Validate($phone,1)) {
        $errors['Phone'] = 'Field Required';
    } elseif (!Validate($phone,5)) {
        $errors['phone'] = 'InValid Number';
    }

    # Validate date ....
    if (!Validate($date, 1)) {
        $errors['date'] = 'Field Required';
    }
      

    
   # Validate time ....
    if (!Validate($time, 1)) {
        $errors['time'] = 'Field Required';
    } 
 
 



    if(count($errors) > 0){
        $Message = $errors;
   }else{
      // DB CODE ..... 
      $date = strtotime($date);
      $time = strtotime($time);


      $sql = "insert into orders(name,email,address,phone,date,time,cour_id) values('$name','$email','$address','$phone',$date,$time,$id )";

      $op  = mysqli_query($con,$sql);

      if($op){
          $Message = ["Message" => "Waiting for confirm order"];
         header("Location:./index.php");


      }else{
          $Message = ["Message" => "Error Try Again ".mysqli_error($con)];
      }

   }
     # Set Session ...... 
     $_SESSION['Message'] = $Message;

}


?>

<head>
    <title> order</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Order</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Order courses</li>

            <?php
            echo '<br>';
            if (isset($_SESSION['Message'])) {
                Messages($_SESSION['Message']);
            
                # Unset Session ...
                unset($_SESSION['Message']);
            }
            
            ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body">

                <form action="booking.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">

                <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="name" aria-describedby=""
                            placeholder="Enter name">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName"> Email</label>
                        <input type="email" class="form-control" id="exampleInputName" name="email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName"> Address</label>
                        <input type="text" class="form-control" id="exampleInputName" name="address" aria-describedby="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName"> phone</label>
                        <input type="text" class="form-control" id="exampleInputName" name="phone" aria-describedby="">
                    </div> <div class="form-group">
                        <label for="exampleInputName"> Date</label>
                        <input type="date" class="form-control" id="exampleInputName" name="date" aria-describedby="">
                    </div>
                    </div> <div class="form-group">
                        <label for="exampleInputName"> time</label>
                        <input type="time" class="form-control" id="exampleInputName" name="time" aria-describedby="">
                    </div>
                    </div> <div class="form-group">
                       <?php
                        $sql="select title from courses where id=$id ";
                         $op2 = mysqli_query($con, $sql);
                         $data = mysqli_fetch_assoc($op2)
                       
                       ?>
                        <label for="exampleInputName"> Course: </label><?php echo $data['title']; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>




                    

                </form>





            </div>
        </div>
    </div>
</main>

