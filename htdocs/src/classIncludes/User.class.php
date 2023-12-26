<?php
include 'Database.class.php';
class User
{
    public $id;
    public $user;
    public $conn;
    public $info;
    public function __construct($email)
    {
        $conn = Database::getConnection();
        $this->conn = $conn;
        $sql_user = "SELECT `id`, `userName` FROM `userinfo` WHERE `emailAddress` = '$email'";
        $result = $conn->query($sql_user);
        try {
            if($result->num_rows) {
                $userId = $result->fetch_assoc();
                $this->id = $userId["id"];
                $this->user = $userId["userName"];
            } else {
                throw new exception("username doesn't exists");
            }
        } catch (Exception $e) {
            throw $e;
        }
        
        

    }
    public static function updateCredentials($userName, $emailAddress, $mobileNumber, $password)
    {
        
        // Getting database connection
        $conn = Database::getConnection();
        // Hashing the password using PHP Hashing
        $cost = [
            'cost' => 10,
        ];
        $pass = (password_hash("$password", PASSWORD_BCRYPT, $cost));
        $sql_query = "INSERT INTO userinfo (`userName`, `emailAddress`, `mobileNumber`, `password`)
        VALUES ('$userName', '$emailAddress', '$mobileNumber', '$pass')";

        if($conn->query($sql_query) === true) {
            echo"New record created successfully";
        } else {
            echo "Error". $conn->error;
        }
        $conn = Database::closeConnection();

    }

    public static function login($emailAddress, $password) : bool
    {
        try {
            $query = "SELECT * FROM `userinfo` WHERE `emailAddress` = '$emailAddress'";
            $conn = Database::getConnection();
            $result = $conn->query($query);
            // print("something is wrong with database");
            
            if($result) {
                $row = $result->fetch_assoc();
                if($row) {
                    // echo "data fetched";
                }
                // print($row["password"]);
                // print($password);

                if (password_verify($password, $row["password"])) {
                    // echo "password matches";
                    return $row["id"];
                } else {
                    throw new Exception("Password didn't match buddy");
                }
            } else {
                throw new Exception("Email didn't match dude");
            }
            
        } catch (Exception $e) {
            // Log the exception for debugging purposes
            error_log("Exception in User::login: " . $e->getMessage());
    
            // Re-throw the exception to propagate it up the call stack
            throw $e;
        }
    }
}
