<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################
# Fetch  User Data .......

$sql = 'select material.*,courses.title as catTitle  from  material inner join courses  on material.cour_id = courses.id ';
// if($_SESSION['user']['role_id'] == 1){
//    $sql = 'select blogs.*,categories.title as catTitle , users.name  from  blogs inner join categories  on blogs.cat_id = categories.id  inner join users on users.id = blogs.addedBy';
// }else{
//     //////status
//        $sql = 'select blogs.*,categories.title as catTitle , users.name  from  blogs inner join categories  on blogs.cat_id = categories.id  inner join users on users.id = blogs.addedBy where blogs.addedBy = '.$_SESSION['user']['id'];

// }



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
                                <th>Title</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>#</th>
                                <th>Title</th>
                                <th>File</th>
                                <th>Action</th>
                        </tfoot>
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                                <td><?php echo $data['id']; ?></td>
                              
                               
                                <td><?php echo $data['catTitle']; ?></td>
                                
                                <td> <a href="./uploads/<?php echo $data['file']; ?>">file </a> </td>
                               


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
