<?php
    require_once("config.php"); //Holds our omdb API key

    function omdbGetImdbRecord($ImdbId) {
        $path = "http://www.omdbapi.com/?i=$ImdbId&apikey=$omdbKey";
        $json = file_get_contents($path);
        return json_decode($json, TRUE);
    }
?>