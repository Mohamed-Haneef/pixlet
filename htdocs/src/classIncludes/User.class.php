<?php
// include 'Database.class.php';
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
        $sql_user = "SELECT `id`, `userName` FROM `userinfo` WHERE `emailAddress` = ?";
        $bind = $conn -> prepare($sql_user);
        $bind -> bind_param("s", $email);
        $bind -> execute();
        $result = $bind -> get_result();
        if($result) {
            $userId = $result->fetch_assoc();
            $this->id = $userId["id"];
            $this->user = $userId["userName"];
            $conn = Database::closeConnection();
            return $this->id;
        } else {
            return 5;
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
        VALUES (?, ?, ?, ?)";

        $bind = $conn -> prepare($sql_query);
        $bind -> bind_param("ssss", $userName, $emailAddress, $mobileNumber, $pass);



        if ($bind->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $bind->error;
        }

        $conn = Database::closeConnection();

    }

    public static function login($emailAddress, $password) : bool
    {
        try {
            $query = "SELECT * FROM `userinfo` WHERE `emailAddress` = ?";
            $conn = Database::getConnection();
            $bind = $conn -> prepare($query);
            $bind -> bind_param("s", $emailAddress);
            $bind -> execute();
            $result = $bind -> get_result();
            if($result) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["password"])) {
                    return $row["id"];
                } else {
                    return false;
                    throw new Exception("Password didn't match buddy");
                }
            } else {
                return false;
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
