<?php
session_start();
header("Content-type:application/json");
include '../response_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']->id;
    $wishlist_item = $_POST['wishlist_item_id'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        deleteTourFromWishlist($wishlist_item);
        normalResponse([
            'message' => 'Uspesno ste izbrisali stavku!',
            'data'=> getWishlistItems($user_id)
        ]);
    } catch (PDOException $e) {
        intervalServerError($e->getMessage());
    }
} else {
    notFound('Stranca nije pronadjena');
}
