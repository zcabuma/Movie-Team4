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
	    		<div class="col-sm-6">

                <?php
                    $movieTitle = $_GET["title"];
                    $year = $_GET["year"];
                    ?>
                                        


                <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Rating </h1>
                            <?php
                            $rating_movieTitle = $movieTitle;
                            $tag_movieTitle = $movieTitle;
                            include '4-ViewerStats/getRatingDataForMainBrowser.php';
                            ?>

                            
                </div><!--features_items-->





	    		</div>
	    		<div class="col-sm-6">



                <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Tags </h1>
                            <?php
                            $rating_movieTitle = $movieTitle;
                            $tag_movieTitle = $movieTitle;
                            include '4-ViewerStats/getTagDataForMainBrowser.php'; 
                            ?>

                            
                </div><!--features_items-->
	    			


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












