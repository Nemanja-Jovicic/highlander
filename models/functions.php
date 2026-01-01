<?php
// constants
define("USER_ROLE", 2);


function getOneRow($query)
{
    global $connection;
    return $connection->query($query)->fetch();
}
function getAll($query)
{
    global $connection;
    return $connection->query($query)->fetchAll();
}
function softDelete($table, $status, $id)
{
    global $connection;
    $status = (int)$status === 0  ? 1 : 0;
    $query = "UPDATE $table set is_deleted = ? WHERE id = ?";
    $updated = $connection->prepare($query);
    $updated->execute([$status, $id]);
}

$replaceAfterSoft = fn($table, $id) => getOneRow("select id, is_deleted from $table where id = '$id'");
$getOneFullRow = fn($table, $id) => getOneRow("select * from $table where id = '$id'");

// AUTH
function checkEmail($email)
{
    return getOneRow("select id from users where email = '$email'");
}
function checkUserAccount($email, $password)
{
    global $connection;
    $query = "SELECT id, role_id FROM users WHERE email = ? , password = ?";
    $select = $connection->prepare($query);
    $select->execute([$email, md5($password)]);
    return $select->fetch();
}
function createNewAccount($first_name, $last_name, $email, $password)
{
    global $connection;
    $query = "INSERT INTO users (first_name, last_name, email, password, role_id) VALUES(?,?,?,?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$first_name, $last_name, $email, md5($password), (int)USER_ROLE]);
}

// GLOBAL 

function getMenu()
{
    $home = '';
    $pages = '';
    $table = '';
    if (!isset($_SESSION['user']) || isset($_SESSION['user']) && $_SESSION()) {
        $table = 'user_menu';
        $home = 'index.php';
    } else {
        $table = 'admin_menu';
        $home = 'admin.php';
    }
    $query = "SELECT * FROM $table";
    return [
        'home' => $home,
        'pages' => getAll($query)
    ];
}

function responseCodes($code)
{
    $responseMessage = "";
    $redirection = "";
    if (!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']->role_id === 1)) {
        $redirection = 'index.php';
    } else {
        $redirection = 'admin.php';
    }
    switch ($code) {
        case '403':
            $responseMessage = "Nemate pristup ovoj stranici!";
            break;
        case '404':
            $responseMessage = 'Stranica nepostoji!';
            break;
    }
    return [
        'redirection' => $redirection,
        'message' => $responseMessage
    ];
}

function replacedPage($urlString)
{

    // var_dump($urlString);
    $replaced = '';
    switch ($urlString) {
        case 'pocetna':
            $replaced = 'home';
            break;
        case 'kategorije':
            $replaced = 'category';
            break;
        case 'ture':
            $replaced = 'tour';
            break;
        case 'dodaj-termine':
            $replaced = 'tour_dates';
            break;
        case 'prijava': 
            $replaced ='login';
            break;
        case 'registracija':
            $replaced = 'register';
            break;
    }
    return $replaced;
}


// kategorije

function getAllCategories()
{
    $query = "SELECT * FROM categories";
    return getAll($query);
}

$checkCategoryName = fn($name) => getOneRow("SELECT id, name from categories WHERE name = '$name'");
$getOneCategory = fn($id) => getOneRow("SELECT id, name FROM categories WHERE id = '$id'");
function storeNewCategory($name)
{
    global $connection;
    $query = "INSERT INTO categories (name) VALUES(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name]);
}
function updateCategory($name, $id)
{
    global $connection;
    $date = date("d/m/Y H:i:s");
    $query = "UPDATE categories SET name = ?, updated_at = ? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$name, $date, $id]);
}


// ture

function getAllTours()
{
    $query = "select * from tours";
    return getAll($query);
}

function changePromotion($id, $promotion)
{
    global $connection;
    $promotion = (int)$promotion === 0 ? 1 : 0;
    $query = "update tour set is_promoted = ? where id = ? ";
    $update = $connection->prepare($query);
    $update->execute([$promotion, $id]);
}

$changeAfterPromotion = fn($id) => getOneRow("select id, is_promoted from tours where id = '$id'");
$getAvailableCategories = fn() => getAll("select id, name from categories where is_deleted = 0");
$checkTourName = fn($name) => getOneRow("select id, name from books where name = '$name'");

function getOneTour($id)
{
    $query = "select * from tours where id = '$id'";
    $data = getOneRow($query);
    $data->tags = getAllTags($id);
}

function getAllTags($id)
{
    $query = "select name from tags t join tour_tags tt on t.tag_id = tt.tage_id where tt.tour_id = '$id'";
    $tags =  getAll($query);
    return implode(",", $tags);
}

