<?php 
  session_start(); 
  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: Login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: Login.php");
  }
  include('quizData.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" type="text/css" href="styleSheet.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="header">
            <h2>
                <?php echo $quizTitle ?>
            </h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-4" style="text-align:center;">
                    <h3>
                        <b>Question <?php echo $pageno ?>/10</b>
                    </h3>
                </div>
                <div class="col-sm-4" style="text-align:center;">
                    <h3>
                        <b><span id='time'><?php echo $_SESSION["timeRemainingTitle"] ?></span> Remaining.</b>
                    </h3>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class='progress'>
                        <div class='progress-bar' role='progressbar' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100' style='width:<?php echo ((int)$pageno-1) ?>0%'>
                            <?php if((int)$pageno === 1){ echo "0% Complete";} else{ echo ((string)($pageno-1))."0% Complete"; } ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <?php  if (isset($_SESSION['username'])) : 
                while($row = mysqli_fetch_array($res_data)){
                    $_SESSION[$pageno.'Question'] = $row['Question'];
                    $_SESSION[$pageno.'Answer'] = $row['CorrectAnswer1'];
                    $_SESSION[$pageno.'QuestionID'] = $row['QuestionID'];
                   //echo html onto page as php tag open
                    echo '<div class="row">';
                        echo '<div class="col-sm-3"></div>';
                        echo '<div class="col-sm-6">';
                            echo "<b>".htmlspecialchars($row['Question'])."</b>";
                            echo '<br>';
                            echo "<input type='radio' name='q$pageno' value='$row[Option1]' class='radio' required onClick='removeWarning()' /> ";
                            echo htmlspecialchars($row['Option1']);
                            echo '<br>';
                            echo "<input type='radio' name='q$pageno' value='$row[Option2]' class='radio'  required onClick='removeWarning()' /> ";
                            echo htmlspecialchars($row['Option2']);
                            echo '<br>';
                            echo "<input type='radio' name='q$pageno' value='$row[Option3]' class='radio' required onClick='removeWarning()' /> ";
                            echo htmlspecialchars($row['Option3']);
                            echo '<br>';
                            echo "<input type='radio' name='q$pageno' value='$row[Option4]' class='radio' required onClick='removeWarning()' /> ";
                            echo htmlspecialchars($row['Option4']);
                            //accesible by JS
                            echo "<input type='hidden' name='answer1' id='answer1' value='$row[CorrectAnswer1]' />";
                            echo "<input type='hidden' name='answer2' id='answer2' value='$row[CorrectAnswer2]' />";
                            echo "<input type='hidden' name='timerVlaue' id='timerVlaue' value='' />";
                            echo '<br>';
                            echo '<br>';
                            echo "<div id='errorBlock' style='color:red;'></div>";
                        echo '</div>';
                        echo '<div class="col-sm-3"></div>';
                    echo '</div>';
                    //stop duplicate q
                    $usedIDs = $_SESSION['usedIDs'] . "," . strval($row['QuestionID']);
                    $_SESSION['usedIDs'] = $usedIDs;
                } ?>
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" style="text-align: center">
                        <ul class="pagination">
                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a onclick="test()">Next</a>
                            </li>
                            <li id="hideUntilFinished"><a onclick="test()">Submit</a></li>
                            <li><a href="home.php" onclick="return confirm('Are you sure you want exit? Your answers so far will not be recorded!');">Exit</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            <?php endif ?>
        </div>
        <script>
            window.onload = function () {
                var fiveMinutes = <?php echo (int)$_SESSION["timeRemaining"] ?>,
                    display = document.querySelector('#time');
                startTimer(fiveMinutes, display);   
                
                if(<?php echo $pageno ?> !== 10){
                    document.getElementById("hideUntilFinished").style.display = "none";
                }    
            };
            
            function removeWarning() {
                document.getElementById('errorBlock').innerHTML = '';
            }
            
            function test() {
                var radios = document.getElementsByName('q<?php echo $pageno ?>');
                for (var i = 0; i < radios.length; i++)
                {
                    if (radios[i].checked)
                    {
                        var selectedAnswer = document.querySelector('input[class="radio"]:checked').value;
                        var correctAnswer = document.getElementById("answer1").value;
                        var remainingTime = document.getElementById("timerVlaue").value;
                        var remainingTimeText = document.getElementById("time").innerText;
                        if(<?php echo (int)$pageno;?> === 10){
                            document.location.href= "testResult.php?ua=" + selectedAnswer;
                            return;
                        } else {
                            //redirects to next pahe if less than 10
                            if(selectedAnswer === correctAnswer){
                                document.location.href= "<?php if($pageno >= $total_pages){ echo 'test.php#'; } else { echo "test.php?pageno=".($pageno + 1).
                                        "&a=1&tr="; } ?>"+ remainingTime + "&trt=" + remainingTimeText + "&ua=" + selectedAnswer;
                                return;
                            } else {
                                document.location.href= "<?php if($pageno >= $total_pages){ echo 'test.php#'; } else { echo "test.php?pageno=".($pageno + 1).
                                        "&a=0&tr="; } ?>"+ remainingTime + "&trt=" + remainingTimeText + "&ua=" + selectedAnswer;
                                return;
                            }  
                        }
                    }
                }
                document.getElementById('errorBlock').innerHTML = 'Please make a selection!';
            }
            
            function startTimer(duration, display) {
                var timer = duration, minutes, seconds;
                setInterval(function () {
                    //radix
                    minutes = parseInt(timer / 60, 10)
                    seconds = parseInt(timer % 60, 10);
                    //turnery statement, shorthand if statement, left=true, right=false
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = minutes + ":" + seconds;
                    document.getElementById("timerVlaue").value = timer;

                    if (--timer < 0) {
                        timer = duration;
                        document.location.href= "testResult.php?questionsAnswered="+ <?php echo $pageno;?>;
                        <?php $_SESSION['timeExpired'] = 'The timer has expired!';?>
                        return;
                    }
                }, 1000);// 1000 milliseconds
            }
        </script>
    </body>
</html>