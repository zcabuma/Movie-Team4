<?php
        
        
        
        $allratings = "SELECT rating, COUNT(*) as tally FROM Coursework.ratings 
        WHERE movieID = ?
        GROUP BY rating 
        ORDER BY tally DESC;";
        $stmt = $mysqli->prepare($allratings);
        $stmt->bind_param("i", $idNo);
        $stmt->execute();
        $rating_results = $stmt->get_result(); 
        
        

        $alltags = "SELECT tag, COUNT(*) as tally FROM Coursework.tags 
        WHERE movieID = ? 
        GROUP BY tag 
        ORDER BY tag ASC;";
        $stmt = $mysqli->prepare($alltags);
        $stmt->bind_param("i", $idNo);
        $stmt->execute();
        $tag_results = $stmt->get_result(); 
        
       
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

          while($row = mysqli_fetch_array($rating_results, MYSQLI_ASSOC)){
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

            while ($row = mysqli_fetch_array($tag_results, MYSQLI_ASSOC)){
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
