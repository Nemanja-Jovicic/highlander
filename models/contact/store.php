<?php
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    include '../validation.php';

    $validation = contactFormValidation($first_name, $last_name, $email, $message);
    if(count($validation) > 0){
        validationError($validation);
    }else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            createNewContactMessage($first_name, $last_name, $email, $message);
            normalResponse(['message' => "Hvala sto ste nas kontaktirali"]);
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
}
else{
    intervalServerError('Stranica nije pronadjena');
}
