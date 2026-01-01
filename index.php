<?php 

session_start();

require 'config/connection.php';
include 'models/functions.php';

include 'includes/fixed/head.php';
include 'includes/fixed/navigation.php';

if(isset($_GET['page'])){
    $page = $_GET['page'];
    $replaced = replacedPage($page);
    if(file_exists("includes/pages/auth/$replaced.php")){
        include "includes/pages/auth/$replaced.php";
    }elseif(file_exists("includes/pages/user/$replaced.php")){
        include "includes/pages/user/$replacd.php";
    }
}

include 'includes/fixed/footer.php';