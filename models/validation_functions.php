<?php

function inputFieldValidation($errorMessage, &$errorArray, $element, $regEx = "")
{
    if (gettype($element) === 'array') {
        $elArray = [];
        // $elementMessage = '$element '.;
        foreach ($element as $index => $el) {
            if (!preg_match($regEx, $el)) {
                array_push($elArray, $el);
            }
        }
        $errorMessage .= implode(', ', $elArray) . "nije u redu!";
        array_push($errorArray, $errorMessage);
    } else {
        if (str_contains($element, "@")) {
            !filter_var($element, FILTER_VALIDATE_EMAIL) ? array_push($errorArray, $errorMessage) : "";
        } else {
            !preg_match($regEx, $element) ? array_push($errorArray, $errorMessage) : "";
        }
    }
}
function checkBoxValidation($checkBoxArray, &$errorArray, $errorMessage)
{
    if (count($checkBoxArray) ===  0) {
        array_push($errorArray, $errorMessage);
    }
}
function inputFileValidation($image, &$errorArray, $errorMessages)
{
    list($emptyError, $typeError, $invalidSizeError) = $errorMessages;

    if ($image === "") {
        array_push($errorArray, $emptyError);
    } else {
        if (count($image) > 1) {
            for ($img = 0; $img < count($image); $img++) {
                $image_type = $image[$img]['type'];
                $image_size = $image[$img]['size'];
                $invalidFormat = ['image/png', 'image/jpeg', 'image/jpg'];

                if (!in_array($image_type, $invalidFormat)) {
                    array_push($errorArray, $typeError."-".$image[$img]['name']);
                }
                if ($image_size > 3 * 1024 * 1024) {
                    array_push($errorArray, $invalidSizeError."-".$image[$img]['name']);
                }
            }
        } else {
            $image_type =  $image['type'];
            $image_size = $image['size'];
            $invalidFormat = ['image/png', 'image/jpeg', 'image/jpg'];

            if (!in_array($image_type, $invalidFormat)) {
                array_push($errorArray, $typeError);
            }
            if ($image_size > 3 * 1024 * 1024) {
                array_push($errorArray, $invalidSizeError);
            }
        }
    }
}

function inputDateValidation($date, &$errors, $errorMessages)
{
    list($emptyError, $invalidValueError) = $errorMessages;
    if ($date === "") {
        $errors[] = $emptyError;
    } else {
        $currentDate = "";
        if ($date < $currentDate) {
            $errors[] = $invalidValueError;
        }
    }
    return $errors;
}
