<?php

echo "Group 4 project wohooo";

$mysqli = new mysqli("db", "root", "example");
mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);

// create database
$sql = "CREATE DATABASE IF NOT EXISTS `Coursework`;";
if ($result = $mysqli->query($sql))
{
    echo 'db created successfully ';
    echo "<br>";
}


$sql_localInfile = 'SET GLOBAL local_infile=1';

if ($result = $mysqli->query($sql_localInfile)){
    echo 'set local_infile';
}
else{
    echo $mysqli->error;
}

// LINKS.CSV

if(checkIfTableExists("Coursework.links", $mysqli) === false){

    $sql = "CREATE TABLE IF NOT EXISTS Coursework.links(
        `movieId` BIGINT PRIMARY KEY ,
        `imdbId` VARCHAR (10) NOT NULL,
        `tmdbId` BIGINT NOT NULL
    );";

    if ($result = $mysqli->query($sql))
    {
    echo 'links table created successfully';
    echo "<br>";
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/links.csv'
            INTO TABLE Coursework.links
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (movieId , imdbId, tmdbId)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'links csv added successfully';
        echo "<br>";
    }
    else{
        echo $mysqli->error;
    }

    // displaying links on the main page

    // $query = 'SELECT * FROM Coursework.links';

    // echo '<table border="0" cellspacing="2" cellpadding="2">
    //     <tr> 
    //         <td> <font face="Arial">movieId</font> </td> 
    //         <td> <font face="Arial">imdbId</font> </td> 
    //         <td> <font face="Arial">tmdbId</font> </td> 
    //     </tr>';

    // if ($result = $mysqli->query($query)) {
    //     while ($row = $result->fetch_assoc()) {
    //         $field1name = $row["movieId"];
    //         $field2name = $row["imdbId"];
    //         $field3name = $row["tmdbId"];

    //         echo '<tr> 
    //                 <td>'.$field1name.'</td> 
    //                 <td>'.$field2name.'</td> 
    //                 <td>'.$field3name.'</td>  
    //             </tr>';
    //     }
    //     $result->free();
    // } 

}

// RATINGS.CSV

if(checkIfTableExists("Coursework.ratings", $mysqli) === false){
    echo "did not find";

    $sql = "CREATE TABLE Coursework.ratings(
        `userId` BIGINT NOT NULL ,
        `movieId` BIGINT NOT NULL ,
        `rating` INT NOT NULL ,
        `timestamp` BIGINT NOT NULL,
        PRIMARY KEY (`userId`, `movieId`,`timestamp`)
    );";
    echo "about to make";
    if ($result = $mysqli->query($sql))
    {
    echo 'ratings created successfully';
    echo "<br>";
    }
    echo "here";
    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/ratings.csv'
            INTO TABLE Coursework.ratings
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (userId , movieId, rating, timestamp)";

    
    if ($result = $mysqli->query($csvSQL)){
        echo 'ratings csv added successfully';
        echo "<br>";
    }
    else{
        echo "here4";
        echo $mysqli->error;
    }

    // displaying it on the main page

    

    // $query = 'SELECT * FROM Coursework.ratings';

    // echo '<table border="0" cellspacing="2" cellpadding="2">
    //     <tr> 
    //         <td> <font face="Arial">userId</font> </td> 
    //         <td> <font face="Arial">movieId</font> </td> 
    //         <td> <font face="Arial">rating</font> </td> 
    //         <td> <font face="Arial">timestamp</font> </td> 
    //     </tr>';

    // if ($result = $mysqli->query($query)) {
    //     while ($row = $result->fetch_assoc()) {
    //         $field1name = $row["userId"];
    //         $field2name = $row["movieId"];
    //         $field3name = $row["rating"];
    //         $field3name = $row["timestamp"];

    //         echo '<tr> 
    //                 <td>'.$field1name.'</td> 
    //                 <td>'.$field2name.'</td> 
    //                 <td>'.$field3name.'</td>  
    //                 <td>'.$field4name.'</td>  
    //             </tr>';
    //     }
    //     $result->free();
    // } 


}

