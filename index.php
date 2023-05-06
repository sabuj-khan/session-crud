<?php 
session_start();
require_once("functions.php");
define("FILE_NAME", "C:\Users\Islam\Desktop\CRUD-Project\info.txt");
$task = isset($_GET['task']) ? $_GET['task'] : 'report';
$error = isset($_GET['error']) ? $_GET['error'] : '0';

$message = '';
if( 'seed' == $task ){
    seed();
    $message = "Seeding has been completed";
}

$roll = '';
$fname = '';
$lname = '';
$email = '';

if( isset($_POST['save'])){
    $roll  = htmlspecialchars($_POST['roll']);
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $email = htmlspecialchars($_POST['email']);
    $id    = htmlspecialchars($_POST['id']);

    if($id){
        if($roll != '' && $fname != '' && $lname != '' && $email != ''){
            update_student($id, $fname, $lname, $email);
            header("location: index.php?task=report");
        }
    }else{
        if($roll != '' && $fname != '' && $lname != '' && $email != ''){
            $result = add_new_student($roll, $fname, $lname, $email);
            if($result){
                header("location: index.php?task=report");
            }else{
                $error = 1;
            }
            
        }
    }    
}

if( 'delete' == $task ){
    $id = $_GET['id'];
    if($id>0){
        delete_student($id);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Project With Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">    
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row project w-50 m-auto">
            <div class="project">
                <h2>Crud Project </h2>
                <p>A simple project to perform crud operation using plain files and PHP.</p>
                <div class="nav-area">
                    <div class="left-area">
                        <p>
                            <a href="index.php?task=report">All Students</a> |
                            <?php if( is_admin() || is_editor() ) : ?>
                            <a href="index.php?task=add">Add New Student</a> |
                            <?php endif; ?>
                            <?php if( is_admin()) : ?>
                            <a href="index.php?task=seed">Seed</a>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="right-area">
                        <p>
                            <?php if( isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
                                <a href="auth.php?logout=true">Log Out <?php if(isset($_SESSION['role'])){ echo "( ".ucfirst($_SESSION['role'])." )"; } ?></a>
                            <?php else: ?>
                                <a href="auth.php">Log In</a> 
                            <?php endif; ?>
                            
                        </p>
                    </div>
                </div>
                <hr>     
                <h4><?php if(isset($message)){ echo $message; } ?></h4>
            </div>
        </div>

        <?php if( 1 == $error) : ?>
            <div class="container mt-3">
                <div class="row project w-50 m-auto">
                    <div class="project">
                        <blockquote>Dublicated roll number has found</blockquote>
                    </div>
                </div>
            </div>

        <?php endif; ?>


        <?php if( 'report' == $task) : ?>
            <div class="container mt-3">
                <div class="row project w-50 m-auto">
                    <div class="project">
                        <?php all_students_display(); ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php if( 'add' == $task) : ?>
            <div class="container mt-3">
                <div class="row project w-50 m-auto">
                    <div class="project">
                       <form action="index.php?task=add" method="POST">
                            <label for="roll">Roll</label> <br/>
                            <input class="w-100 p-1 mb-2" type="number" name="roll" id="roll" value="<?php  echo $roll; ?>"> <br/>
                            <label for="fname">First Name</label> <br/>
                            <input class="w-100 p-1 mb-2" type="text" name="fname" id="fname" value="<?php  echo $fname; ?>"> <br/>
                            <label for="lname">Last Name</label> <br/>
                            <input class="w-100 p-1 mb-2" type="text" name="lname" id="lname" value="<?php  echo $lname; ?>"> <br/>
                            <label for="email">Email</label> <br/>
                            <input class="w-100 p-1 mb-2" type="email" name="email" id="email" value="<?php  echo $email; ?>"> <br/>
                            <input type="submit" value="Save" name="save" class="btn btn-secondary">
                       </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>


        <?php if( 'edit' == $task) : 
            $id = $_GET['id'];
            $student = get_and_update_student($id);
            ?>
            <?php if($student): ?>
            <div class="container mt-3">
                <div class="row project w-50 m-auto">
                    <div class="project">
                       <form action="index.php?task=edit" method="POST">
                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <label for="roll">Roll</label> <br/>
                            <input class="w-100 p-1 mb-2" type="number" name="roll" id="roll" value="<?php  echo $student['roll']; ?>"> <br/>
                            <label for="fname">First Name</label> <br/>
                            <input class="w-100 p-1 mb-2" type="text" name="fname" id="fname" value="<?php  echo $student['fname']; ?>"> <br/>
                            <label for="lname">Last Name</label> <br/>
                            <input class="w-100 p-1 mb-2" type="text" name="lname" id="lname" value="<?php  echo $student['lname']; ?>"> <br/>
                            <label for="email">Email</label> <br/>
                            <input class="w-100 p-1 mb-2" type="email" name="email" id="email" value="<?php  echo $student['email']; ?>"> <br/>
                            <input type="submit" value="Save Update" name="save" class="btn btn-secondary">
                       </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        <?php endif; ?>


    </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="assets/js/scripts.js"></script>

    </body>
</html>