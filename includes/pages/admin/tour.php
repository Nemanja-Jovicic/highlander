<?php
if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id === 2)) {
    header("Location: index.php?page=greske&code=403");
}
$tours = getAllTours();
$categories = $getAvailableCategories();
$numberOfTours = $numberOfElements("tours");
?>
<main class="container">
    <div class="row mt-5">
        <div id="message" class="my-2"></div>
    </div>
    <div class="row my-2" id="events">
        <div class="col-lg-8">
            <div class="table-responsive-sm table-responsive-md <?= (int) $numberOfTours->numberOfElements > (int) ADMIN_OFFSET ? 'table-container' : '' ?>">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv</th>
                            <th scope="col">Broj dana</th>
                            <th scope="col">Cena</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Promocija</th>
                            <th scope="col">Termini</th>
                            <th scope="col">Izmeni</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="tour">
                        <?php foreach ($tours as $index => $tour): ?>
                            <tr id='tour_<?= $index ?>'>
                                <th scope="col"><?= $index + 1 ?></th>
                                <td><?= $tour->name ?></td>
                                <td><?= $tour->price ?></td>
                                <td><?= $tour->duration ?></td>
                                
                                <td><?= date('d/m/Y H:i:s', strtotime($tour->created_at)) ?></td>
                                <td><?= $tour->updated_at !== null ? date('d/m/Y H:i:s', strtotime($tour->updated_at)) : "-" ?></td>
                                <td><button type='button' class="btn btn-sm btn-warning btn-promotion btn-promotion-tour" data-id="<?= $tour->id ?>" data-promotion="<?= $tour->is_promoted ?>"
                                        data-index="<?= $index ?>"><?= $tour->is_promoted === 0 ? 'Aktiviraj' : 'Deaktiviraj' ?></button></td>
                                <td><a href="admin.php?page=dodaj-termine&id=<?= $tour->id ?>" class="btn btn-sm btn-primary">Dodaj</a></td>
                                <td><button type="button" class="btn btn-sm btn-success btn-edit btn-edit-tour"
                                        data-id="<?= $tour->id ?>" data-index="<?= $index ?>">Izmeni</button></td>
                                <td>
                                    <button type="button" class="btn  btn-sm btn-danger btn-delete btn-delete-tour"
                                        data-id="<?= $tour->id ?>" data-index="<?= $index ?>" data-status="<?= $tour->is_deleted ?>"><?= $tour->is_deleted === 0 ? "Izbrisi" : "Aktiviraj" ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 mt-2 mg-lg-0">
            <input type="hidden" name="tour_id" id="tour_id">
            <input type="hidden" name="tour_index" id="tour_index">
            <div class="mb-2">
                <label for="tour_name" class="mb-1">Naziv ture</label>
                <input type="text" name="tour_name" id="tour_name" class="form-control mb-1">
                <div id="tour_name_error"></div>
            </div>
            <div class="mb-2">
                <label for="tour_price" class="mb-1">Cena</label>
                <input type="number" name="tour_price" id="tour_price" class="form-control mb-1">
                <div id="tour_price_error"></div>
            </div>
            <div class="mb-2">
                <label for="tour_duration" class="mb-1">Broj dana</label>
                <input type="number" name="tour_duration" id="tour_duration" class="form-control mb-1">
                <div id="tour_duration_error"></div>
            </div>
            <div class="mb-2">
                <label for="tour_category" class="mb-1">Kategorije</label>
                <div class="row mb-2">
                    <?php foreach ($categories as $category): ?>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<?= $category->id ?>" id="category_<?= $category->id ?>"
                                    name="categories">
                                <label class="form-check-label" for="category_<?= $category->id ?>">
                                    <?= $category->name ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="tour_category_error"></div>
            </div>
            <div class="mb-2">
                <label for="tour_description" class="mb-1">Opis ture</label>
                <!-- quill editor kao description -->
                <div id="tour_description"></div>
                <div id="tour_description_error"></div>
            </div>
            <div class="mb-2">
                <label for="tour_tags" class="mb-1">Tagovi:</label>
                <textarea name="tour_tags" id="tour_tags" class="form-control mb-1"></textarea>
                <div id="tour_tags_error"></div>
                <!-- tagovi moraju biti razdvojeni zarezom -->
            </div>
            <div class="mb-2">
                <label for="tour_banner" class="mb-1">Banner</label>
                <input type="file" name="tour_banner" id="tour_banner" class="form-control mb-1">
                <div id="tour_banner_error"></div>
                <img src="#" alt="#" class="img-fluid d-none" id="cover">
                <!-- dodati deo za prikazivanje slike -->
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-sm btn-primary btn-save btn-save-tour" type="button">Sacuvaj</button>
                <button class="btn btn-sm btn-danger btn-reset btn-reset-tour" type="button">Ponisti</button>
            </div>
        </div>
    </div>
</main>