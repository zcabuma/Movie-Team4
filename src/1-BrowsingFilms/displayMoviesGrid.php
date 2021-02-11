<?php

                        while($row = mysqli_fetch_assoc($moviesList))
                        {
                            $movieTitle = $row['title'];
                            $year = $row['year'];
							$count = $row['count']; 
							$variance = $row['variance'];
                            echo "<div class=\"col-sm-4\"> 
							<div class=\"product-image-wrapper\">
								<div class=\"single-products\">
									<div class=\"productinfo text-center\">
										<!-- <img src=\"images/shop/product12.jpg\" alt=\"\" /> -->
										<h4>$movieTitle</h3>
										<p>$year</p>
										<p>$count</p>
										<p>$variance</p>
									</div>
									<div class=\"product-overlay\">
									</div>
								</div>
								<div class=\"choose\">
									<ul class=\"nav nav-pills nav-justified\">
										<li><a href=\"\"><i class=\"fa fa-plus-square\"></i>Add to wishlist</a></li>
										<li><a href=\"\"><i class=\"fa fa-plus-square\"></i>Add to compare</a></li>
									</ul>
								</div>
							</div>
						</div>";
                        }

                        ?>