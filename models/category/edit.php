<?php
header("Content-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        $element = $getOneCategory($id);
        $element ?
            normalResponse(['data' => $element]) 
            : notFound("Elemenet sa takvim id-em nije pronadjen");
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
} else {
    notFound("Servis nije pronadjen");
}
