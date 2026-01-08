<?php
header("Content-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $tour_id = $_POST['tour_id'];
    $date = $_POST['tour_date'];



    include '../validation.php';

    $validation = dateFormValidation($date);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkDate = $checkDate($tour_id, $date);

            if ($checkDate && $checkDate->start_date === $date && $checkDate->id !== $id) {
                conflictError("Tura koja je rezervisana tog datuma vec postoji!");
            } else {
                updateTourDate($id, $date);
                normalResponse([
                    'data' => $getOneTourDateFullRow($id),
                    'message' => 'Datum za turneju je uspesno promenjen'
                ]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
} else {
    notFound("Stranica nije pronadjenaw");
}
