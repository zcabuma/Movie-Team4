<?php

echo "Hello from the docker yooooo container";

$mysqli = new mysqli("db", "root", "example");

$sql = "CREATE DATABASE IF NOT EXISTS `company1`;";
//$result = $mysqli->query($sql);
if ($result = $mysqli->query($sql))
{
    echo 'db created successfully \n';
}

$sql = "CREATE TABLE IF NOT EXISTS company1.users(
        `person_id` INT AUTO_INCREMENT PRIMARY KEY ,
        `name` VARCHAR(30) NOT NULL ,
        `fav_colour` VARCHAR(30) NOT NULL
);";
//$result = $mysqli->query($sql);

if ($result = $mysqli->query($sql))
{
    echo 'table created successfully';
}


$sql = "INSERT INTO company1.users (name, fav_colour) VALUES('Lil Sneazy', 'Yellow');";
$result = $mysqli->query($sql);
$sql = "INSERT INTO company1.users (name, fav_colour) VALUES('Nick Jonas', 'Brown');";
$result = $mysqli->query($sql);
$sql = "INSERT INTO company1.users (name, fav_colour) VALUES('Maroon 5', 'Maroon');";
$result = $mysqli->query($sql);
$sql = "INSERT INTO company1.users (name, fav_colour) VALUES('Tommy Baker', 'Gold');";
if ($result = $mysqli->query($sql)){
    echo 'data added successfully';
}
else{
    echo $mysqli->error;
}

// $sql = 'SELECT * FROM users';

// if ($result = $mysqli->query($sql)) {
//     while ($data = $result->fetch_object()) {
//         $users[] = $data;
//     }
// }


// //if (is_array($users) || is_object($users))
// {
// foreach ($users as $user) {
//     echo "<br>";
//     echo $user->name . " " . $user->fav_colour;
//    echo "<br>";
// }
// }

$mysqli->close;