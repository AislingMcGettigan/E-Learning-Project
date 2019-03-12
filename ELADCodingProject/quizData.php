<?php
    // including config page for db connection
    include('config.php'); 

    // if checks if there is a page number being passed through the url
    if (isset($_GET['pageno'])) {
        // set url page number to local variable $pageno
        // it initiliase the local variable $pageno to be the value being passed in the url ($_GET['pageno'])
        $pageno = $_GET['pageno'];
        // setting the session variable = to the session variable + the a variable from the url
        // example score is already 3 and user gets answer correct making a = 1 
        $_SESSION["score"] = (int)$_SESSION["score"] + (int)$_GET['a'];
        // getting time remaining from url variable tr and setting to session variable timeRemaining
        $_SESSION["timeRemaining"] = (int)$_GET['tr'];
        // set initiale display variable (trt) from url variable timeRemainingTitle
        $_SESSION["timeRemainingTitle"] = (string)$_GET['trt'];
        // allows all users answers to be stored in unique variables, without creating unique variable names 
        // each time the users answer wold be overwritten
        $_SESSION[($pageno-1)."UserAnswer"] = (string)$_GET['ua'];
    } else {
        // this will only apply when the first question is loaded
        // sets the pageno variable to 1 to start off with
        $pageno = 1;
        // set score to 0 when first question loads
        $_SESSION["score"] = 0;
        // set timeRemaining to 1200 (seconds) when first question loads
        $_SESSION["timeRemaining"] = 1200;
        // set timeRemainingTitle to "20:00" when first question loads (javascript does the timer)
        $_SESSION["timeRemainingTitle"] = "20:00";
        
        // query to get newest test group, groups users answers together
        // user can have multiple testGroupIDs
        $sql = "SELECT `testGroupID` FROM `testgroup`";

        // execute query
        $groupIdQuery = mysqli_query($db,$sql);

        // get id from query result set
        $groupId = mysqli_fetch_array($groupIdQuery);

        // set session variable groupID = $groupId
        $_SESSION['groupID'] = $groupId['testGroupID'];

        // create $incrementGroupID variable and set = session variable groupID + 1
        $incrementGroupID = (int)$_SESSION['groupID'] + 1;

        // update statement incremnets testGroupID by one so that all testGroupIDs are unique
        $query = "UPDATE `testgroup` SET `testGroupID`= '$incrementGroupID'";

        // execute query
        mysqli_query($db, $query);
    }  

    // sets questions per page(pagination) to one
    $no_of_records_per_page = 1;
    $offset = ($pageno-1) * $no_of_records_per_page;
    $total_pages = 10;

    // if statement checks if id is set (isset()) in the url
    if(isset($_GET['id'])){
        // set quizid = to test from the url
        $_SESSION['quizID'] = $_GET['id'];
    }
    $quizID = $_SESSION['quizID'];
    // if statment checks if session var usedId doesnt exist,
    //initilising variable so no duplicates are included in questions
    if(!isset($_SESSION['usedIDs'])){
        $_SESSION['usedIDs'] = "0";
    }
    $uids = $_SESSION['usedIDs'];
    $sql = "SELECT i.QuestionID"
            . ", i.Question"
            . ", i.Option1"
            . ", i.Option2"
            . ", i.Option3"
            . ", i.Option4"
            . ", i.CorrectAnswer1"
            . ", i.CorrectAnswer2 "
            . "FROM item i "
            . "INNER JOIN itemintest iit ON i.QuestionID and iit.QuestionID "
            . "WHERE iit.TestID = $quizID "
            . "AND i.QuestionID NOT IN ($uids)"
            . "ORDER BY RAND() "
            . "LIMIT $offset, $no_of_records_per_page";
    $res_data = mysqli_query($db,$sql);
    if($quizID == 1){
        $quizTitle = "JavaScript Quiz";
    } else {
        $quizTitle = "HTML Quiz";
    }
