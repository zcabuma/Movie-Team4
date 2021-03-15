<?php

$rating = "All";
$movieTitle = "Enter a movie name";
$year = "All";
$movieTitleTag = "Enter a movie name";
$tag = "Enter a tag";
$rating_movieTitle = "Enter a movie name";
$tag_movieTitle = "Enter a movie name";


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

    $tag_movieTitle = test_input($_POST["tag_movieTitle"]);
    $tag_movieTitle = $tag_movieTitle." ";
    if($tag_movieTitle != "All" && $tag_movieTitle != " "){
        $cmd_tag_movieTitle= "SELECT movieId 
                     FROM Coursework.movies 
                     WHERE title LIKE \"%$tag_movieTitle%\"";
        array_push($cmd_list, $cmd_tag_movieTitle);
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
    if(count($cmd_list) != 0 && ($movieTitle != "") && ($movieTitle != " ")){
        $count_total_watchers = "SELECT COUNT(userId) as count
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        ";
        
        //This movie list has movies that will be displayed on the grid. 
        echo "protecting!!";
        $moviestmt = $mysqli->prepare($count_total_watchers);

        $parameters = array();
        array_push($parameters, "$movieTitle");

        $moviestmt->bind_param("s", ...$parameters); //... allows us to pass an array
        
        $moviestmt->execute();

        $total_watchers = $moviestmt->get_result();

        // $total_watchers = $mysqli->query($count_total_watchers);
        // print_r($moviesList." hehe");
    }
    else{
        $count_total_watchers = "SELECT COUNT(userId) as count
                        FROM Coursework.ratings 
                        WHERE movieId 
                        ";
        
        //This movie list has movies that will be displayed on the grid. 
        $total_watchers = $mysqli->query($count_total_watchers);
        // print_r($moviesList." hehe");
    }

    //get count of users based on rating
    if(count($cmd_list) != 0 && ($movieTitle != "") && ($movieTitle != " ")){
        if ($rating !="All" && $rating != ""){
        $displaycountCommand = "SELECT COUNT(userId) as count
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        AND rating = ?";
                        echo "protecting 2";

                        $moviestmt = $mysqli->prepare($displaycountCommand);

                        $parameters = array();
                        array_push($parameters, "$movieTitle");
                        array_push($parameters, $rating);
                
                        $moviestmt->bind_param("si", ...$parameters); //... allows us to pass an array
                        
                        $moviestmt->execute();
                
                        $displaycountUsers = $moviestmt->get_result();


        // $displaycountUsers = $mysqli->query($displaycountCommand);
        // print_r($moviesList." hehe");
                        }
    }
    else{
        if ($rating !="All" && $rating != ""){
            $displaycountCommand = "SELECT COUNT(userId) as count
                            FROM Coursework.ratings 
                            WHERE rating = ?";
                            
                            $moviestmt = $mysqli->prepare($displaycountCommand);

                            $parameters = array();
                            array_push($parameters, $rating);
                    
                            $moviestmt->bind_param("i", ...$parameters); //... allows us to pass an array
                            
                            $moviestmt->execute();
                    
                            $displaycountUsers = $moviestmt->get_result();


            // $displaycountUsers = $mysqli->query($displaycountCommand);
            // print_r($moviesList." hehe");
                            }
    }
    //get all user ids
    if(count($cmd_list) != 0){
        $placeHolders = "";
        $datatype = "";
        $parameters = array();
        $entered = false;
        if($movieTitle != "" && $movieTitle != " " && $movieTitle != NULL){
            // echo "1";
            $entered = true;
            $displayUsersCommand = "SELECT userId as ids, rating, movieId
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title LIKE ?)
                        ";
                        $placeHolders = $placeHolders . "?";
                        $datatype = $datatype . "s";
                        array_push($parameters, $movieTitle);
            if ($rating !="All" && $rating != ""){
                $displayUsersCommand = $displayUsersCommand . "AND rating = ?";
                $placeHolders = $placeHolders . "?";
                $datatype = $datatype . "i";
                array_push($parameters, $rating);
            }
            
        }
        else{
            $entered = true;
            // echo "2";
            $displayUsersCommand = "SELECT userId as ids, rating, movieId
                        FROM Coursework.ratings";
            if ($rating !="All" && $rating != ""){
                $displayUsersCommand = $displayUsersCommand . " WHERE rating = ?";
                $placeHolders = $placeHolders . "?";
                $datatype = $datatype . "i";
                array_push($parameters, $rating);
            }
            // echo $displayUsersCommand;
        }
        if(count($parameters) !== 0){
            echo "protecting3";
            echo $displayUsersCommand;
            echo $datatype;
            echo  count($parameters);
            foreach ($parameters as $val){
                echo $val;
            }
            //This movie list has movies that will be displayed on the grid.
            $moviestmt = $mysqli->prepare($displayUsersCommand);
    
            $moviestmt->bind_param($datatype, ...$parameters); //... allows us to pass an array
                                
            $moviestmt->execute();
                        
            $displayUsers = $moviestmt->get_result();
            echo "result";
            echo $displaycountUsers->error_log;
                                
                                
            // $displayUsers = $mysqli->query($displayUsersCommand);
            // print_r($moviesList." hehe");
        }
        else{
            $displayUsers = $mysqli->query($displayUsersCommand);
        }
        
    }

    //get all user tags
    if(count($cmd_list) != 0 && ($movieTitle != "")){
        $displaytagCommand = "SELECT  tag, Count(userId) as count_users
        FROM Coursework.tags 
        WHERE movieId IN (
        SELECT movieId 
        FROM Coursework.movies
        WHERE title = ?
        )
        GROUP BY tag";
        echo "protecting4";
        $moviestmt = $mysqli->prepare($displaytagCommand);

        $parameters = array();
        array_push($parameters, $movieTitle);

        $moviestmt->bind_param("s", ...$parameters); //... allows us to pass an array

        $moviestmt->execute();

        $displaytag = $moviestmt->get_result();



        //This movie list has movies that will be displayed on the grid. 
        // $displaytag = $mysqli->query($displaytagCommand);
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
                WHERE tag LIKE ? 
                AND movieId 
                IN ( SELECT movieId 
                FROM Coursework.movies 
                WHERE title LIKE ?)";    
                                // print_r($displayUsersbyTagsMovieCommand);
                echo "protecting 5";
        $moviestmt = $mysqli->prepare($displayUsersbyTagsMovieCommand);

        $parameters = array();
        array_push($parameters, $tag);
        array_push($parameters, $movieTitleTag);

        $moviestmt->bind_param("ss", ...$parameters); //... allows us to pass an array

        $moviestmt->execute();

        $displayUsersbyTagsMovie = $moviestmt->get_result();

                // $displayUsersbyTagsMovie = $mysqli->query($displayUsersbyTagsMovieCommand); 
            }
            else{
                
                $displayUsersbyTagsCommand = "SELECT userId as users ,title 
                FROM Coursework.tags JOIN Coursework.movies 
                WHERE tag LIKE ?
                ORDER BY userId
                ";

echo "protecting 6";
$moviestmt = $mysqli->prepare($displayUsersbyTagsCommand);

$parameters = array();
array_push($parameters, $tag);

$moviestmt->bind_param("s", ...$parameters); //... allows us to pass an array

$moviestmt->execute();

$displayUsersbyTags = $moviestmt->get_result();

                // print_r($displayUsersbyTagsCommand);
                // $displayUsersbyTags = $mysqli->query($displayUsersbyTagsCommand);
                }
            
        }
    }

    //segregation by tags
    if(count($cmd_list) != 0 && ($rating_movieTitle != " ")){

        $parameters = array();
        
        $ratingLE1_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        AND rating <= 1 ";


        $ratingBET12_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        AND rating BETWEEN 1.1 AND 2.0 ";

        $ratingBET23_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        AND rating BETWEEN 2.1 AND 3 ";
                        // array_push($parameters, $rating_movieTitle);

        $ratingEQ3_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        AND rating BETWEEN 3.1 AND 4";
                        // array_push($parameters, $rating_movieTitle);
        
        $ratingBET34_cmd = "SELECT userId 
                        FROM Coursework.ratings 
                        WHERE movieId IN ( 
                        SELECT movieId 
                        FROM Coursework.movies
                        WHERE title = ?)
                        AND rating BETWEEN 4.1 AND 5 ";
                        // array_push($parameters, $rating_movieTitle);
        
                        
                        echo "protecting 7";

                        $moviestmt = $mysqli->prepare($ratingLE1_cmd);
                        
                        
                        $moviestmt->bind_param("s", $rating_movieTitle); //... allows us to pass an array
                        
                        $moviestmt->execute();
                        
                        $ratingLE1 = $moviestmt->get_result();



                        $moviestmt = $mysqli->prepare($ratingBET12_cmd);
                        
                        $moviestmt->bind_param("s", $rating_movieTitle); //... allows us to pass an array
                        
                        $moviestmt->execute();
                        
                        $ratingBET12 = $moviestmt->get_result();


                        $moviestmt = $mysqli->prepare($ratingBET23_cmd);
                        
                        $moviestmt->bind_param("s", $rating_movieTitle); //... allows us to pass an array
                        
                        $moviestmt->execute();
                        
                        $ratingBET23 = $moviestmt->get_result();



                        $moviestmt = $mysqli->prepare($ratingEQ3_cmd);
                        
                        $moviestmt->bind_param("s", $rating_movieTitle); //... allows us to pass an array
                        
                        $moviestmt->execute();
                        
                        $ratingEQ3 = $moviestmt->get_result();




                        $moviestmt = $mysqli->prepare($ratingBET34_cmd);
                        
                        $moviestmt->bind_param("s", $rating_movieTitle); //... allows us to pass an array
                        
                        $moviestmt->execute();
                        
                        $ratingBET34 = $moviestmt->get_result();



        // $ratingLE1 = $mysqli->query($ratingLE1_cmd);
        // $ratingBET12 = $mysqli->query($ratingBET12_cmd);
        // $ratingBET23 = $mysqli->query($ratingBET23_cmd);
        // $ratingEQ3 = $mysqli->query($ratingEQ3_cmd);
        // $ratingBET34 = $mysqli->query($ratingBET34_cmd);
                     
    }

    if(count($cmd_list) != 0 && ($tag_movieTitle != " ")){
        

        $displaytagSegCommand = "SELECT  tag
        FROM Coursework.tags 
        WHERE movieId IN (
        SELECT movieId 
        FROM Coursework.movies
        WHERE title = ?
        )
        GROUP BY tag";

        echo "protecting8";
        //This movie list has movies that will be displayed on the grid. 
        $moviestmt = $mysqli->prepare($displaytagSegCommand);

        $parameters = array();
        array_push($parameters, $tag_movieTitle);

        $moviestmt->bind_param("s", ...$parameters); //... allows us to pass an array

        $moviestmt->execute();

        $displaytagSeg = $moviestmt->get_result();



        // $displaytagSeg = $mysqli->query($displaytagSegCommand);

        
                     
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


