<?php

// echo "Group 4 project wohooo";

$mysqli = new mysqli("db", "root", "example");
mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);

// create database
$sql = "CREATE DATABASE IF NOT EXISTS `Coursework`;";
if ($result = $mysqli->query($sql))
{
    // echo 'db created successfully ';
    // echo "<br>";
}


$sql_localInfile = 'SET GLOBAL local_infile=1';

if ($result = $mysqli->query($sql_localInfile)){
    // echo 'set local_infile';
}
else{
    echo $mysqli->error;
}

// LINKS.CSV
if(checkIfTableExists("Coursework.movies", $mysqli) === false){

    $sql = "CREATE TABLE IF NOT EXISTS Coursework.movies(
        `movieId` BIGINT PRIMARY KEY ,
        `title` VARCHAR(50),
        `year` INT,
        `avg_rating` FLOAT
    );
    
    ";

    if ($result = $mysqli->query($sql))
    {
    // echo 'movies table created successfully';
    // echo "<br>";
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/movies.csv'
            INTO TABLE Coursework.movies
            FIELDS TERMINATED BY '|'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (movieId , title, year, avg_rating)";


    if ($result = $mysqli->query($csvSQL)){
        // echo 'movie csv added successfully';
        // echo "<br>";
    }
    else{
        echo $mysqli->error;
    }


}

if(checkIfTableExists("Coursework.genres", $mysqli) === false){


    //create genre table
    $sql = "CREATE TABLE IF NOT EXISTS Coursework.genres(
        `genreID` INT AUTO_INCREMENT PRIMARY KEY ,
        `genre` VARCHAR(50) UNIQUE
    );";
    if ($result = $mysqli->query($sql))
    {
    // echo 'genres table created successfully';
    // echo "<br>";
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/genres.csv'
            INTO TABLE Coursework.genres
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (genreID , genre)";


    if ($result = $mysqli->query($csvSQL)){
        // echo 'genre csv added successfully';
        // echo "<br>";
    }
    else{
        echo $mysqli->error;
    }



}

if(checkIfTableExists("Coursework.links", $mysqli) === false){

    $sql = "CREATE TABLE IF NOT EXISTS Coursework.links(
        `movieId` BIGINT PRIMARY KEY ,
        `imdbId` VARCHAR (10) NOT NULL,
        `tmdbId` BIGINT NOT NULL,
        CONSTRAINT FK_linksMovie FOREIGN KEY (movieId) REFERENCES Coursework.movies(movieId)
    );
    
    
";



    if ($result = $mysqli->query($sql))
    {
    // echo 'links table created successfully';
    // echo "<br>";
    }

    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/links.csv'
            INTO TABLE Coursework.links
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (movieId , imdbId, tmdbId)";


    if ($result = $mysqli->query($csvSQL)){
        // echo 'links csv added successfully';
        // echo "<br>";
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
    // echo "did not find";

    $sql = "CREATE TABLE Coursework.ratings(
        `userId` BIGINT NOT NULL ,
        `movieId` BIGINT NOT NULL ,
        `rating` INT NOT NULL ,
        `timestamp` BIGINT NOT NULL,
        PRIMARY KEY (`userId`, `movieId`,`timestamp`),
        CONSTRAINT FK_ratingsMovie FOREIGN KEY (movieId) REFERENCES Coursework.movies(movieId)
        
    );
    
    
";
    // echo "about to make";
    //FOREIGN KEY (`movieId`) REFERENCES Coursework.movies(`movieId`)
    if ($result = $mysqli->query($sql))
    {
    // echo 'ratings created successfully';
    // echo "<br>";
    }

   
    // echo "here";
    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/ratings.csv'
            INTO TABLE Coursework.ratings
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (userId , movieId, rating, timestamp)";

    
    if ($result = $mysqli->query($csvSQL)){
        // echo 'ratings csv added successfully';
        // echo "<br>";
    }
    else{
        // echo "here4";
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

if(checkIfTableExists("Coursework.tagGroups", $mysqli) === false){
    $sql_query_for_tags = "CREATE TABLE IF NOT EXISTS Coursework.tagGroups(
        `tag` VARCHAR(50) PRIMARY KEY, 
        `group` INT
        
    );
   
";

    // if ($result = $mysqli->query($sql_localInfile)){
    //     echo 'set local_infile';
    // }
    // else{
    //     echo $mysqli->error;
    // }

    if ($result = $mysqli->query($sql_query_for_tags))
    {
        // echo 'tagsGroups table created successfully';
        // echo "<br>";
    }else{
        echo $mysqli->error;
    }



    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/tagGroups.csv'
            INTO TABLE Coursework.tagGroups
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (`tag`,`group`)";


    if ($result = $mysqli->query($csvSQL)){
        // echo 'TAGSSS Groups added successfully';
        // echo "<br>";
    }
    else{
        echo $mysqli->error;
    }
    #TAGS TABLE STUFF ENDS HEREE----------------------
}

