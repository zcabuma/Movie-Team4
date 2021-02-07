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

// create LINKS table if not created already
$sql = "CREATE TABLE IF NOT EXISTS Coursework.links(
        `movieId` BIGINT PRIMARY KEY ,
        `imdbId` BIGINT NOT NULL ,
        `tmdbId` BIGINT NOT NULL
);";

if ($result = $mysqli->query($sql))
{
    echo 'table created successfully';
}


$sql_localInfile = 'SET GLOBAL local_infile=1';

if ($result = $mysqli->query($sql_localInfile)){
    echo 'set local_infile';
}
else{
    echo $mysqli->error;
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

// displaying it on the main page

// $query = 'SELECT * FROM Coursework.links';

// echo '<table border="0" cellspacing="2" cellpadding="2">
//       <tr> 
//           <td> <font face="Arial">movieId</font> </td> 
//           <td> <font face="Arial">imdbId</font> </td> 
//           <td> <font face="Arial">tmdbId</font> </td> 
//       </tr>';

// if ($result = $mysqli->query($query)) {
//     while ($row = $result->fetch_assoc()) {
//         $field1name = $row["movieId"];
//         $field2name = $row["imdbId"];
//         $field3name = $row["tmdbId"];

//         echo '<tr> 
//                   <td>'.$field1name.'</td> 
//                   <td>'.$field2name.'</td> 
//                   <td>'.$field3name.'</td>  
//               </tr>';
//     }
//     $result->free();
// } 



// create MOVIES table if not created already
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

$mysqli->close;
?>
