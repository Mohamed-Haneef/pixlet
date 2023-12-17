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
        $conn = Database::closeConnection();

    }

    public static function login($userName, $password){
        try {
            $query = "SELECT * FROM `userinfo` WHERE `userName` = '$userName'";
            $conn = Database::getConnection();
            $result = $conn->query($query);
            print("something is wrong with database");
            
            if($result) {
                $row = $result->fetch_assoc();
                print($row["password"]);
                print($password);

                if (password_verify($password, $row["password"])) {
                    $login=true;
                    echo"success";
                } else {
                    throw new Exception("Password didn't match buddy");
                }
            } else {
                throw new Exception("Username didn't match dude");
            }
            return $login;
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            error_log("Exception in User::login: " . $e->getMessage());
    
            // Re-throw the exception to propagate it up the call stack
            throw $e;
        }
    }
}