<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
# Fetch  User Data .......

if($_SESSION['user']['role_id'] == 1){
    $sql = 'select coursedetails.*,courses.title as couTitle , user.name  from  coursedetails inner join courses  on coursedetails.cour_id = courses.id  inner join user on user.id = coursedetails.teachby';
 }
 elseif($_SESSION['user']['role_id'] == 2){
        $sql = 'select coursedetails.*,courses.title as couTitle , user.name  from  coursedetails inner join courses  on coursedetails.cour_id = courses.id  inner join user on user.id = coursedetails.teachby where coursedetails.teachby = '.$_SESSION['user']['id'];
 
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
            <li class="breadcrumb-item active">Dashboard/Coursesdetails/display</li>
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
                               
                                <th>Description</th>
                                <th>Price</th>
                                <th>Appoinment</th>
                                <th>Courses</th>
                                <th>image</th>
                                <th>Teachby</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>#</th>
                               
                                <th>Description</th>
                                <th>Price</th>
                                <th>Appoinment</th>
                                <th>Courses</th>
                                <th>image</th>
                                <th>Teachby</th>
                                <th>Action</th>
                        </tfoot>
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                            <td><?php echo $data['id']; ?></td>
                            
                                <td><?php echo substr($data['description'],0,20); ?></td>
                                <td><?php echo $data['price']; ?></td>
                                <td><?php echo date('Y/m/d',$data['appoinment']); ?></td>
                                <td><?php echo $data['couTitle']; ?></td>
                                <td> <img src="./uploads/<?php echo $data['image']; ?>" height="40px" width="40px">  </td>
                                <td><?php echo $data['name'];?></td>
                                <td>
                                    <a href='delete.php?id=<?php echo $data['id']; ?>'
                                        class='btn btn-danger m-r-1em'>Delete</a>
                                    <a href='edit.php?id=<?php echo $data['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                </td>

                            </tr>

                            <?php 
                                        }
                                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
