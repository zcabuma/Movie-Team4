<?php
include 'configDB.php';
include 'Cache.php';

function SQL_test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function check_cache_and_query_for_one_row_pred_rating($part_4_sql){
    global $mysqli;
    $hashed_query = md5($part_4_sql); 
    $pred_rating = "";
    echo "hashed query is";
    echo $hashed_query;
    // cache stuff
    $cached_ans = get_from_cache($hashed_query);
    if ($cached_ans != ""){
        //$pred_rating = $cached_ans['AVG(rating)']; 
        $pred_rating = $cached_ans['AVG(rating)']; 
        echo "This is what I got from cache"; 
        echo $pred_rating; 
        echo "Got from cache"; 
    }
    else{
        $avg_result = $mysqli->query($part_4_sql);
        $row = mysqli_fetch_assoc($avg_result); 
        // creating cache array
        $arr_cache = array();
        $pred_rating = $row['AVG(rating)'];
        $arr_cache['AVG(rating)'] = $pred_rating;
        // adding to cache
        put_to_cache($hashed_query, $arr_cache);
    }
    return $pred_rating;
}


function clean_string($data){
    $listOfStrings =  explode(',', $data);
    $tags = "";
    foreach ($listOfStrings as $value){
        $tags = $tags."'";
        $processedValue = SQL_test_input($value);
        $tags = $tags.$processedValue;
        $tags = $tags."'";
        $tags = $tags.",";
    }

    $tags = substr($tags, 0, -1);
    return $tags;
}

function get_average_from_string_ratings($data){
    $integer_array = array_map('intval', explode(',', $data));
    $average = array_sum($integer_array) / count($integer_array); 
    return $average;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $movieTitle = SQL_test_input($_POST["movieTitle_r"]);
     $year = SQL_test_input($_POST["year_r"]);
     if($movieTitle != "" && $year != ""){
        $part_4_sql = "SELECT AVG(rating)
        FROM (SELECT AVG(rating) as rating
        FROM Coursework.tags
        JOIN Coursework.ratings on Coursework.ratings.movieId = Coursework.tags.movieId
        WHERE Coursework.tags.tag in (SELECT DISTINCT tag 
        FROM Coursework.tags
        WHERE movieId = (SELECT movieId 
        FROM Coursework.movies
        WHERE title LIKE '%$movieTitle%' AND year = $year)) 
        GROUP BY Coursework.tags.movieId) TMP;"; 
        $pred_rating  = check_cache_and_query_for_one_row_pred_rating($part_4_sql);
        
        //cache stuff done

        if (is_null($pred_rating)){
            $part_4_sql = "SELECT AVG(rating)
            FROM Coursework.ratings
            JOIN Coursework.movies on Coursework.movies.movieId = Coursework.ratings.movieId
            WHERE Coursework.ratings.movieId = (SELECT movieId 
            FROM Coursework.movies
            WHERE title LIKE '%$movieTitle%' AND year = $year)"; 
            $pred_rating = check_cache_and_query_for_one_row_pred_rating($part_4_sql);
        }

        $final_pred = $pred_rating;

        echo "<br><br>"; 
        echo "<h2 class=\"title text-center\">Results:</h2>";
        echo "<h4 class=\"title text-center\">Movie Title: $movieTitle</h4>";
        echo "<h4 class=\"title text-center\">Predicted Rating: $final_pred</h4>";
        echo "<br><br>"; 

     }
     else{
        $movieTitle = SQL_test_input($_POST["movieTitle_n"]);
        $year = SQL_test_input($_POST["year_n"]);
        $tags = SQL_test_input($_POST["tags_n"]);

        if ($movieTitle != "" && $year != "" && $tags != "" ){
            $tags = clean_string($tags);
            $part_4_sql = "SELECT AVG(rating)
            FROM (SELECT AVG(rating) as rating
            FROM Coursework.tags
            JOIN Coursework.ratings on Coursework.ratings.movieId = Coursework.tags.movieId
            WHERE Coursework.tags.tag in ($tags)
            GROUP BY Coursework.tags.movieId) TMP;"; 
            $pred_rating = check_cache_and_query_for_one_row_pred_rating($part_4_sql);

            // average result with ratings we get from the peer review
            $ratings = SQL_test_input($_POST["ratings_n"]);
            if ($ratings != ""){
                $avg_rating = get_average_from_string_ratings($ratings); 
                if ($pred_rating == NULL){
                    $pred_rating = $avg_rating;
                }
                else{
                    $pred_rating = ($avg_rating + $pred_rating) / 2; 
                }
            }

            echo "<br><br>"; 
            echo "<h2 class=\"title text-center\">Results:</h2>";
            echo "<h4 class=\"title text-center\">Movie Title: $movieTitle</h4>";
            echo "<h4 class=\"title text-center\">Tags: $tags</h4>";
            echo "<h4 class=\"title text-center\">Predicted Rating: $pred_rating</h4>";
            echo "<br><br>"; 
        }
     
     }

}
?>
