<?php
    $categories = getAllCategories();
?>
<main class="container">
    <div class="row mt-5">
        <div id="message" class="my-2"></div>
    </div>
    <div class="row mt-2" id="events">
        <div class="col-lg-8">
            <div class="table-responsive-sm table-responsive-md">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Naziv</th>
                            <th scope="col">Datum kreiranja</th>
                            <th scope="col">Datum izmene</th>
                            <th scope="col">Izmena</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody id="categories">
                        <?php foreach($categories as $index => $category):?>
                        <tr id="category_<?= $index?> ?>">
                            <th scope="row"><?= $index+1 ?></th>
                            <td><?= $category->name ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($category->created_at)) ?></td>
                            <td><?=  $category->updated_at !== null ? date("d/m/Y H:i:s", strtotime($category->updated_at)) : "-" ?></td>
                            <td><button class="btn btn-sm btn-success btn-edit btn-edit-category" type="button" data-id="<?= $category->id ?>"
                                data-index="<?= $index ?>">Izmeni</button></td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-delete btn-delete-category " type="button" data-id="<?= $category->id ?>"
                                    data-status = "<?= $category->is_deleted ?>" data-index = "<?= $index ?>"
                                ><?= $category->is_deleted === 0 ? "Izbrisi" : "Aktiviraj" ?></button>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4 mt-2 mt-lg-0">
            <form action="#">
                <input type="hidden" name="category_index" id="category_id">
                <input type="hidden" name="category_index" id="category_index">
                <div class="mb-2">
                    <label for="category_name" class="mb-1">Naziv kategorije:</label>
                    <input type="text" name="category_name" id="category_name" class="form-control mb-1">
                    <div id="category_name_error"></div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-sm btn-primary btn-save btn-save-category" type="button">Unesi</button>
                    <button class="btn btn-sm btn-danger btn-reset btn-reset-cateogry" type="button">Ponisti</button>
                </div>
            </form>
        </div>
    </div>
</main>