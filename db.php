<?php
class AnswersDB {
    private $conn;
    const SERVERNAME = "127.0.0.1";
    const USERNAME = "root";
    const PASSWORD = "12345";
    const DBNAME = "project";
    function __construct() {
        $this->conn = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if ($this->conn->connect_error) {
            throw new Exception("this->Connection failed: " . $this->conn->connect_error); 
        }
    }

    function createUser($name, $password, $email, $phone, $image, $role) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $password = mysqli_real_escape_string($this->conn, $password);
        $pass_crypt = crypt($password,'$#!da@#BBDF!#');
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $image = mysqli_real_escape_string($this->conn, $image);
        $role = mysqli_real_escape_string($this->conn, $role);
        $sql = "INSERT INTO users (user_name, user_password, user_email ,user_phone ,user_role ,user_image)
        VALUES ('$name', '$pass_crypt', '$email', '$phone', '$role' ,'$image')";
        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateUser($id, $name, $password, $email, $phone, $image, $role) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $password = mysqli_real_escape_string($this->conn, $password);
        $pass_crypt = crypt($password,'$#!da@#BBDF!#');
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $image = mysqli_real_escape_string($this->conn, $image);
        $role = mysqli_real_escape_string($this->conn, $role);

        $sql = "UPDATE users 
        SET user_name='$name', user_password='$pass_crypt', 
        user_email='$email', user_phone='$phone', user_role='$role', user_image='$image'
        WHERE user_id='$id'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function delUser($name) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $sql = "DELETE FROM users WHERE use_name = '$name'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function createCourse($name, $des, $image) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $des = mysqli_real_escape_string($this->conn, $des);
        $image = mysqli_real_escape_string($this->conn, $image);
        $sql = "INSERT INTO courses (course_name, course_des, course_image)
        VALUES ('$name', '$des', '$image')";
        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateCourse($id, $name, $des, $image) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $des = mysqli_real_escape_string($this->conn, $des);
        $image = mysqli_real_escape_string($this->conn, $image);

        $sql = "UPDATE courses 
        SET course_name='$name', course_des='$des', course_image='$image'
        WHERE course_id='$id'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function delCourse($name) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $sql = "DELETE FROM courses WHERE course_name = '$name'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function login($email, $password) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
        $pass_crypt = crypt($password,'$#!da@#BBDF!#');
        $sql = "SELECT user_id FROM users WHERE user_email = '$email' and user_password = '$pass_crypt'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $row['user_id'];
        } else {
            return 0;
        }
    }

    function showUser($name) {
        $name = mysqli_real_escape_string($this->conn, $name);

        $sql = "SELECT * FROM users 
                WHERE user_name='$name'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user = array(
                "name"=>$row["user_name"],
                "phone"=>$row["user_phone"],
                "email"=>$row["user_email"],
                "image"=>$row["user_image"],
                "courses"=>array()
            );
            $sql = "SELECT course_name FROM courses
                    NATURAL JOIN users
                    NATURAL JOIN user_course
                    WHERE user_id = '$row[user_id]'";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($user["courses"],$row["course_name"]);
                }
            }
            return $user;
        } else {  
            return 0;
        }
    }

    function showUsers() {
        $sql = "SELECT user_name, user_phone FROM users";
        
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while($row = $result->fetch_assoc()) {
                array_push($users, $row["user_name"]);
            }
        return $users;
        } else {  
            return 0;
        }
    }

    function __destruct(){
        $this->conn->close();
    }

}
?>