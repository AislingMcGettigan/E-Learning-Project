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
    
    // test details hold the sql work for retrieving the details anout the test
    include('testDetails.php');

    // converts the query result set returned from testDetails.php
    // into an array ready to be applied to the page below
    $row = mysqli_fetch_array($res_data);
?>
<!DOCTYPE html>
<html>
    <head>
	<title>Quiz Details</title>
        <!-- stylesheets and external libraries used on this page -->
        <link rel="stylesheet" type="text/css" href="styleSheet.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="header">
                <h2>Test Details</h2>
        </div>
        <div class="content">
            <!-- if statement checks is the username variable in the session (this effectively checks is the user logged in )-->
            <?php  if (isset($_SESSION['username'])) :?>
                <h3>Overview</h3>
                <hr>
                <div class="row">
                    <div class="col-sm-2">
                        <label><b>Test Name:</b> </label> 
                    </div>
                    <div class="col-sm-8">
                        <!-- echo (print) testname from the resulting query from above to the page -->
                        <?php echo $row['TestName']; ?>
                    </div>
                    <div class='col-sm-2'></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-2">
                        <label><b>Test Topic:</b> </label> 
                    </div>
                    <div class="col-sm-8">
                        <!-- echo (print) test topic from the resulting query from above to the page -->
                        <?php echo $row['TestTopic']; ?>
                    </div>
                    <div class='col-sm-2'></div>
                </div>   
                <br>
                <div class="row">
                    <div class="col-sm-2">
                        <label><b>Test Time:</b> </label>
                    </div>
                    <div class="col-sm-8">
                        20:00 Minutes
                    </div>
                    <div class='col-sm-2'></div>
                </div>  
                <br>
                <div class="row">
                    <div class="col-sm-2">
                        <label><b>Average Test Score:</b> </label>
                    </div>
                    <div class="col-sm-8">
                        <!-- echo (print) the average score for this test onto the page and format the number to 1 decimal place -->
                        <!-- $averageScore is created in the testDetail.php page along with the details for the test -->
                        <?php echo number_format((float)$averageScore, 1, '.', ''); ?>/10
                    </div>
                    <div class='col-sm-2'></div>
                </div>  
                <br>
                <div class="row">   
                    <div class="col-sm-2">
                        <label><b>Test Description:</b> </label>
                    </div>
                    <div class="col-sm-8">
                        <!-- echo (print) test description from the resulting query from above to the page -->
                        <?php echo $row['TestDescription']; ?>
                    </div>
                    <div class='col-sm-2'></div>
                </div>
                <br>
                <br>
                <div style="text-align:center;">
                    <!-- proceed to test, the $TestID is from the testDetails.php page. 
                    this ID being passed over the url will take the user to the correct test  -->
                    <input type="button" value="Proceed to Test" class="btn btn-success" id="btnHTML" onClick="document.location.href='test.php?id=<?php echo $TestID; ?> '" />
                </div>
                <br>
                <!-- previous test attemps section -->
                <h3>Previous Test Results</h3>
                <hr>
                <br>
                <!-- headers for the results -->
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <b>Score</b>
                    </div>
                    <div class="col-sm-4">
                        <b>Date/Time</b>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class='col-sm-2'></div>
                </div>  
                <hr>
                <!-- a do while loop, this will continue to loop until it has looped over all the result sets
                it is looping over the $prev_res_data query result and converting it to an array to loop over
                $prevRow is a reference to each row of data in the result set -->
                <?php while($prevRow = mysqli_fetch_array($prev_res_data)){
                    echo '<div class="row">';
                        echo '<div class="col-sm-2"></div>';
                        echo '<div class="col-sm-2">';
                            // show the score from the previously taken test
                            echo $prevRow['score']."/10 Correct";
                        echo '</div>';
                        echo '<div class="col-sm-4">';
                            // show the date/time from the previously taken test
                            echo $prevRow['dateTimeOfTest'];
                        echo '</div>';
                        echo '<div class="col-sm-2">'; ?>
                            <!-- button that will redirect the user to review their previous test attempt -->
                            <input type="button" value="Review Previous Attempt" class="btn btn-success" id="btnPreviousAttempt" onClick="document.location.href='previousTestAttempt.php?groupid=<?php echo $prevRow['quizGroupID']; ?>&id=<?php echo $TestID; ?>'" />
                        <?php
                        echo '</div>';
                        echo '<div class="col-sm-2"></div>';
                    echo '</div>';
                    echo '<hr>';
                } ?>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8" style="text-align: center">
                        <!-- button that will redirect the user to home page -->
                        <input type="button" value="Back" class="btn btn-success" id="btnBack" onClick="document.location.href='home.php'" />
                    </div>
                    <div class='col-sm-2'></div>
                </div>
            <!-- end of if statement -->
            <?php endif ?>
        </div>
    </body>
</html>