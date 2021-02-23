<?php 

   
$genre = "All";
$rating = "All";
$movieTitle = "All";
$idNo = null; 
// this array builds up queries for genre and rating related filters (is not used for statistics filter)
$listOfCommands = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Handling Post request from genre filter 
    $genre = test_input($_POST["genre"]);
    if($genre != "All" && $genre != ""){
        
        $genreIDQuery = "SELECT genreID FROM Coursework.genres WHERE genre LIKE \"%$genre%\"";
        $genreID = $mysqli->query($genreIDQuery);
        
        $row_result = mysqli_fetch_assoc($genreID);
        $idNo = $row_result['genreID'];;
        
        $commandForGenre = "SELECT movieID 
                            FROM Coursework.moviesGenres 
                            WHERE genreID=$idNo";
        array_push($listOfCommands, $commandForGenre);
    }

    // Handling Post request from rating filter 
    $rating = test_input($_POST["rating"]);
    if($rating != "All" && $rating != ""){
        $commandForRatings = "SELECT movieId 
                                FROM Coursework.ratings 
                                WHERE rating=$rating";
        array_push($listOfCommands, $commandForRatings);
    }

    // Handling Post request from trying to search for a specific movie
    $movieTitle = test_input($_POST["movieTitle"]);
    if($movieTitle != "All" && $movieTitle != ""){
        $commandForMovieTitle= "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE title LIKE \"%$movieTitle%\"";
        array_push($listOfCommands, $commandForMovieTitle);
    }

    // Handling Post request from trying to search for movies absed on start year
    $startYear = test_input($_POST["start"]);
    if($startYear != ""){
        $commandForStart = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE year >= $startYear";
        array_push($listOfCommands, $commandForStart);
    }

    // Handling Post request from trying to search for movies based on end year
    $endYear = test_input($_POST["end"]);
    if($endYear != ""){
        $commandForEnd = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE year <= $endYear";
        array_push($listOfCommands, $commandForEnd);
    }

     // Handling Post request from statistics filter 
    $statistic = test_input($_POST["statistics"]);
    if ($statistic == "popular" || $statistic == "polarizing"){
        // query to get most popular movies
        if ($statistic == "popular"){
            $popular_movies = "SELECT COUNT(r.rating) as count, r.movieId, m.title"; 
        }
        else{
            $popular_movies = "SELECT VARIANCE(r.rating) as variance, r.movieId, m.title"; 
        }
        
        // common code dynammically created
        $popular_movies .= " FROM Coursework.ratings as r
        JOIN Coursework.movies as m ON  r.movieId = m.movieId"; 
        if ($idNo != null){
            $popular_movies .= " JOIN Coursework.moviesGenres as mg ON r.movieId = mg.movieId"; 
        }
        
        $popular_movies .=" WHERE timestamp = (SELECT MAX(timestamp) FROM Coursework.ratings as r2 WHERE r2.userId = r.userId and r2.movieId = r.movieId)"; 
        
        if ($idNo != null){
            $popular_movies .= " AND mg.genreId = $idNo"; 
        }
        if ($rating != "All"){
            $popular_movies .= " AND rating = $rating";  
        }

        if($startYear != ""){
            $popular_movies .= " AND m.year >= $startYear";  
        }

        if($endYear != ""){
            $popular_movies .= " AND m.year <= $endYear";  
        }

        // if($movieTitle != ""){
        //     $popular_movies .= " AND m.title LIKE $movieTitle";  
        // }
        
        if ($statistic == "popular"){
            $popular_movies .= " GROUP BY movieId
            ORDER BY COUNT(r.rating) DESC
            LIMIT 21;"; 
        }
        else{
            $popular_movies .= " GROUP BY movieId
            ORDER BY VARIANCE(r.rating) DESC
            LIMIT 21;"; 

        }
    
        $moviesList = $mysqli->query($popular_movies);

    }

    // Forming entire SQL Query for different filters(genre,ratings,etc ) except statistic (for that the query already created and processed)
    if(count($listOfCommands) != 0 && ($statistic == null || $movieTitle != "")){
        echo "Nope we hereee";
        $fullCommand = "SELECT * 
                        FROM Coursework.movies 
                        WHERE movieID IN ( ";
        // compile all the code:
        $counter = 0;
        foreach ($listOfCommands as $value){
        // echo "value:\n";
        // echo $value;
        $fullCommand = $fullCommand." ";
        $fullCommand = $fullCommand.$value;
        if($counter != count($listOfCommands) - 1){
            $fullCommand = $fullCommand." AND movieID IN ( ";
        }
        $counter++;
        //echo $value;
        }
        foreach ($listOfCommands as $value){
            $fullCommand = $fullCommand.")";
        }
        //echo "command: \n";

        //echo $fullCommand;
        
        //This movie list has movies that will be displayed on the grid. 
        $moviesList = $mysqli->query($fullCommand);
    }
}
else{
    echo "should be hereee";
    $getAllMovies = "SELECT * FROM Coursework.movies LIMIT 21";
    $moviesList = $mysqli->query($getAllMovies);
}

function test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>