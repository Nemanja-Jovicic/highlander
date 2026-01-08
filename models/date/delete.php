<?php 
header("Content-type:Application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST['id'];
    $status = $_POST['status'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        softDelete('tour_dates', $status, $id);
        normalResponse(['data' => $replaceAfterSoft('tour_dates', $id)]);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}
else{
    notFound("Stranica nije pronadjena");
}