<?php 
header('Content-type:application/json');
include '../response_functions.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id  = $_GET['id'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        normalResponse(['data' => $getOneTourDateData($id)]);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}
else{
    notFound('Stranica nije pronadjena');
}