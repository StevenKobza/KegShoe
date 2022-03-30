<?php
    //For this program, you will either input ?type= for just the type, ?state= for just the state, or ?type=&state= for both the state and the type
    $breweryArray;
    //I wanted to focus on the two that were set out but I also wanted to leave room to expand on it if necessary. 
    function getState($state) {
        $page = 1;
        //I noticed while looking through the documentation that there may be more than 1 page of breweries in a state, and as such I wanted to include them
        $tempJsonArray = json_decode(file_get_contents("https://api.openbrewerydb.org/breweries?by_state=$state&per_page=50&page=1"));
        $breweryArray = $tempJsonArray;
        if (count($tempJsonArray) == 50) {
            $page++;
            while (count($tempJsonArray) == 50) {
                $tempJsonArray = json_decode(file_get_contents("https://api.openbrewerydb.org/breweries?by_state=$state&per_page=50&page=$page"));
                $breweryArray = array_merge($breweryArray, $tempJsonArray);
                $page++;
                
            }
            return $breweryArray;
        } else {
            return $breweryArray;
        }
    }
    //Very similar functions for both of these and they can be expanded upon if necessary
    function getTypeOfBrew($type) {
        $page = 1;
        //I noticed while looking through the documentation that there may be more than 1 page of a type of brewery and wanted to include them.
        $tempJsonArray = json_decode(file_get_contents("https://api.openbrewerydb.org/breweries?by_type=$type&per_page=50&page=1"));
        $breweryArray = $tempJsonArray;
        if (count($tempJsonArray) == 50) {
            $page++;
            while (count($tempJsonArray) == 50) {
                $tempJsonArray = json_decode(file_get_contents("https://api.openbrewerydb.org/breweries?by_type=$type&per_page=50&page=$page"));
                $breweryArray = array_merge($breweryArray, $tempJsonArray);
                $page++;
                
            }
            return $breweryArray;
        } else {
            return $breweryArray;
        }
    }

    function getStateAndType($state, $type) {
        $page = 1;
        $tempJsonArray = json_decode(file_get_contents("https://api.openbrewerydb.org/breweries?by_type=$type&by_state=$state&per_page=50&page=1"));
        $breweryArray = $tempJsonArray;
        if (count($tempJsonArray) == 50) {
            $page++;
            while (count($tempJsonArray) == 50) {
                $tempJsonArray = json_decode(file_get_contents("https://api.openbrewerydb.org/breweries?by_type=$type&by_state=$state&per_page=50&page=$page"));
                $breweryArray = array_merge($breweryArray, $tempJsonArray);
                $page++;
                
            }
            return $breweryArray;
        } else {
            return $breweryArray;
        }
    }
    //This might get slow as you introduce more and more different things to search through the API for, but for the two provided I believe that it is sufficient
    if (isset($_GET["state"], $_GET["type"])) {
        $stateToUse = $_GET["state"];
        $typeToUse = $_GET["type"];
        $output = getStateAndType($stateToUse,  $typeToUse);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($output);
    }
    elseif (isset($_GET["state"])) {
        $stateToUse = $_GET["state"];
        $output = getState($stateToUse);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($output);
    }
    elseif (isset($_GET["type"])) {
        $typeToUse = $_GET["type"];
        $output = getTypeOfBrew($typeToUse);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($output);
    }


?>
