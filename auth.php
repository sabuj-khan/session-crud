<?php 
define('FINE_NAME_DATA', 'C:\Users\Islam\Desktop\SESSION-CRUD\data.txt');
session_start(array(
    'cookie_lifetime'   => '120',
));
$error = false;

if(isset($_POST['login'])){

    $user = $_POST['user'];
    $password = $_POST['password'];
    $fp = fopen(FINE_NAME_DATA, "r");

        if( $user && $password ){
            $_SESSION['loggedin']   = false;
            $_SESSION['user']       = false;
            $_SESSION['role']       = false;
            while( $data = fgetcsv($fp) ){
                if( $data[0] == $user && $data[1] == sha1($password) ){
                    $_SESSION['loggedin']   = true;
                    $_SESSION['user']   = $user;
                    $_SESSION['role']   = $data[2];
                    header("location: index.php");

                }
            }
            if(!$_SESSION['loggedin']){
                $error = true;
            }

        }

    }

if( isset($_GET['logout'])){
    $_SESSION['loggedin']   = false;
    $_SESSION['user']       = false;
    $_SESSION['role']       = false;
    session_destroy();
    header("location: index.php");
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
                <h2>Simple Auth Project With Session </h2>
                <?php if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true) : ?>
                    <p>Hello Admin, Welcome</p>
                <?php else: ?>
                    <p>Hello Stranger, Please Log In</p>
                <?php endif; ?>                
                
            </div>
        </div>

            <div class="container mt-3">
                <div class="row project w-50 m-auto">
                    <div class="project">
                    <?php if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true) : ?>
                        <p> <a class="btn btn-secondary" href="auth.php?logout=true">Log Out</a> </p>
                    <?php else: ?>
                        <?php if(isset($error) && $error == true){ echo "<b><i style='color:maroon'>Username and Password are not matching</i></b>"; } ?>
                        <form action="" method="POST">
                            <label for="user">User Name</label> <br/>
                            <input class="w-100 p-1 mb-2" type="text" name="user" id="user"> <br/>
                            <label for="password">Password</label> <br/>
                            <input class="w-100 p-1 mb-2" type="password" name="password" id="password"> <br/>
                            
                            <input type="submit" value="Log In" name="login" class="btn btn-secondary">
                       </form>
                    <?php endif; ?>
                       
                    </div>
                </div>
            </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>