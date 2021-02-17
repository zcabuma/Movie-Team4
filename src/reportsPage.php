<?php include 'configDB.php'; ?>
<?php
$movieTitle = $_GET["title"];
$year = $_GET["year"];
?>

<!DOCTYPE html>
<html lang="en">
<head>


<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head><!--/head-->

<body>
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
								<li><a href=""><i class="fa fa-star"></i> Page2</a></li>
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
    <div class="choose">
    <ul class="nav nav-pills nav-justified">
    <li><a href="browseFilms.php">Main Page</a></li>
</ul>
</div>
    <div class="padding-left">
					<div class="features_items"><!--features_items-->
                        

                        <?php include "2-ReportsFunction/RatingsCalculation.php";?>
						
						<?php include "2-ReportsFunction/drawPieCharts.php";?>

						<ul class="pagination">
							<li class="active"><a href="">1</a></li>
							<li><a href="">2</a></li>
							<li><a href="">3</a></li>
							<li><a href="">&raquo;</a></li>
						</ul>
					</div><!--features_items-->
				</div>
    
    

<!------ Include the above in your HEAD tag ---------->
				




	<script src="js/pie.js"></script>
    <script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>