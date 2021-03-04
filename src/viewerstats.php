<?php include 'configDB.php'; ?>
<?php include '4-ViewerStats/movieSelection.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Viewer Statistics</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">      
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
	<style>
		
		* {
			box-sizing: border-box;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
		}

		/* Float four columns side by side */
		.column {
			float: left;
			width: 50%;
			padding: 0 10px;
		}

		/* Remove extra left and right margins, due to padding */
		.row {margin: 0 -5px;}

		/* Clear floats after the columns */
		.row:after {
			content: "";
			display: table;
			clear: both;
		}

		/* Responsive columns */
		@media screen and (max-width: 600px) {
			.column {
			width: 100%;
			display: block;
			margin-bottom: 20px;
			}
		}

		/* Style the counter cards */
		.card {
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
			padding: 16px;
			text-align: center;
			background-color: #f1f1f1;
		}

		table {
			width: 716px; /* 140px * 5 column + 16px scrollbar width */
			border-spacing: 0;
		}

		tbody, thead tr { display: block; }

		tbody {
			height: 250px;
			overflow-y: auto;
			overflow-x: hidden;
		}

		tbody td, thead th {
			width: 140px;
		}
		thead th:first-child {
			width: 40px; 
		}
		tbody td:first-child {
			width: 40px; 
		}
		thead th:last-child {
			width: 156px; /* 140px + 16px scrollbar width */
		}
		footer {
		text-align: center;
		padding: 3px;
		background-color: Orange;
		color: white;
		}
	</style>
</head><!--/head-->

<body>

<!-- Usual headers and banner -->
	<header id="header"><!--header-->		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<!-- <div class="logo pull-left">
							<a href="index.html"><img src="images/home/logo.png" alt="" /></a>
						</div> -->
					</div>
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-center">
							<ul class="nav navbar-nav">
								<li><a href=""><i class="fa fa-user"></i> Page1</a></li>
								<li><a href="viewerstats.php"><i class="fa fa-star"></i> Viewer Stats</a></li>
								<li><a href="checkout.html"><i class="fa fa-crosshairs"></i> Page3</a></li>
								<li><a href="cart.html"><i class="fa fa-shopping-cart"></i> Page4</a></li>
								<li><a href="login.html"><i class="fa fa-lock"></i> Page4</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
					</div>
					<div class="col-sm-3">
						
					</div>
				</div>
				</div>
			</div>
	</header>
	
	<section id="advertisement">
		<div class="container">
			<img src="images/shop/banner.png" alt="" />
		</div>
	</section>
	<!-- Usual headers and banner -->
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						
                        <h2>Criteria</h2>
                        
                        <form method="post" action="viewerstats.php">

						<label for="movie">Search for movie:</label>
							<input type="text" placeholder="Movie Title" id="movieTitle" name="movieTitle">  
                        <br><br>

						<label for="rating">Choose a rating:</label>
							<select name="rating" id="rating">
							<?php include '1-BrowsingFilms/getUniqueRatings.php'; ?>
							</select>
                        <br><br>

                        <input type="submit" name ="ratingSubmit" value="Submit">

                        </form>
						<hr>
						<form method="post" action="viewerstats.php">
						<br>
						<label for="movie">Search for users by year:</label>
							<select name="year" id="year">
								<?php include '4-ViewerStats/getUniqueYears.php'; ?>
								</select>  
                        <br><br>

                        <input type="submit" name ="yearSubmit" value="Submit">

                        </form>

						<hr>

						<form method="post" action="viewerstats.php">
						<br>
						<label for="movie">(Optional)Enter a movie name :</label>
							<input type="text" placeholder="Movie Title" id="movieTitleTag" name="movieTitleTag">  
                        <br><br>

						<label for="movie">Search for users by TAGs:</label>
							<input type="text" placeholder="Tag" id="tag" name="tag">  
                        <br><br>
						
                        <input type="submit" name ="tagSubmit" value="Submit">

                        </form>

						<hr>
                        
						<form method="post" action="viewerstats.php">

						<label for="movie">Segregate Viewers by Ratings for movie:</label>
							<input type="text" placeholder="Movie Title" id="rating_movieTitle" name="rating_movieTitle">  
                        <br><br>

                        <input type="submit" name ="segregateSubmit" value="Submit">

                        </form>
						
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
                        <h1 class="title text-center">Viewer Statistics </h1>
						<?php
						if(isset($_POST["ratingSubmit"])) {
							if ($movieTitle != "All" && $movieTitle != ""){
								echo '<h2 class="title text-center">For '.$movieTitle . " </h2>";
								}
								if($movieTitle == " "){
								echo "
								
								<body>
								<div class=\"column\">
								<div class=\"card\">
									<h1> SELECT A MOVIE FIRST</h1>
								</div>
								</body>
								<hr>
								";
								}
								else{
							include '4-ViewerStats/displayViewerStats.php'; 
							}
						}
						else if(isset($_POST["yearSubmit"])){
							if ($year == "" || $year == "All"){
								echo "
								
								<body>
								<div class=\"column\">
								<div class=\"card\">
									<h1> ENTER A YEAR FIRST</h1>
								</div>
								</body>
								<hr>
								";
								}
								else{
								include '4-ViewerStats/displayViewerbyYear.php';
							}
						}
						else if(isset($_POST["tagSubmit"])){
							if ($tag == ""){
								echo "
								
								<body>
								<div class=\"column\">
								<div class=\"card\">
									<h1> ENTER A TAG FIRST</h1>
								</div>
								</body>
								<hr>
								";
								}
								else{
								include '4-ViewerStats/displayViewerbyTags.php';
							}
						}else if(isset($_POST["segregateSubmit"])) {
							if ($rating_movieTitle != "All" && $rating_movieTitle != ""){
								echo '<h2 class="title text-center">For '.$rating_movieTitle . " </h2>";
								}
								if($rating_movieTitle == " "){
								echo "
								
								<body>
								<div class=\"column\">
								<div class=\"card\">
									<h1> SELECT A MOVIE FIRST</h1>
								</div>
								</body>
								<hr>
								";
								}
								else{
							include '4-ViewerStats/segregateViewersbyRatings.php'; 
							}
						}
						else{
							echo "
								<body>
								<div class=\"column\">
								<div class=\"card\">
									<h1> SELECT ANY QUERY</h1>
								</div>
								</body>
								<hr>
								";
						}
						 ?>

						
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
	
	
	

  
    
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
<footer>
	<br>
	
</footer>
</html>