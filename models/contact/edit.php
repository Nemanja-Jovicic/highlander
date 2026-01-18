<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER['REQUEST_METHOD'] === "GET"){
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        normalResponse(['data' => getOneMessage($_GET['id'])]);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}else{
    notFound("Stranica nije pronadjena");
}