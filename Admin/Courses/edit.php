<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

#############################################################################
$id = $_GET['id'];

$sql = "select * from courses where id = $id";
$op = mysqli_query($con, $sql);

if (mysqli_num_rows($op) == 1) {
    // code .....
    $data = mysqli_fetch_assoc($op);
} else {
    $_SESSION['Message'] = ['Message' => 'Invalid Id'];
    header('Location: index.php');
    exit();
}
#############################################################################

# Code .....

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = Clean($_POST['title']);
    $shortDesc = Clean($_POST['shortDesc']);

    # Validate Title ....
    $errors = [];

    if (!Validate($title, 1)) {
        $errors['Title'] = 'Required Field';
    } elseif (!Validate($title, 6)) {
        $errors['Title'] = 'Invalid String';
    }

    # Validate Desc ...
    if (!Validate($shortDesc, 1)) {
        $errors['shotDesc'] = 'Required Field';
    } elseif (!Validate($shortDesc, 3, 30)) {
        $errors['shotDesc'] = 'Length Must be  >= 30  CHARS';
    }

    if (count($errors) > 0) {
        # Set Session ......
        $_SESSION['Message'] = $errors;
    } else {
        // DB CODE .....
        $sql = "update courses set title='$title' , shortDesc = '$shortDesc' where id = $id";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $Message = ['Message' => 'Raw Updated'];
        } else {
            $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
        }

        # Set Session ......
        $_SESSION['Message'] = $Message;
        header('Location: index.php');
        exit();
    }
}

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/courses/Edit</li>

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

                <form action="edit.php?id=<?php echo $data['id']; ?>" method="post">

                    <div class="form-group">
                        <label for="exampleInputName">Title</label>
                        <input type="text" class="form-control" id="exampleInputName" name="title" aria-describedby=""
                            placeholder="Enter Title" value="<?php echo $data['title']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Short Desc</label>
                        <textarea class="form-control" id="exampleInputName"
                            name="shortDesc"> <?php echo $data['shortDesc']; ?> </textarea>
                    </div>


                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>





            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
