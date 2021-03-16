<?php 
include 'Cache.php';

$genre = "All";
$rating = "All";
$movieTitle = "All";
$idNo = null; 
// this array builds up queries for genre and rating related filters (is not used for statistics filter)
$listOfCommands = array();
$parameters = array();
$parameterTypes = "";

function check_cache_and_query_for_rows_of_results($query){
    global $mysqli;
    global $statsParameterTypes;
    global $statsParameters; 
    global $idNo; 
    global $movieTitle; 
    global $rating; 
    global $genre;
    $hashed_query = md5($query); 
    // echo "hashed query is";
    // echo $hashed_query;
    // cache stuff
    $cached_ans = get_from_cache($hashed_query);
    if ($cached_ans != ""){
        //$pred_rating = $cached_ans['AVG(rating)']; 
        $moviesList = $cached_ans;
        // echo "took from cache wohoo";
        return $moviesList;
    }
    else{
        $moviestmt = $mysqli->prepare($query);

        $moviestmt->bind_param($statsParameterTypes, ...$statsParameters); //... allows us to pass an array
        
        $moviestmt->execute();

        $moviesList = $moviestmt->get_result();
        if (empty($moviesList)){
            // echo "this empty tooooo wtf";
        }
        //$arr_cache = process_result_to_add_to_cache($moviesList);
        // adding to cache
        // done in the display movies grid page
       
        return $moviesList;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Handling Post request from genre filter 
    $genre = test_input($_POST["genre"]);
    if($genre != "All" && $genre != ""){

        $genreChanged = "%$genre%";
        $genreIDQuery = "SELECT genreID 
                        FROM Coursework.genres 
                        WHERE genre LIKE ?";
        $stmt = $mysqli->prepare($genreIDQuery);
        $stmt->bind_param("s", $genreChanged);
        $stmt->execute();

        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $idNo = $row_result['genreID'];

        
        $commandForGenre = "SELECT movieID 
                            FROM Coursework.moviesGenres 
                            WHERE genreID= ?";


        array_push($listOfCommands, $commandForGenre);
        $parameterTypes.="i";
        array_push($parameters, $idNo);
    }

    // Handling Post request from rating filter 
    $rating = test_input($_POST["rating"]);
    if($rating != "All" && $rating != ""){
        $commandForRatings = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE avg_rating >= ? - 0.5 AND avg_rating< ? + 0.5";
        array_push($listOfCommands, $commandForRatings);
        $parameterTypes.="ii";
        array_push($parameters, $rating );
        array_push($parameters, $rating );
    }

    // Handling Post request from trying to search for a specific movie
    $movieTitle = test_input($_POST["movieTitle"]);
    if($movieTitle != "All" && $movieTitle != ""){
        // echo $movieTitle;
        $titleChanged = "%$movieTitle%";
        $commandForMovieTitle= "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE title LIKE ?";
        
        $parameterTypes.="s";
        array_push($parameters, $titleChanged );
        array_push($listOfCommands, $commandForMovieTitle);

        

    }

    // Handling Post request from trying to search for movies absed on start year
    $startYear = test_input($_POST["start"]);
    if($startYear != "" && is_numeric($startYear)){
        $commandForStart = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE year >= ?";
        $parameterTypes.="i";
        array_push($parameters, $startYear );
        array_push($listOfCommands, $commandForStart);
    }

    // Handling Post request from trying to search for movies based on end year
    $endYear = test_input($_POST["end"]);
    if($endYear != "" && is_numeric($startYear)){
        $commandForEnd = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE year <= ?";
        $parameterTypes.="i";
        array_push($parameters, $endYear );
        array_push($listOfCommands, $commandForEnd);
    }

     // Handling Post request from statistics filter 
    $statistic = test_input($_POST["statistics"]);
    if ($statistic == "popular" || $statistic == "polarizing"){
        $statsParameters = array();
        $statsParameterTypes = "";
        // query to get most popular movies
        if ($statistic == "popular"){
            $popular_movies = "SELECT COUNT(r.rating) as count, r.movieId, m.title, m.year"; 
        }
        else{
            $popular_movies = "SELECT VARIANCE(r.rating) as variance, r.movieId, m.title, m.year"; 
        }
        
        // common code dynammically created
        $popular_movies .= " FROM Coursework.ratings as r
        JOIN Coursework.movies as m ON  r.movieId = m.movieId"; 
        if ($idNo != null){
            $popular_movies .= " JOIN Coursework.moviesGenres as mg ON r.movieId = mg.movieId"; 
        }
        
        $popular_movies .=" WHERE timestamp = 
        (SELECT MAX(timestamp) FROM Coursework.ratings as r2 
        WHERE r2.userId = r.userId and r2.movieId = r.movieId)"; 
        
        if ($idNo != null){
            $popular_movies .= " AND mg.genreId = ?"; 
            $statsParameterTypes.="i";
            array_push($statsParameters, $idNo ); 
        }
        if ($rating != "All"){
            $popular_movies .= " AND rating = ?";
            $statsParameterTypes.="i";
            array_push($statsParameters, $rating );  
        }

        if($startYear != "" && is_numeric($startYear)){
            $popular_movies .= " AND m.year >= ?";
            $statsParameterTypes.="i";
            array_push($statsParameters, $startYear );   
        }

        if($endYear != "" && is_numeric($endYear)){
            $popular_movies .= " AND m.year <= ?";
            $statsParameterTypes.="i";
            array_push($statsParameters, $endYear );  
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
        // CACHE query for PART 3
        $hashed_query = sha1($popular_movies . serialize($statsParameters));
        // echo "hashed query is";
        // echo $hashed_query;
        // cache stuff
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
            //$pred_rating = $cached_ans['AVG(rating)']; 
            $moviesList = $cached_ans;
            // echo "took from cache wohoo";
        }
        else{
            $moviestmt = $mysqli->prepare($popular_movies);
    
            $moviestmt->bind_param($statsParameterTypes, ...$statsParameters); //... allows us to pass an array
            
            $moviestmt->execute();
            $moviesList = $moviestmt->get_result();
            if (empty($moviesList)){
                // echo "this empty tooooo wtf";
            }
        }
        // Cached Query for part 3 ENDS

    }

    if(count($parameters) == 0 && $statistic == null ){
        echo "WARNING: no filter was applied. You may have entered invalid text into the filters or you may have submitted an empty filter request --> RESETTING TO HOME";
        $getAllMovies = "SELECT * FROM Coursework.movies LIMIT 21";
        $moviesList = $mysqli->query($getAllMovies);   
    } 

    // Forming entire SQL Query for different filters(genre,ratings,etc ) except statistic (for that the query already created and processed)
    if(count($listOfCommands) != 0 && ($statistic == null || $movieTitle != "")){
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
        
        // Check if its in cache first. 
        $hashed_query = sha1($fullCommand . serialize($parameters));
        // echo "hashed query is";
        // echo $hashed_query;
        // cache stuff
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
            //$pred_rating = $cached_ans['AVG(rating)']; 
            $moviesList = $cached_ans;
            echo "took from cache wohoo";
        }
        else{
            $moviestmt = $mysqli->prepare($fullCommand);

            $moviestmt->bind_param($parameterTypes, ...$parameters); //... allows us to pass an array
            
            $moviestmt->execute();

            $moviesList = $moviestmt->get_result(); 
        }
        
    }
     
}
else{
    // THIS QUERY IS NOT CACHED cuz its only run once when we open the app right?!?
    echo "should be hereee";
    
    $getAllMovies = "SELECT * FROM Coursework.movies";
    $moviesList = $mysqli->query($getAllMovies);
}

function test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>