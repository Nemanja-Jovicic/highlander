<?php 
header("Content-type:Application/json");
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST['id'];
    $status = $_POST['status'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        softDelete('tour_date', $status, $id);
        normalResponse(['data' => $replaceAfterSoft('tour_date', $id)]);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}
else{
    notFound("Stranica nije pronadjena");
}