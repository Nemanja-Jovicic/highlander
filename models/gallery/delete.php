<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $image_id = $_POST['image_id'];
    try {
        require_once '../../config/connection.php';
        include '../validation.php';
        deleteFromGallery($image_id);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}else{
    notFound("Stranica nije pronadjena!");
}