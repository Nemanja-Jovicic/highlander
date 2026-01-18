<?php
header("Content-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['tour_name'];
    $description = $_POST['tour_description'];
    $price = $_POST['tour_price'];
    $duration = $_POST['tour_duration'];
    $categories = $_POST['categories'];
    $banner = $_FILES['banner'];
    $tour_tags = $_POST['tour_tags'];

    include '../validation.php';
    $validation = tourFormValidation(
        $name,
        $description,
        $price,
        $duration,
        $categories,
        $tour_tags,
        $banner
    );



    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            include '../functions.php';

            if ($checkTourName($name)) {
                conflictError("Tura sa tim nazivom vec postoji!");
            } else {
                $banner_name = moveBanner($banner);
                storeNewTour($name, $description, $duration, $price, $banner_name, $categories, $tour_tags);
                successfullResponseCode([
                    'message' => "Tura je uspesno kreirana!",
                    'data' => getAllTours()
                ]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
} else {
    notFound("Stranica nije pronadjena!");
}
