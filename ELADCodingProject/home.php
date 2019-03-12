<?php 
    // start session allows the user to interact, assign and destroy variables stored in the session.
    session_start(); 

    // if the username is NOT stored in the session add a msg saying the must login and
    // redirect them back to the login page.  
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: Login.php');
    }
    // if a logout variable is being passed in the url 
    if (isset($_GET['logout'])) {
        // destroys session
        session_destroy();
        // deletes username from the session and redirects the user to the login page.
        unset($_SESSION['username']);
        header("location: Login.php");
    }
    
    // when this page loads delete the below varibales from the session
    // all of these are created while the user is in test and are no longer needed
    // if left undeleted they may have caused the test to error when the user tried to reattempt the test
    unset($_SESSION['usedIDs']);
    unset($_SESSION['score']);
    unset($_SESSION['timeRemaining']);
    
    // this for loop deletes all the questions/ answers/ user answers/ and question ids from the test
    // these were all stored during the test so that when the user finished the test all of this data 
    // would be looped over and written into the db
    // so that when the test is completed the user no longer needs these to be stored any longer
    for ($x = 1; $x <= 10; $x++) {
        unset($_SESSION[$x.'Question']);
        unset($_SESSION[$x.'Answer']);
        unset($_SESSION[$x.'UserAnswer']);
        unset($_SESSION[$x.'QuestionID']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
	<title>Home</title>
        <link rel="stylesheet" type="text/css" href="styleSheet.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
<body>
    <div class="header">
            <h2>Home Page</h2>
    </div>
    <div class="content">
        <!-- the success variable is being assigned to the session when the user logs in successfully -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                    <?php 
                        // prints out that the login has been a "success" 
                        echo $_SESSION['success']; 
                        // remove from session so that if the page reloads this message 
                        // isn't shown again as is only applicable to when the user logs in/ registers
                        unset($_SESSION['success']);
                     ?>
                </h3>
            </div>
        <?php endif ?>

        <!-- if statement checks is the username variable in the session (this effectively checks is the user logged in )-->
        <?php  if (isset($_SESSION['username'])) : ?>
            <div class="row">
                <div class='col-sm-2'></div>
                <div class='col-sm-8' style='text-align: center;'>
                    <!-- Welcome the user -->
                    Welcome <strong><?php echo $_SESSION['username'] ?></strong>
                </div>
                <div class='col-sm-2'></div>
            </div>
            <br>
            
            <!-- buttons for proceeding to the tests and information relating to the tests -->
            <div class="row">
                <div class='col-sm-2'></div>
                <div class='col-sm-4' style='text-align: center;'>
                    <input type="button" value="HTML Test" class="btn btn-primary" id="btnHTML" onClick="document.location.href='preTest.php?id=2'" />  
                    <p>This is a beginners HTML quiz which covers topics such as events, attributes and data types.</p>
                </div>
                <div class='col-sm-4' style='text-align: center;'>
                    <input type="button" value="JavaScript Test" class="btn btn-primary" id="btnJS" onClick="document.location.href='preTest.php?id=1'" /> 
                    <p>This is a beginners JavaScript quiz which covers topics such as for loops, while loops and if statements. </p>
                </div>
            </div>
            <br>
            <br>
            <!-- test tips -->
            <div class="row">
                <div class='col-sm-12' style='text-align: center;'>
                    <h2>How to prepare for taking an online test!</h2> 
                </div>
            </div>          
            <div class="row">
                <div class='col-sm-2'></div>
                <div class='col-sm-8'>  
                    <ul>
                        <li>Read and understand the test guidelines. </li>
                        <li>Check your computer. Avoid last-minute problems! </li>
                        <li>Plan your time.</li>
                        <li>Carve out a quiet test-taking spot with minimal distractions.</li>
                        <li>Determine when you will take the test. </li>
                        <li>Gather all that you will need to take the test.</li>
                        <li>Take a deep breath! Once you’re logged in, take a moment to relax and get focused.</li>
                    </ul>
                </div>
                <div class='col-sm-2'></div>
            </div>
            <br>
            <br>
            
            <div class="row">
                <div class='col-sm-2'></div>
                <div class='col-sm-8' style='text-align: center;'>
                    <input type="button" value="Logout" class="btn btn-danger" id="btnLogout" onClick="document.location.href='home.php?logout=1'" />
                </div>
                <div class='col-sm-2'></div>
            </div>         
        <!-- end of if statement -->  
        <?php endif ?>
    </div>

    </body>
</html>