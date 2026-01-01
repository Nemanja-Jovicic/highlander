<?php 
include 'validation_functions.php';
function registerFormValidation($first_name, $last_name, $email, $password){
    $errors = [];

    $regFirstLastName = "/\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/";
    $regPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";


    inputFieldValidation("Ime nije u redu!", $errors, $first_name, $regFirstLastName);
    inputFieldValidation("Prezime nije u redu!", $errors, $last_name, $regFirstLastName);
    inputFieldValidation("Email nije u redu!", $errors, $email);
    inputFieldValidation("Lozinka nije u redu!", $errors, $password, $regPassword);

    return $errors;

}

function loginFormValidation($email, $password){
    $errors  = [];

    $regPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";

    inputFieldValidation("Email nije u redu!", $errors, $email);
    inputFieldValidation("Lozinka nije u redu!", $errors, $password, $regPassword);

    return $errors;
}

function categoryFormValidation ($name){
    $errors  = [];
    $regCategoryName = "/^$/";

    inputFieldValidation("Naziv kategorije nije u redu!", $errors, $name, $regCategoryName);

    return $errors;
}

function tourFormValidation($name, $description, $price, 
    $duration, $categories, $tour_tags, $banner = '',$tour_id = ''){
        $errors = [];

        $regTourName = '';
        $regTourDescription = ''; // quill validacija
        $regPrice = '';
        $regDuration = '';
        $regTourTags = '';
        

        inputFieldValidation("Naziv ture nije u redu!",
                $errors, $name, $regTourName);
        // quill validacija
        inputFieldValidation("Cena nije u redu!", 
            $errors, $price, $regPrice);
        inputFieldValidation("Broj dana nije u redu!",
            $errors, $duration, $regDuration);
        checkBoxValidation($categories, $errors,"Morate odabrati tag!");
        inputFieldValidation("Naziv taga", $errors, explode(', ', $tour_tags, $regTourTags));
         if($tour_id === ''){
            inputFileValidation($banner, $errors,
             ['Morate odabrati sliku']);
        }else if($banner !== ''){
             inputFileValidation($banner, $errors,
             ['Morate odabrati sliku!', 
                'Format slike nije u redu!' , 'Velicina slike nije u redu!']);
        }

        return $errors;
    }

    function dateFormValidation($date){
        $errors  = [];

        inputDateValidation($date, $errors, ["Morate odabrati datum!","Odabrani datum nije validan!"]);

        return $errors;
    }

    function contactFormValidation($first_name, $last_name, $email, $message){
        $errors = [];

        $regFirstLastName = "";
        $regMessage = "";

        inputFieldValidation("Ime nije u redu!", $errors, $first_name, $regFirstLastName);
        inputFieldValidation("Prezime nije u redu!", $errors, $last_name, $regFirstLastName);
        inputFileValidation("Email nije u redu!",$errors, $email );
        inputFieldValidation("Poruka nije u redu!", $errors, $message, $regMessage);

        return $errors;
    }

    function tourGalleryValidation($images){
        $errors  = [];
        
        return $errors;
    }