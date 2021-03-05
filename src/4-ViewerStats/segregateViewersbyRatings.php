<?php
// echo "|moviesList ".$moviesList ." |\n|";
// print_r($moviesList);
// echo $movieTitle;


$users1 =  array();
$users2 =  array();
$users3 =  array();
$users4 =  array();
$users5 =  array();
$usersAll = array();



// print("||".$movieTitleTag."||");
if ($rating_movieTitle != " "){
    while ($row = mysqli_fetch_assoc($ratingLE1))
    {
        $users1[]  = $row['userId'];
    }
    while ($row = mysqli_fetch_assoc($ratingBET12))
    {
        $users2[]  = $row['userId'];
    }
    while ($row = mysqli_fetch_assoc($ratingBET23))
    {
        $users3[]  = $row['userId'];
    }
    while ($row = mysqli_fetch_assoc($ratingEQ3))
    {
        $users4[]  = $row['userId'];
    }
    while ($row = mysqli_fetch_assoc($ratingBET34))
    {
        $users5[]  = $row['userId'];
    }

    
    $getCount = array(count($users1),count($users2),count($users3),
    count($users4),count($users5));
    $getMax = max($getCount);
    // foreach($getCount as $u){
    //   echo "$u \n";
    // }
    $usersAll = array($users1,$users2,$users3,$users4,$users5);

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
      border-spacing: 2;
  }

  tbody, thead tr { display: block; }

  tbody {
      height: 250px;
      overflow-y: auto;
      overflow-x: hidden;
  }

  tbody td, thead th {
    text-align: center;
      width: 140px;
  }
  thead th:first-child {
      width: 120px; 
  }
  tbody td:first-child {
      width: 120px; 
  }
  thead th:last-child {
      width: 156px; /* 140px + 16px scrollbar width */
  }
</style>
</head>


<body>

<!-- users based on ranking -->
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
      <div class="white-box">
          <div class="d-md-flex mb-3">
              <h3 class="box-title mb-0">Rating</h3>
              
          </div>
          <div class="table-responsive">
              <table class="table no-wrap" >
                  <thead>
                      <tr>
                          <th class="border-top-0"> 1 </th>
                          <th class="border-top-0"> 2 </th>
                          <th class="border-top-0"> 3 </th>
                          <th class="border-top-0"> 4 </th>
                          <th class="border-top-0"> 5 </th>
                      </tr>
                  </thead>
                  <tbody >
                  <?php
                  if($rating_movieTitle!=" "){
                    for ($i=0; $i < $getMax; $i++) { 
                      echo "
                      <tr>
                      ";
                      for ($k=0; $k <  5 ; $k++) { 


                        if (!empty($usersAll[$k][$i])) {
                          
                            echo "
                                <td >"; print_r($usersAll[$k][$i]); echo "</td>
                            ";
                            
                        }
                        else{
                          echo "
                                <td >"; echo " "; echo " </td>
                            ";
                        }
                        
                      }
                      echo "
                        <tr>
                        "; 
                    }
                      
                    }
                  ?>
                      
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  </div>



</body>
<hr>


</html>
