<?php
// echo "|moviesList ".$moviesList ." |\n|";
// print_r($moviesList);
// echo $movieTitle;
$usercount = 0;
$usersIds = array();

while ($row = mysqli_fetch_assoc($displaycountUsers))
{
    foreach($row as $value){
        $usercount  = $value;
    }
}

while($row = mysqli_fetch_assoc($displayUsers))
{
    foreach($row as $value){
        $usersIds[] = $value;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
}
</style>
</head>
<body>
<div class="row">
  <div class="column">
    <div class="card">
    <h3>Number of Users</h3>
    <br>
      <h2><? echo $usercount;?></h2>
    </div>
  </div>
  <div class="column">
    <div class="card">
    <h3>Card 1</h3>
      <p>Some text</p>
      <p>Some text</p>
    </div>
    
  </div>
</div>

</body>
</html>
