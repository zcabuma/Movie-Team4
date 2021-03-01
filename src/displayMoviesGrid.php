
<?php
// echo "<script src=\"js/jquery.js\"></script>";

// echo "<script>
// $(document).ready(function(){
//   $(\".product-image-wrapper\").mouseover(function(){
// 	alert(\"Value: \" + $(\"#test\").val());
//     $(this).css(\"background-color\", \"black\");
//   });
//   $(\".product-image-wrapper\").mouseout(function(){
//     $(this).css(\"background-color\", \"white\");
//   });
// });
// </script>";

				


					while ($row = mysqli_fetch_array($moviesList, MYSQLI_ASSOC))
                        {
                            $movieTitle = $row['title'];
                            $year = $row['year'];
							$count = $row['count']; 
							$variance = $row['variance'];
							
						
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
									$idNo <br><br><br>
									</div>
									</div>
									<div class = \"hide\"> Hello </div>
									
								</div>
								<div class=\"choose\">
									<ul class=\"nav nav-pills nav-justified\">
										<li><a href= \"5-PredictedRating\predictedViewerRating.php?title=$movieTitle&year=$year\"></i>Predicted viewer rating</a></li>
										<li><a href=\"reportsPage.php?title=$movieTitle&year=$year\">Rating Report</a></li>

										
									</ul>
								</div>
							</div>
						</div>";
                         }

                        ?>
