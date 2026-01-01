<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "GET"){
    $id = $_GET['id'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        normalResponse(getOneTour($id));
    } catch (PDOException $th) {
        invalidArugmentException($th->getMessage());
    }
}else{
    notFound('Stranica nije pronadjena');
}