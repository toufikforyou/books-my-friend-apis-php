<?php
namespace Includes\Account;

use Includes\Common\ApiCall;

class UserLogin
{
    private string $account;
    private string $password;
    private bool $remember;

    public function __construct(array $param)
    {
        $this->account = (string) trim($param['account']);
        $this->password = (string) trim($param['password']);
        $this->remember = (bool) trim($param['remember']);
    }

    public function userAccountLogin($param): string
    {
        if(isset($param['password']))
        {
            $param['password']  = md5($param['password']);
        }
        $data = array(
            'account' => $this->account,
            'password' => md5(htmlspecialchars($this->password)),
            'remember' => $this->remember
        );

        return ApiCall::ApiLogInRequest($param);
    }


}