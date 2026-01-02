<?php
header("Content-type:application/json");
include '../response_functions.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['category_name'];

    include '../validation.php';
    $validation  = categoryFormValidation($name);
    if (count($validation) > 0) {
        validationError($validation);
    } else {
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            $checkCategoryName = $checkCategoryName($name);
            if ($checkCategoryName && $checkCategoryName->name && $checkCategoryName->id !== $id) {
                conflictError("Kategorija sa tim nazivom vec postoji");
            } else {
                updateCategory($name, $id);
                normalResponse(['message' => 'Kategorija je uspesno izmenjena', 'data' => $getOneFullRow('categories', $id)]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
} else {
    notFound("Stranica nije pronadjena");
}