function moveBanner($banner)
{
    $new_banner_name = time() . "_" . $banner['name'];
    $banner_path_normal = "../../assets/images/banners/normal/$new_banner_name";
    $banner_tmp = $banner['tmp_name'];

    move_uploaded_file($banner_tmp, $banner_path_normal);
    return $new_banner_name;
}

function unlinkBanner($banner)
{
    if (file_exists("../../assets/images/banner/normal/$banner")) {
        unlink("../../assets/images/banner/normal/$banner");
        unlink("../../assets/images/banner/small/$banner");
    }
}

function checkTags($tags)
{
    $getAllTags = getAll("select name from tags");
    $tagsArray = [];
    $newTagArray = [];
    foreach ($getAllTags as $tag) {
        array_push($tagsArray, $tag->name);
    }

    foreach ($tags as $tag) {
        if (!in_array($tag, $tagsArray)) {
            array_push($newTagArray, $tag);
        }
    }
    return $newTagArray;
}

function storeTags($tour_tags)
{
    global $connection;
    $last_id = getOneRow("select id from tags limit 1");
    $idArray = [];
    $valueArray  = [];
    $queryArray  = [];
    $query = " insert into tags (name) values ";
    $tour_tags_array = explode(",", $tour_tags);
    foreach ($tour_tags_array as $tag) {
        $queryArray[] = "(?)";
        $valueArray[] = $tag;
        $idArray[] = (int)$last_id === 0 ? 1 : (int)$last_id++;
    }
    $query .= implode(", ", $queryArray);
    $insert = $connection->prepare($query);
    $insert->execute($valueArray);
    return $idArray;
}

function storeNewTour(
    $name,
    $description,
    $price,
    $duration,
    $categories,
    $tour_tags,
    $banner
) {

    global $connection;
    $tag_ids = storeTags($tour_tags);
    $query = "insert into tours (name, description, price, duration, image_path) 
        values (?,?,?,?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$name, $description, $price, $duration, $banner]);
    $last_id = $connection->lastInsertId();

    createTourCategory($last_id, $categories);
    createTourTag($last_id, $tag_ids);
}

function createTourCategory($tourId, $categories)
{
    global $connection;
    $queryParams = [];
    $queryValues = [];
    $query = "insert into category_tour (category_id, tour_id) values ";
    foreach ($categories as $category) {
        $queryParams[] = "(?,?)";
        $queryValues[] = (int)$category;
        $queryValues[] = (int)$tourId;
    }

    $query .= implode(", ", $queryParams);
    $insert = $connection->prepare($query);
    $insert->execute($queryValues);
}

function createTourTag($tour_id, $tags)
{
    global $connection;
    $queryParams = [];
    $queryValues = [];

    $query = "insert into tour_tags (tour_id, tag_id) values";
    foreach ($tags as $tag) {
        $queryParams[] = "(?,?)";
        $queryValues[] = (int)$tour_id;
        $queryValues[] = (int)$tag;
    }

    $query .= implode(",", $queryParams);
    $insert = $connection->prepare($query);
    $insert->execute($queryValues);
}

function updateBanner(
    $id,
    $name,
    $description,
    $price,
    $duration,
    $categories,
    $tour_tags,
    $banner = ''
) {

    global $connection;
    $tagIds = storeTags($tour_tags);
    $valueArray = [];
    $date = date("d/m/Y H:i:s");
    $query = "update tours set name = ?, description = ?,
        price = ?, duration = ?,  ";
    array_push($valueArray, $name);
    array_push($valueArray, $description);
    array_push($valueArray, $price);
    array_push($valueArray, $duration);
    if ($banner !== "") {
        $query .= " image_path = ?,";
        array_push($valueArray, $banner);
    }
    $query .= " updated_at =?  where id = ?";
    array_push($valueArray, $date);
    array_push($valueArray, $id);
    $update = $connection->prepare($query);
    $update->execute($valueArray);


    deleteFromPivotTable('tour_tag', 'tag_id', $id);
    deleteFromPivotTable('category_tour', 'tour_id', $id);
    createTourTag($id, $tagIds);
}


function deleteFromPivotTable($table, $column, $id)
{
    global $connection;
    $query = "delete from $table where $column = ?";
    $update = $connection->prepare($query);
    $update->execute([$id]);
}

//  datumi tura

