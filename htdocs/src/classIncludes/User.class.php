<?php
include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/Database.class.php";

class User{
    public static function updateCredentials($userName, $emailAddress, $mobileNumber, $password){
        
        // Getting database connection
        $conn = Database::getConnection();
        // Hashing the password using PHP Hashing
        $cost = [
            'cost' => 10,
        ];
        $pass = (password_hash("$password", PASSWORD_BCRYPT, $cost));
        $sql_query = "INSERT INTO userinfo (`userName`, `emailAddress`, `mobileNumber`, `password`)
        VALUES ('$userName', '$emailAddress', '$mobileNumber', '$pass')";

        if($conn->query($sql_query) === true)
        {
            echo"New record created successfully";
        }else
        {
            echo "Error". $conn->error;
        }


    }
}