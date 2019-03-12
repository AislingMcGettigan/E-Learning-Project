<?php
//include db connection
include('config.php');
    // get id variable from the url and assign it to the variable $urlID
    $urlID = $_GET['id'];
    // query that passes in the urlID(urlID is the testID, so this is used to get the questions for the associated test) variable into a query and returns all the questions and answers associated with that test
    $query = "SELECT DISTINCT 
                    t.testName,
                    i.Question,
                    i.option1,
                    i.option2,
                    i.option3,
                    i.option4,
                    i.correctAnswer1
                FROM item i
                    INNER JOIN itemintest iit ON i.QuestionId=iit.QuestionId
                    INNER JOIN tests t ON iit.TestID=t.TestID
                WHERE t.TestID = '$urlID'";
    // execute the above query
    $result = $db->query($query);
?>
