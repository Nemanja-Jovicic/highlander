<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST['id'];
    $promotion = $_POST['promotion'];

    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        changePromotion($id, $promotion);
        normalResponse(['data' => $changeAfterPromotion($id) ]);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}else{
    notFound("Stranica nije pronadjena");
}