<?php namespace Includes\Account;

use Includes\Common\ApiCall;

class UserSingUp
{
    private array $params;


    public function __construct($params)
    {
        $this->params = $params;

    }

    public function userAccountCrate(): string
    {
        if(isset($this->params['password']))
        {
            $this->params['password'] = md5(htmlspecialchars($this->params['password']));
        }
        
        return ApiCall::ApiSingUpRequest($this->params);
    }
}