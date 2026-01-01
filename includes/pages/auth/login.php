<div class="container">
    <div class="row mt-5">
        <div class="col-10 col-md-6 col-lg-4 mx-auto">
            <div id="message" class="my-2"></div>
            <h1 class="fs-5 text-center">Prijava</h1>
            <form action="#" method="post">
                <div class="mb-2">
                    <label for="email" class="mb-1">Email:</label>
                    <input type="email" name="email" id="email" class="form-control mb-1">
                     <div id="email_error"></div>
                </div>
                <div class="mb-2">
                    <label for="password" class="mb-1">Lozinka:</label>
                    <input type="password" name="password" id="password" class="form-control mb-1">
                    <div id="password_error"></div>
                </div>
                <div class="d-grid mb-3">
                    <button class="btn btn-sm btn-primary" id="btnLogin" type="button">Uloguj se</button>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <span>Nemate nalog?</span>
                    <a href="index.php?page=register">Registruj se </a>
                </div>
            </form>
        </div>
    </div>
</div>