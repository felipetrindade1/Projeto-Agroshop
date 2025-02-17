<?php
try {
    $user = "root";
    $pass = "";
    $con = new PDO('mysql:host=localhost;dbname=projeto', $user, $pass);
    /*if($con){
        echo "Deu bom";
    }*/
} catch(PDOException $e) {
    echo "Deu muito ruim $e";
}