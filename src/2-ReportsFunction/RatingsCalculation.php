<?php   


        //get id first
        $movieTitleChanged = "%$movieTitle%";
        $movieID = "SELECT movieID FROM Coursework.movies 
        WHERE title LIKE ? AND year = ?";

        

        $parameters = array();
        array_push($parameters, $movieTitleChanged); 
        array_push($parameters, $year); 
        
        // echo $idNo;

        global $mysqli;
        $hashed_query = sha1($movieID . serialize($parameters));
        //echo "hashed query is";
        //echo $hashed_query;
        // cache stuff
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
            $idNo = $cached_ans['movieID']; 
        //     echo "Got from cache"; 
        }
        else{
        $stmt = $mysqli->prepare($movieID);
        $stmt->bind_param("si", ...$parameters);
        $stmt->execute();
        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $idNo = $row_result['movieID'];
        $arr_cache = array();
        $arr_cache['movieID'] = $idNo;
        // adding to cache
        put_to_cache($hashed_query, $arr_cache); 
        }
        
        
        //Get title information
        //SQL INJECTION PROTECTION STATEMENTS
        $avgRating = "SELECT AVG(rating) 
        FROM Coursework.ratings 
        WHERE movieID = ?";

        $hashed_query = sha1($avgRating . serialize($idNo));
        //echo "hashed query is";
        //echo $hashed_query;
        // cache stuff
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
        $avg_rating = $cached_ans['AVG(rating)']; 
        // echo "Got from cache"; 
        }
        else{
        $stmt = $mysqli->prepare($avgRating);
        $stmt->bind_param("i", $idNo);
        $stmt->execute();
        $row_result = mysqli_fetch_assoc($stmt->get_result());
        $avg_rating = $row_result['AVG(rating)'];
        $arr_cache = array();
        $arr_cache['AVG(rating)'] = $avg_rating;
        // adding to cache
        put_to_cache($hashed_query, $arr_cache); 
        }
        
        
        //$ratings = $mysqli->query($avgRating);

        

        
        

        //SQL QUERY TO GET THE IMDB AND TMDB IDs
        $links = "SELECT imdbID, tmdbiD FROM Coursework.links 
        WHERE movieID = ? ";

        $hashed_query = sha1($links . serialize($idNo));
        //echo "hashed query is";
        //echo $hashed_query;
        // cache stuff
        $cached_ans = get_from_cache($hashed_query);
        if ($cached_ans != ""){
        $idResult = $cached_ans;
        // echo "Got from cache"; 
        }
        else{
        $stmt = $mysqli->prepare($links);
        $stmt->bind_param("i", $idNo);
        $stmt->execute();
        $idResult = mysqli_fetch_assoc($stmt->get_result());
        
        $arr_cache = array();
        $arr_cache = $idResult;
        // adding to cache
        put_to_cache($hashed_query, $arr_cache); 
        }
        
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