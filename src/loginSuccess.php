<?php include 'configDB.php'; ?>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $table = $_POST["table"];
  $data = $_POST["data"];

  if (!($table == "" or $data =="")){
    
    $table = "Coursework.".$table;
    
    $listOfStrings = explode(",", $data);
    $endstring = str_repeat("?,", count($listOfStrings));
    $endstring = substr($endstring, 0, -1);
    $sql = "INSERT INTO ? VALUES (".$endstring.") ;";
    echo $sql;
  }
}else{
  echo "nothing";
}
  ?>

<?php
echo "whassup";
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