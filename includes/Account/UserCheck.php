<?php
namespace Includes\Account;

use Includes\Common\ApiCall;

class UserCheck
{
    private array $params;

    public function __construct($param)
    {
        $this->params = $param;    
    }

    public function getCheckUserInfo()
    {
        return ApiCall::ApiUserCheckInfo($this->params);
    }
}