<?php


        $movieTitleChanged = "%$movieTitle%";
        $avgRating = "SELECT AVG(rating) 
        FROM Coursework.ratings 
        WHERE movieID = 
        (SELECT movieID 
        FROM Coursework.movies 
        WHERE title LIKE ? AND year = ?)";
        
        $stmt = $mysqli->prepare($avgRating);
        $stmt->bind_param("si", $movieTitleChanged, $year);
        $stmt->execute();
        
        //$ratings = $mysqli->query($avgRating);

        

        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $idNo = $row_result['AVG(rating)'];

        $movieID = "SELECT imdbID, tmdbiD FROM Coursework.links WHERE movieID =(SELECT movieID FROM Coursework.movies WHERE title LIKE \"%$movieTitle%\" AND year = $year);";
        
        
        $idResult = mysqli_fetch_assoc($mysqli->query($movieID));
        

        
        echo "<h2 class=\"title text-center\">Report: $movieTitle ($year) </h2>";
        
        

        $imdbID = $idResult['imdbID'];
        $tmdbID = $idResult['tmdbiD'];
        //$imdbID = "0114709";
        
        //echo $imdbID;
        //echo $tmdbID;
        
        
        

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
        //         $imageURL = $data['image'];
        //         echo "<center>
        //         <img src = $imageURL align = \"center\" width = \"240\" height = \"330\" >
        //         </center>";
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
        //echo $tmdbResponse;
        curl_close($curl);

        if ($tmdbErr){
                echo "cURL Error #:" . $tmdbErr;
        } else {
                //echo "hellooo";
                // $tmdbResponse;
                $data = json_decode($tmdbResponse, true);
                
                $tmDBrating = $data['vote_average'];
                

                $posterPath = $data['poster_path'];
                echo "<center>
                <img  src = https://image.tmdb.org/t/p/original$posterPath align = \"center\"width = \"240\" height = \"330\"  >
                </center>";
                echo "<br>";

                echo $data['overview'];

                echo "<br>";

                echo "<h4> tmDB Rating: $tmDBrating/10 </h4>";
                }

        

        echo "<h4> Rating: $idNo/5 </h4>";
        

        

        //echo "nothing?";


?>