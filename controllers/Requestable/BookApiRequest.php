<?php

namespace Controllers\Requestable;

use Includes\Account\TokenVerify;
use Includes\Common\ReturnSmg;
use Includes\Requestable\CreateBook;
use Includes\Requestable\MyBooks;

class BookApiRequest
{
    public static function createBook($param): void
    {
        if (TokenVerify::verifyTokenCheck()) {

            $data = json_decode($param['info'], true); // Decode the 'info' string inside the data

            if (empty($data['name']) || !isset($_FILES['cover'])) {
                http_response_code(400);

                echo ReturnSmg::return(1050, false, '701: Please enter either an book name and cover image!');
                return;
            }



            $create = new CreateBook($data);

            echo $create->createNewBook();
        } else {
            http_response_code(401);

            echo ReturnSmg::return(1049, false, '701: Unauthorize user token login');
            exit();
        }
    }

    public static function myAllBooks(): void
    {
        if (TokenVerify::verifyTokenCheck()) {

            $uid = (string) $_SERVER['HTTP_SOPNOLIKHI'] ?? '';


            if (empty($uid)) {
                http_response_code(400);

                echo ReturnSmg::return(1050, false, '701: Please enter your uid or login again!');
                return;
            }



            $myAllBooks = new MyBooks();

            echo $myAllBooks->showMyAllBooks($uid);
        } else {
            http_response_code(401);

            echo ReturnSmg::return(1049, false, '701: Unauthorize user token login');
            exit();
        }
    }
}