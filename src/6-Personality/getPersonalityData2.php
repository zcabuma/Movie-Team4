<?php

$tags = "ALL";

$movieTitle = "ALL";

$openness = 0;
$agreeableness = 0;
$emotionalStability = 0;
$conscientiousness = 0;
$extraversion = 0;

function clean_string_per2($data){
  $listOfStrings =  explode(',', $data);
 $tags = array(); 
 foreach ($listOfStrings as $value){
     $processedValue = SQL_test_input($value);
     $processedValueNew = $processedValue;
     $finalprocessedValueNew =  substr($processedValueNew, 1, -1);
     array_push($tags, $finalprocessedValueNew);
    //  echo $finalprocessedValueNew;
 }
 return $tags;
}


function check_cache_and_query_for_one_row_personality2($part_4_sql, $para_count, $parameters){
  global $mysqli;
  $hashed_query = sha1($part_4_sql . serialize($parameters));
  $pred_rating = array();
  // echo "hashed query is";
  // echo $hashed_query;
  // cache stuff

  $cached_ans = get_from_cache($hashed_query);
  // echo "this is chaches ans";
  // echo $cached_ans;
  if ($cached_ans != ""){
    $pred_rating = $cached_ans;

      // echo "Got from cache"; 
  }
  else{

      $moviestmt = $mysqli->prepare($part_4_sql);
      $moviestmt->bind_param($para_count, ...$parameters); 
      $moviestmt->execute();
      $moviesList = $moviestmt->get_result();
      
      $row = mysqli_fetch_array($moviesList, MYSQLI_ASSOC);


      $pred_rating = $row;
      $arr_cache = array();
      $arr_cache = $row;

      put_to_cache($hashed_query, $arr_cache); 
  }
  return $pred_rating;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $movieId = 0;
    $tags = "";

    $movieTitle = test_input($_POST["movieTitle2"]);
    

    $tagsInput = test_input($_POST["tags2"]);

    if($tagsInput != "All" && $tagsInput != ""){

        $listOfStrings =  explode(',', $tagsInput);

        foreach ($listOfStrings as $value){
            $tags = $tags."'";
            $processedValue = test_input($value);
            $tags = $tags.$processedValue;
            $tags = $tags."'";
            $tags = $tags.",";
        }

        $tags = substr($tags, 0, -1);




    }
    
    // echo $tags;
    if ($tags != ""){
      include 'getExpandedListOfTags.php'; 
      // echo "calling get all tags with";
      // echo $tags;
      $expandedListOfTags = getAllTags($tags);
      // echo "this is expended list of tags";
      // echo $expandedListOfTags;
      // echo gettype($expandedListOfTags);
      // echo "end";

      foreach ($expandedListOfTags as $value){
        echo $value;
        $tagsInputToDisplay = $tagsInputToDisplay . $value . ",";
      }


      $tagsUnprocessed = $tagsInputToDisplay;
      $count = count($expandedListOfTags); 
      // echo "this is count";
      // echo $count;
      $placeholders = implode(',', array_fill(0, $count, '?'));
      $overallCommandToGetPersonalityData = "SELECT SUM(opennessAvg * noMoviesWatched)/SUM(noMoviesWatched) as openness, SUM(agreeablenessAvg * noMoviesWatched)/SUM(noMoviesWatched) as agreeableness, SUM(emotionalStabilityAvg * noMoviesWatched)/SUM(noMoviesWatched) as emotionalStability, AVG(conscientiousnessAvg * noMoviesWatched)/SUM(noMoviesWatched) as conscientiousness, AVG(extraversionAvg * noMoviesWatched)/SUM(noMoviesWatched) as extraversion
      FROM (SELECT DISTINCT personalityRatings.hashedUserID, COUNT(personalityRatings.movieId) as noMoviesWatched, AVG(personalityRatings.rating) as ratingAvg, AVG(personalityType.openness) as opennessAvg, AVG(personalityType.agreeableness) as agreeablenessAvg, AVG(personalityType.emotional_stability) as emotionalStabilityAvg, AVG(personalityType.conscientiousness) as conscientiousnessAvg, AVG(personalityType.extraversion) as extraversionAvg
      FROM (Coursework.personalityRatings
      LEFT JOIN Coursework.personalityType ON personalityRatings.hashedUserID = personalityType.hashedUserID )
      WHERE personalityRatings.movieId IN (SELECT movieId FROM Coursework.tags WHERE tag IN ($placeholders))
      GROUP BY personalityRatings.hashedUserID
      HAVING AVG(personalityRatings.rating) > 4) TMP";
      $bindStr = str_repeat('s', $count);
      $pred_rating = check_cache_and_query_for_one_row_personality2($overallCommandToGetPersonalityData, $bindStr, $expandedListOfTags);
      
  
  
      $openness = $pred_rating["openness"];
      // echo "openness";
      // echo $openness ;
      $agreeableness = $pred_rating["agreeableness"];
      $emotionalStability = $pred_rating["emotionalStability"];
      $conscientiousness = $pred_rating["conscientiousness"];
      $extraversion = $pred_rating["extraversion"];
  
      
      echo "<br><br>";  
      echo "<h2 class=\"title text-center\">Results:</h2>";
      echo "<h4 class=\"title text-center\">Movie Title: $movieTitle</h4>";
      echo "<h4 class=\"title text-center\">Tags: $tagsUnprocessed</h4>";
      echo "<br><br>"; 
      echo "<table style=\"width:100%\" border=\"1\">
      <tr>
        <th style=\"text-align: center; vertical-align: middle;\">Personality Trait</th>
        <th style=\"text-align: center; vertical-align: middle;\">Score</th>
      </tr>
      <tr>
        <td style=\"text-align: center; vertical-align: middle;\">Openness</td>
        <td style=\"text-align: center; vertical-align: middle;\">$openness</td>
      </tr>
      <tr>
        <td style=\"text-align: center; vertical-align: middle;\">Agreeableness</td>
        <td style=\"text-align: center; vertical-align: middle;\">$agreeableness</td>
      </tr>
      <tr>
        <td style=\"text-align: center; vertical-align: middle;\">EmotionalStability</td>
        <td style=\"text-align: center; vertical-align: middle;\">$emotionalStability</td>
      </tr>
      <tr>
        <td style=\"text-align: center; vertical-align: middle;\">Conscientiousness</td>
        <td style=\"text-align: center; vertical-align: middle;\">$conscientiousness</td>
      </tr>
      <tr>
        <td style=\"text-align: center; vertical-align: middle;\">Extraversion</td>
        <td style=\"text-align: center; vertical-align: middle;\">$extraversion</td>
      </tr>
    </table>";
    }
   



}


// function test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
//     $data = trim($data);
//     $data = stripslashes($data);
//     $data = htmlspecialchars($data);
//     return $data;
// }



?>