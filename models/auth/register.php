<?php 
header("Content-type:application/json");
include '../response_functions.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    include "../validation.php";
    $validation = registerFormValidation($first_name, $last_name, $email, $password);
    if(count($validation) > 0){
        validationError($validation);
    }else{
        try {
            include  '../functions.php';
            require_once '../../config/connection.php';
            if(checkEmail($email)){
                conflictError("Doslo je do greske! Nalog sa tim email-om vec postoji!");
            }else{
                createNewAccount($first_name, $last_name, $email, $password);
                normalResponse();
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
}else{
    notFound("Stranica nije pronadjena");
}