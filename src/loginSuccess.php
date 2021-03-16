<?php include 'configDB.php'; ?>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $table = $_POST["table"];
  $data = $_POST["data"];
  $sql = "INSERT INTO Coursework.";
  if (!($table == "" or $data =="")){
    
    $paramTypes = "";
    if ($table == "movies"){
        $paramTypes = "isid";
        $sql = $sql.$table;
    }
    if ($table == "tags"){
      $paramTypes = "iisi";
      $sql = $sql.$table;
    }
    if ($table == "ratings"){
      $paramTypes = "iiii";
      $sql = $sql.$table;
  }
  if ($table == "moviesGenres"){
    $paramTypes = "ii";
    $sql = $sql.$table;
  }
//0,up,2009,4.5
  
    $table = $table;
    
    $listOfStrings = explode(",", $data);
    // echo count($listOfStrings);
    $endstring = str_repeat("?,", count($listOfStrings));
    $endstring = substr($endstring, 0, -1);
    $sql = $sql." VALUES (".$endstring.") ;";
    // echo $sql;
    $moviestmt = $mysqli->prepare($sql);

    $moviestmt->bind_param($paramTypes, ...$listOfStrings); //... allows us to pass an array
    
    $moviestmt->execute();

    // echo $mysqli->error;

    //$moviesList = $moviestmt->get_result(); 

    
  }
}else{
  // echo "nothing";
}
  ?>

<?php
// echo "whassup";
echo "Click here to clean <a href = \"logout.php\" tite = \"Logout\">Session/LogOut.</a>";
echo "<br>";
echo "<label for=\"tables\">Choose a table to enter new info for:</label>
<form class = \"form-signin\" role = \"form\" action = \"loginSuccess.php\" method = \"post\">
<select name=\"table\" id=\"table\">
<option disabled hidden selected>Select One</option>
  <option value=\"movies\">movies</option>
  <option value=\"tags\">tags</option>
  <option value=\"ratings\">ratings</option>
  <option value=\"moviesGenres\">moviesGenres</option>
</select>


<br>
<br>
<br>
Please enter information separated by commas that suit the table you have selected.<br>

<label for=\"data\">Data:</label>
  <input type=\"text\" id=\"data\" name=\"data\"><br><br>
  
  <button class = \"btn btn-lg btn-primary btn-block\" type = \"submit\" 
               name = \"insert\">Add To Table</button>
               
               </form>";
?>