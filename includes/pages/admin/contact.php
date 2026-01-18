<?php
if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id === 2) ){
    header("Location: index.php?page=greska&code=403");
}
$messages = getAllMessages();
$pagiantion = $messagePagination();

?>

<main class="container">
    <div class="row mt-5">
        <div id="message" class="mb-2"></div>
    </div>
    <div class="mb-2">
        <div class="row" id="events">
            <div class="col-lg-10 mx-auto">
                <div class="table-responsive-sm table-responsive-md">
                    <table class="table text-center align-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ime i prezime</th>
                                <th scope="col">Email</th>
                                <th scope="col">Datum kreiranja</th>
                                <th scope="col">Procitaj</th>
                            </tr>
                        </thead>
                        <tbody id="contact">
                            <?php foreach ($messages as $index => $message): ?>
                                <tr id="contact_<?= $index ?> ?>">
                                    <th scope="row"><?= $index  + 1  ?></th>
                                    <td><?= $message->first_name . ' ' . $message->last_name ?></td>
                                    <td><?= $message->email ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($message->created_at)) ?></td>
                                    <td><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-sm btn-success btn-edit btn-edit-contact" data-id="<?= $message->id ?>" data-index="<?= $index ?>">Procitaj</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="Page navigation example" class='mt-3 d-flex justify-content-center'>
                <ul class="pagination" id="contact_pagination">
                    <?php for ($i = 0; $i < $pagiantion; $i++): ?>
                        <li class="page-item"><a class="<?= $i === 0 ? 'active' : '' ?> page-link page-contact" href="#" data-link="<?= $i ?>"><?= $i + 1 ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex gap-2 mb-2">
                    <span class="fw-bold">From:</span>
                    <span id="from"></span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <span class="fw-bold">Email:</span>
                    <span id="email_from"></span>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <span class="fw-bold">Datum kreiranja</span>
                    <span id="date"></span>
                </div>
                <div class="mb-2">
                    <span class="fw-bold mb-2">Poruka:</span>
                     <p id="text"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>