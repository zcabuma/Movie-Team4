
<?php                                                                                                                                                                                          
$mc = new Memcached();                                                             
$mc->addServer("mymemcached", 11211);                                              
// $mc->add("key1", "value1");                                                        
// $mc->add("key2", "value2");                                                        
// $mc->add("key3", "value3");                                                        

echo "key1 : " . $mc->get("key1") . "\n";                                          
echo "key2 : " . $mc->get("key2") . "\n";                                          
echo "key3 : " . $mc->get("key3") . "\n";   
echo "key4 : " . $mc->get("key4") . "\n";
?>

<a href="browseFilms.php">Browser Page</a>
<?php include 'database.php'; ?>