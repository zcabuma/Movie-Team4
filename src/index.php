

<?php
echo "Proof of load balancing <br>";
echo "Currently being hosted on: ";
echo gethostname(); // may output e.g,: sandie
echo "<br>";
// Or, an option that also works before PHP 5.3
//echo php_uname('n'); // may output e.g,: sandie
?>



<?php   

$mc = new Memcached();                                                             
$mc->addServer("mymemcached", 11211);                                              
$mc->add("key1", "value1");                                                        
$mc->add("key2", "value2");                                                        
$mc->add("key3", "value3");                                                        
$r1 = $mc->get("key1");
if ($r1 == ""){
    echo "yep key1 is null too";
}
$r4 = $mc->get("key4");
if ($r4 == ""){
    echo "yep it is null";
}
echo "key1 : " . $r1. "\n";                                          
echo "key2 : " . $mc->get("key2") . "\n";                                          
echo "key3 : " . $mc->get("key3") . "\n";   
echo "key4 : " . $r4. "\n";

echo "<br>";
echo "<br>";
echo "<br>";
?>
<?php 
echo "<br>";
echo "<br>";
echo "<br>";
include 'database.php'; ?>


<head>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Index</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">   
    
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 50px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 4px;
  
}

</style>
    
</head><!--/head-->

<button  class ="button" style = "float: left;margin-left: 250px " ><a href="browseFilms.php">Browser Page</a></button>


<button  class ="button"style="float: right;margin-right: 250px;"><a href="login.php">Admin Page</a></button>


