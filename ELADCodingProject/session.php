<?php
    session_start();
    
    // initializing variables
    $username = "";
    $fName = "";
    $sName = "";
    $email = "";
    $stuId = "";
    $edDepartment = "";
    $errors = array(); 

    // connect to the database
    include("config.php");

    // REGISTER USER
    //post is passing var to be written into db
    //if register button is executed
    if (isset($_POST['registerUser'])) {
        // receive all input values from the form
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $pword1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $pword2 = mysqli_real_escape_string($db, $_POST['password_2']);
        $fName = mysqli_real_escape_string($db, $_POST['firstName']);
        $sName = mysqli_real_escape_string($db, $_POST['surname']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $stuId = mysqli_real_escape_string($db, $_POST['studentId']);
        $edDepartment = $_POST['educationalDepartment'];

        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error into $errors array
        if (empty($username)) { array_push($errors, "Username is required"); }
        if (empty($pword1)) { array_push($errors, "Password is required"); }
        if (empty($pword2)) { array_push($errors, "Confirmation password is required"); }
        if (empty($fName)) { array_push($errors, "First name is required"); }
        if (empty($sName)) { array_push($errors, "Surname is required"); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($stuId)) { array_push($errors, "Student id is required"); }
        if (empty($edDepartment)) { array_push($errors, "Educational Department is required"); }
        if ($pword1 != $pword2) {
              array_push($errors, "The two passwords do not match");
        }

        // first check the database to make sure 
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT username, email FROM student WHERE username='" . $username . "' OR email='" . $email . "' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        if (!$result || mysqli_num_rows($result) == 1){
            $user = mysqli_fetch_assoc($result);
            if ($user) { // if user exists
                if ($user['username'] === $username) {
                    array_push($errors, "Username already exists");
                }              
                if ($user['email'] === $email) {
                    array_push($errors, "email already exists");
                }
            }
        }

        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) {
            $query = "INSERT INTO `student`(`StudentID`, `Username`, `Password`, `Firstname`, `Surname`, `EducationDepartment`, `Email`) 
                VALUES('$stuId', '$username', '$pword1', '$fName', '$sName', '$edDepartment', '$email')";
            mysqli_query($db, $query);
            $user_check_query = "SELECT id FROM student WHERE username='".$username."' OR email='".$email."' LIMIT 1";
            $newResults = mysqli_query($db, $user_check_query);
            $newUser = mysqli_fetch_assoc($newResults);
            //creating session var
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['userId'] = $newUser['id'];
            header('location: home.php');
        }
    }
    
    // LOGIN
    //if login button is executed
    if (isset($_POST['loginUser'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $query = "SELECT id FROM student WHERE username='".$username."' AND password='".$password."'";
            $loginResults = mysqli_query($db, $query);
            $user = mysqli_fetch_assoc($loginResults);
            if (mysqli_num_rows($loginResults) == 1) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                $_SESSION['userId'] = $user['id'];
                header('location: home.php');
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }
