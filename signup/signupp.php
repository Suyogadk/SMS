<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
</head>
<body>
<body>
    
    <center>
        <?php

        $host = 'sql8.freesqldatabase.com'; 
        $db = 'sql8739904';
        $user = 'sql8739904';
        $pass = 'UBN9aaWh58';
        $conn = mysqli_connect("$host", "$user", "$pass", "$db");
        
        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. " 
                . mysqli_connect_error());
        }
        
        // Taking all 5 values from the form data(input)
        $first_name =  $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
        $username =  $_REQUEST['username'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        
        // Performing insert query execution
        // here our table name is college
        $sql = "INSERT INTO `SMS4L`(`id`, `first_name`, `last_name`, `username`, `email`, `password`, `time`)   VALUES ('' ,'$first_name','$last_name','$username','$email','$password', '')";
        
        if(mysqli_query($conn, $sql)){
            echo("welcome Mr. \n$first_name $last_name\n ");
            
                header("Location: ../log-in/login.html");
                exit; 
            }
         else{
            echo "ERROR: Hush! Sorry $sql. " 
                . mysqli_error($conn);
        }
        
        // Close connection
        mysqli_close($conn);
        ?>
    </center>
</body>

</html>
