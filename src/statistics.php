<?php
// SQL query for most popular movies 
$sql = "SELECT COUNT(r.rating) as count, r.movieId, m.title
FROM Coursework.ratings as r
JOIN Coursework.movies as m ON  r.movieId = m.movieId
WHERE timestamp = (SELECT MAX(timestamp) FROM ratings as r2 WHERE r2.userId = r.userId and r2.movieId = r.movieId)
GROUP BY movieId
ORDER BY COUNT(r.rating) DESC"; 

//SQL query for most polarizing movies
$sql2 = "SELECT VARIANCE(r.rating) as variance, r.movieId, m.title
FROM ratings as r
JOIN movies as m ON  r.movieId = m.movieId
WHERE timestamp = (SELECT MAX(timestamp) FROM ratings as r2 WHERE r2.userId = r.userId and r2.movieId = r.movieId)
GROUP BY MovieId
ORDER BY VARIANCE(r.rating) DESC"; 
                        ?>