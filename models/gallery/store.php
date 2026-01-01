<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $tour_id = $_POST['tour_id'];
    $gallery_images  =$_FILES['gallery_images'];

    $validation = tourGalleryValidation($gallery_images);
    if(count($validation) > 0){
        validationError($validation);
    }else{
        $image_names = moveUploadFile($gallery_images,"../../assets/images/banner/normal");
        storeIntoGallery($image_names, $tour_id);
        successfullResponseCode([
            'message' => "Slike su dodate u galeriju!",
            'data' => $getAllTourImages($tour_id)
        ]);
    }
}else{
    notFound("Stranica nije pronadjena");
}