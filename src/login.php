<?php
   ob_start();
   session_start();
?>

<?php
$credentialsSqli = new mysqli("userdb", "root", "example");
mysqli_options($credentialsSqli, MYSQLI_OPT_LOCAL_INFILE, true);

// echo "Group 4 project wohooo";


// create database
$sql = "CREATE DATABASE IF NOT EXISTS `Credentials`;";
if ($result = $credentialsSqli->query($sql))
{
    // echo 'Credentials db created successfully ';
    // echo "<br>";
}
else{
    echo $credentialsSqli->error;
}


$sql_localInfile = 'SET GLOBAL local_infile=1';

if ($result = $credentialsSqli->query($sql_localInfile)){
    // echo 'set local_infile';
}
else{
    echo $credentialsSqli->error;
}
// echo "<br>";

if(checkIfTableExists("Credentials.users", $credentialsSqli) === false){

    $sql = "CREATE TABLE IF NOT EXISTS Credentials.users(
        `username` VARCHAR(50) PRIMARY KEY ,
        `password` VARCHAR(40)
    );
    
    ";

    if ($result = $credentialsSqli->query($sql))
    {
    // echo 'movies table created successfully';
    // echo "<br>";
    }

    $sql = "INSERT INTO Credentials.users (username, password) VALUES('someone', SHA('password'))";

    if ($result = $credentialsSqli->query($sql))
    {
    // echo 'Added to table';
    // echo "<br>";
    }

    
    
}



function checkIfTableExists($tableName, $mysqli) {
    $checktable = $mysqli->query("SHOW TABLES LIKE '$tableName'");
    $table_exists = $checktable->num_rows > 0;
    return $table_exists;
}
?>



<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
<li><a href="index.php"><i class="fa fa-star"></i> Index Page</a></li>
   <head>
      <title>Admin login</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      <link rel="stylesheet" type="text/css" href="css/style.css"> 
   </head>
	
   <body>
      
      <h2>Admin Login Page</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            // echo $_SESSION['username'];
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                //echo "this is username:";
				//echo $username;
                //echo "<br>";
                //echo $password;
                //$msg = "Welcome back ".$username;
                //$sql = "SELECT * FROM Credentials.users where `password` =SHA('whatt') ";
                $sql = "SELECT `password` FROM Credentials.users where `username` = '$username'";
                // echo $sql;

                if ($result = $credentialsSqli->query($sql)){
                    $idResult = mysqli_fetch_assoc($credentialsSqli->query($sql));
                    //echo $idResult;
                    echo $credentialsSqli->error;
                    // echo "<br>apparently it worked?";
                        
                    
                    $hashedPassword = $idResult['password'];
                     //echo $hashedPassword;
                     //echo "<br>";
                     //echo sha1("whatt");
                    if (strcmp($hashedPassword, sha1($password)) == 0){
                        // echo "ITS CORRECT!!";
                        // echo "<br>";
                        $_SESSION['valid'] = true;
                        //$_SESSION['timeout'] = time();
                        $_SESSION['username'] = $username;
                        //include index.php;
                        header('Refresh: 2; URL = loginSuccess.php');
                        echo 'You have entered valid use name and password';

                    }
                    else{
                        $_SESSION = Array();
                        $msg = 'Wrong username or password';
                        
                    }
                    echo "<br>";
                }
                else{
                    // echo "ot didnt work <br>";
                    echo $credentialsSqli->error;
                }
               
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "login.php" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "username" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
			
         Click here to clean <a href = "logout.php" tite = "Logout">Session/LogOut.
         
      </div> 
      
   </body>
</html>
