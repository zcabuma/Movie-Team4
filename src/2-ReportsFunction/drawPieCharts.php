<?php
        
        $allratings = "SELECT rating, COUNT(*) as tally FROM Coursework.ratings 
        WHERE movieID = ?
        GROUP BY rating 
        ORDER BY tally DESC;";

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
        $hashed_query = sha1($allratings . serialize($idNo));
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
            //$pred_rating = $cached_ans['AVG(rating)']; 
            $rating_results = $cached_ans;
            

                    foreach ($rating_results as $row) {
                      $rating = $row['rating'];
                      $tally = $row['tally'];

                      echo "<li data-value=\"$tally\">Rating: $rating/5 ($tally)</li>";
                  }
                  
                  }
        else{
          $stmt = $mysqli->prepare($allratings);
          $stmt->bind_param("i", $idNo);
          $stmt->execute();
          $rating_results = $stmt->get_result(); 
          
                    $cache_arr = array();
                    while($row = mysqli_fetch_array($rating_results, MYSQLI_ASSOC)){
                      $rating = $row['rating'];
                      $tally = $row['tally'];
                      $sub_row = array();
                      $sub_row["rating"] = $row['rating'];
                      $sub_row["tally"]= $row['tally'];
                      array_push($cache_arr, $sub_row); 
                      echo "<li data-value=\"$tally\">Rating: $rating/5 ($tally)</li>";
                  }
                  put_to_cache($hashed_query, $cache_arr);
          
        }

        
        // $stmt = $mysqli->prepare($allratings);
        // $stmt->bind_param("i", $idNo);
        // $stmt->execute();
        // $rating_results = $stmt->get_result(); 
        echo" </ul>
        </div>
        <div class=\"col-md-3\">
          <div id=\"svg\"></div>
        </div>
        <div class=\"col-md-3\">
          <ul data-pie-id=\"my-cool-chart\" data-options='{\"donut\": \"true\"}'>";
        

        $alltags = "SELECT tag, COUNT(*) as tally FROM Coursework.tags 
        WHERE movieID = ? 
        GROUP BY tag 
        ORDER BY tag ASC;";
        $hashed_query = sha1($alltags . serialize($idNo));
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
            //$pred_rating = $cached_ans['AVG(rating)']; 
            $tag_results = $cached_ans;
                    foreach ($tag_results as $row) {
                      $tag = $row['tag'];
                      $tally = $row['tally'];
                      
                      echo "<li data-value=\"$tally\">$tag</li>";
                  }
                  
            
                  }
        else{
          $stmt = $mysqli->prepare($alltags);
          $stmt->bind_param("i", $idNo);
          $stmt->execute();
          $tag_results = $stmt->get_result(); 
          
          $cache_arr = array();
                    while ($row = mysqli_fetch_array($tag_results, MYSQLI_ASSOC)){
                      $tag = $row['tag'];
                      $tally = $row['tally'];
                      $sub_row = array();
                      $sub_row["tag"] = $row['tag'];
                      $sub_row["tally"]= $row['tally'];
                      array_push($cache_arr, $sub_row); 
                      echo "<li data-value=\"$tally\">$tag</li>";
                  }
                  put_to_cache($hashed_query, $cache_arr);
          
        }

       
        echo "</ul>
            
        </div>
        <div class=\"col-md-3\">
            <div id=\"my-cool-chart\"></div>
        </div>
    </div>
</div>";


        

        //https://bootsnipp.com/user/snippets/MrVB9
        


            

?>
