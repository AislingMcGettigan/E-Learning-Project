<?php
    include('config.php');
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
    //10 useranswer hardcoded as no pageload after 10q, so redirect to resultspage, cant get to rsult without answering 10q
    //store ans 1 when page reloaded to show q2
    if (isset($_GET['ua'])){
        $_SESSION["10UserAnswer"] = (string)$_GET['ua'];
    }
    $questionsAnswered = 10;
    if (isset($_GET['questionsAnswered'])){
        //arrays start at 0, so we decsrement the question answered by 1 to 9.
        $questionsAnswered = ((int)$_GET['questionsAnswered'] - 1);
    }
    $studentID = $_SESSION['userId'];
    $testID = $_SESSION['quizID'];
    $quizGroupID = $_SESSION['groupID'];
    //looping over so dont have to write insert statement 10 times
    for($i = 1; $i <= $questionsAnswered; $i++) {
        //i.questionId = 1questionId, 2questionId, 3questionId..concatation
        $questionID = $_SESSION[$i.'QuestionID'];
        $studentAnswer = $_SESSION[$i.'UserAnswer'];
        $score = $_SESSION['score'];
        $query = "INSERT INTO `testresults`(`studentID`, `questionID`, `studentAnswer`, `score`, `dateTimeOfTest`, `testID`, `quizGroupID`)"
                . "VALUES ('$studentID','$questionID','$studentAnswer','$score',NOW(),'$testID','$quizGroupID')";
        mysqli_query($db, $query);    
    }
    

