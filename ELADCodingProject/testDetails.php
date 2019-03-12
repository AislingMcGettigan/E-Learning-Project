<?php   
    $TestID = $_GET['id'];
    $studentID = $_SESSION['userId'];
    
    include('config.php');
    
    $sql = "SELECT TestName"
            . ", TestTopic"
            . ", TestDescription "
            . "FROM tests "
            . "WHERE TestID = $TestID "
            . "LIMIT 1";
    $res_data = mysqli_query($db,$sql);
    
    $previousSql = "SELECT "
            . "`studentID`, "
            . "`score`, "
            . "`dateTimeOfTest`, "
            . "`testID`, "
            . "`quizGroupID` "
            . "FROM `testresults` "
            . "WHERE testID = '$TestID' "
            . "AND studentID = '$studentID' "
            . "GROUP BY quizGroupID";
            
            //average score
    $scoreSql = "SELECT "
            . "`studentID`, "
            . "`score`, "
            . "`dateTimeOfTest`, "
            . "`testID`, "
            . "`quizGroupID` "
            . "FROM `testresults` "
            . "WHERE testID = '$TestID' "
            . "GROUP BY quizGroupID";
    $prev_res_data = mysqli_query($db,$previousSql);
    $score_data = mysqli_query($db,$scoreSql);
    $numOfRows = (int)mysqli_num_rows($score_data);
    $summedScore = 0;
    //loop
    while($scoreRow = mysqli_fetch_array($score_data)){
        $summedScore = $summedScore + $scoreRow['score'];
    }
    $averageScore = (float)$summedScore/(float)$numOfRows;