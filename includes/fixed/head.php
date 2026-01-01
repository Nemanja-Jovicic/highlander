<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
    <script src="assets/js/admin.js" defer></script>
    <script src="assets/js/admin_validation.js" defer></script>
    <script src="assets/js/admin_utility.js" defer></script>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js" defer></script>

    <script src="assets/js/utility.js" defer></script>

    <!-- user scripts -->

    <script src="assets/js/user.js" defer></script>
    <script src="assets/js/user_validation.js"defer></script>
    <script src="assets/js/user_utility.js" defer></script>

    <?php if (!isset($_SESSION['user'])): ?>
        <script src="assets/js/auth.js" defer></script>
        <script src="assets/js/auth_functions.js" defer></script>
        <script src="assets/js/auth_validation.js" defer></script>
        <script src="assets/js/validation_functions.js" defer></script>
    <?php elseif (isset($_SESSION['user']) && $_SESSION['user']->role_id === 1): ?>


    <?php endif; ?>
</head>

<body>