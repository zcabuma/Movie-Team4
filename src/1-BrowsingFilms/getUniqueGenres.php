<?php 
                            $listOfGenres = 'SELECT genre FROM Coursework.genres';

                            $result = $mysqli->query($listOfGenres);
                            echo "<option value=\"All\">All</option>";
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $currentElement = $row['genre'];
                                if(strcmp($currentElement, "") !== 0){
                                    echo $row['genre']." ";
                                    echo "<option value=".$currentElement.">".$currentElement."</option>";
                                }
                                
                            }
                        ?> 