#LINKS TABLE UPLOAD AND DISPLAY ENDS HERE -----------------------

// THIS CHUCK OF CODE IS TO ADD TAGS TABLE WHICH WAS ALREADY NORMALIZED------------
// create Tags table if not created already
if(checkIfTableExists("Coursework.links", $mysqli) === false){
    $sql_query_for_tags = "CREATE TABLE IF NOT EXISTS Coursework.tags(
        `userId` BIGINT NOT NULL,
        `movieId` BIGINT NOT NULL ,
        `tag` VARCHAR(50) NOT NULL, 
        `timestamp` BIGINT NOT NULL, 
        PRIMARY KEY (`userId`, `movieId`,`timestamp`)
    );";

    if ($result = $mysqli->query($sql_localInfile)){
        echo 'set local_infile';
    }
    else{
        echo $mysqli->error;
    }

    if ($result = $mysqli->query($sql_query_for_tags))
    {
        echo 'tags table created successfully';
        echo "<br>";
    }


    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/tags.csv'
            INTO TABLE Coursework.tags
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (userId , movieId,tag, timestamp)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'TAGSSS added successfully';
        echo "<br>";
    }
    else{
        echo $mysqli->error;
    }
    #TAGS TABLE STUFF ENDS HEREE----------------------
}


// create MOVIES table if not created already

if(checkIfTableExists("Coursework.movies", $mysqli) === false){

    $sql = "CREATE TABLE IF NOT EXISTS Coursework.movies(
        `movieId` BIGINT PRIMARY KEY ,
        `title` VARCHAR(50),
        `year` INT
    );";

    if ($result = $mysqli->query($sql))
    {
    echo 'movies table created successfully';
    echo "<br>";
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/movies.csv'
            INTO TABLE Coursework.movies
            FIELDS TERMINATED BY '|'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (movieId , title, year)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'movie csv added successfully';
        echo "<br>";
    }
    else{
        echo $mysqli->error;
    }

}

if(checkIfTableExists("Coursework.movies", $mysqli) === false){


    //create genre table
    $sql = "CREATE TABLE IF NOT EXISTS Coursework.genres(
        `genreID` BIGINT AUTO_INCREMENT PRIMARY KEY ,
        `genre` VARCHAR(50) UNIQUE
    );";
    if ($result = $mysqli->query($sql))
    {
    echo 'genres table created successfully';
    echo "<br>";
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/genres.csv'
            INTO TABLE Coursework.genres
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (genreID , genre)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'genre csv added successfully';
        echo "<br>";
    }
    else{
        echo $mysqli->error;
    }



}


if(checkIfTableExists("Coursework.moviesGenres", $mysqli) === false){

    //create combined table
    $sql = "CREATE TABLE IF NOT EXISTS Coursework.moviesGenres(
        `movieID` BIGINT ,
        `genreID` INT
    );";


    if ($result = $mysqli->query($sql))
    {
    echo 'moviesGenres table created successfully';
    echo "<br>";
    }
    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/movies_genres.csv'
    INTO TABLE Coursework.moviesGenres
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES
    (movieID , genreID)";


    if ($result = $mysqli->query($csvSQL)){
    echo 'moviegenre csv added successfully';
    echo "<br>";
    }
    else{
    echo $mysqli->error;
    }

}


function checkIfTableExists($tableName, $mysqli) {
    echo "check if table exists starting";
    echo "SHOW TABLES LIKE '$tableName'";
    echo "<br>";
    $checktable = $mysqli->query("SHOW TABLES LIKE '$tableName'");
    $table_exists = $checktable->num_rows > 0;
    echo "result for if table exists\n";
    echo $checktable->num_rows;
    echo "end of result\n";
    return $table_exists;
}

 $mysqli->close;


?>
