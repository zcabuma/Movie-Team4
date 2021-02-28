<?php

$ids_years = array();
// $ids_all_years = array();
// $years = array();




if ($year !="All" && $year != ""){
  while ($row = mysqli_fetch_assoc($displayUsersbyYears))
  {
//     print("Hello");
// echo "<br>";
//     print_r($row);
//     echo "<br>";
// print("Hello");
$ids_years[]  = $row['ids'];
  }
}



// while($row = mysqli_fetch_assoc($displayUsersbyAllYears))
// {
  
//     $ids_all_years[] = $row['ids'];
    
//     $years[] = $row['year'];
    
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
  <?php if ($year !="All" && $year != ""){
    $count_ids_by_year = count($ids_years);
   echo "
    <div class=\"card\">
    <h3>Users Who Watched <strong>$year</strong>'s movies</h3>
    <br>
    <h2>$count_ids_by_year</h2>
    </div>
    
  ";}
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
                          <th class="border-top-0">Viewer ids</th>
                          <th class="border-top-0">Year</th>
                      </tr>
                  </thead>
                  <tbody >
                  <?php
                  // $list_users_display = "";
                  foreach($ids_years as $i => $id){
                    $j = $i + 1;
                    echo "
                      <tr>
                          <td> $j</td>
                          <td class=\"txt-oflo\">$id</td>
                          <td class=\"txt-oflo\">$year </td>
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
