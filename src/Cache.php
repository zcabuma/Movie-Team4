<?php   

$mc = new Memcached();                                                             
$mc->addServer("mymemcached", 11211); 
 

function get_from_cache($query){ //function parameters, two variables.
    global $mc; 
    $result = $mc->get($query); 
    return $result; 
}

function put_to_cache($query, $result){
    global $mc; 
    //echo "I am trying to add ";
    //echo print_r($result);
    $new_result = $mc->add($query, $result); 
    echo var_dump( $mc->getAllKeys() );
    // echo "added successfully"; 
    // echo $new_result? 'true' : 'false'; 
}



?>