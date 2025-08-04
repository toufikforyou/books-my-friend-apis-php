<?php

namespace Includes\Common;

use Services\Apis\ApiController;

class ApiCall
{
    public static function ApiUserTokenVerify(array $data): string
    {
        $obj = new ApiController;

        $result = $obj->PostApiCall('https://verify.sopnolikhi.com/v1/account/login/verify', $data);

        $apiRes = json_decode($result, true);

        if ($apiRes['code'] === 1000) {
            http_response_code(200);

            return $result;
        } else {
            http_response_code(400);
            return $result;
        }
    }
    public static function ApiUserCheckInfo(array $data): string
    {
        $obj = new ApiController;

        $result = $obj->PostApiCall('https://verify.sopnolikhi.com/v1/account/check', $data);

        $apiRes = json_decode($result, true);

        if ($apiRes['code'] === 1000) {
            http_response_code(200);

            return $result;
        } else {
            http_response_code(400);

            return $result;
        }
    }

    public static function ApiLogInRequest(array $data): string
    {
        $obj = new ApiController;

        $result = $obj->PostApiCall('https://verify.sopnolikhi.com/v1/account/login', $data);

        $apiRes = json_decode($result, true);

        if ($apiRes['code'] === 1000) {
            http_response_code(200);

            return $result;
        } else {
            http_response_code(400);

            return $result;
        }
    }

    public static function ApiSingUpRequest(array $data): string
    {
        $obj = new ApiController;

        $result = $obj->PostApiCall('https://verify.sopnolikhi.com/v1/account/create', $data);

        $apiRes = json_decode($result, true);

        if ($apiRes['code'] === 1001) {
            http_response_code(201);

            return $result;
        } else {
            http_response_code(400);

            return $result;
        }
    }

    public static function ApiSendOtpRequest(array $data): string
    {
        $obj = new ApiController;

        $result = $obj->PostApiCall('https://verify.sopnolikhi.com/v1/account/otp/send', $data);

        $apiRes = json_decode($result, true);

        if ($apiRes['code'] === 1001) {
            http_response_code(201);

            return $result;
        } else {
            http_response_code(400);

            return $result;
        }
    }

    public static function ApiVerifyOtpRequest(array $data): string
    {
        $obj = new ApiController;

        $result = $obj->PostApiCall('https://verify.sopnolikhi.com/v1/account/otp/verify', $data);

        $apiRes = json_decode($result, true);

        if ($apiRes['code'] === 1000) {
            http_response_code(200);

            return $result;
        } else {
            http_response_code(400);

            return $result;
        }
    }
}
