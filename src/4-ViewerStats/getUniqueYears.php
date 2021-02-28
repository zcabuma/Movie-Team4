<?php 
						
							$listOfYears = 'SELECT DISTINCT year FROM Coursework.movies ORDER BY year';

							$result = $mysqli->query($listOfYears);
							echo "<option value=\"All\">All</option>";
							while($row = mysqli_fetch_assoc($result))
							{
								echo $row['year']." ";
								$currentElement = $row['year'];
								echo "<option value=".$currentElement.">".$currentElement."</option>";
							}

                        ?> 