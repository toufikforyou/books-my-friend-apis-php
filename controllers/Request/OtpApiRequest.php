<?php
namespace Controllers\Request;

use Includes\Account\OtpHandler;
use Includes\Common\ReturnSmg;

class OtpApiRequest
{
    public static function sendOtp($param): void
    {
        // Retrieve the JSON data from the request body
        $json_data = file_get_contents('php://input');

        // Parse the JSON data into an associative array
        $data = json_decode($json_data, true);

        if (empty($data['account'])) {
            http_response_code(400);

            echo ReturnSmg::return(1050, false, '701: Account is empty!');
            exit();
        }

        $otpSend = new OtpHandler($data);

        echo $otpSend->userSendOtp();
    }

    public static function verifyOtp($param): void
    {
        // Retrieve the JSON data from the request body
        $json_data = file_get_contents('php://input');

        // Parse the JSON data into an associative array
        $data = json_decode($json_data, true);

        if (empty($data['account'])) {
            http_response_code(400);

            echo ReturnSmg::return(1050, false, '701: Account is empty!');
            exit();
        }

        $otpVerify = new OtpHandler($data);

        echo $otpVerify->userVerifyOtp();
    }
}