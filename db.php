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

    function createAdmin($id, $name, $password, $email, $phone, $image, $role) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $password = mysqli_real_escape_string($this->conn, $password);
        $pass_crypt = crypt($password,'$#!da@#BBDF!#');
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $image = mysqli_real_escape_string($this->conn, $image);
        $role = mysqli_real_escape_string($this->conn, $role);
        $sql = "INSERT INTO admins (user_id, user_name, user_password, user_email ,user_phone ,user_role ,user_image)
        VALUES ('$id', '$name', '$pass_crypt', '$email', '$phone', '$role' ,'$image')";
        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return $this->  conn->error;
        }
    }

    function updateAdmin($id, $name, $password, $email, $phone, $image, $role) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $password = mysqli_real_escape_string($this->conn, $password);
        $pass_crypt = crypt($password,'$#!da@#BBDF!#');
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $image = mysqli_real_escape_string($this->conn, $image);
        $role = mysqli_real_escape_string($this->conn, $role);

        $sql = "UPDATE admins 
        SET user_name='$name', user_password='$pass_crypt', 
        user_email='$email', user_phone='$phone', user_role='$role', user_image='$image'
        WHERE user_id='$id'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function delAdmin($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "DELETE FROM admins WHERE user_id = '$id'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function createStudent($id, $name, $email, $phone, $image) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $image = mysqli_real_escape_string($this->conn, $image);
        $sql = "INSERT INTO users (user_id, user_name, user_email ,user_phone ,user_image)
        VALUES ('$id', '$name', '$email', '$phone', '$image')";
        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return $this->  conn->error;
        }
    }   
    
    function delStudent($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "DELETE FROM users WHERE user_id = '$id'";
        $sql2 = "DELETE FROM user_course WHERE user_id = '$id'";

        if ($this->conn->query($sql) === TRUE && $this->conn->query($sql2) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function updateStudent($id, $name, $email, $phone, $image) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $image = mysqli_real_escape_string($this->conn, $image);

        $sql = "UPDATE users 
        SET user_name='$name', user_email='$email', user_phone='$phone', user_image='$image'
        WHERE user_id='$id'";

        if ($this->conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function addToCourse($id, $courseid) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $courseid = mysqli_real_escape_string($this->conn, $courseid);
        $sql = "INSERT INTO user_course (user_id, course_id)
        VALUES ('$id' , '$courseid')";
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

    function delCourse($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "DELETE FROM courses WHERE course_id = '$id'";
        $sql2 = "DELETE FROM user_course WHERE course_id = '$id'";

        if ($this->conn->query($sql) === TRUE && $this->conn->query($sql2) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    function findCourse($name) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $sql = "SELECT course_id FROM courses WHERE course_name = '$name'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['course_id'];
        } else {
            return 0;
        }
    }

    function clearUserCourses($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "DELETE FROM user_course WHERE user_id = '$id'";
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
        $sql = "SELECT user_id FROM admins WHERE user_email = '$email' and user_password = '$pass_crypt'";  
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
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

    function showAdmins() {
        $sql = "SELECT * FROM admins";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $admins = array();
            while($row = $result->fetch_assoc()) {
                $adminid = $row['user_id'];
                $admin = array(
                    "id"=>$row["user_id"],
                    "password"=>$row["user_password"],
                    "name"=>$row["user_name"],
                    "phone"=>$row["user_phone"],
                    "email"=>$row["user_email"],
                    "image"=>$row["user_image"],
                    "role"=>$row["user_role"]
                );
                $admins[$adminid] = $admin;
            }
                $_SESSION['admins'] = $admins;
                return 1;
        } else {
            return 0;
        }
    }

    function showUsers() {
        $sql = "SELECT * FROM users";
        
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $users = array();
            while($row = $result->fetch_assoc()) {
                $userid = $row['user_id'];
                $user = array(
                    "id"=>$row["user_id"],
                    "name"=>$row["user_name"],
                    "phone"=>$row["user_phone"],
                    "email"=>$row["user_email"],
                    "image"=>$row["user_image"],
                    "courses"=>array()
                );
                $sql2 = "SELECT course_name, course_id, course_image FROM courses
                        NATURAL JOIN users
                        NATURAL JOIN user_course
                        WHERE user_id = '$row[user_id]'";
                $result2 = $this->conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {
                        $course = array(
                            "id"=>$row2["course_id"],
                            "name"=>$row2["course_name"],
                            "image"=>$row2["course_image"]
                        );
                        $user['courses'][$row2["course_id"]] = $course;
                    }
                } else {
                    array_push($user["courses"],"No Courses");
                }
                $users[$userid] = $user;
            }
            $_SESSION['users'] = $users;
            return 1;
        } else {  
            
            return 0;
        }
    }

    function showCourses() {
        $sql = "SELECT * FROM courses";
        
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $courses = array();
            while($row = $result->fetch_assoc()) {
                $courseid = $row['course_id'];
                $course = array(
                    "id"=>$row["course_id"],
                    "name"=>$row["course_name"],
                    "des"=>$row["course_des"],
                    "image"=>$row["course_image"],
                    "users"=>array()
                );
                $sql2 = "SELECT user_name, user_id, user_phone, user_image FROM users
                        NATURAL JOIN courses
                        NATURAL JOIN user_course
                        WHERE course_id = '$row[course_id]'";
                $result2 = $this->conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {
                        $user = array(
                            "id"=>$row2["user_id"],
                            "name"=>$row2["user_name"],
                            "phone"=>$row2["user_phone"],
                            "image"=>$row2["user_image"]
                        );
                        array_push($course["users"],$user); 
                    }
                } else {
                    array_push($course["users"],"No Users");
                }
                $courses[$courseid] = $course;
            }
            $_SESSION['courses'] = $courses;
            return 1;
        } else {  
            return 0;
        }
    }

    function __destruct(){
        $this->conn->close();
    }

}
?>