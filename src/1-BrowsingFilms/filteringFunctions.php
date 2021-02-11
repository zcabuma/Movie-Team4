<?php 

    
$genre = "All";
$rating = "All";
$movieTitle = "All";
$listOfCommands = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $genre = test_input($_POST["genre"]);
    if($genre != "All" && $genre != ""){
        $genreIDQuery = "SELECT genreID FROM Coursework.genres WHERE genre=\"$genre\"";
        // echo $genreIDQuery;
        $genreID = $mysqli->query($genreIDQuery);
        $row_result = mysqli_fetch_assoc($genreID);
        $idNo = $row_result['genreID'];
        // // echo $idNo;
        // $getAllMovies = "SELECT * 
        //                 FROM Coursework.movies 
        //                 WHERE movieID IN (SELECT movieID 
        //                     FROM Coursework.moviesGenres 
        //                     WHERE genreID=$idNo) ";
        // $moviesList = $mysqli->query($getAllMovies);
        $commandForGenre = "SELECT movieID 
                            FROM Coursework.moviesGenres 
                            WHERE genreID=$idNo";
        array_push($listOfCommands, $commandForGenre);
        // echo "outputting\n";
        // echo $getAllMovies;
        // echo $moviesList->num_rows;
    }

    $rating = test_input($_POST["rating"]);
    if($rating != "All" && $rating != ""){
        // $getAllMovies = "SELECT * 
        //                 FROM Coursework.movies 
        //                 WHERE movieID IN (SELECT movieId 
        //                     FROM Coursework.ratings 
        //                     WHERE rating=$rating) ";
    
        // $moviesList = $mysqli->query($getAllMovies);
        // echo $getAllMovies;
        // echo "num rows:";
        // echo $moviesList->num_rows;
        $commandForRatings = "SELECT movieId 
                                FROM Coursework.ratings 
                                WHERE rating=$rating";
        array_push($listOfCommands, $commandForRatings);
    }

    $movieTitle = test_input($_POST["movieTitle"]);
    if($movieTitle != "All" && $movieTitle != ""){
        $commandForMovieTitle= "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE title LIKE \"%$movieTitle%\"";
        array_push($listOfCommands, $commandForMovieTitle);
    }

    $startYear = test_input($_POST["start"]);
    if($startYear != ""){
        $commandForStart = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE year >= $startYear";
        array_push($listOfCommands, $commandForStart);
    }


    $endYear = test_input($_POST["end"]);
    if($endYear != ""){
        $commandForEnd = "SELECT movieId 
                                FROM Coursework.movies 
                                WHERE year <= $endYear";
        array_push($listOfCommands, $commandForEnd);
    }

    if(count($listOfCommands) != 0){
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


        // echo "command: \n";

        // echo $fullCommand;

        $moviesList = $mysqli->query($fullCommand);

        
    }
    else{
        $getAllMovies = "SELECT * FROM Coursework.movies LIMIT 21";
        $moviesList = $mysqli->query($getAllMovies);
    }

}
else{
    $getAllMovies = "SELECT * FROM Coursework.movies LIMIT 21";
    $moviesList = $mysqli->query($getAllMovies);
}

// echo "title \n";
//     echo $movieTitle;

//     echo "size: \n";

//     echo $moviesList->num_rows;


function test_input($data) { // taken from : https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>