<?php   
    // get group id from the url and assign it to $groupID
    $groupID = $_GET['groupid'];
    // include the db connection
    include('config.php');
    // sql statement which returns the questions, correct answers and the students answers
    // being passed in is the $groupID, this make sure that only data for this test attempt was returned
    $sql = "SELECT "
            . "tr.studentAnswer, "
            . "tr.score, "
            . "it.Question, "
            . "it.CorrectAnswer1 "
            . "FROM testresults tr INNER JOIN "
            . "item it ON it.QuestionID = tr.questionID "
            . "WHERE tr.quizGroupID = $groupID";
    // execture query
    $prev_res_data = mysqli_query($db,$sql);
    // assign data returned to $data for use in previousTestAttempt.php
    $data = mysqli_fetch_assoc($prev_res_data);