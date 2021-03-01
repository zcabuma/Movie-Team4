<?php include '../configDB.php'; ?>
<?php
$movieTitle = $_GET["title"];
$year = $_GET["year"];

$part_4_sql = "SELECT AVG(rating)
FROM (SELECT AVG(rating) as rating
FROM Coursework.tags
JOIN Coursework.ratings on Coursework.ratings.movieId = Coursework.tags.movieId
WHERE Coursework.tags.tag in (SELECT DISTINCT tag 
FROM Coursework.tags
WHERE movieId = (SELECT movieId 
FROM Coursework.movies
WHERE title LIKE '%$movieTitle%' AND year = $year)) 
GROUP BY Coursework.tags.movieId) TMP;"; 

$avg_result = $mysqli->query($part_4_sql);

$row = mysqli_fetch_assoc($avg_result); 
$pred_rating = $row['AVG(rating)'];

// if pred_rating is NULL -> that means there are no tags associated with the movie in the DB
// In this case, we will just output the average panel viewer rating 
if (is_null($pred_rating)){
    $part_4_sql_2 = "SELECT AVG(rating)
    FROM Coursework.ratings
    JOIN Coursework.movies on Coursework.movies.movieId = Coursework.ratings.movieId
    WHERE Coursework.ratings.movieId = (SELECT movieId 
    FROM Coursework.movies
    WHERE title LIKE '%$movieTitle%' AND year = $year)"; 
    $avg_result = $mysqli->query($part_4_sql_2);
    $row = mysqli_fetch_assoc($avg_result); 
    $pred_rating = $row['AVG(rating)'];
}


$final_pred = $pred_rating
?>
<html>
<title>Movies Browser</title>
<h2>For movie <?php echo $movieTitle ?> released in <?php echo $year ?><h2>
<h3> Predicted movie rating is: <?php echo $final_pred ?> <h1>
</html>