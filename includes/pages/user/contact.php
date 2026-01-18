<?php

if(isset($_SESSION['user']) && $_SESSION['user']->role_id === 1){
    header("Location: admin.php?page=greske&code=403");
}
?>
<main class="container">
    <div class="row mt-5">
        <div id="message"></div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-4 mx-auto">
            <form action="#" method="post">
                <h1 class="mb-3 fs-3">Kontaktirajte nas</h1>
                <div class="mb-2">
                    <label for="first_name" class="mb-1">Ime</label>
                    <input type="text" name="first_name" id="first_name" class="form-control mb-1">
                    <div id="first_name_error"></div>
                </div>
                <div class="mb-2">
                    <label for="last_name" class="mb-1">Prezime</label>
                    <input type="text" name="last_name" id="last_name" class="form-control mb-1">
                    <div id="last_name_error"></div>
                </div>
                <div class="mb-2">
                    <label for="email" class="mb-1">Email</label>
                    <input type="email" name="email" id="email" class="form-control mb-1">
                    <div id="email_error"></div>
                </div>
                <div class="mb-2">
                    <label for="message_field" class="mb-1">Poruka</label>
                    <textarea name="message_field" id="message_field" class="form-control mb-1"></textarea>
                    <div id="message_error"></div>
                </div>
               
                    <button class="btn btn-sm btn-primary"type='button' id="btnContactUs">Posalji</button>
            
            </form>
        </div>
    </div>
</main>