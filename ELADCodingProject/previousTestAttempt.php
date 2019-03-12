<?php 
    // indlude previousTestDetails which has the query and db requests 
    // which will have all the data to be output on this page
    include('previousTestDetails.php');
?>
<!DOCTYPE html>
<html>
    <head>
	<title>Previous Test Details</title>
        <!-- stylesheets and external libraries used on this page -->
        <link rel="stylesheet" type="text/css" href="styleSheet.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="header">
            <h2>Previous Test Details</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8" style="text-align:center;">
                    <!-- $data is a reference from previousTestDetails.php it is the result set
                    from the query that has all details about the previous test attempt.
                    this time the score is being echoed onto the page -->
                    <h1>You scored <?php echo $data['score']; ?>/10!</h1>
                </div>
                <div class='col-sm-2'></div>
            </div>
                <br>
                <hr>   
                <!-- headers for the previous test feilds -->
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-4" style="text-align:center;">
                        <h3>Question</h3>
                    </div>
                    <div class="col-sm-2" style="text-align:center;">
                        <h3>Answer</h3>
                    </div>
                    <div class="col-sm-3" style="text-align:center;">
                        <h3>Your Answer</h3>
                    </div>
                    <div class='col-sm-1'></div>
                </div>
                <hr>
                <!-- while loop loops over results returned from the query -->
                <?php while($prevRow = mysqli_fetch_array($prev_res_data)){
                    // this assigns a color to the variable $answerColour, 
                    // green if the user got the question right, red if they didnt
                    // this is used below for the student answer
                    if($prevRow['CorrectAnswer1'] === $prevRow['studentAnswer']){
                        $answerColour = 'green';
                    } else{
                        $answerColour = 'red';
                    }
                    echo '<div class="row">';
                        echo '<div class="col-sm-2"></div>';
                        echo '<div class="col-sm-4">';
                            // echo question to the page
                            echo $prevRow['Question'];
                        echo "</div>";
                        echo '<div class="col-sm-2">';
                            // echo correctAnswer to the page
                            echo $prevRow['CorrectAnswer1'];
                        echo "</div>";
                        // set color of text using $answerColour
                        echo "<div class='col-sm-2' style='text-align:center;color:$answerColour'>";
                            // echo studnetAnswer to the page
                            echo $prevRow['studentAnswer'];
                        echo "</div>";
                        echo "<div class='col-sm-2'></div>";
                    echo "</div>";
                    echo '<br>';
                    echo '<hr>';
                    echo '<br>';   
                }
            ?>
            <br>
            <br>
            <div style="text-align:center;">
                <!-- back button which would take you to the pretest overview again -->
                <input type="button" value="Back" class="btn btn-success" id="btnBack" onClick="document.location.href='preTest.php?id=<?php echo $groupID = $_GET['id'];?>'" />
            </div>
        </div>
    </body>
</html>