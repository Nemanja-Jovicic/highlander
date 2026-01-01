<?php
session_start();
require_once 'config/connection.php';
include 'models/functions.php';



include 'includes/fixed/head.php';
include 'includes/fixed/navigation.php';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $urlToPage = replacedPage($page);
    
    if (file_exists("includes/pages/admin/$urlToPage.php")) {
        include "includes/pages/admin/$urlToPage.php";
    }
}
include 'includes/fixed/footer.php';
