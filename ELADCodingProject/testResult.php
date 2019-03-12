<?php 
    include('resultsToDB.php');
?>
<!DOCTYPE html>
<html>
    <head>
	<title>Results</title>
        <link rel="stylesheet" type="text/css" href="styleSheet.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="header">
            <h2>Test Results</h2>
        </div>
        <div class="content">            
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8" style="text-align:center;">
                    <?php if(isset($_SESSION['timeExpired']) && $questionsAnswered != 10){
                        echo "<h1>".$_SESSION['timeExpired']."</h1>";
                        unset($_SESSION['timeExpired']);
                    } ?>
                    <h1>You scored <?php echo $_SESSION['score'] ?>/10!</h1>
                </div>
                <div class='col-sm-2'></div>
            </div>
                <br>
                <hr>   
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
                <?php  if (isset($_SESSION['username'])) :
                    for ($x = 1; $x <= (int)$questionsAnswered; $x++) {
                        if($_SESSION[$x.'Answer'] === $_SESSION[$x.'UserAnswer']){
                            $answerColour = 'green';
                        } else{
                            $answerColour = 'red';
                        }
                        echo '<div class="row">';
                            echo '<div class="col-sm-2"></div>';
                            echo '<div class="col-sm-4">';
                                echo $_SESSION[$x.'Question'];
                            echo "</div>";
                            echo '<div class="col-sm-2">';
                                echo $_SESSION[$x.'Answer'];
                            echo "</div>";
                            echo "<div class='col-sm-2' style='text-align:center;color:$answerColour'>";
                                echo $_SESSION[$x.'UserAnswer'];
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
                    <input type="button" value="Return to Home" class="btn btn-success" id="btnExit" onClick="document.location.href='home.php'" />
                </div>
            <?php endif ?>
        </div>
    </body>
</html>