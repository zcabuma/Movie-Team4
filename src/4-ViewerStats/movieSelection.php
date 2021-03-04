<?php

$rating = "All";
$movieTitle = "Enter a movie name";
$year = "All";
$movieTitleTag = "Enter a movie name";
$tag = "Enter a tag";
$rating_movieTitle = "Enter a movie name";


$cmd_list = array();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //RATING HANDLER
    $rating = test_input($_POST["rating"]);
    if($rating != "All" && $rating != ""){
        $cmd_ratings = "SELECT movieId 
                        FROM Coursework.ratings
                        WHERE rating = $rating";
        array_push($cmd_list,$cmd_ratings);
    }

    // Handling Post request from trying to search for a specific movie
    $movieTitle = test_input($_POST["movieTitle"]);
    $movieTitle = $movieTitle." ";
    if($movieTitle != "All" && $movieTitle != ""){
        $cmd_movieTitle= "SELECT movieId 
                     FROM Coursework.movies 
                     WHERE title LIKE \"%$movieTitle%\"";
        array_push($cmd_list, $cmd_movieTitle);
    }


    // Handling Post request from trying to search for a specific movie

    $year = test_input($_POST["year"]);
    if($year != "All" && $year != ""){
        $cmd_year = "SELECT movieId 
                        FROM Coursework.movies
                        WHERE year = $year";
        array_push($cmd_list,$cmd_year);
    }



    // Handling Post request from trying to search for a specific movie
    $movieTitleTag = test_input($_POST["movieTitleTag"]);
    $movieTitleTag = $movieTitleTag." ";
    if($movieTitleTag != "All" && $movieTitleTag != ""){
        $cmd_movieTitleTag= "SELECT movieId 
                     FROM Coursework.movies 
                     WHERE title LIKE \"%$movieTitleTag%\"";
        array_push($cmd_list, $cmd_movieTitleTag);
    }

    $rating_movieTitle = test_input($_POST["rating_movieTitle"]);
    $rating_movieTitle = $rating_movieTitle." ";
    if($rating_movieTitle != "All" && $rating_movieTitle != ""){
        $cmd_rating_movieTitle= "SELECT movieId 
                     FROM Coursework.movies 
                     WHERE title LIKE \"%$rating_movieTitle%\"";
        array_push($cmd_list, $cmd_rating_movieTitle);
    }

    // Handling Post request from trying to search for a specific movie
    $tag = test_input($_POST["tag"]);
    if($tag != ""){
        $cmd_tag= "SELECT movieId 
                        FROM Coursework.tags 
                        WHERE tag LIKE \"%$tag%\"";
        array_push($cmd_list, $cmd_tag);
    }

    //FORMING THE SQL QUERIES
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        $count_total_watchers = "SELECT COUNT(userId) as count
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$movieTitle\")
                        ";
        
        //This movie list has movies that will be displayed on the grid. 
        $total_watchers = $mysqli->query($count_total_watchers);
        // print_r($moviesList." hehe");
    }

    //get count of users based on rating
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        if ($rating !="All" && $rating != ""){
        $displaycountCommand = "SELECT COUNT(userId) as count
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$movieTitle\")
                        AND rating = $rating";
                        
        
        $displaycountUsers = $mysqli->query($displaycountCommand);
        // print_r($moviesList." hehe");
                        }
    }
    //get all user ids
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        $displayUsersCommand = "SELECT userId as ids, rating
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title LIKE \"$movieTitle\")
                        ";
        if ($rating !="All" && $rating != ""){
            $displayUsersCommand = $displayUsersCommand . "AND rating = $rating";
        }
        
        //This movie list has movies that will be displayed on the grid. 
        $displayUsers = $mysqli->query($displayUsersCommand);
        // print_r($moviesList." hehe");
    }

    //get all user tags
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        $displaytagCommand = "SELECT  tag, Count(userId) as count_users
        FROM Coursework.tags 
        WHERE movieId IN (
        SELECT movieId 
        FROM Coursework.movies
        WHERE title = \"$movieTitle\"
        )
        GROUP BY tag";
        //This movie list has movies that will be displayed on the grid. 
        $displaytag = $mysqli->query($displaytagCommand);
        // print_r($moviesList." hehe");
    }

    //get all users by years
    if($year !="All" && $year != ""){
        if(count($cmd_list) != 0){
            
            $displayUsersbyYearsCommand = "SELECT DISTINCT userId as ids
            FROM Coursework.ratings 
            WHERE movieId 
            IN (SELECT movieId 
            FROM Coursework.movies 
            WHERE year = $year)
                            ";

            
            // print_r($displayUsersbyYearsCommand);
            $displayUsersbyYears = $mysqli->query($displayUsersbyYearsCommand);
        }
    }

    //get all users by years
    if($tag != ""){
        if(count($cmd_list) != 0){
            if($movieTitleTag != " "){
                $displayUsersbyTagsMovieCommand = "SELECT userId as users 
                FROM Coursework.tags  
                WHERE tag LIKE \"$tag\" 
                AND movieId 
                IN ( SELECT movieId 
                FROM Coursework.movies 
                WHERE title LIKE \"%$movieTitleTag%\")";    
                                // print_r($displayUsersbyTagsMovieCommand);
   
                $displayUsersbyTagsMovie = $mysqli->query($displayUsersbyTagsMovieCommand); 
            }
            else{
                
                $displayUsersbyTagsCommand = "SELECT userId as users ,title 
                FROM Coursework.tags JOIN Coursework.movies 
                WHERE tag LIKE \"$tag\" 
                ORDER BY userId
                ";
                // print_r($displayUsersbyTagsCommand);
                $displayUsersbyTags = $mysqli->query($displayUsersbyTagsCommand);
                }
            
        }
    }

    //segregation by tags
    if(count($cmd_list) != 0 && ($rating_movieTitle != " ")){
        
        $ratingLE1_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$rating_movieTitle\")
                        AND rating < 1 ";

        echo "$ratingLE1_cmd";

        $ratingBET12_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$rating_movieTitle\")
                        AND rating BETWEEN 1 AND 2 ";

        $ratingBET23_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$rating_movieTitle\")
                        AND rating BETWEEN 2 AND 3 ";

        $ratingEQ3_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$rating_movieTitle\")
                        AND rating = 3 ";
        
        $ratingBET34_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$rating_movieTitle\")
                        AND rating BETWEEN 3 AND 4 ";
        
        $ratingGE4_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$rating_movieTitle\")
                        AND rating > 4 ";
                        
        
        $ratingLE1 = $mysqli->query($ratingLE1_cmd);
        $ratingBET12 = $mysqli->query($ratingBET12_cmd);
        $ratingBET23 = $mysqli->query($ratingBET23_cmd);
        $ratingEQ3 = $mysqli->query($ratingEQ3_cmd);
        $ratingBET34 = $mysqli->query($ratingBET34_cmd);
        $ratingGE4 = $mysqli->query($ratingGE4_cmd);
                     
    }

}
else{
    $getAllMovies = "SELECT * FROM Coursework.movies LIMIT 21";
    $countUsers = $mysqli->query($getAllMovies);
}

function test_input($data) { 
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>


