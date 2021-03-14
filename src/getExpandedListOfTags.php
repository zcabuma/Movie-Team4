<?php 

function check_cache_and_query_for_tagData($part_4_sql, $para_count, $parameters){
    global $mysqli;
    $hashed_query = sha1($part_4_sql . serialize($parameters));
    $pred_rating = array();
    // cache stuff
  
    $cached_ans = get_from_cache($hashed_query);
    if (false){
      $pred_rating = $cached_ans;
  
        // echo "Got from cache"; 
    }
    else{
        // mysqli_report(MYSQLI_REPORT_ALL);
        $moviestmt2 = $mysqli->prepare($part_4_sql);
        $moviestmt2->bind_param($para_count, ...$parameters); 
        $moviestmt2->execute();
        $moviesList2 = $moviestmt2->get_result();
        // echo "this is final reuslt-000000";
        while($row = mysqli_fetch_array($moviesList2, MYSQLI_ASSOC)){
            array_push($pred_rating, $row['tag']);
            // echo $row['tag'];
        }

        $arr_cache = array();
        $arr_cache = $pred_rating;
  
        put_to_cache($hashed_query, $arr_cache); 
    }
    return $pred_rating;
  }

function clean_string_tags($data){
    $listOfStrings =  explode(',', $data);
   $tags = array(); 
//    echo count($listOfStrings);
   foreach ($listOfStrings as $value){
       $processedValue = SQL_test_input($value);
       $processedValueNew = $processedValue;
       $finalprocessedValueNew =  substr($processedValueNew, 1, -1);
       array_push($tags, $finalprocessedValueNew);
    //    echo $finalprocessedValueNew;
   }
   return $tags;
  }

function getAllTags($tags){
    // echo "these are the tags we pass in";
    // echo $tags;
    $tagsUnprocessed = $tags;
    $tags = clean_string_tags($tags);
    $count = count($tags);
    $placeholders = implode(',', array_fill(0, $count, '?'));
    $overallCommandToGetPersonalityData = "SELECT tagGroups.tag FROM Coursework.tagGroups 
    WHERE tagGroups.group IN 
    (SELECT tagGroups.group FROM Coursework.tagGroups WHERE tagGroups.tag IN ($placeholders)) ";
    $bindStr = str_repeat('s', $count);
    // echo "FINAL THIS IS IN";
    foreach ($tags as $value){
        // echo $value;
    }
    $tagData = check_cache_and_query_for_tagData($overallCommandToGetPersonalityData, $bindStr, $tags);
    if(count($tagData) == 0){
        $tagData = $tags;
        // echo "it is empty";
    }
    // echo "FINAL THIS IS IN";
    foreach ($tagData as $value){
        // echo $value;
    }
    return $tagData;
}

?>