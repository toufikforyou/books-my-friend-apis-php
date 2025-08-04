<?php
namespace Includes\Account;

use Includes\Common\ApiCall;

class OtpHandler
{

    private array $params;

    public function __construct(array $param)
    {
        $this->params = $param;


    }

    public function userSendOtp(): string
    {
        return ApiCall::ApiSendOtpRequest($this->params);
    }

    public function userVerifyOtp(): string
    {
        return ApiCall::ApiVerifyOtpRequest($this->params);
    }
}