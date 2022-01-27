<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

#########################################################################
$id = $_GET['id'];
$sql ="select * from orders where id=$id";

$op = mysqli_query($con, $sql);
#########################################################################

################################################################

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/student info/display</li>
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
                            <th>name</th>
                              <th>Status</th>
                              

                          
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>#</th>
                            <th>Name</th>
                              <th>status</th>
                            
                       
                         


                              
                        </tfoot>
                        <tbody>

                            <?php 
                                        # Fetch Data ...... 
                                        while($data = mysqli_fetch_assoc($op)){
                                      
                                    ?>

                            <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['name']; ?></td>

                            <?php if($data['status'] == 1): ?>
                        <td class="text-center"><span>Confirmed</span></td>
                    <?php else: ?>
                        <td class="text-center"><span >Not confirmed</span></td>
                    <?php endif; ?>
                               
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
