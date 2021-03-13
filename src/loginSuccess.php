<?php include 'configDB.php'; ?>

<?php
echo "whassup";
echo "Click here to clean <a href = \"logout.php\" tite = \"Logout\">Session/LogOut.</a>";
echo "<br>";
echo "<label for=\"tables\">Choose a table to enter new info for:</label>

<select name=\"cars\" id=\"cars\">
  <option value=\"movies\">movies</option>
  <option value=\"tags\">tags</option>
  <option value=\"ratings\">ratings</option>
  <option value=\"moviesGenres\">moviesGenres</option>
</select>


<br>
<br>
<br>
Please enter information separated by commas that suit the table you have selected.<br>

<label for=\"datas\">Data:</label>
  <input type=\"text\" id=\"datas\" name=\"datas\"><br><br>";
?>