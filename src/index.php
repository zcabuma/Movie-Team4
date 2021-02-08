<?php

echo "Group 4 project";

$mysqli = new mysqli("db", "root", "example");
mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);

// create database
$sql = "CREATE DATABASE IF NOT EXISTS `Coursework`;";
if ($result = $mysqli->query($sql))
{
    echo 'db created successfully \n';
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
        `imdbId` BIGINT NOT NULL ,
        `tmdbId` BIGINT NOT NULL
    );";

    if ($result = $mysqli->query($sql))
    {
    echo 'links table created successfully';
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'links.csv'
            INTO TABLE Coursework.links
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (movieId , imdbId, tmdbId)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'csv added successfully';
    }
    else{
        echo $mysqli->error;
    }

    // displaying links on the main page

    $query = 'SELECT * FROM Coursework.links';

    echo '<table border="0" cellspacing="2" cellpadding="2">
        <tr> 
            <td> <font face="Arial">movieId</font> </td> 
            <td> <font face="Arial">imdbId</font> </td> 
            <td> <font face="Arial">tmdbId</font> </td> 
        </tr>';

    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $field1name = $row["movieId"];
            $field2name = $row["imdbId"];
            $field3name = $row["tmdbId"];

            echo '<tr> 
                    <td>'.$field1name.'</td> 
                    <td>'.$field2name.'</td> 
                    <td>'.$field3name.'</td>  
                </tr>';
        }
        $result->free();
    } 

}

// RATINGS.CSV

if(checkIfTableExists("Coursework.ratings", $mysqli) === false){

    $sql = "CREATE TABLE IF NOT EXISTS Coursework.ratings(
        `userId` BIGINT PRIMARY KEY ,
        `movieId` BIGINT NOT NULL ,
        `rating` INT NOT NULL ,
        `timestamp` BIGINT NOT NULL
    );";

    if ($result = $mysqli->query($sql))
    {
    echo 'table created successfully';
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ratings.csv'
            INTO TABLE Coursework.ratings
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (userId , movieId, rating, timestamp)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'csv added successfully';
    }
    else{
        echo $mysqli->error;
    }

    // displaying it on the main page

    $query = 'SELECT * FROM Coursework.ratings';

    echo '<table border="0" cellspacing="2" cellpadding="2">
        <tr> 
            <td> <font face="Arial">userId</font> </td> 
            <td> <font face="Arial">movieId</font> </td> 
            <td> <font face="Arial">rating</font> </td> 
            <td> <font face="Arial">timestamp</font> </td> 
        </tr>';

    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $field1name = $row["userId"];
            $field2name = $row["movieId"];
            $field3name = $row["rating"];
            $field3name = $row["timestamp"];

            echo '<tr> 
                    <td>'.$field1name.'</td> 
                    <td>'.$field2name.'</td> 
                    <td>'.$field3name.'</td>  
                    <td>'.$field4name.'</td>  
                </tr>';
        }
        $result->free();
    } 

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
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'movies.csv'
            INTO TABLE Coursework.movies
            FIELDS TERMINATED BY '|'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (movieId , title, year)";


    if ($result = $mysqli->query($csvSQL)){
        echo 'csv added successfully';
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
    }
    $allgenres = [];
    //manually upload the combined data
    if($file = fopen("genres.csv","r")){
        $line =fgets($file);
        while(!feof($file)){
            $line = fgets($file);
            //echo $line;
            //echo "<br>";
            $data = explode(",", $line);
            $movieID = $data[0];
            $genres = explode("|", $data[1]);

            
            foreach ($genres as $genre){
                $genre = trim($genre);
                if (!$allgenres[$genre]){
                    $sql = "INSERT INTO Coursework.genres (`genre`) VALUES('$genre');";
                    $mysqli->query($sql);
                    //array_push($allgenres, $genre);
                    //echo $genre;
                    //echo "<br>";
                    $sql = "SELECT genreID FROM Coursework.genres WHERE genre='$genre';";
                    $result = $mysqli->query($sql);
                    $row = $result->fetch_assoc();
                    $genreID = $row["genreID"];
                    $allgenres[$genre] = $genreID;
                }


                $genreID = $allgenres[$genre];
                
                //$sql = "INSERT INTO Coursework.moviesGenres (`movieID`,`genreID`) VALUES ($movieID,$genreID )";
                //$mysqli->query($sql);

                //echo $genre;
                //echo "<br>";
                
            }

        }
        fclose($file);
    }
    echo "Data added";

}


function checkIfTableExists($tableName, $mysqli) {
    echo "starting";
    echo "SHOW TABLES LIKE '$tableName'";
    $checktable = $mysqli->query("SHOW TABLES LIKE '$tableName'");
    $table_exists = $checktable->num_rows > 0;
    echo "result for if table exists\n";
    echo $checktable->num_rows;
    echo "end of result\n";
    return $table_exists;
}

 $mysqli->close;


?>