$getTourNameAndTourDuration = fn($id) => getOneRow("select name, duration from tours where id = '$id'");
$getOneTourDateData = fn($id) => getOneRow("SELECT id, start_date FROM tour_date WHERE id = '$id'");
$checkDate = fn($tour_id, $date) => getOneRow("SELECT id, start_date, tour_id FROM tour_date WHERE start_date = '$date' AND tour_id = '$tour_id'");
$getOneTourDateFullRow = fn($id) => getOneRow("select * from tour_date where id = '$id'");
function tourDates($tour_id)
{
    return getAll("select td.*, t.duration from tour_dates td
        join tours t on td.tour_id = t.id where td.tour_id = '$tour_id'");
}
function storeNewTourDate($tour_id, $date)
{
    global $connection;
    $query = "INSERT INTO tour_date (tour_id, start_date) VALUES(?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$tour_id, date('d/m/Y', strtotime($date))]);
}
function updateTourDate($id, $date)
{
    global $connection;
    $date_update = date("d/m/Y H:i:s");
    $query = "update tour_date set start_date = ?, updated_at = ? where id = ?";
    $update = $connection->prepare($query);
    $update->execute([$date, $date_update, $id]);
}

// contact 

function createNewContactMessage($first_name, $last_name, $email, $message)
{
    global $connection;
    $query = "insert into contact_messages (first_name, last_name, email, message) values (?,?,?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$first_name, $last_name, $email, $message]);
}

// wishlist

function wishlistStore($user_id, $tour_id)
{
    global $connection;
    $wishlistId = checkUserWishlist($user_id);
    if ($wishlistId) {
        $wishlist_id = $wishlistId->id;
        wishlistItemStore($wishlist_id, $tour_id);
    } else {
        $connection->beginTransaction();
        $wishlist_id  = createWishlist($user_id);
        if (wishlistItemStore($wishlist_id, $tour_id)) {
            $connection->commit();
        } else {
            $connection->rollBack();
        }
    }
}

function checkUserWishlist($user_id)
{
    $query = "select id from wishlist where user_id = '$user_id'";
    return getOneRow($query);
}

function createWishlist($user_id)
{
    global $connection;
    $query = "insert into wishlist (user_id) values(?)";
    $insert = $connection->prepare($query);
    $insert->execute([$user_id]);
    return $connection->lastInsertId();
}

function wishlistItemStore($wishlist_id, $tour_id)
{
    global $connection;
    $query = "insert into wishlist_items (wishlist_id, tour_id) values (?,?)";
    $insert = $connection->prepare($query);
    $insert->execute([$wishlist_id, $tour_id]);
}


function deleteTourFromWishlist($user_id, $tour_id)
{
    global $connection;
    $user_wishlist_id = checkUserWishlist($user_id);
    $query = "delete from wishlist_items where wishlist_id = ? and tour_id = ?";
    $delete = $connection->prepare($query);
    $delete->execute([$user_wishlist_id->id, $tour_id]);
}


function getAllItemsFromWishlist($user_id){
    $query = "select wi.id, t.id, t.name, t.duration, t.price, t.banner_name
        from wishlist w join
        wishlist_items wi on w.id = wi.wishlist_id 
        join tours t on wi.tour_id = t.id
        where w.user_id = '$user_id'";
    return getAll($query);
}

// gallery
$getAllTourImages = fn($tour_id) => getAll("select * from tour_gallery where tour_id = '$tour_id'");
function deleteFromGallery($image_id)
{
    $query = "select image_name from tour_gallery where id ='$image_id'";
    $res = getOneRow($query);

    if (file_exists("../../assets/images/tours/small/$res->image_name"
        && "../../assets/images/tours/normal/$res->image_name")) {
        unlink("../../assets/images/tours/normal/$res->image_name");
        unlink("../../assets/images/tours/small/$res->image_name");
        $query = "delete from tour_gallery where id = '$image_id'";
    }
}

function moveUploadFile($images,$path){
    $image_name = count($images) > 1 ? [] : '';
    if(count($images) > 1){
        for($image = 0 ; $image<count($images); $image++){
            $image_name_new = $images[$image]['name'];
            $image_path = $path.$image_name;
            move_uploaded_file($images[$image]['tmp_name'], $image_path);
            array_push($image_name, $image_name_new);
        }
    }
    else{
        $image_name_new = time()."_".$images['name'];
        $image_path = $path.$image_name;
        move_uploaded_file($images['tmp_name'], $image_path);
        $image_name = $image_name_new;
    }
    return $image_name;
}


// da li moze bez count

function storeIntoGallery($image_names, $tour_id){
    global $connection;
    $query = "insert into tour_gallery (tour_id, image_name) ";
    if(count($image_names) > 1){
        $queryParams = [];
        $queryValues = [];
        foreach($image_names as $image_name){
            $queryParams[] = "(?,?)";
            $queryValues[] = (int)$tour_id;
            $queryValues[] = $image_name;
        }
        $query.= " values ".implode(",", $queryParams);
        $insert = $connection->prepare($query);
        $insert->execute($queryValues);
    }else{
        $query.= "values (?,?)";
        $insert = $connection->prepare($query);
        $insert->execute([$tour_id, $image_names]);
    }
}


