<?php

namespace Services\Controllers\Requestable;

use Includes\Common\ReturnSmg;
use Services\Models\Requestable\MyBooksModel;

class MyBooksCntr extends MyBooksModel
{
    protected function requestMyAllBooks(string $uid): string
    {

        $result = $this->fetchMyAllBooks($uid);

        if ($result['success'] !== null && $result['success'] === 1) {
            // This result for success response
            $response = $result['result'];
            // Send Email and sms for the user account successfully login

            // $this->uploadImage($param['cover']);

            // Response success message
            http_response_code(200);
            return ReturnSmg::return(1000, true, $response);
        }

        // All error handler
        switch ($result['error']) {
            case 1:
                http_response_code(404);
                $errorResponse = ReturnSmg::return(1054, false, '700: ' . $result['result']);
                break;
            case -1:
                http_response_code(500);

                $errorResponse = ReturnSmg::return(1053, false, '701: ' . $result['result']);
                break;
            default:
                http_response_code(500);

                $errorResponse = ReturnSmg::return(1053, false, '702: ' . $result['result']);
        }

        return $errorResponse;
    }
}
