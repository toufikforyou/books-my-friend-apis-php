<?php

namespace Includes\Account;

use Includes\Common\ApiCall;

class TokenVerify
{
    private array $params;

    public function __construct($param)
    {
        $this->params = $param;
    }

    public function getTokenVerify()
    {
        return ApiCall::ApiUserTokenVerify($this->params);
    }

    public static function verifyTokenCheck(): bool
    {
        $uToken = (string) $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $uid = (int) $_SERVER['HTTP_SOPNOLIKHI'] ?? '';

        if (empty($uToken) || empty($uid)) {
            return false;
        }

        $result = json_decode(ApiCall::ApiUserTokenVerify(array()), true);

        if ($result['code'] === 1000) {
            return true;
        } else {
            return false;
        }
    }
}
