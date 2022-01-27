<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

#########################################################################
# Fetch corses ....
// $sql = 'select stud_course.*,user.name from stud_course join user  on user.id=stud_course.stud_id  join  courses on courses.id=stud_course.cour_id';

// $RoleOp = mysqli_query($con, $sql);

    $sql = 'select stud_course.*,courses.title , user.name  from  stud_course inner join courses  on stud_course.cour_id = courses.id  inner join user on user.id = stud_course.stud_id';
 $RoleOp = mysqli_query($con, $sql);
 
//  elseif($_SESSION['user']['role_id'] == 2){
//         $sql = 'select coursedetails.*,courses.title as couTitle , user.name  from  coursedetails inner join courses  on coursedetails.cour_id = courses.id  inner join user on user.id = coursedetails.teachby where coursedetails.teachby = '.$_SESSION['user']['id'];
 
//  }
 

#########################################################################
# Fetch user ....
//$sql = 'select * from user where role_id=3';
// $sql='select user.*,stud_course.* from user inner join stud_course on user.id=stud_course.stud_id ';
// $RoleOp2 = mysqli_query($con, $sql);
#########################################################################
# Fetch stud_corse ....
// if($_SESSION['user']['role_id'] == 1){
// $sql = 'select * from stud_course';
// $RoleOp3 = mysqli_query($con, $sql);
// $sdata = mysqli_fetch_assoc($RoleOp3);
// }
// else{
//     exit();
// }
# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $cour_id = $_POST['cour_id'];
    $stud_id = $_POST['stud_id'];
    $status = Clean($_POST['status']);
 

   # Validate status 
   if(!Validate($status,1)){
      $errors['status'] = "Required Field";
   }elseif(!Validate($status,6)){
      $errors['status'] = "Invalid String"; 
   }


    $errors = [];

   


    if (count($errors) > 0) {
        $Message = $errors;
    } else {
        // DB CODE .....

        // $disPath = './uploads/' . $FinalName;

        
      
        


            $sql1 = "update stud_course  set status ='$status'";
            $op = mysqli_query($con, $sql1);

            if ($op) {
                $Message = ['Message' => 'Raw Inserted'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }
         
        }
        
    
    # Set Session ......
    $_SESSION['Message'] = $Message;
}

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/student courses/Create</li>

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

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

                  


                <?php
                               while($data = mysqli_fetch_assoc($RoleOp)){
                            ?>

                    <div class="form-group">
                        <label for="exampleInputPassword">Corces</label>
                        <select class="form-control" id="exampleInputPassword1" name="cour_id">


                            <option value="<?php echo $data['id']; ?>"><?php echo $data['title']; ?></option>

                           

                        </select>
                       
                    </div>
                  
                           
                    <div class="form-group">
                        <label for="exampleInputPassword">Student</label>

                        <select class="form-control" id="exampleInputPassword1" name="stud_id">

                       

                       

                            <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>

                          
                         

                        </select>
                    </div>
                    <div class="form-group">
                      
                   

                        <label for="exampleInputName">Status</label>
                        <input type="text" name="status" value="<?php echo $data['status']; ?>" >
                       
                      
                    </div>
                    <?php } ?>

                  
                  

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>





            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
