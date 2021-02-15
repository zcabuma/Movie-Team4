<?php
        $movieIDQuery = "SELECT AVG(rating) FROM Coursework.ratings WHERE movieID = (SELECT movieID FROM Coursework.movies WHERE title LIKE \"%$movieTitle%\" AND year = $year)";

        $movieID = $mysqli->query($movieIDQuery);

        $row_result = mysqli_fetch_assoc($mysqli->query($movieIDQuery));
        $idNo = $row_result['AVG(rating)'];

        
        echo "<h2 class=\"title text-center\">Report: $movieTitle ($year) </h2>";
        
        echo "<h4> Rating: $idNo </h4>";


?>