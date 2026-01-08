<?php
if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id === 2)){
    header("Location: index.php?page=greske&code=403");
}
$tourInfo = $getTourNameAndTourDuration($_GET['id']);
$dates = tourDates($_GET['id']);
if (!$tourInfo) {
    header("Location: admin.php?page=error&code=403");
}

?>
<main class="container">
    <div class="mt-5">
        <div id="message" class="my-2"></div>
    </div>
    <div class="row mt-2" id="events">
        <h6 class="fs-3 "><?= $tourInfo->name ?><span class="fs-4">(<?= $tourInfo->duration > 1 ?> dan)</span></h6>
        <div class="col-lg-8">
            <div class="table-responsive-sm table-responsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Pocetak ture</th>
                            <th scope="col">Zavrsetak ture</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Izmeni</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="dates">
                        <?php foreach ($dates as $index =>  $date): ?>
                            <tr id="date_<?= $index ?>">
                                <th scope="row"><?= $index + 1 ?></th>

                                <td><?= date('d/m/Y', strtotime($date->start_date)) ?></td>
                                <!-- <td><?= date('d/m/Y H:i:s', strtotime($date->start_date + $date->duration)) ?></td> -->
                                <td>1</td>
                                <td><?= date('d/m/Y H:i:s', strtotime($date->created_at)) ?></td>
                                <td><?= $date->updated_at !== null ? "" : "" ?></td>
                                <td><button class="btn btn-sm btn-success btn-edit btn-edit-date"
                                        type="buton" data-id="<?= $date->id ?>" data-index="<?= $index ?>">Izmeni</button></td>
                                <td>
                                    <button class="btn btn-sm btn-danger btn-delete btn-delete-date" type="button" data-id="<?= $date->id ?>"
                                        data-index="<?= $index ?>" data-status="<?= $date->is_deleted ?>">
                                        <?= $date->is_deleted === 0 ? "Izbrisi" : "Aktiviraj" ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
            <input type="hidden" name="tour_id" id="tour_id" value="<?= $_GET['id'] ?>">
            <input type="hidden" name="date_index" id="date_index">
            <input type="hidden" name="date_id" id="date_id">
            <div class="mb-2">
                <label for="start_date" class="mb-1">Pocetak ture</label>
                <input type="date" name="start_date" id="start_date" class="form-control mb-1">
                <div id="start_date_error"></div>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-sm btn-primary btn-save btn-save-date" type="button">Sacuvaj</button>
                <button class="btn btn-sm btn-danger btn-reset btn-reset-date" type="reset">Ponisti</button>
            </div>
        </div>
    </div>
</main>