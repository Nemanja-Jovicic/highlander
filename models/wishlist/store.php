<?php 
session_start();
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER['REQUEST_METHOD'] === "POST"){
    $user_id = $_SESSION['user']->id;
    $tour_id = $_POST['tour_id'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        wishlistStore($user_id, $tour_id);
        normalResponse([
            'message' => "Uspesno ste dodatli na listu zelja!"
        ]);
    } catch (PDOException $th) {
       intervalServerError($th->getMessage());
    }
}else{
    notFound("Stranica nije pronadjena");
}