<?php
session_start();
header("Content-type:application/json");
include '../response_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']->id;
    $tour_id = $_POST['tour_id'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        deleteTourFromWishlist($user_id, $tour_id);
        normalResponse([
            'message' => 'Uspesno ste izbrisali stavku!',
            'data'=> getAllItemsFromWishlist($user_id)
        ]);
    } catch (PDOException $e) {
        intervalServerError($e->getMessage());
    }
} else {
    notFound('Stranca nije pronadjena');
}
