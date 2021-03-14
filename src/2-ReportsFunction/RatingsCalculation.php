<?php
        $movieTitleChanged = "%$movieTitle%";
        $movieID = "SELECT movieID FROM Coursework.movies 
        WHERE title LIKE ? AND year = ?";

        $stmt = $mysqli->prepare($movieID);
        $stmt->bind_param("si", $movieTitleChanged, $year);
        $stmt->execute();

        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $idNo = $row_result['movieID'];
        echo $idNo;

        //Get title information
        //SQL INJECTION PROTECTION STATEMENTS
        $movieTitleChanged = "%$movieTitle%";
        $avgRating = "SELECT AVG(rating) 
        FROM Coursework.ratings 
        WHERE movieID = ?";
        
        $stmt = $mysqli->prepare($avgRating);
        $stmt->bind_param("i", $idNo);
        $stmt->execute();
        
        //$ratings = $mysqli->query($avgRating);

        

        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $avg_rating = $row_result['AVG(rating)'];
        

        //SQL QUERY TO GET THE IMDB AND TMDB IDs
        $movieID = "SELECT imdbID, tmdbiD FROM Coursework.links 
        WHERE movieID = ? ";
        $stmt = $mysqli->prepare($movieID);
        $stmt->bind_param("i", $idNo);
        $stmt->execute();
        
        $idResult = mysqli_fetch_assoc($stmt->get_result());
        $imdbID = $idResult['imdbID'];
        $tmdbID = $idResult['tmdbiD'];

        
        echo "<h2 class=\"title text-center\">Report: $movieTitle ($year) </h2>";
        
        // COMMENTED OUT IMDB API CALL (DUE TO 100 CALLS PER DAY LIMIT)

        // $curl = curl_init();

        // curl_setopt_array($curl, [
        //         CURLOPT_URL => "https://imdb-api.com/en/API/Title/k_23zo2q7v/tt$imdbID",
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_ENCODING => "",
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 10,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => "GET",
                
        // ]);

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);
        

        // if ($err) {
        //         echo "cURL Error #:" . $err;
        // } else {
        //         $data = json_decode($response, true);
        //         echo "<br><br>";
        //         echo $data['plot'];
        //         echo "<br><br>";
        //         echo $data['awards'];
        //         echo "<br><br>";
                
               
                
        //         $imDBrating = $data['imDbRating'];
        //         echo "<h4> imDB Rating: $imDBrating/10 </h4>";;
        //         //echo $data[0]->{'title'};
        //         //echo "<br><br>";
        //         //echo $response;


        //         // 'awards' 'image' 'companies' 'imDbRating' 'similars' 
        // }
        $curl = curl_init();
        $tmdbID = (int) $tmdbID;
        //echo $tmdbID;
        //echo "https://api.themoviedb.org/3/movie/$tmdbID?api_key=acd7122df7779323db781c38430de0ac&language=en-US";
        curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/movie/$tmdbID?api_key=acd7122df7779323db781c38430de0ac&language=en-US",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                
        ]);

        $tmdbResponse = curl_exec($curl);
        $tmdbErr = curl_error($curl);
        curl_close($curl);

        if ($tmdbErr){
                echo "cURL Error #:" . $tmdbErr;
        } else {
                $data = json_decode($tmdbResponse, true);
                
                $tmDBrating = $data['vote_average'];
                

                $posterPath = $data['poster_path'];

                $overview = $data['overview'];

                echo "<div class=\"container\">
                        <div class=\"row\">
                                <center>
                                         <img src = https://image.tmdb.org/t/p/original$posterPath align = \"center\"width = \"240\" height = \"330\"  >
                                </center>
                                <br>
                        </div>
                        <div class=\"row\">
                                
                                $overview
                                
                        <h2>tmDB Rating: $tmDBrating/10 </h2>
                        <h2>Rating: $avg_rating/5 </h2>

                        ";


                

        
                }
        

        

        //echo "nothing?";


?>