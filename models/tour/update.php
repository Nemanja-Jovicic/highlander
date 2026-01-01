<?php
header("Content-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['tour_id'];
    $name = $_POST['tour_name'];
    $description = ''; // quill
    $price = $_POST['tour_price'];
    $duration = $_POST['tour_duration'];
    $categories = $_POST['categories'];
    $banner = isset($_FILES['banner']) ? $_FILES['banner'] : '';
    $tour_tags = $_POST['tour_tags'];

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
            if ($checkTourName && $checkTourName->name === $name && $checkTourName->id !== $id) {
                conflictError("Tura sa tim nazivom vec postoji");
            } else {
                $banner_name = "";
                if ($banner !== "") {
                    unlinkBanner($banner);
                    $banner_name = moveBanner($banner);
                }
                updateBanner($id, $name, $duration,
                    $price, $duration, $categories, $tour_tags, banner: $banner_name);
            normalResponse(['message' => 'Tura je uspesno izmenjena', 'data' => $getOneFullRow('tours', $id)]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
} else {
    notFound("Stranica nije pronadjena");
}
