<?php
session_start();
header("Conent-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $user_id = $_SESSION['user']->id;
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        deleteReservationItem($id);
        normalResponse([
            'message' => 'Uspsno ste izbrisali rezervaciju',
            'data' => getAllReservations($user_id)
        ]);
    } catch (PDOException $th) {
        invalidArugmentException($th->getMessage());
    }
} else {
    notFound("Stranica nije pronadjena");
}
