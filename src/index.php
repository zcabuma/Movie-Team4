<?php

echo "Hello from the docker yooooo container";

$mysqli = new mysqli("db", "root", "example");

$sql = "CREATE DATABASE IF NOT EXISTS `company1`;";
//$result = $mysqli->query($sql);
if ($result = $mysqli->query($sql))
{
    echo 'db created successfully';
}
echo 'Anything from me';
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


$sql = "INSERT INTO company1.users (`name`, `fav_color`) VALUES('Lil Sneazy', 'Yellow');";
$result = $mysqli->query($sql);
$sql = "INSERT INTO company1.users (`name`, `fav_color`) VALUES('Nick Jonas', 'Brown');";
$result = $mysqli->query($sql);
$sql = "INSERT INTO company1.users (`name`, `fav_color`) VALUES('Maroon 5', 'Maroon');";
$result = $mysqli->query($sql);
$sql = "INSERT INTO company1.users (`name`, `fav_color`) VALUES('Tommy Baker', '043A2B');";
if ($result = $mysqli->query($sql)){
    echo 'data added successfully';
}

$sql = 'SELECT * FROM users';

if ($result = $mysqli->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

//foreach ($users as $user) {
  //  echo "<br>";
   // echo $user->name . " " . $user->fav_color;
   // echo "<br>";
//}