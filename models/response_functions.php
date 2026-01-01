<?php
function notFound($message)
{
    http_response_code(404);
    echo json_encode([
        'message' => $message
    ]);
}

function validationError($errorArray)
{
    http_response_code(422);
    foreach ($errorArray as $error) {
        echo json_encode(['error' => $error]);
    }
}

function intervalServerError($message)
{
    http_response_code(500);
    echo json_encode(['message' => $message]);
}

function conflictError($message)
{
    http_response_code(409);
    echo json_encode(['message' => $message]);
}

function invalidArugmentException($message){
    http_response_code(401);
    echo json_encode(['message' => $message]);
}

function successfullResponseCode($data)
{
    http_response_code(201);
    echo json_encode($data);
}
function normalResponse($data = '')
{
    http_response_code(200);
    if ($data !== '') {
        echo json_encode($data);
    }
}
