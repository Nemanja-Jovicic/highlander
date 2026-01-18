<?php
header("Content-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['tour_name'];
    $description = $_POST['tour_description'];
    $price = $_POST['tour_price'];
    $duration = $_POST['tour_duration'];
    $categories = $_POST['categories'];
    $banner = isset($_FILES['banner']) ? $_FILES['banner'] : '';
    $tour_tags = $_POST['tour_tags'];
    $cover = $_POST['banner_cover'];
    
    include '../validation.php';
    $validation = tourFormValidation(
        $name,
        $description,
        $price,
        $duration,
        $categories,
        $tour_tags,
        $banner,
        $id
    );
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkTourName = $checkTourName($name);
            if ($checkTourName && $checkTourName->name === $name && $checkTourName->id !== (int)$id) {
                conflictError("Tura sa tim nazivom vec postoji");
            } else {
                $banner_name = "";
                if ($banner !== "") {
                    unlinkBanner($cover);
                    $banner_name = moveBanner($banner);
                }
                updateTour($id, $name, $description, $price, $duration, $banner_name, $tour_tags, $categories);
                normalResponse([
                    'message' => 'Tura je uspesno izmenjena',
                    'data' => $getOneTourFullRow($id)
                ]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
} else {
    notFound("Stranica nije pronadjena");
}
