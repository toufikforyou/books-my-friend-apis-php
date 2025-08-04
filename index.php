<?php

declare(strict_types=1);

use Includes\Common\ReturnSmg;

date_default_timezone_set('Asia/Dhaka');

header("Content-type: application/json; charset=UTF-8");

header('Access-Control-Allow-Origin: *');

header('X-XSS-Protection: 1; mode=block');

header('X-Content-Type-Options: nosniff');

header('X-Frame-Options: DENY');

header('Access-Control-Allow-Headers: X-Auth-Token, Authorization');

$allowedMethods = ['GET', 'POST', 'PUT', 'DELETE'];

// Check if the request method is allowed
if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: ' . implode(', ', $allowedMethods));

    echo json_encode([
        'code' => 1049,
        'success' => false,
        'result' =>  '703: Method not allowed',
        'language' => $_SERVER['HTTP_X_LANG'] ?? 'bn',
        'timestamp' => date("Y-m-d H:i:s", time())
    ]);

    exit();
}

// Retrieve the API key and API token from the request headers or query parameters
$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? $_POST['api_key'];
$apiToken = $_SERVER['HTTP_X_API_TOKEN'] ?? $_POST['api_token'];

require __DIR__ . '/vendor/autoload.php';

set_exception_handler("Controllers\ErrorHandler::handlerException");


$authentication = new Controllers\Authentication($apiKey, $apiToken);

// Check if the API key and API token are valid

if ($authentication->verifyToken() === false) {
    header('HTTP/1.0 401 Unauthorized');
    http_response_code(401);

    echo ReturnSmg::return(1049, false, '701: Unauthorized api');

    exit();
}

$router = new Sources\Router();

// Define routes
// get all books fetch limit 10; page start 1;
$router->get('/', 'Controllers\Request\BookApiRequest::getBooksList');

// get book infomation fetch with bid (books my friend -> book id). all of them
$router->get('/book/{bid}/info', 'Controllers\Request\BookApiRequest::getBookInfo');

// get book read for all chapter fetch with bid (books my friend -> book id). all of them;
$router->get('/book/{bid}/read', 'Controllers\Request\BookApiRequest::getBookRead');

// create book
$router->post('/create/book', 'Controllers\Requestable\BookApiRequest::createBook');
$router->post('/myaccount/books/all', 'Controllers\Requestable\BookApiRequest::myAllBooks');

// TODO: Account routes
$router->post('/account/create', 'Controllers\Request\AccountApiRequest::userSingUp');
$router->post('/account/login', 'Controllers\Request\AccountApiRequest::userLogin');
$router->post('/account/login/verify', 'Controllers\Request\AccountApiRequest::tokenVerify');
$router->post('/account/check', 'Controllers\Request\AccountApiRequest::checkUser');

//TODO:: Otp send and verify
$router->post('/account/otp/send', 'Controllers\Request\OtpApiRequest::sendOtp');
$router->post('/account/otp/verify', 'Controllers\Request\OtpApiRequest::verifyOtp');



// Set not found handler
$router->addNotFoundHandler(function () {
    http_response_code(404);

    echo ReturnSmg::return(1054, false, '701: 404 page not found!');

    exit();
});

// Run the router
$router->run();
