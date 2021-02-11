<?php 
						
							$listOfRatings = 'SELECT DISTINCT rating FROM Coursework.ratings ORDER BY rating';

							$result = $mysqli->query($listOfRatings);
							echo "<option value=\"All\">All</option>";
							while($row = mysqli_fetch_assoc($result))
							{
								echo $row['rating']." ";
								$currentElement = $row['rating'];
								echo "<option value=".$currentElement.">".$currentElement."</option>";
							}

                        ?> 