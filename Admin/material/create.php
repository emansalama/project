<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

#########################################################################
# Fetch Roles ....
$sql = 'select * from courses';
$RoleOp = mysqli_query($con, $sql);

#########################################################################

# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $cour_id = $_POST['cour_id'];
 

    # Validate Title ....
    $errors = [];

   

    # Validate cat_id ....
    if (!Validate($cour_id, 1)) {
        $errors['cour_id'] = 'Field Required';
    } elseif (!Validate($cour_id, 4)) {
        $errors['cour_id'] = 'Invalid Id';
    }

 

    # Validate Image
    if (!Validate($_FILES['image']['name'], 1)) {
        $errors['Image'] = 'Field Required';
    } else {
        $ImgTempPath = $_FILES['image']['tmp_name'];
        $ImgName = $_FILES['image']['name'];

        $extArray = explode('.', $ImgName);
        $ImageExtension = strtolower(end($extArray));

        if (!Validate($ImageExtension, 8)) {
            $errors['Image'] = 'Invalid Extension';
        } else {
            $FinalName = time() . rand() . '.' . $ImageExtension;
        }
    }

    if (count($errors) > 0) {
        $Message = $errors;
    } else {
        // DB CODE .....

        $disPath = './uploads/' . $FinalName;

        if (move_uploaded_file($ImgTempPath, $disPath)) {
      
        


            $sql = "insert into material (file,cour_id) values ('$FinalName',$cour_id)";
            $op = mysqli_query($con, $sql);

            if ($op) {
                $Message = ['Message' => 'Raw Inserted'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }
        } else {
            $Message = ['Message' => 'Error  in uploading Image  Try Again '];
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
            <li class="breadcrumb-item active">Dashboard/materials/Create</li>

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

                  



                    <div class="form-group">
                        <label for="exampleInputPassword">Corces</label>
                        <select class="form-control" id="exampleInputPassword1" name="cour_id">

                            <?php
                               while($data = mysqli_fetch_assoc($RoleOp)){
                            ?>

                            <option value="<?php echo $data['id']; ?>"><?php echo $data['title']; ?></option>

                            <?php }
                            ?>

                        </select>
                    </div>


                  

                    <div class="form-group">
                        <label for="exampleInputName">File</label>
                        <input type="file" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>





            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
