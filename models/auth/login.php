<?php
session_start();
header("Content-type:application/json");
include_once  "../response_functions.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    include '../validation.php';
    $validation = loginFormValidation($email, $password);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            if (checkEmail($email)) {
               invalidArugmentException('Nalog sa email nepostji');
            } else {
                $user = checkUserAccount($email, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    normalResponse(['role_id' => $user->role_id]);
                } else {
                   invalidArugmentException('Nalog sa unesenim kredencijalima nepostoji');
                }
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
} else {
    notFound("Stranica nije pronadjena");
}
