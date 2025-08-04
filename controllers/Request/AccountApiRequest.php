<?php

namespace Controllers\Request;

use Includes\Account\TokenVerify;
use Includes\Account\UserCheck;
use Includes\Account\UserLogin;
use Includes\Account\UserSingUp;
use Includes\Common\ReturnSmg;

class AccountApiRequest
{

    public static function tokenVerify($param): void
    {
        $uToken = (string) $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $uid = (int) $_SERVER['HTTP_SOPNOLIKHI'] ?? '';

        if (empty($uToken) || empty($uid)) {
            http_response_code(400);

            echo ReturnSmg::return(1050, false, '708: User token is invalid!');

            exit();
        }

        $tokenVerify = new TokenVerify($param);

        echo $tokenVerify->getTokenVerify();
    }


    public static function checkUser($param): void
    {
        // Retrieve the JSON data from the request body
        $json_data = file_get_contents('php://input');

        // Parse the JSON data into an associative array
        $data = json_decode($json_data, true);

        if (empty($data['account'])) {
            http_response_code(400);

            echo ReturnSmg::return(1050, false, '707: Please enter either an email or a mobile number and password!');
            exit();
        }

        $userCheckInfo = new UserCheck($data);

        echo $userCheckInfo->getCheckUserInfo();
    }



    public static function userLogin($param): void
    {
        // Retrieve the JSON data from the request body
        $json_data = file_get_contents('php://input');

        // Parse the JSON data into an associative array
        $data = json_decode($json_data, true);

        if (empty($data['account']) || empty($data['password'])) {
            http_response_code(400);

            echo ReturnSmg::return(1050, false, '701: Mobile or email and password is require!');
            exit();
        }

        $logIn = new UserLogin($data);

        echo $logIn->userAccountLogin($data);
    }

    public static function userSingUp($param): void
    {
        // Retrieve the JSON data from the request body
        $json_data = file_get_contents('php://input');

        // Parse the JSON data into an associative array
        $data = json_decode($json_data, true);

        if (empty($data['account']) || empty($data['password'])) {
            http_response_code(400);

            echo ReturnSmg::return(1050, false, '707: Please enter either an email or a mobile number and password!');
            exit();
        }

        $singUp = new UserSingUp($data);

        echo $singUp->userAccountCrate();
    }
}