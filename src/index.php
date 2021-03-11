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
?>
<a href="browseFilms.php">Browser Page</a>
<?php include 'database.php'; ?>