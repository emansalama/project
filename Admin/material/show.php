<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
# Fetch  User Data .......
#########################################################################
$sql ='select stud_course.*,user.name from stud_course join user  on stud_course.stud_id = user.id ';

$courseop = mysqli_query($con, $sql);
#########################################################################
$sql = 'select material.*,courses.title as catTitle  from  material inner join courses  on material.cour_id = courses.id ';

$Mat_op = mysqli_query($con, $sql);



#########################################################################

if($_SESSION['user']['role_id'] == 1){
    $sql = 'select coursedetails.*,courses.title , user.name as uname  from  coursedetails inner join courses  on coursedetails.cour_id = courses.id  inner join user on user.id = coursedetails.teachby';
 }
 elseif($_SESSION['user']['role_id'] == 2){
        $sql = 'select coursedetails.*,courses.title , user.name  from  coursedetails inner join courses  on coursedetails.cour_id = courses.id  inner join user on user.id = coursedetails.teachby where coursedetails.teachby = '.$_SESSION['user']['id'];
 
 }
$op = mysqli_query($con, $sql);
################################################################

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/material/display</li>
            <?php 
            echo '<br>';
           if(isset($_SESSION['Message'])){
             Messages($_SESSION['Message']);
          
              # Unset Session ... 
              unset($_SESSION['Message']);
              }
        
             ?>
        </ol>


        <div class="card mb-4">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>teachby</th>
                              <th>course</th>
                              <th>Student</th>

                              <th></th>
                              <th>files</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>#</th>
                            <th>teachby</th>
                              <th>course</th>
                              <th>Student</th>
                              <th></th>
                              <th>files</th>


                              
                        </tfoot>
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['uname']; ?></td>

                                <td><?php echo $data['title']; ?></td>
                                <?php 
                                        }
                                    ?>
                                <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($courseop)){
                                      
                                    ?>
                                <td><?php echo $data['name']; ?></td>
                               

                                
                                <?php 
                                        }
                                    ?>

<?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($Mat_op)){
                                      
                                    ?>
                                   <td> <a href="./uploads/<?php echo $data['file']; ?>">file </a> </td>
                               

                                
                                <?php 
                                        }
                                    ?>


                                 
                                
                                 
           
                               

                                
                               
                                
                                
                            </tr>
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function confirm_order(){
        start_load()
        $.ajax({
            url:'ajax.php?action=confirm_order',
            method:'POST',
            data:{id:'<?php echo $_GET['id'] ?>'},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Order confirmed.")
                        setTimeout(function(){
                            location.reload()
                        },1500)
                }
            }
        })
    }
</script>

<?php
require '../layouts/footer.php';
?>
