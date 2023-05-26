<?php
try {

    $host = "localhost";

    $dbname = "jobboard";

    $user = "root";

    $pass = "";

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


// if($conn == true){
//     echo "Connected successfully";
// } else {
//     echo "Connection failed: " ;
// }

?>