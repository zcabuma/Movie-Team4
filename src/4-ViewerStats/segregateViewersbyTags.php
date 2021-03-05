<?php
// echo "|moviesList ".$moviesList ." |\n|";
// print_r($moviesList);
// echo $movieTitle;

$tags = array();
$usersAll = array();
$usersAllCount = array();



// print("||".$movieTitleTag."||");
if ($tag_movieTitle != " "){
    while ($row = mysqli_fetch_assoc($displaytagSeg))
    {
      $tags[]  = $row['tag'];
    }

    for ($i=0; $i < count($tags) ; $i++) { 
      $tag2 = $tags[$i];
      // print_r($tag2);
      $displayUsersbyTagsSegMovieCommand = "SELECT userId as users 
      FROM Coursework.tags  
      WHERE tag LIKE \"$tag2\" 
      AND movieId 
      IN ( SELECT movieId 
      FROM Coursework.movies 
      WHERE title LIKE \"%$tag_movieTitle%\")";    

      // echo "$displayUsersbyTagsSegMovieCommand";
      $displayUsersbyTagsSegMovie= $mysqli->query($displayUsersbyTagsSegMovieCommand);

      $userIds = array();
      while ($row2 = mysqli_fetch_assoc($displayUsersbyTagsSegMovie))
      {
        $userIds[]  = $row2['users'];
      }
      $usersAllCount[$i] = count($userIds);
      $usersAll[$i] = $userIds;
        
        
    }
    // print_r($usersAll[0][0]);
    // echo "   g   ".$usersAll[0][1];
    $getMax = count($usersAll);
    // echo "$getMax";   


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
          <?php
          for ($a=0; $a < $getMax ; $a = $a + 5) { 
            if ($a % 5 == 0) {
              echo "
              <table class=\"table no-wrap\" >
                <thead>
                    <tr> ";
            }
            $b = $a;
            $d = $a;
            $c = 0;
            while($c < 5 && !empty($tags[$b])){
              echo " <th class=\"border-top-0\">"; echo "$tags[$b]"; echo "</th>";
              $b++;
              $c++;
            }
            echo "</tr>
            </thead>
            <tbody >";
            
              for ($x=0; $x < max($usersAllCount); $x++) { 
                

                echo "
                <tr>
                ";
                for ($k=$a; $k <  $b ; $k++) { 
                  // echo "k is ". $k;
                  // echo "x is ". $x ;
                  // echo " ".empty($usersAll[$k][$x]);

                  if (!empty($usersAll[$k][$x])) {
                      echo "
                          <td >"; print_r($usersAll[$k][$x]); echo "</td>
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

              echo "</tbody>
              </table>";
            }
            
          
          ?>
                      
                  
          </div>
      </div>
  </div>
  </div>



</body>
<hr>


</html>
