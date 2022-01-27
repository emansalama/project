<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';


#############################################################################
$id = $_GET['id'];

$sql = "select * from material where id = $id";
$op = mysqli_query($con, $sql);

if (mysqli_num_rows($op) == 1) {

    
    // code .....
    $BlogData = mysqli_fetch_assoc($op);

    //   if(!($_SESSION['user']['role_id'] == 2 || ($_SESSION['user']['id'] == $BlogData['addedBy']))){
    //     header('Location: index.php');
    //     exit();

    //   }




} else {
    $_SESSION['Message'] = ['Message' => 'Invalid Id'];
    header('Location: index.php');
    exit();
}
#############################################################################

#########################################################################

$sql = 'select * from courses';
$CatOp = mysqli_query($con, $sql);

#########################################################################

# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $cour_id = $_POST['cour_id'];
 
    $errors = [];

    # Validate cource_id ....
    if (!Validate($cour_id, 1)) {
        $errors['cour_id'] = 'Field Required';
    } elseif (!Validate($cour_id, 4)) {
        $errors['cour_id'] = 'Invalid Id';
    }
    $Message=[];
    # Validate file
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

        if (Validate($_FILES['image']['name'], 1)) {
            $disPath = './uploads/' . $FinalName;

            if (!move_uploaded_file($ImgTempPath, $disPath)) {
                $Message = ['Message' => 'Error  in uploading Image  Try Again '];
            } else {
                unlink('./uploads/' . $BlogData['file']);
            }
        } else {
            $FinalName = $BlogData['file'];
        }

        if (count($Message) == 0) {
           
            $sql = "update material set cour_id = $cour_id , file ='$FinalName' where id = $id";

            $op = mysqli_query($con, $sql);

            if ($op) {
                $Message = ['Message' => 'Raw Updated'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }
        }
        # Set Session ......
        $_SESSION['Message'] = $Message;
        header('Location: index.php');
        exit();
    }
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
            <li class="breadcrumb-item active">Dashboard/Mateerial/Create</li>

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

                <form action="edit.php?id=<?php echo $BlogData['id']; ?>" method="post" enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputPassword">Category</label>
                        <select class="form-control" id="exampleInputPassword1" name="cour_id">

                            <?php
                               while($data = mysqli_fetch_assoc($CatOp)){
                            ?>

                            <option value="<?php echo $data['id']; ?>" <?php if ($data['id'] == $BlogData['cour_id']) {
    echo 'selected';
} ?>><?php echo $data['title']; ?></option>

                            <?php }
                            ?>

                        </select>
                    </div>


                   



                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="image">
                    </div>

                    <a href="./uploads/<?php echo $BlogData['file']; ?>" ></a> <br>


                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>





            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
