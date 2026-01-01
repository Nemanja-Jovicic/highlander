<?php 
header("Content-type:application/json");
include '../response_functions.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['category_name'];

    include '../validation.php';
    $validation = categoryFormValidation($name);
    if(count($validation) > 0){
        validationError($validation);
    }else{
        try {
            require_once '../../config/connection.php';
            include '../functions.php';
            
            if($checkCategoryName($name)){
                conflictError("Kategorija sa tim nazivom vec postoji");
            }else{
                storeNewCategory($name);
                successfullResponseCode([
                    'message' => 'Nova kategorija je dodata',
                    'data' => getAllCategories()
                ]);
            }
        } catch (PDOException $th) {
            intervalServerError($th->getMessage());
        }
    }
}
else{
    notFound("Stranica nije pronadjena");
}