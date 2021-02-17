<?php

        $movieID = "SELECT movieID FROM Coursework.movies WHERE title LIKE \"%$movieTitle%\" AND year = $year";
        $id = $mysqli->query($movieID);

        //echo $movieID;

        $id = mysqli_fetch_assoc($mysqli->query($movieID));
        $idNo = $id['movieID'];
        $allratings = "SELECT rating, COUNT(*) as tally FROM Coursework.ratings WHERE movieID = $idNo GROUP BY rating ORDER BY tally DESC;;";
        $result = $mysqli->query($allratings);
        //$execRatings = mysqli_fetch_assoc($mysqli->query($allratings));
        //echo $allratings;
        

        $alltags = "SELECT tag, COUNT(*) as tally FROM Coursework.tags WHERE movieID = $idNo GROUP BY tag ORDER BY tag ASC;";
        $tagResult = $mysqli->query($alltags); 
        
       
        //while($row = mysqli_fetch_assoc($moviesList))

        //echo $execRatings;
        //https://bootsnipp.com/user/snippets/MrVB9
        
echo "<script type=\"text/javascript\" src=\"//cdn.jsdelivr.net/snap.svg/0.1.0/snap.svg-min.js\"></script>
 

<div class=\"container\">
	<div class=\"row\">
        <div class=\"col-md-12\">
            <h2>User rating and tags Report</h2>
        </div>
	</div>
    <div class=\"row\">
        <div class=\"col-md-3\">
          <ul data-pie-id=\"svg\">";

          while($row = mysqli_fetch_assoc($result)){
            $rating = $row['rating'];
            $tally = $row['tally'];
            echo "<li data-value=\"$tally\">Rating: $rating/5 ($tally)</li>";
        }
         echo" </ul>
        </div>
        <div class=\"col-md-3\">
          <div id=\"svg\"></div>
        </div>
        <div class=\"col-md-3\">
          <ul data-pie-id=\"my-cool-chart\" data-options='{\"donut\": \"true\"}'>";

            while ($row = mysqli_fetch_assoc($tagResult)){
                $tag = $row['tag'];
                $tally = $row['tally'];
                echo "<li data-value=\"$tally\">$tag</li>";
            }
            echo "</ul>
            
        </div>
        <div class=\"col-md-3\">
            <div id=\"my-cool-chart\"></div>
        </div>
    </div>
</div>"

?>
