<?php
    try{
        $host = "localhost";
        $bdd = new PDO("mysql:host=localhost;dbname=yb_aventure;charset=utf8", "root", "");    
    }
    catch(Exception $e){
        echo $e -> getMessage();
        die;
    }
?>