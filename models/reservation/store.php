<?php 
session_start();
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST['tour_date_id'];

    include '../validation.php';
    $validation = reservationFormValidation($id);
    if(count($validation) > 0){
        validationError($validation);
    }else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            reservationStore($_SESSION['user']->id, $id);
            normalResponse(['message' => 'Uspesno ste reservali putovanje']);
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
}else{
    notFound('Stranica nije pronadjena');
}