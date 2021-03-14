
<?php
				
if (is_array($moviesList)){
	foreach ($moviesList as $row) {

		$movieTitle = $row['title'];
		$year = $row['year'];
		$count = $row['count']; 
		$variance = $row['variance'];
		if(strcmp($count, "") !== 0){
			$count =  "# of Views: ".$count;
			$year = "";
		}
		if(strcmp($variance, "") !== 0){
			$variance =  "Variance: ".$variance;
			$year = "";
		}
		echo "<div class=\"col-sm-4\"> 
			<div class=\"product-image-wrapper\">
				<div class=\"single-products\">
					<div class=\"productinfo text-center\">
						<!-- <img src=\"images/shop/product12.jpg\" alt=\"\" /> -->
						<br>
						<h4>$movieTitle</h4>
						<p>$year</p>
						<p>$count</p>
						<p>$variance</p>
					</div>
					<p><id = \"name\" value = \"myname\"></p>
					
					<div class=\"product-overlay\">
					<div class = \"overlay-content\">
					<br><br><br>
					</div>
					</div>
					<div class = \"hide\"> Hello </div>
					
				</div>
				<div class=\"choose\">
					<ul class=\"nav nav-pills nav-justified\">
						<li><a href= \"displayOnMovieBrowser.php?title=$movieTitle&year=$year\"></i>Viewer segmentation</a></li>
						<li><a href=\"reportsPage.php?title=$movieTitle&year=$year\">Viewer Reaction</a></li>
					</ul>
				</div>
			</div>
		</div>";
	}
	
	
}
else{
	$cache_arr = array(); 
	while ($row = mysqli_fetch_array($moviesList, MYSQLI_ASSOC))
		{

			$movieTitle = $row['title'];
			$year = $row['year'];
			$count = $row['count']; 
			$variance = $row['variance'];
			// adding to cache
			$sub_row = array();
			$sub_row["title"] = $row['title'];
			$sub_row["year"]= $row['year'];
			$sub_row["count"] = $row['count']; 
			$sub_row["variance"] = $row['variance'];
			array_push($cache_arr, $sub_row); 
			
		
			//$movieIDQuery = "SELECT AVG(rating) FROM Coursework.ratings WHERE movieID = (SELECT movieID FROM Coursework.movies WHERE title LIKE \"%$movieTitle%\" AND year = $year)";

			//$movieID = $mysqli->query($movieIDQuery);

			//$row_result = mysqli_fetch_assoc($mysqli->query($movieIDQuery));
			//$idNo = $row_result['AVG(rating)'];
			echo "<div class=\"col-sm-4\"> 
			<div class=\"product-image-wrapper\">
				<div class=\"single-products\">
					<div class=\"productinfo text-center\">
						<!-- <img src=\"images/shop/product12.jpg\" alt=\"\" /> -->
						<br>
						<h4>$movieTitle</h4>
						<p>$year</p>
						<p>$count</p>
						<p>$variance</p>
					</div>
					<p><id = \"name\" value = \"myname\"></p>
					
					<div class=\"product-overlay\">
					<div class = \"overlay-content\">
					<br><br><br>
					</div>
					</div>
					<div class = \"hide\"> Hello </div>
					
				</div>
				<div class=\"choose\">
					<ul class=\"nav nav-pills nav-justified\">
					<li><a href= \"displayOnMovieBrowser.php?title=$movieTitle&year=$year\"></i>Viewer segmentation</a></li>
					<li><a href=\"reportsPage.php?title=$movieTitle&year=$year\">Viewer Reaction</a></li>

						
					</ul>
				</div>
			</div>
		</div>";
		}
	put_to_cache($hashed_query, $cache_arr);
}

?>
