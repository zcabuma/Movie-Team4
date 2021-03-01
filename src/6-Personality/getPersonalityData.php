<?php

$tags = "ALL";

$movieTitle = "ALL";

$openness = 0;
$agreeableness = 0;
$emotionalStability = 0;
$conscientiousness = 0;
$extraversion = 0;



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $movieId = 0;
    $tags = "";

    $movieTitle = test_input($_POST["movieTitle"]);
    
    if($movieTitle != "All" && $movieTitle != ""){

        $movieTitleChanged = "$movieTitle ";
        $movieIDQuery = "SELECT movieId 
                        FROM Coursework.movies 
                        WHERE title = ?";
        $stmt = $mysqli->prepare($movieIDQuery);
        $stmt->bind_param("s", $movieTitleChanged);
        $stmt->execute();

        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $movieId = $row_result['movieId'];

        // echo $movieId;


    }



    $tagsInput = test_input($_POST["tags"]);

    if($tagsInput != "All" && $tagsInput != ""){

        $listOfStrings =  explode(',', $tagsInput);

        foreach ($listOfStrings as $value){
            $tags = $tags."'";
            $tags = $tags.$value;
            $tags = $tags."'";
            $tags = $tags.",";
        }

        $tags = substr($tags, 0, -1);




    }
    
    // echo $tags;

    $overallCommandToGetPersonalityData = "SELECT SUM(opennessAvg * noMoviesWatched)/SUM(noMoviesWatched) as openness, SUM(agreeablenessAvg * noMoviesWatched)/SUM(noMoviesWatched) as agreeableness, SUM(emotionalStabilityAvg * noMoviesWatched)/SUM(noMoviesWatched) as emotionalStability, AVG(conscientiousnessAvg * noMoviesWatched)/SUM(noMoviesWatched) as conscientiousness, AVG(extraversionAvg * noMoviesWatched)/SUM(noMoviesWatched) as extraversion
    FROM (SELECT DISTINCT personalityRatings.hashedUserID, COUNT(moviesGenres.movieId) as noMoviesWatched, AVG(personalityRatings.rating) as ratingAvg, AVG(personalityType.openness) as opennessAvg, AVG(personalityType.agreeableness) as agreeablenessAvg, AVG(personalityType.emotional_stability) as emotionalStabilityAvg, AVG(personalityType.conscientiousness) as conscientiousnessAvg, AVG(personalityType.extraversion) as extraversionAvg
    FROM ((Coursework.personalityRatings
    LEFT JOIN Coursework.personalityType ON personalityRatings.hashedUserID = personalityType.hashedUserID )
    LEFT JOIN Coursework.moviesGenres ON  personalityRatings.movieId = moviesGenres.movieId )
    WHERE moviesGenres.genreId IN (SELECT genreId FROM Coursework.moviesGenres WHERE movieId IN (SELECT movieId FROM Coursework.tags WHERE tag IN ($tags) OR movieId = $movieId))
    GROUP BY personalityRatings.hashedUserID
    HAVING AVG(personalityRatings.rating) > 4) TMP";


    $result = $mysqli->query($overallCommandToGetPersonalityData);

    $row_result = mysqli_fetch_assoc($result);

    $openness = $row_result["openness"];
    $agreeableness = $row_result["agreeableness"];
    $emotionalStability = $row_result["emotionalStability"];
    $conscientiousness = $row_result["conscientiousness"];
    $extraversion = $row_result["extraversion"];

    
    echo "<br><br>";  
    echo "<h2 class=\"title text-center\">Results:</h2>";
    echo "<h4 class=\"title text-center\">Movie Title: $movieTitle</h4>";
    echo "<h4 class=\"title text-center\">Tags: $tags</h4>";
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


function test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



?>