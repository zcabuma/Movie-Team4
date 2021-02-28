<?php
// echo "|moviesList ".$moviesList ." |\n|";
// print_r($moviesList);
// echo $movieTitle;
$usercount = 0;
$user_count_ratings = 0;
$ids = array();
$usersids = array();
$ratings =  array();
$usersratings =  array();
$tag =  array();
$count_users_tag =  array();



while ($row = mysqli_fetch_assoc($total_watchers))
{
    $usercount  = $row['count'];
}

if ($rating !="All" && $rating != ""){
  while ($row = mysqli_fetch_assoc($displaycountUsers))
{
    
    $user_count_ratings  = $row['count'];
}
}

while($row = mysqli_fetch_assoc($displayUsers))
{
  
    $ids[] = $row['ids'];
    // foreach($ids as $value){
    //   $usersids[] = $value;
    // }
    $ratings[] = $row['rating'];
    // foreach($ratings as $value){
    //   $userratings[] = $value;
    // }
}

if ($movieTitle !="All" && $movieTitle != ""){
  while($row = mysqli_fetch_assoc($displaytag))
  {
    
    $tag[] = $row['tag'];
    $count_users_tag[] = $row['count_users'];
  
  }
}
// foreach($ids as $value){
//   $usersids[] = $value;
// }
// print_r($userratings);
// print(count($usersids));
// for ($i=0; $i < count($usersids) ; $i++) { 
//   print($usersids[$i]);
// }
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
      border-spacing: 0;
  }

  tbody, thead tr { display: block; }

  tbody {
      height: 250px;
      overflow-y: auto;
      overflow-x: hidden;
  }

  tbody td, thead th {
      width: 140px;
  }
  thead th:first-child {
      width: 40px; 
  }
  tbody td:first-child {
      width: 40px; 
  }
  thead th:last-child {
      width: 156px; /* 140px + 16px scrollbar width */
  }
</style>
</head>


<body>
<!-- tiles above -->
<div class="row">
  <div class="column">
    <div class="card">
    <h3>Total Number of Users Who Watched</h3>
    <br>
      <h2><? echo $usercount;?></h2>
    </div>
  </div>
  <?php if ($rating !="All" && $rating != ""){
   echo "<div class=\"column\">
    <div class=\"card\">
    <h3>Users Who Gave a Rating of <strong>$rating</strong></h3>
    <br>
      <h2>$user_count_ratings</h2>
    </div>
    
  </div>";}
  else{
    echo "<div class=\"column\">
    <div class=\"card\">
    <h3>Users For</h3>
    <br>
      <h2>All Rating</h2>
    </div>
    
  </div>";
  }
  ?>
</div>

<!-- break -->
<!-- users based on ranking -->
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
      <div class="white-box">
          <div class="d-md-flex mb-3">
              <h3 class="box-title mb-0">All Users</h3>
              
          </div>
          <div class="table-responsive">
              <table class="table no-wrap" >
                  <thead>
                      <tr>
                          <th class="border-top-0">#</th>
                          <th class="border-top-0">Viewer Ids</th>
                          <th class="border-top-0">Rating</th>
                      </tr>
                  </thead>
                  <tbody >
                  <?php
                  // $list_users_display = "";
                  foreach($ids as $i => $id){
                    $j = $i + 1;
                    $rating = $ratings[$i];
                    echo "
                      <tr>
                          <td> $j</td>
                          <td class=\"txt-oflo\">$id</td>
                          <td class=\"txt-oflo\">$rating </td>
                      </tr>
                    ";
                  }
                  ?>
                      
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12">
      <div class="white-box">
          <div class="d-md-flex mb-3">
              <h3 class="box-title mb-0">Tags</h3>
              
          </div>
          <div class="table-responsive">
              <table class="table no-wrap" >
                  <thead>
                      <tr>
                          <th class="border-top-0">#</th>
                          <th class="border-top-0">Tags</th>
                          <th class="border-top-0">Number of People</th>
                      </tr>
                  </thead>
                  <tbody >
                  <?php
                  // $list_users_display = "";
                  foreach($tag as $i => $t){
                    $j = $i + 1;
                    $f= $count_users_tag[$i];
                    echo "
                      <tr>
                          <td> $j</td>
                          <td class=\"txt-oflo\">$t</td>
                          <td class=\"txt-oflo\">$f </td>
                      </tr>
                    ";
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
