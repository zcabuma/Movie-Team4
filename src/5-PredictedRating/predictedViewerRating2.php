<?php
include 'configDB.php';
include 'Cache.php';

function SQL_test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function check_cache_and_query_for_one_row_pred_rating($part_4_sql, $para_count, $parameters){
    global $mysqli;
    $hashed_query = sha1($part_4_sql . serialize($parameters));
    $pred_rating = "";
    //echo "hashed query is";
    //echo $hashed_query;
    // cache stuff
    $cached_ans = get_from_cache($hashed_query);
    if ($cached_ans != ""){
        $pred_rating = $cached_ans['AVG(rating)']; 
        echo "Got from cache"; 
    }
    else{
        $moviestmt = $mysqli->prepare($part_4_sql);

        $moviestmt->bind_param($para_count, ...$parameters); //... allows us to pass an array
        
        $moviestmt->execute();

        $moviesList = $moviestmt->get_result();
        $row = mysqli_fetch_array($moviesList, MYSQLI_ASSOC);
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
    $tags = array(); 
    foreach ($listOfStrings as $value){
        $processedValue = SQL_test_input($value);
        array_push($tags, $processedValue);
    }
    return $tags;
}

function get_ratings_based_on_user_history( $userIds, $ratings){
    $total_past_rating = 0;
    $curr_count = 0;
    for($i=0; $i<count($userIds); $i++) {
        $part_5_sql_user_hist = "SELECT AVG(rating)
        FROM (
        Select m.avg_rating as rating
        FROM Coursework.movies as m
        WHERE m.movieId in (
        SELECT r.movieId
        FROM Coursework.ratings as r
        WHERE userId = ? and rating = ?)
        ) as temp; "; 
        $parameters = array();
        array_push($parameters, $userIds[$i]); 
        array_push($parameters,$ratings[$i] ); 
        $curr = check_cache_and_query_for_one_row_pred_rating($part_5_sql_user_hist, "ii", $parameters);
        if ($curr != 0 && $curr != ""){$curr_count = $curr_count + 1; }
        $total_past_rating += $curr;
    }
    $avg_user_rating = $total_past_rating / count($userIds); 
    echo "Finally avg user rating is"; 
    echo $avg_user_rating; 
    return $avg_user_rating;
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
        WHERE title LIKE ? AND year = ?) and rand() < .5) 
        GROUP BY Coursework.tags.movieId) TMP;"; 
        $para_count = "si"; 
        $movieTitle_changed = "%$movieTitle%";
        $parameters = array();
        array_push($parameters, $movieTitle_changed); 
        array_push($parameters, $year); 
        $pred_rating  = check_cache_and_query_for_one_row_pred_rating($part_4_sql, $para_count, $parameters); 
        //cache stuff done

        if (is_null($pred_rating)){
            $part_4_sql = "SELECT AVG(rating)
            FROM Coursework.ratings
            JOIN Coursework.movies on Coursework.movies.movieId = Coursework.ratings.movieId
            WHERE Coursework.ratings.movieId = (SELECT movieId 
            FROM Coursework.movies
            WHERE title LIKE ? AND year = ?)"; 
            $pred_rating = check_cache_and_query_for_one_row_pred_rating($part_4_sql, $para_count, $parameters);
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
        $userIds = SQL_test_input($_POST["users_n"]);

        if ($movieTitle != "" && $year != "" && $tags != "" && $userIds != ""){
            $tags = clean_string($tags);
            $userIds = clean_string($userIds);
            $count = count($tags); 
            $placeholders = implode(',', array_fill(0, $count, '?'));
            $part_4_sql = "SELECT AVG(rating)
            FROM (SELECT AVG(rating) as rating
            FROM Coursework.tags
            JOIN Coursework.ratings on Coursework.ratings.movieId = Coursework.tags.movieId
            WHERE Coursework.tags.tag in ($placeholders)
            GROUP BY Coursework.tags.movieId) TMP;";  
            $bindStr = str_repeat('s', $count);
            $pred_rating = check_cache_and_query_for_one_row_pred_rating($part_4_sql, $bindStr, $tags);

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
            $ratings = clean_string($ratings);
            $pred_rating = ($pred_rating + get_ratings_based_on_user_history($userIds, $ratings)) / 2; 

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
