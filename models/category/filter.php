<?php 
header("Content-type:application/json");
include '../response_functions.php';
if($_SERVER["REQUEST_METHOD"] === "GET"){
   $link = $_GET['link'];
    try {
        require_once '../../config/connection.php';
        include '../functions.php';
        normalResponse([
            'data' => getAllCategories($link),
            'pagination' => $categoryPagination(),
            'activePage' => $link
        ]);
    } catch (PDOException $th) {
        intervalServerError($th->getMessage());
    }
}else{
    notFound("Stranica nije pronadjena!");
}