// THIS CHUCK OF CODE IS TO ADD TAGS TABLE WHICH WAS ALREADY NORMALIZED------------
// create Tags table if not created already
if(checkIfTableExists("Coursework.tags", $mysqli) === false){
    $sql_query_for_tags = "CREATE TABLE IF NOT EXISTS Coursework.tags(
        `userId` BIGINT NOT NULL,
        `movieId` BIGINT NOT NULL ,
        `tag` VARCHAR(50) NOT NULL, 
        `timestamp` BIGINT NOT NULL, 
        PRIMARY KEY (`userId`, `movieId`,`timestamp`),
        CONSTRAINT FK_tagsMovie FOREIGN KEY (movieId) REFERENCES Coursework.movies(movieId),
        CONSTRAINT FK_tags FOREIGN KEY (tag) REFERENCES Coursework.tagGroups(tag)
    );
   
";

    if ($result = $mysqli->query($sql_localInfile)){
        // echo 'set local_infile';
    }
    else{
        echo $mysqli->error;
    }

    if ($result = $mysqli->query($sql_query_for_tags))
    {
        // echo 'tags table created successfully';
        // echo "<br>";
    }



    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/tags.csv'
            INTO TABLE Coursework.tags
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (userId , movieId,tag, timestamp)";


    if ($result = $mysqli->query($csvSQL)){
        // echo 'TAGSSS added successfully';
        // echo "<br>";
    }
    else{
        echo $mysqli->error;
    }
    #TAGS TABLE STUFF ENDS HEREE----------------------
}



// create MOVIES table if not created already



if(checkIfTableExists("Coursework.moviesGenres", $mysqli) === false){

    //create combined table
    $sql = "CREATE TABLE IF NOT EXISTS Coursework.moviesGenres(
        `movieID` BIGINT ,
        `genreID` INT,
        PRIMARY KEY (movieID, genreID),
        CONSTRAINT FK_Movies FOREIGN KEY (movieID) REFERENCES Coursework.movies(movieId),
        CONSTRAINT FK_Genres FOREIGN KEY (genreID) REFERENCES Coursework.genres(genreID)
    );";


    if ($result = $mysqli->query($sql))
    {
    // echo 'moviesGenres table created successfully';
    // echo "<br>";
    }


    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/movies_genres.csv'
    INTO TABLE Coursework.moviesGenres
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES
    (movieID , genreID)";


    if ($result = $mysqli->query($csvSQL)){
    // echo 'moviegenre csv added successfully';
    // echo "<br>";
    }
    else{
        // echo "not being created <br>";
    echo $mysqli->error;
    }

}

if(checkIfTableExists("Coursework.personalityType", $mysqli) === false){
    // echo "the table doesnt exist!!! <br>";
    //create combined table
    $sql = "CREATE TABLE IF NOT EXISTS Coursework.personalityType(
        `hashedUserID` VARCHAR(50) PRIMARY KEY,
        `openness` DECIMAL  ,
        `agreeableness` DECIMAL  ,
        emotional_stability DECIMAL  ,
        `conscientiousness` DECIMAL  ,
        `extraversion` DECIMAL  ,
        `assigned_metric` VARCHAR(15),
        `assigned_condition` VARCHAR(15),
        `is_personalised`  INT,
        `enjoy_watching` INT

    );";


    if ($result = $mysqli->query($sql))
    {
    // echo 'personalityType table created successfully';
    echo "<br>";
    }
    else{
        echo $mysqli->error;
        echo "<br>";
    }
    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/personality_type.csv'
    INTO TABLE Coursework.personalityType
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES
    (hashedUserID, openness, agreeableness, emotional_stability, conscientiousness, extraversion, assigned_metric, assigned_condition, is_personalised, enjoy_watching)";


    if ($result = $mysqli->query($csvSQL)){
    // echo 'personality type csv added successfully';
    echo "<br>";
    }
    else{
    echo $mysqli->error;
    }

}
if(checkIfTableExists("Coursework.personalityRatings", $mysqli) === false){

    //create combined table
    $sql = "CREATE TABLE IF NOT EXISTS Coursework.personalityRatings(
        `hashedUserID` VARCHAR(50) ,
        `movieID` BIGINT  ,
        `rating` FLOAT,
        CONSTRAINT PK_personalityRating PRIMARY KEY(hashedUserID, movieID),
        CONSTRAINT FK_userId FOREIGN KEY (hashedUserID) REFERENCES Coursework.personalityType(hashedUserID)
        
    );
    
    ";

    if ($result = $mysqli->query($sql))
    {
    // echo 'personalityRatings table created successfully';
    echo "<br>";
    }
    else{
        echo $mysqli->error;
    }


    $csvSQL = "LOAD DATA LOCAL INFILE 'ExcelFiles/personality_ratings.csv'
    INTO TABLE Coursework.personalityRatings
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES
    (hashedUserID, movieID, rating)";


    if ($result = $mysqli->query($csvSQL)){
    // echo 'personality rating csv added successfully';
    echo "<br>";
    }
    else{
    echo $mysqli->error;
    }

}



function checkIfTableExists($tableName, $mysqli) {
    // echo "check if table exists starting";
    // echo "SHOW TABLES LIKE '$tableName'";
    // echo "<br>";
    $checktable = $mysqli->query("SHOW TABLES LIKE '$tableName'");
    $table_exists = $checktable->num_rows > 0;
    // echo "result for if table exists\n";
    // echo $checktable->num_rows;
    // echo "end of result\n";
    return $table_exists;
}

 $mysqli->close;


?>
