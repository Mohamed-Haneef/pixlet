<?php
include 'config.php';


/*
'config.php' - Extracts the database credentials from the 'config.json' file.
*/
class Database
{
    public static $conn = null;

    /**
     * Get a database connection.
     *
     * @return mysqli|null The database connection or null on failure.
     * @throws Exception If unable to establish a database connection.
     */

    public static function getConnection()
    {
        if (self::$conn == null) {
            $servername = get_config('DB_SERVER');
            $username   = get_config('DB_USER');
            $password   = get_config('DB_PASSWORD');
            $db_name   = get_config('DB_NAME');
        
            //establishing a new database
            $connection = new mysqli($servername, $username, $password, $db_name);

            //Checking for errors
            if ($connection->connect_error) {
                throw new Exception("Connection failed: " . $connection->connect_error);
            } else {

                //If there is no connection error, Store the Connection details.
                self::$conn = $connection;
                return self::$conn;
            }
        } else {

            //If there is already an existing connection, Return the existing connection
            return self::$conn;
        }
        
    }
    /*
    Closing the function
    */
    public static function closeConnection()
    {
        
        if(self::$conn !== null) {
            self::$conn -> close();
            //Close the connection and set the value to null...
            self::$conn = null;
            return self::$conn;
        }
    }

}
