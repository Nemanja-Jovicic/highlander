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
    }else{
         try {
             require_once '../../config/connection.php';
             include '../functions.php';

             if($checkTourName($name)){
                 conflictError("Tura sa tim nazivom vec postoji!");
             }else{
                 $banner_name = moveBanner($banner);
                 $tags  = checkTags($tour_tags);
                 storeNewTour($name, $description, $price, $duration,
                     $categories, $tags, $banner_name);
                 successfullResponseCode(['message' => 'Nova tura je kreirana!', 
                        'data' => getAllTours()]);
             }
         } catch (PDOException $th) {
             intervalServerError($th->getMessage());
        }
     }
} else {
    notFound("Stranica nije pronadjena!");
}
