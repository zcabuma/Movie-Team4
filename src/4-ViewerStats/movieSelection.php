<?php

$rating = "All";
$movietitle = "Enter a movie name";

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

    //FORMING THE SQL QUERIES
    //get count of users
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        $displaycountCommand = "SELECT COUNT(userId) as count
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$movieTitle\")
                        ";
        if ($rating !="All" && $rating != ""){
            $displaycountCommand = $displaycountCommand . "AND rating = $rating";
        }
        
        //This movie list has movies that will be displayed on the grid. 
        $displaycountUsers = $mysqli->query($displaycountCommand);
        // print_r($moviesList." hehe");
    }
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        $displayUsersCommand = "SELECT userId as ids
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = \"$movieTitle\")
                        ";
        if ($rating !="All" && $rating != ""){
            $displayUsersCommand = $displayUsersCommand . "AND rating = $rating";
        }
        
        //This movie list has movies that will be displayed on the grid. 
        $displayUsers = $mysqli->query($displayUsersCommand);
        // print_r($moviesList." hehe");
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


