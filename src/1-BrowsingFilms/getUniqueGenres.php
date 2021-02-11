<?php 
                            $listOfGenres = 'SELECT genre FROM Coursework.genres';

                            $result = $mysqli->query($listOfGenres);
                            echo "<option value=\"All\">All</option>";
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo $row['genre']." ";
                                $currentElement = $row['genre'];
                                echo "<option value=".$currentElement.">".$currentElement."</option>";
                            }
                        ?> 