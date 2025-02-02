<?php include 'configDB.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-right">
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

			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	 
	 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					</div>
				</div>			 		
			</div>    	
    		<div class="row">  	
	    		<div class="col-sm-6">
	    			<div class="contact-info">
						 <h2 class="title text-center">New movie rating (Movie in DB)</h2>
						 <p> The predicted rating outputted by this section assumes that the review panel ratings and tags are already in the database. We selected a sample from the population of users in the database that had given a rating/tag to the user-selected movie to be the review panel using the rand() function in SQL.
						<br><br>
						 <form method="post" action="">
                            <label for="movie">Movie Title:</label>
                                <input type="text" placeholder="Movie Title" id="movieTitle_r" name="movieTitle_r">  
                            <br><br>
							<label for="movie">Movie Year:</label>
                                <input type="text" placeholder="Release year" id="year_r" name="year_r">  
                            <br><br>
                            <input type="submit" value="Submit">
                        </form> 
						 <h2 class="title text-center">New movie rating (Movie in not DB)</h2>
						 <p> The predicted rating outputted by this section assumes that Review panel ratings and tags are given as user input.
							 <br><br>
                        <form method="post" action="">
                            <label for="movie">Movie Title:</label>
                                <input type="text" placeholder="Movie Title" id="movieTitle_n" name="movieTitle_n">  
                            <br><br>
							<label for="movie">Movie Year:</label>
                                <input type="text" placeholder="Release year" id="year_n" name="year_n">  
                            <br><br>
							<label for="movie">User Ids (comma separated):</label>
                                <input type="text" placeholder="User Ids" id="users_n" name="users_n">  
                            <br><br>
							<label for="movie">Tags (comma separated):</label>
                                <input type="text" placeholder="Tags" id="tags_n" name="tags_n">  
                            <br><br>
							<label for="movie">Ratings (comma separated):</label>
                                <input type="text" placeholder="Ratings" id="ratings_n" name="ratings_n">  
                            <br><br>
                            <input type="submit" value="Submit">
                        </form> 
						<?php include '5-PredictedRating/predictedViewerRating2.php'; ?>
	    			</div>
	    		</div>
	    		<div class="col-sm-6">
	    			<div class="contact-info">
                        <h2 class="title text-center">User Personality for New Movie (focus on genre)</h2>
						<p>The predicted personality outputted by this section will also incorporate the genre & movies linked to the tags inputted</p>
                        <br><br>
						<form method="post" action="">

                            <label for="movie">Movie Title:</label>
                                <input type="text" placeholder="Movie Title" id="movieTitle" name="movieTitle">  
                            <br><br>


                            <label for="movie">Tags (comma separated):</label>
                                <input type="text" placeholder="Tags" id="tags" name="tags">  
                            <br><br>


                            <input type="submit" value="Submit">


						</form>


						<?php include '6-Personality/getPersonalityData.php'; ?>

						<br>



						<h2 class="title text-center">User Personality for New Movie (focus on movies)</h2>
						<p>The predicted personality outputted by this section will NOT incorporate the genre linked to the tags inputted. It will only incorporate the movies linked to the tags inputted.</p>
                        <br><br>
						<form method="post" action="">

                            <label for="movie">Movie Title:</label>
                                <input type="text" placeholder="Movie Title" id="movieTitle2" name="movieTitle2">  
                            <br><br>


                            <label for="movie">Tags (comma separated):</label>
                                <input type="text" placeholder="Tags" id="tags2" name="tags2">  
                            <br><br>


                            <input type="submit" value="Submit">


						</form>


						<?php include '6-Personality/getPersonalityData2.php'; ?>

						<br>

                        
	    			</div>
    			</div> 


	    	</div>  
    	</div>	
    </div><!--/#contact-page-->
	
	

  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="js/gmaps.js"></script>
	<script src="js/contact.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>