<?php include 'configDB.php'; ?>

<?php include '1-BrowsingFilms/filteringFunctions.php'; ?>



<!DOCTYPE html>
<html lang="en">
<head>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Movies Browser</title>
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
</head><!--/head-->

<body>


	<header id="header"><!--header-->
	<li><a href="index.php"><i class="fa fa-star"></i> Index Page</a></li>
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
							
								<li><a href="viewerstats.php"><i class="fa fa-star"></i> Viewer Stats</a></li>
								<li><a href="browseFilms.php"><i class="fa fa-star"></i>Current movies</a></li>
								<li><a href="predictedPage.php"><i class="fa fa-crosshairs"></i>Future movies</a></li>
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
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						
                        <h2>Filter</h2>
                        
                        <form method="post" action="browseFilms.php">
                        <label for="genre">Choose a genre:</label>
                        <select name="genre" id="genre">

						<?php include '1-BrowsingFilms/getUniqueGenres.php'; ?>
                        
                        </select>
                        <br><br>

						
                        
                        <label for="rating">Choose a rating:</label>
							<select name="rating" id="rating">
							<?php include '1-BrowsingFilms/getUniqueRatings.php'; ?>
							</select>
                        <br><br>


						<label for="statistics">Statistics</label>
							<select name="statistics" id="statistics">
							<option disabled selected value> - select an option - </option>
								<option value="popular">Most Popular</option>
								<option value="polarizing">Most Polarizing</option>
							</select>
                        <br><br>

						<label for="movie">Search for movie:</label>
							<input type="text" placeholder="Movie Title" id="movieTitle" name="movieTitle">  
                        <br><br>

						

							<label for="movie">Enter a Date Range (start&end):</label>
								<input type="text" id="start" name="start" placeholder="Start Year"> 
								<input type="text" id="end" name="end" placeholder="End Year">  
                        	<br><br>

                        <input type="submit" value="Submit">

                        </form>
                        
						
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
				
					<div class="features_items"><!--features_items-->
					
                        <h2 class="title text-center">Movies</h2>
						
                        <?php include 'displayMoviesGrid.php'; ?>
						Click on these pages to return to browse all movies.
						<ul class="pagination">
							<li class="active"><a href="">1</a></li>
							<li><a href="browseFilms.php?page=2">2</a></li>
							<li><a href="browseFilms.php?page=3">3</a></li>
							<li><a href="browseFilms.php?page=4">4</a></li>
							<li><a href="browseFilms.php?page=5">5</a></li>
							<li><a href="browseFilms.php?page=6">6</a></li>
							<li><a href="browseFilms.php?page=7">7</a></li>
							<li><a href="browseFilms.php?page=8">8</a></li>
							<li><a href="browseFilms.php?page=9">9</a></li>
							<li><a href="browseFilms.php?page=10">10</a></li>
							<li><a href="browseFilms.php">&raquo;</a></li>
						</ul>
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
</html>