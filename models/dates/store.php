<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $date = $_POST['tour_date'];
    $tour_id = $_POST['tour_id'];

    include '../validation.php';
    $validation = dateFormValidation($date);
    if(count($validation) > 0 ){
        validationError($validation);
    }else{
        try {
            require_once '../../config/connection.php';
            include '../validation.php';

            if($checkDate($tour_id, $date)){
               conflictError('Tura koja je pocinje ovog datuma vec postoji');
            }else{
                storeNewTourDate($tour_id, $date);
                successfullResponseCode([
                    'message' => 'Novi datum je dodat',
                    'data' => tourDates($tour_id)
                ]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
}else{
    notFound("Stranica nije pronadjena");
}